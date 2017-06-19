<?php
/**
 * 
 * dao 主类
 *
 */
class Group_Dao extends My_Dao{
	private static $_instance = null;

	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	function getArc(){
		return new Group_Dao_Arc();
	}
	
	function getInfo(){
		return new Group_Dao_Info();
	}
	
	function getRecommendlog(){
		return new Group_Dao_Recommendlog();
	}
	
	function getTree(){
		return new Group_Dao_Tree();
	}
	
	function getUser(){
		return new Group_Dao_User();
	}
}