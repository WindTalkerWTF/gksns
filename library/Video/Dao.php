<?php
/**
 * 
 * dao 主类
 *
 */
class Video_Dao extends My_Dao{
    private static $_instance = null;
    
    public static function getInstance(){
        if(!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /************以下是自定义区***************/
    
    function getDetail(){
    	return new Video_Dao_Detail();
    }
    
    function getImg(){
    	return new Video_Dao_Img();
    }
    
    function getList(){
    	return new Video_Dao_List();
    }
    
    function getTree(){
    	return new Video_Dao_Tree();
    }
    
    function getRecommendlog(){
    	return new Video_Dao_Recommendlog();
    }
    
}