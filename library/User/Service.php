<?php
/**
 * service 主类
 * @author kaihui_wang
 *
 */
class User_Service extends My_Service{
	
	private static $_instance = null;
	
	
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	function getCommon(){
		return new User_Service_Common();
	}
	
	function getMail(){
		return new User_Service_Mail();
	}
	
	function getOpenlogin(){
		return new User_Service_Openlogin();
	}
	
}
