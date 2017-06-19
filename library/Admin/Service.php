<?php
/**
 * service 主类
 * @author kaihui_wang
 *
 */
class Admin_Service extends My_Service{
	
	private static $_instance = null;
	
	
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

   function getApp(){
   	    return new Admin_Service_App();
   }
   
   function getCommon(){
   	    return new Admin_Service_Common();
   }
   
   function getSys(){
   	    return new Admin_Service_Sys();
   }
   
	
}
