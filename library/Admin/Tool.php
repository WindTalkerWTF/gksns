<?php
class Admin_Tool{
	static private $hasAlert=0;	
	
    function showMsg($msg='', $href='',$isJs=0, $goUrl="/index/msg",$appName="admin"){
        My_Tool::showMsg($msg, $href,$isJs, $goUrl,$appName);
    }
	#显示错误提示
	static function showAlert($msg, $goUrl=''){
		My_Tool_FlashMessage::set("showAlert", $msg);
		self::$hasAlert = 1;
		if($goUrl) My_Tool::redirect($goUrl);
	}
	
	#是否存在错误
	static function hasAlert(){
		return self::$hasAlert;
	}
	
}