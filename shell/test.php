<?php
define("RUN_CLI", 1);
php_sapi_name() != 'cli' && exit('no access!');
require_once str_replace("shell", "", dirname(__FILE__)) . "/index.php";

/************以下是自定义区***************/

class test{
	
	static function todo(){

	}
	
}
test::todo();