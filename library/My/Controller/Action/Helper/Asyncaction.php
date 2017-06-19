<?php
class My_Controller_Action_Helper_Asyncaction extends Zend_Controller_Action_Helper_Abstract {
	private $actions = null;
	
	function direct($actions){
		$this->actions = $actions;
	}
	
	function preDispatch(){
		
		$actionName = $this->getRequest()->getActionName();
		if(in_array($actionName, $this->actions)){
			$check = $this->getRequest()->getParam("asyncActionCheck");
		  	if(!$check){
		  		$currUrl = My_Tool::getCurrentUrl();
		  		$url = stristr($currUrl, "?") ? $currUrl . "&asyncActionCheck=1":$currUrl . "?asyncActionCheck=1";
		  		My_Tool::debug("async:".$url);
		  		My_Cache::set("My_Controller_Action_Helper_Asyncaction_url", $url, 60);
		  		My_Tool::asyncCurl($url);
		  		exit;
		  	}
		  	set_time_limit(0);
			ignore_user_abort(0);
		}
	}
	
}