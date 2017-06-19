<?php
/**
 * 
 * 文件缓存
 * @author kaihui_wang
 *
 */
My_Tool::importOpen("FileCache.php");
class My_Cache_File{
	private  $options = null;
	private  $cacheDir = null;
	private static $_instance = null;
	
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public  function setOptions(){
		$config = My_Config::getInstance()->getInit();
		$this->options = $config;
	}
	
	function __construct(){
		$this->setOptions();
		$this->setCacheDir();
	}
	
	function set($key,$value,$expire=0){
		FileCache::set($key, $value,$expire, $this->cacheDir);
	}
	
	function get($key){
		return FileCache::get($key, $this->cacheDir);
	}
	
	function delete($key){
		return FileCache::un_set($key, $this->cacheDir);
	}
	
	/**
	 * 
	 * 缓存路径
	 */
	public function setCacheDir(){
		$config = $this->options;
		$cacheDir = isset($config['cache']['file']['dir']) ? CACHE_DIR . "/" . $config['cache']['file']['dir'] : CACHE_DIR. "/file";
		if (!is_file($cacheDir)) {
			if(!is_dir($cacheDir)) mkdir($cacheDir, 0777, 1);
		}
		$this->cacheDir = $cacheDir;
	}
}