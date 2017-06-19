<?php
/**
 * 
 * app 工具
 * @author kaihui_wang
 *
 */
class Admin {
	
	static function dao(){
		return Admin_Dao::getInstance();
	}
	
	static function service(){
		return Admin_Service::getInstance();
	}

}