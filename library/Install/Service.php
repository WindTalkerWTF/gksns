<?php
/**
 * service 主类
 *
 */
class Install_Service extends My_Service{
	
	private static $_instance = null;
	
	
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	function getCommon(){
		return new Install_Service_Common();
	}
	
}
