<?php
/**
 * 
 * app 工具
 *
 */
class @Tpl@ {
	
    /**
     * @return @Tpl@_Dao
     */
	static function dao(){
		return @Tpl@_Dao::getInstance();
	}
	
	/**
	 * @return @Tpl@_Service
	 */
	static function service(){
	    return @Tpl@_Service::getInstance();
	}

}