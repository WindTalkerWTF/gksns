<?php
/**
 * 
 * app 工具
 * @author kaihui_wang
 *
 */
class Msg {
	
	static function dao(){
		return Msg_Dao::getInstance();
	}
	
	static function service(){
		return Msg_Service::getInstance();
	}

}