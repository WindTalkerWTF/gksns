<?php
/**
 * yb配置类
 */

class My_Config{
	private static $_instance = null;
	
	
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * 
	 * 获取配置
	 * @param unknown_type $fileName
	 * @param unknown_type $ismo
	 * @param unknown_type $hasSection
	 * @param unknown_type $appName
	 */
	function getConfig($fileName, $ismo = 0 , $hasSection=1, $appName=''){
		if(!$fileName) return false;
		$iniConfigPath="";
		$configPath = "";
		if(!$ismo){
			$iniConfigPath = ROOT_DIR.DS. "configs" . DS . $fileName . ".ini.php";
			$applicationCachePath = CACHE_DIR . "/ini" ;
		}else{
			$appName = $appName ? $appName:Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
			$iniConfigPath = ROOT_DIR. DS . "configs" . DS .strtolower($appName).DS. $fileName . ".ini.php";	
			$applicationCachePath = CACHE_DIR . "/ini/_app_" . DS . $appName ;
			
		}
		$configPath = $applicationCachePath  . DS . $fileName . ".php";
		return $this->_getConfig($configPath, $iniConfigPath, $hasSection);
	}
	
	
	
	
	/**
	 * 根据路径 ini配置
	 * @param string $fileName
	 * @param int $ismo
	 * @return boolean|exceptiom
	 */
	public function getSimpleConfig($iniConfigPath,$configPath=''){
		if(!$iniConfigPath) return false;
		if(!$configPath){
			$configPath = CACHE_DIR . "/ini" . DS . "simple".DS.md5($iniConfigPath).".php";
		}
		return $this->_getConfig($configPath, $iniConfigPath,1);
	}
	
	
	
	/**
	 * 魔术函数获取配置
	 * @param string $methodName
	 * @param array $args
	 */
	public function __call($methodName, $args){
		if($methodName == 'get') return false;
		
		if(substr($methodName, 0, 3) == "get"){
			if(substr($methodName, 0, 5) != "getMo"){
				$configName = substr($methodName, 3);
				$isMo = 0;
			}else{
				$configName = substr($methodName, 5);
				$isMo = 1;
			}
			//将字符串按大写字母分隔成字符串数组
			$arr = preg_split("/(?=[A-Z])/", $configName);
			$configNameStr = implode('_', $arr);
			$configNameStr = strtolower(trim($configNameStr, "_"));
			//获取配置
			return $this->getConfig($configNameStr, $isMo);
		}
		
		return false;
	}
	
	/**
	 * 写入配置文件
	 * @param array $configData 配置数据(数组)
	 * @param string $fileName
	 * @param int $ismo 是否是app
	 * @return boolean
	 */
	public function save($configData, $fileName="init", $ismo = 0, $appName=''){
		if(!$fileName || !$configData) return false;

		if(!is_file($fileName)){
			if(!$ismo){
				$configPath = ROOT_DIR.DS. "configs" . DS . $fileName . ".ini.php";
			}else{
				$appName = $appName ? $appName:Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
				$configPath = ROOT_DIR. DS . "configs" . DS .strtolower($appName).DS. $fileName . ".ini.php";
			}
		}
		$config = new Zend_Config_Ini($configPath, null,
                              		array('skipExtends'        => true,
                                    	  'allowModifications' => true
                              			 )
								 );
		foreach($configData as $k=>$v){
		    $karr = explode('.',$k);
    		$developmentObj = '$config->'.APPLICATION_ENV;
    		$productionStr = "";
    		$developmentStr = "";
		    if($karr){
		    	foreach ($karr as $kv){
        	        $developmentObj .= '->'.$kv;
		    	}
		    	
		    	$developmentStr = "if(isset(".$developmentObj.")) ".$developmentObj."=".var_export($v,true).";";
		    	
		    }
	        if($productionStr) eval($productionStr);
	        if($developmentStr) eval($developmentStr);
		}

		$writer = new Zend_Config_Writer_Ini();
    	$writer->setConfig($config)
	           ->setFilename($configPath)
	           ->write();
    	//添加php注释
    	$dataTmp = file_get_contents($configPath);
    	$strTmp = ";<?php /*\r\n".$dataTmp."\r\n;*/";
    	file_put_contents($configPath, $strTmp);
    	//清空文件缓存
    	My_Cache::clearFileCache();
		return true;
	}
	
	/**
	 * 
	 * 根据配置文件名获取配置信息
	 */
    protected  function _getConfig($configPath, $iniConfigPath, $hasSection=1){
		if(!$configPath) return false;
		
		if(isDebug()){
			if(is_file($iniConfigPath)){
				if($hasSection){
					$config= new Zend_Config_Ini($iniConfigPath, APPLICATION_ENV);
				}else{
					$config= new Zend_Config_Ini($iniConfigPath);
				}
				$config = $config->toArray();
				return $config;
			}else{
				new My_Exception("配置文件不存在");
			}
		}else{
			return fileCached($configPath, array($this, "_getZfConfig"), array($iniConfigPath, $hasSection));
		}
	}
	
	//获取zf解析的配置
	function _getZfConfig($iniConfigPath, $hasSection){
		if($hasSection){
			$config= new Zend_Config_Ini($iniConfigPath, APPLICATION_ENV);
		}else{
			$config= new Zend_Config_Ini($iniConfigPath);
		}
		return $config->toArray();
	}
	
	/**
	 * 
	 * 获取application数据
	 */
	public function getOptions(){
		return $this->getApplication();
	}
	
	
	function getDbConfig($key){
		return stripslashes(Home::service()->getCommon()->getSysData($key));
	}
	
	function saveDbConfig($key,$value){
		return Home::service()->getCommon()->saveSysData($key,$value);
	}
	
}
