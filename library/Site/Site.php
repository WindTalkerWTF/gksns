<?php
/**
 * 
 * app 工具
 *
 */
class Site {
	
	static function dao(){
		return Site_Dao::getInstance();
	}
	
	static function service(){
		return Site_Service::getInstance();
	}

}