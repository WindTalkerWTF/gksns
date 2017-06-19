<?php
/**
 * 
 * app 工具
 *
 */
class Video {
	
    /**
     * @return Video_Dao
     */
	static function dao(){
		return Video_Dao::getInstance();
	}
	
	/**
	 * @return Video_Service
	 */
	static function service(){
	    return Video_Service::getInstance();
	}

}