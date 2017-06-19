<?php
/**
 * 
 * dao 主类
 *
 */
class Site_Dao extends My_Dao{
	private static $_instance = null;

	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	
	function getArc(){
		return new Site_Dao_Arc();
	}
	
	function getRecommendlog(){
		return new Site_Dao_Recommendlog();
	}
	
	function getTree(){
		return new Site_Dao_Tree();
	}
}