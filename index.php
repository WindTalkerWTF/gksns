<?php
header("content-type:text/html; charset=utf-8");
date_default_timezone_set('Asia/Shanghai');
ini_set("display_errors", true);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.auto_start',0);
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

define('ROOT_DIR', str_replace("\\", "/", realpath(dirname(__FILE__))));
define('ROOT_LIB', ROOT_DIR.'/library');
define('PUBLIC_DIR', ROOT_DIR);
define('CACHE_DIR', ROOT_DIR . '/data/cache');
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(ROOT_DIR . '/apps'));

if(defined("RUN_CLI")){
	$dev = isset($argv[1])  ? $argv[1] : "production";
	define('APPLICATION_ENV',$dev);
}else{
	defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
}
include ROOT_LIB . DS . "My" .DS."Init.php";
My_Init::getInstance()->create();