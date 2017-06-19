<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     *
     * @var Zend_Controller_Front
     */
    private $front;
    
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
	
	function _initHelper(){
		Zend_Controller_Action_HelperBroker::addPath(ROOT_LIB . "/My/Controller/Action/Helper", "My_Controller_Action_Helper");
	}
	
	#app导入
	function _initControllers()
    {
        $obj = Admin::dao()->getAppinfo();
    	$appsInfo = fileCached("data/_apps_/appinfo.php", array($obj, "gets"));
    	if($appsInfo){
    	    $adminCommonService = new Admin_Service_Common();
    		foreach($appsInfo as $v){
    			if($adminCommonService->isCoreApp($v['name'])){
                	continue;
    			}
    			if(!$v['state']){
    			    $this->front->removeControllerDirectory($v['name']);
    			}else{
    			    $this->front->addControllerDirectory(APPLICATION_PATH . DS . "{$v['name']}/controllers", $v['name']);   
    			}
    		}
    	}
    }
    
}

