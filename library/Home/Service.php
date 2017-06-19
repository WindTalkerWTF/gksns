<?php
/**
 * service 主类
 * @author kaihui_wang
 *
 */
class Home_Service extends My_Service{
	
	private static $_instance = null;
	
	
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
    function getCommon(){
    	return new Home_Service_Common();
    }
    
    function getSession(){
    	return new Home_Service_Session();
    }
    
}
