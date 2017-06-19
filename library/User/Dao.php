<?php
/**
 * 
 * dao 主类
 * @author kaihui_wang
 *
 */
class User_Dao extends My_Dao{
	private static $_instance = null;

	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	function getCoinlogs(){
		return new User_Dao_Coinlogs();
	}
	
	function getEmailvalidate(){
		return new User_Dao_Emailvalidate();
	}
	
	function getFeed(){
		return new User_Dao_Feed();
	}
	
	function getFindpwdvalidate(){
		return new User_Dao_Findpwdvalidate();
	}
	
	function getFollow(){
		return new User_Dao_Follow();
	}
	
	function getInfo(){
		return new User_Dao_Info();
	}
	
	function getSign(){
		return new User_Dao_Sign();
	}
	
	function getStat(){
		return new User_Dao_Stat();
	}
	
	function getOpenlogin(){
		return new User_Dao_Openlogin();
	}
}