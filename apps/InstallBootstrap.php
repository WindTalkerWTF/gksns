<?php

class InstallBootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	function _initErrorReport(){
		$this->bootstrap('frontController');
		$frontController = $this->getResource('frontController');
		$this->front = $frontController;
		$showException = false;
		$frontController->throwExceptions($showException);
	}
	
	function _initMyErrorHandler(){
		$this->front->registerPlugin(new My_Controller_Plugin_MyErrorHandler());
	}
	
	function _initSetHtml(){
		$view = new Zend_View();   
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');   
		$viewRenderer->setView($view)->setViewSuffix('php'); 
	}
	
	#app导入
	function _initControllers()
    {
    	$this->front->addControllerDirectory(ROOT_DIR . "/apps/install/controllers", "install");
    }
	
}

