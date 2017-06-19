<?php
/**
 * 
 * app 工具
 * @author kaihui_wang
 *
 */
class Home {
	
	static function dao(){
		return Home_Dao::getInstance();
	}
	
	static function service(){
		return Home_Service::getInstance();
	}

}