<?php
class Dong_Service_Common  extends My_Service{
	function getAdmMenu(){
		$config = My_Config::getInstance()->getConfig("init", 1, 1, "dong");
		return isset($config['adminUrl']) ? $config['adminUrl']:"";
	}
}