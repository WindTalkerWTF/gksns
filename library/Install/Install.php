<?php
/**
 * 
 * app 工具
 *
 */
class Install {
	
	static function dao(){
		return Install_Dao::getInstance();
	}
	
	static function service(){
		return Install_Service::getInstance();
	}

}