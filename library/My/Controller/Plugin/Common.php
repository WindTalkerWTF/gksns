<?php
class My_Controller_Plugin_Common extends Zend_Controller_Plugin_Abstract
{
    // route 结束时
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        // 获取模块名，如 admin，front 等
        $app = $request->getModuleName();
 		
        // bootstrap 类
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        // 加载 view
        try {	
       	 	$bootstrap->bootstrap('View');
	        $view = $bootstrap->getResource('View');
	        $appParams = $view ? $view->$app : "";
	 		if($appParams){
		        // 配置 view
		        $view->addBasePath($appParams['basePath'])
		             ->addHelperPath($appParams['helperPath'],
		                             $appParams['helperPathPrefix']);
		 
		        // 加载 layout 并配置
		        $bootstrap->bootstrap('Layout');
		        $layout = $bootstrap->getResource('Layout');
		        $layout->setLayoutPath($appParams['layoutPath'])
		               ->setLayout($appParams['layout']);
	 		}else{
				 // 加载 layout 并配置
	 			$this->_setDefaultView($bootstrap, $app);
	 		}
        }catch (Exception $e){
        	$this->_setDefaultView($bootstrap, $app);
        }
       
    }
    
    private function _setDefaultView($bootstrap, $app){
    		$defaultAppName = Zend_Controller_Front::getInstance()->getDefaultModule();
    		$appDirectory = Zend_Controller_Front::getInstance()->getModuleDirectory();
    		$defaultAppPath = Zend_Controller_Front::getInstance()->getModuleDirectory($defaultAppName);
    		$appPath=array();
    		#皮肤
    		$config = My::config()->getConfig("init", 1,1,$app);
    		$tpl = isset($config['view']['tpl']) && $config['view']['tpl'] ?  $config['view']['tpl'] : "default";
    		$appPath[] = $appDirectory.DS."views".DS.$tpl. DS. "layouts";
    		#view
    		$view = $bootstrap->getResource('View');
    		#默认
    		$defaultAppConfig = My::config()->getConfig("init", 1,1,$defaultAppName);
    		$defaulttpl =  isset($defaultAppConfig['view']['tpl']) && $defaultAppConfig['view']['tpl'] ?  $defaultAppConfig['view']['tpl'] : "default";
    		$view->addBasePath($defaultAppPath . DS . "views" . DS .$defaulttpl)
    			 ->addHelperPath($defaultAppPath . DS . "views" . DS . $defaulttpl.DS . "helpers", ucfirst($defaultAppName) . "_View_Helper_");
    		#本地
    		$view->addBasePath($appDirectory . DS . "views" . DS .$tpl)
    			   ->addHelperPath($appDirectory . DS . "views" . DS . $tpl.DS. "helpers", ucfirst($app) . "_View_Helper_");
    	
    		#设置layout
    		$controllName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
			$appName =  Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
    		$bootstrap->bootstrap('Layout');
	        $layout = $bootstrap->getResource('Layout');
			//layout
		if(Admin::service()->getCommon()->isAdminController($appName, $controllName)){
			$adminAppConfig = My::config()->getConfig("init", 1,1,"admin");
			$admintpl = isset($adminAppConfig['view']['tpl']) && $adminAppConfig['view']['tpl'] ?  $adminAppConfig['view']['tpl'] : "default";
			$appPath = APPLICATION_PATH. DS . "admin".DS."views". DS . $admintpl . DS . "layouts";
			$layoutName = "admin_layout";
		}else{
				$appNames = Admin::service()->getSys()->getAllAppNames();
				
				foreach($appNames as $v){
					if($appName == $v) continue;
					if($appName == "admin") continue;
					$appConfig = My::config()->getConfig("init", 1,1,$v);
					$appTpl = isset($appConfig['view']['tpl']) && $appConfig['view']['tpl'] ?  $appConfig['view']['tpl'] : "default";
					$appPath[] = Zend_Controller_Front::getInstance()->getModuleDirectory($v).DS."views"  .DS.$appTpl. DS . "layouts";
				}
				if($appName == $defaultAppName){
					$layoutName = "layout";
				}else{
					$layoutName = $appName."_layout";
				}
		}
		$layout->setLayoutPath($appPath)
			   ->setLayout($layoutName);
    }
    
    
}