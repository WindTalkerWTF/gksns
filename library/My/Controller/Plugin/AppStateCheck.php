<?php
class My_Controller_Plugin_AppStateCheck extends Zend_Controller_Plugin_Abstract
{
    // route 结束时
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {	
    	$appName= $request->getAppName();
    	$obj = Admin::dao()->getAppinfo();
		$info = My_Tool::mcached(__CLASS__."_".$appName, array($obj, "get"), array(array("name"=>$appName)));
    	if($info){
    		if(!$info['state']){
    			throw new My_Exception("页面不存在!");
    		} 
    	}
    }
    
}