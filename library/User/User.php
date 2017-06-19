<?php
/**
 * 
 * app 工具
 * @author kaihui_wang
 *
 */
class User {
	
	static function dao(){
		return User_Dao::getInstance();
	}
	
	static function service(){
		return User_Service::getInstance();
	}

}