<?php
/**
 * 
 * memcache缓存类
 * @author kaihui_wang
 *
 */
class My_Cache_Memcache{
	private static $_instance = null;
	private $memcacheObj = null;
	public static function getInstance(){
		if(!self::$_instance){
			$obj=new self();
			self::$_instance = $obj->memcacheObj;
		}
		return self::$_instance;
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
		return $config['cache']['memcache']['server'] ? $config['cache']['memcache']['server'] : "";
	}
	

	/**
	 * 
	 * 获取基本适配器
	 */
	public function __construct(){
        if (!extension_loaded('memcache')) {
            My_Tool::showError("请确认memcache扩展是否安装");
        }
		try{
			$servers = $this->getServers();
//			print_r($servers);
			$memcacheObj = new Memcache();
//		    $memcacheObj->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_CONSISTENT);
//			$memcacheObj->setOption(Memcached::OPT_HASH, Memcached::HASH_CRC);
			foreach($servers as $k=>$v){
				$memcacheObj->addServer($v['ip'], $v['port'], true, $v['weight'],10);
			}
			$this->memcacheObj = $memcacheObj;
		}catch(Exception $e){
            My_Tool::showError($e->getMessage());
		}
	}
}