<?php
/**
 * 
 * dao 主类
 * @author kaihui_wang
 *
 */
class Admin_Dao extends My_Dao{
	private static $_instance = null;

	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	
	/**
	 *
	 * @return Admin_Dao_Actions
	 */
	function getActions(){
	    return new Admin_Dao_Actions();
	}
	
	
	/**
	 *
	 * @return Admin_Dao_Appinfo
	 */
	function getAppinfo(){
	    return new Admin_Dao_Appinfo();
	}
	
	/**
	 *
	 * @return Admin_Dao_Masterrole
	 */
	function getMasterrole(){
	    return new Admin_Dao_Masterrole();
	}
	
	/**
	 *
	 * @return Admin_Dao_Roleaction
	 */
	function getRoleaction(){
	    return new Admin_Dao_Roleaction();
	}
	
	/**
	 *
	 * @return Admin_Dao_Menu
	 */
	function getMenu(){
	    return new Admin_Dao_Menu();
	}
	
	
	/**
	 *
	 * @return Admin_Dao_Roles
	 */
	function getRoles(){
	    return new Admin_Dao_Roles();
	}
}