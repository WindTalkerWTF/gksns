<?php
/**
 * 
 * dao 主类
 * @author kaihui_wang
 *
 */
class Msg_Dao extends My_Dao{
	private static $_instance = null;

	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    
	
	function getData(){
		return new Msg_Dao_Data();
	}
	
	function getNotice(){
		return new Msg_Dao_Notice();
	}
	
	function getNoticereadlog(){
		return new Msg_Dao_Noticereadlog();
	}
}