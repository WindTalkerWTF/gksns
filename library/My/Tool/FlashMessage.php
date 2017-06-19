<?php
class My_Tool_FlashMessage{
	/**
     * 
     * 闪存数据保存
     * @param string $key
     * @param string $value
     */
    public static function set($key, $value){
    	$key = __CLASS__ ."_FlashMessage_" . $key;
    	if(!$key) new My_Exception("flash key为空");
    	
    	$session = new My_Session_Namespace("flash_message");
    	$session->$key = $value;
    	return true;
    }
    
    /**
     * 
     * 闪存数据获取
     * @param string $key
     */
    public static function get($key, $isDelete=0){
    	$key = __CLASS__ ."_FlashMessage_" . $key;

		$session = new My_Session_Namespace("flash_message");
    	$result = $session->$key;
    	if($isDelete)  $session->$key = "";//用过删除  	
    	return $result;
    }
    
    static function has($key){
    	$key = __CLASS__ ."_FlashMessage_" . $key;
    	$session = new My_Session_Namespace("flash_message");
    	$result = $session->$key;
    	return $result?true:false;
    }
}