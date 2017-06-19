<?php
/**
 * 
 * 初始化
 * @author kaihui
 *
 */
if(!isset($_COOKIE['PHPSESSID']))
{
    setcookie('PHPSESSID', time(), time()+60*60, '/');
}
set_include_path(implode(PS, array(
    ROOT_DIR,
    ROOT_LIB,
    ROOT_LIB.'/Home',
    ROOT_LIB.'/Zend',
    get_include_path(),
)));
spl_autoload_register('classLoader');
runXhprof();
set_error_handler("myError",E_ALL);
// register_shutdown_function("lastError");
// set_exception_handler("myException");
class My_Init{
	private static $inStance=null;
	private $appNames=array();
	private $configs = array();
	private $libraryFiles = array();
	private $application = null;
	public  $time=0;
	public static $isInstall = 0;
              public static $sessionIsSet=0;
	
	static function getInstance(){
		if(!self::$inStance){
			self::$inStance = new self();
			self::$isInstall = isInstall();
		}
		return self::$inStance;
	}
	
	//获取花费的时间
	function getTime(){
		return number_format(getMicrotime()-$this->time, 4);
	}
	
	//获取调试信息
	function getDebug(){
		$func = get_defined_functions();
		$include = get_included_files();
		$class = get_declared_classes();
		return array(
			'func'=>$func,
			'include_file'=>$include,
			'class'=>$class
		);
	}
	
	//创建site
	function create(){
		$this->time = getMicrotime();
		include 'Zend/Application.php';
		$this->cachePlugin();
		include "My/Tool/File.php";
		$this->siteIni();

		$this->namespaceInit();
		$allConfigs = mergeConfigs($this->configs);
//		print_r($allConfigs);exit;
		if(!My_Init::$isInstall){
			$allConfigs['bootstrap']['path'] = APPLICATION_PATH . DS."InstallBootstrap.php";
			$allConfigs['bootstrap']['class'] = "InstallBootstrap";
		}
		// Create application, bootstrap, and run
		$this->application = new Zend_Application(
		    APPLICATION_ENV,
		   	$allConfigs
		);

		$this->openNameSpace();

		if(!defined("RUN_CLI")){
			$this->application->bootstrap()->run();
		}
	}
	
	//plugin缓存
	function cachePlugin(){
		if(isDebug()) return true;
		require_once 'Zend/Loader/PluginLoader.php';
		$cacheFilePath = CACHE_DIR . '/data';
		$classFileIncCache = $cacheFilePath . '/pluginLoaderCache.php';
		
		if (!is_file($classFileIncCache)) {
			if(!is_dir($cacheFilePath)) mkdir($cacheFilePath, 0777, 1);
			Zend_Loader_PluginLoader::setIncludeFileCache($classFileIncCache);
		}else{
			include_once $classFileIncCache;
		}
	}
	
	//网站配置缓存文件
	function siteIni(){
		$applicationIniPath = ROOT_DIR . '/configs/application.ini.php';
		$applicationIniCachePath = CACHE_DIR . "/ini/application.php";
		
		$appsRouterIniPath = ROOT_DIR . '/configs/router.ini.php';
		$appsRouterIniCachePath = CACHE_DIR . "/ini/router.php";
		
		$configs[] = array("ini"=>$applicationIniPath, "inc"=>$applicationIniCachePath);
		$configs[] = array("ini"=>$appsRouterIniPath, "inc"=>$appsRouterIniCachePath);
		$this->configs = $configs;
		return $configs;
	}
	
	
	
