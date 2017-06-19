<?php
/**
 * 
 * dao 主类
 * @author kaihui_wang
 *
 */
class Home_Dao extends My_Dao{
	private static $_instance = null;

	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    
	function getArc(){
		return new Home_Dao_Arc();
	}
	
	function getArea(){
		return new Home_Dao_Area();
	}
	
	function getCommon(){
		return new Home_Dao_Common();
	}
	
	function getLogs(){
		return new Home_Dao_Logs();
	}
	
	function getReply(){
		return new Home_Dao_Reply();
	}
	
	function getSessions(){
		return new Home_Dao_Sessions();
	}
	
	function getSysdata(){
		return new Home_Dao_Sysdata();
	}

    function getLinks(){
        return new Home_Dao_Links();
    }

    function getTree(){
        return new Home_Dao_Tree();
    }

    function getTag(){
        return new Home_Dao_Tag();
    }

    function getTagext(){
        return new Home_Dao_Tagext();
    }
}