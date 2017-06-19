<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
	public $frontController= null;
	function _initExec(){
		$this->bootstrap('frontController');
		$this->frontController = $this->getResource('frontController');
		$this->adminCheckLogin();
		$this->adminHelper();
	}
	#判断是否是后台action
	function adminCheckLogin(){
		$this->frontController->registerPlugin(new Admin_Controller_Plugin_Adminlogincheck());
	}
	
	#admin  helper
	function adminHelper(){
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . "/admin/library/Admin/Controller/Action/Helper", "Admin_Controller_Action_Helper");
	}	

}