	//namespace初始化
	function namespaceInit(){
		$this->getLibraryFiles();
		$this->getAppNames();
			//app
		 if($this->appNames){
			    foreach($this->appNames as $v){
			    	if(preg_match("/^@.*?@$/", $v)) continue;
					$this->libraryFiles[] = ucfirst($v);
					$appsRouterIniPathTmp = ROOT_DIR . DS.'/configs/'.strtolower($v).'/router.ini.php';
					$appsRouterIniCachePathTmp = CACHE_DIR . "/ini/_app_/".strtolower($v)."/router.php";
					$this->configs[] = array("ini"=>$appsRouterIniPathTmp, "inc"=>$appsRouterIniCachePathTmp);
			    }
		  }
	 	
      }
      
     
      //开启namespance
      function openNameSpace(){
      		$namespaces = array();
      		$this->libraryFiles = array_unique($this->libraryFiles);
//      		print_r($this->libraryFiles);exit;
			if($this->libraryFiles){
				foreach($this->libraryFiles as $file){
					if($file != "Open" && $file != "Zend"){
						$namespaces[] = $file . "_";
						$fileTmp = $file . DS . $file . ".php";
						require_once $fileTmp;
					}
				}
			}
			$this->application = $this->application->setAutoloaderNamespaces($namespaces);
      }
  
	//library namespace
	function getLibraryFiles(){
		$libraryFiles =  fileCached("data/autoloaderNamespaces.php", array("My_Tool_File", "getDirNames"), array(ROOT_LIB));
		$this->libraryFiles = $libraryFiles;
		return $libraryFiles;
	}
	
	//app
	function getAppNames(){
		$appNames = fileCached("data/_app_/apps.php", array("My_Tool_File", "getDirNames"), array(APPLICATION_PATH));
		$this->appNames = $appNames;
		return $appNames;
	}
	
}

//===================================函数===========================================================================
function classLoader($className) {
    $pathArr = explode('_', $className);
    if($pathArr){
        $path = "";
        foreach($pathArr as $v){
            $path .= ucfirst($v)."/";
        }
        $path = trim($path, "/");
    }
    include_once $path.".php";
}

function isInstall(){
      $path = ROOT_DIR . "/data/install.lock";
      return is_file($path) ? true:false;
}
      
function isDebug(){
	return My_Init::$isInstall ? false:true;
}
#文件缓存
function fileCached($newCacheFilePath, $dataCome, $params=array()){
	if(!isDebug()){
		$cacheListPath = CACHE_DIR . "/cacheList.php";
		if(!is_file($cacheListPath)) file_put_contents($cacheListPath, "<?php return array(); ",LOCK_EX);
		$cacheList = include $cacheListPath;
		$newCacheFilePath = str_replace("\\", "/", $newCacheFilePath);
		//是否全路径
		$tmp = str_replace(CACHE_DIR, "", $newCacheFilePath);
		if($newCacheFilePath != $tmp){
			$cachePath = $newCacheFilePath;
		}else{
			$cachePath = CACHE_DIR . "/" . ltrim($newCacheFilePath, "/");
		}

		if((!is_array($cacheList)) || (!in_array($cachePath, $cacheList))){
			$result = call_user_func_array($dataCome, $params);
			$data = $result;
		
			if(!is_dir(dirname($cachePath)))  mkdir(dirname($cachePath), 0755, 1);
			$result = is_array($result) ? var_export($result, true) :  $result;
			$result = is_object($result) ? var_export($result->toArray(), true) : $result; 
			$configs = '<?php' . PHP_EOL . 'return ' . $result .";". PHP_EOL;
         	file_put_contents($cachePath, $configs,LOCK_EX);
         	//保存cache路径列表
         	$cacheList[] = $cachePath;
			if(!$cacheList) return $data;
         	$cacheListStr = '<?php' . PHP_EOL . 'return ' . var_export($cacheList, true) .";". PHP_EOL;
         	file_put_contents($cacheListPath, $cacheListStr,LOCK_EX);
         	return $data;
		}else{
			$result = include($cachePath);
			return 	$result;
		}
	}else{
		return call_user_func_array($dataCome, $params);
	}
	
}

//合并配置文件
function mergeConfigs(array $configs){
	if(!$configs) return false;
	$data = array();
	foreach($configs as $v){
		$ini  =  $v['ini'];
		$inc  =  $v['inc'];
		$configData = fileCached($inc, "getIni", array($ini));
		$data = array_merge_recursive($data, $configData);
	}
	return $data;
}

