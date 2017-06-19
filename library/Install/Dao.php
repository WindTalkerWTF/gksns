<?php
/**
 * 
 * dao 主类
 *
 */
class Install_Dao extends My_Dao{
	private static $_instance = null;

	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

}