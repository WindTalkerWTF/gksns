<?php
class My_Tool_File{
	
	
	/**
    * 
    * 文件列表
    * @param string $path
    * @param array $result
    */
   static function listFiles($path){
   		$result = array();
   		$handler = opendir($path);
	   	while(($filename = readdir($handler)) !== false ){
	      if($filename != '.' && $filename != '..'){
	      	$result[] = $filename;
	      }
	   }
	   return $result;
   }
   
	
	#删除文件夹
	static function deldir($dir) {
		$dh=opendir($dir);
		while ($file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$dir."/".$file;
				if(!is_dir($fullpath)) {
					unlink($fullpath);
				} else {
					self::deldir($fullpath);
				}
			}
		}
		closedir($dh);
		if(rmdir($dir)) {
			return true;
		} else {
			return false;
		}
	}
	
	
   /**
    *
    * 创建目录
    * @param string $path
    * @param STRING $mode
    */
   static function createfolder($path, $mode=0777)
   {
	   	if(!file_exists($path))
	   	{
	   		mkdir($path, $mode,true);
	   	}
   }
   
   
	/**
	 * 
	 * 获取路径名称
	 * @param string $dir
	 */
	static function getDirNames($dir){
		if(!$dir) return false;
		$arr = scandir($dir);
		if(!$arr) return false;
		$result = array();
		foreach($arr as $v){
			$path = $dir . DS . $v;
			if(is_dir($path) && $v != "." && $v != ".." && !stristr($v, ".")) $result[] = $v;
		}
		return $result;
	}
   
	 /**
	  * 
	  * 获取目录下所有文件夹
	  * @param string $path
	  */	
	static function getDirs($path){
		$result = array();
		$result[] = $path;
		$dir = scandir($path);
		foreach($dir as $v){
			if(is_dir($path."/".$v) && $v != "." && $v != ".." ) {
				$result = array_merge($result, self::getDirs($path."/".$v));
			}
		}
		return $result;
	}
	
}