function getIni($ini){
	if(!is_file($ini)) return array();
	require_once 'Zend/Config/Ini.php';
	$config = new Zend_Config_Ini($ini, APPLICATION_ENV, array('allowModifications' => true));
    return $config->toArray();
}
//错误处理
function myError($errno, $errstr, $errfile, $errline){
	if(error_reporting() == 0) return true; 
	$trace = My_Tool::trace(0);
	if(isDebug()){
		echo "<pre>";
		echo $trace;
	}
}

//时间
function getMicrotime()
{
	list($usec, $sec) = explode(' ', microtime()); 
	return ((float)$usec + (float)$sec); 
}

function getSysData($key){
	return Home::service()->getCommon()->getSysData($key);
}

function saveSysData($k,$v){
    if(!$k) return false;
	return Home::service()->getCommon()->saveSysData($k, $v);
}

function getInit($key=''){
	if(!$key) return My::config()->getInit();
    $sysDefault = My::config()->getInit();
    $config = array();
    My_Tool::changeArray2One($sysDefault,$config);
    return $config[$key];
}

function saveInit($k,$v){
    if(!$k) return false;
    $data=array($k=>$v);
    My::config()->save($data);
    return true;
}

function dd($str){
    print_r($str);
    exit();
}

function ddif($str,$k,$v){
    if($k==$v){
        dd($str);
    }
}

function sessionIsset(){
    if(My_Init::$sessionIsSet) return true;
    $sessionHandle = getInit("session.handle");
    $sessionConfig = array();
    $sessionConfig['name']=getInit('appname');
    $sessionConfig['gc_probability']=1;
    $sessionConfig['gc_maxlifetime']=3600;
    $sessionConfig['cookie_httponly'] = true;
    $sessionConfig['cookie_path'] = "/";
    $sessionConfig['cookie_lifetime'] = "1800";
    $sessionConfig['strict']='on';
    $sessionConfig['use_only_cookies']=true;
    $sessionDomain = My_Tool::parseHost( My_Tool::getCurrentUrl());
    if($sessionDomain){
    	$sessionConfig['cookie_domain']=$sessionDomain;
    }
    if($sessionHandle == "memcache"){
        $memConfig = array(
            'memcached'=> getInit("cache.memcache.server"),
            'lifetime' => getInit("cache.memcache.lifetime")
        );

        Zend_Session::setSaveHandler(new My_Controller_Plugin_Memcached($memConfig));
    }else{
        $obj = new Home_Dao_Common();
        $db=$obj->getMasterDb();
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        $dbConfig = array(
            'name'           => 'home_sessions',
            'primary'        => 'id',
            'modifiedColumn' => 'modified',
            'dataColumn'     => 'data',
            'lifetimeColumn' => 'lifetime'
        );
        Zend_Session::setSaveHandler(new Zend_Session_SaveHandler_DbTable($dbConfig));
    }
    Zend_Session::start($sessionConfig);
    My_Init::$sessionIsSet=1;
}

function runXhprof(){
    if (!extension_loaded('xhprof')) {
        return false;
    }
    if(mt_rand(1,1)==1){ //这里设置监控的比例
        xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
        register_shutdown_function("saveXhprof");
    }
}

function saveXhprof(){
    if(isDebug()) return true;
    if (!extension_loaded('xhprof')) {
        return false;
    }

    $request = Zend_Controller_Front::getInstance()->getRequest();

    $m = $request->getModuleName();
    $c = $request->getControllerName();
    $a=  $request->getActionName();

    $urlTmp = $m."/".$c."/".$a;

    $config = My_Config::getInstance()->getXhpurl();
    $url = isset($config['url']) ? $config['url']:"";
    if(!$url) return true;
    if(!in_array($urlTmp,$url)) return true;
    $xhprof_data = xhprof_disable();
    $appNamespace = str_replace('/',"_",$urlTmp);
    My_Tool::importOpen("xhprof/xhprof_lib/utils/xhprof_lib.php");
    My_Tool::importOpen("xhprof/xhprof_lib/utils/xhprof_runs.php");
    $xhprof_runs = new XHProfRuns_Default();
    $xhprof_runs->save_run($xhprof_data, $appNamespace);
}