<?php

class User_Bootstrap extends Zend_Application_Module_Bootstrap
{
		protected function _initExec(){
			$this->autologin();
			$this->loginedHelper();
		}
		
		#自动登录
		protected function autologin(){
	    	$this->bootstrap('frontController');
			$frontController = $this->getResource('frontController');
			$frontController->registerPlugin(new User_Controller_Plugin_Autologin());
	    }
	    
	    #登录helper 工具
	    function loginedHelper(){
	    	Zend_Controller_Action_HelperBroker::addPath(ROOT_LIB . "/User/Controller/Action/Helper", "User_Controller_Action_Helper");
	    }
}

