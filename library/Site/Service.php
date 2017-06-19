<?php
/**
 * service 主类
 *
 */
class Site_Service extends My_Service{
	
	private static $_instance = null;
	
	
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	function getCommon(){
		return new Site_Service_Common();
	}
	
}
