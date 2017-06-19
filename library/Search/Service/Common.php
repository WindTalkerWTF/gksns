<?php
class Search_Service_Common{
	function getAdmMenu(){
		$config = My_Config::getInstance()->getConfig("init", 1, 1, "search");
		return isset($config['adminUrl']) ? $config['adminUrl']:"";
	}
}