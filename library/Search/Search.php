<?php
/**
 * 
 * app 工具
 *
 */
class Search {
	
	static function dao(){
		return Search_Dao::getInstance();
	}
	
	static function service(){
		return Search_Service::getInstance();
	}

}