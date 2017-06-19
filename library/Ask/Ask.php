<?php
/**
 * 
 * app 工具
 *
 */
class Ask {
	
	static function dao(){
		return Ask_Dao::getInstance();
	}
	
	static function service(){
		return Ask_Service::getInstance();
	}

}