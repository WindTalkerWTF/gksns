<?php
/**
 * service 主类
 *
 */
class Dong_Service extends My_Service{
    private static $_instance = null;
    
    
    public static function getInstance(){
        if(!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /************以下是自定义区***************/
    
    /**
     *
     * @return Dong_Service_Common
     */
    function getCommon(){
        return new Dong_Service_Common();
    }
    
}
