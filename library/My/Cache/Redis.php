<?php
/**
 * 
 * redis
 * @author kaihui_wang
 *
 */
class My_Cache_Redis{
	
	private static $_instance = null;
	private  $redis = null;
	
	public static function getInstance($isp=0){
		if(!self::$_instance){
			$obj = new self($isp);
			self::$_instance = $obj->redis;
		}
		return self::$_instance;
	}
	
	function __construct($isp=0){
		try{
			$redis = new redis();  
			$serverConfig = $this->getServers();
			if(!$isp){
				$redis->connect($serverConfig['host'], $serverConfig['port']);
			}else{
				$redis->pconnect($serverConfig['host'], $serverConfig['port']);
			}
			$this->redis = $redis;
		}catch(Exception $e){
			throw new My_Exception("redis server connect fail : " . $e->getMessage());
		}
	}
	
	/**
	 * 
	 * 获取配置
	 */
	public function getConfig(){
		return My_Config::getInstance()->getInit();
	}
	
	/**
	 * 
	 * 获取服务器
	 */
	public function getServers(){
		$config = $this->getConfig();
		$servers =  isset($config['cache']['redis']['server']) ? $config['cache']['redis']['server'] : "";
//		print_r($servers);
		return $servers;
	}
}