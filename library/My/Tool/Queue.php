<?php
/**
 * 简单队列
 * 
 * @author kaihui
 *
 */
class My_Tool_Queue{
	
	private static $inStance=null;
	private $queueKey = null;
	private $queuePath = null;
	
	static function getInstance($queueKey){
		if(!self::$inStance){
			self::$inStance = new self($queueKey);
		}
		
		return self::$inStance;
	}
	
	function __construct($queueKey){
		$this->queueKey = $queueKey;
		$pathMd5 = md5($queueKey);
		$path = ROOT_DIR . "/data/queue/" . substr($pathMd5,0,2).'/'. substr($pathMd5,2,2).'/'. substr($pathMd5,4,2).'/';
		$filePah = $path . $pathMd5;
		if(!is_dir($path)){
			mkdir($path, 0777, true);
			file_put_contents($filePah, "",LOCK_EX);
		}
		$this->queuePath = $filePah;
	}
	
	function set($value){
		if(!$value) return false;
		$lock = $this->queuePath . '.lock';
		while(true) {
		    if(is_file($lock) ) {
		        usleep(100);
		    } else {
		        touch($lock);
		        file_put_contents($this->queuePath, serialize($value) . chr(0),FILE_APPEND|LOCK_EX);
		        break;
		    }
		}
		if( is_file($lock) ) {
		    unlink($lock);
		}
		return true;
	}
	
	
	function get($number=1){
	    $lock = $this->queuePath . '.lock';
	    $result = array();
	    while(true) {
	        if(is_file($lock) ) {
	            usleep(100);
	        } else {
	            touch($lock);
                $result = $this->_get($number);
	            break;
	        }
	    }
	    if( is_file($lock) ) {
	        unlink($lock);
	    }
	    return $result;
	}
	
	
	
	function _get($number){
	    $file = file_get_contents($this->queuePath);
	    if(!$file) return false;
	    $fileArr = explode(chr(0), $file);
	    if(!$fileArr) return false;
	    $result = array();
	    $str = "";
	    for($i=0; $i<$number;$i++){
	        if((!isset($fileArr[$i])) || (!$fileArr[$i])) break;
	        $value = $fileArr[$i];
	        unset($fileArr[$i]);
	        $result[] = unserialize($value);
	    }
	    $str = implode(chr(0), $fileArr);
	    //写入
	    file_put_contents($this->queuePath, $str,LOCK_EX);
	    return $result;
	} 
	
}