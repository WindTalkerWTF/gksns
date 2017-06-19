<?php
/**
 * 
 * dao 主类
 *
 */
class Ask_Dao extends My_Dao{
	private static $_instance = null;

	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * 
	 * @return Ask_Dao_Arc
	 */
	function getArc(){
		return new Ask_Dao_Arc();
	}
	
	function getFollowlog(){
		return new Ask_Dao_Followlog();
	}
	
	function getReplylog(){
		return new Ask_Dao_Replylog();
	}
	

	
	function getTagFollow(){
		return new Ask_Dao_Tagfollow();
	}
	

	
}