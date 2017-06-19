<?php
/**
 * 
 * app 工具
 *
 */
class Group {
	
	static function dao(){
		return Group_Dao::getInstance();
	}
	
	static function service(){
		return Group_Service::getInstance();
	}

}