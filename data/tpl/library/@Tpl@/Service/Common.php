<?php
class @Tpl@_Service_Common  extends My_Service{
	function getAdmMenu(){
		$config = My_Config::getInstance()->getConfig("init", 1, 1, "@tpl@");
		return isset($config['adminUrl']) ? $config['adminUrl']:"";
	}
}