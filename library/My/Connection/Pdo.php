<?php
class My_Connection_Pdo extends My_Connection_Abstract{
	private $_masterAdapter = null;
	private $_slaveAdapter = null;
	private $_config = null;
	private static $_instance = null;
	
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * 获取配置文件
	 * @param string $configFileName
	 * @return boolean
	 */
	public function setConfig($configFileName){
		if(!$configFileName) return false;
		$config = My_Config::getInstance()->getConfig($configFileName);
		if(!isset($config['slave'])) $config['slave'] = $config['master'];
		$this->_config = $config;
		return $config;
	}
	
	/**
	 * 
	 * 连接
	 * @param array $config
	 */
	private function _connectExecute($config){
		if(!$config) return false;
		try{
			$db = Zend_Db::factory('Pdo_Mysql', $config);
//			My_Tool::debug($db);
//			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			$db->query("SET NAMES utf8");
//			My_Tool::debug($db);
			return $db;
		}catch (Exception $e){
			My_Tool::debug($e->getMessage());
			echo $e->getMessage();
			exit;
		}
	}
	
	/**
	 * 
	 * 写服务器连接
	 */
	public function getMasterConnection(){
		if($this->_masterAdapter) return $this->_masterAdapter;
		$this->_masterAdapter = $this->_connectExecute($this->_config['master']);
		return $this->_masterAdapter;
	}
	
	/**
	 * 
	 * 读服务器连接
	 */
	public function getSlaveConnection(){
		if($this->_slaveAdapter) return $this->_slaveAdapter;
		$this->_slaveAdapter = $this->_connectExecute($this->_config['slave']);
		return $this->_slaveAdapter;
	}

}