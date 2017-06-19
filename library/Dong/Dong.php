<?php
/**
 * 
 * app 工具
 *
 */
class Dong {
	
    /**
     * @return Dong_Dao
     */
	static function dao(){
		return Dong_Dao::getInstance();
	}
	
	/**
	 * @return Dong_Service
	 */
	static function service(){
	    return Dong_Service::getInstance();
	}

}