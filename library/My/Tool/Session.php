<?php
class My_Tool_Session {
	
	public static function getAdapter($str){
		if(empty($str)) throw new My_Exception("session 参数错误!", -401);
		return new My_Session_Namespace($str);
	}
}
