<?php
class Admin_Service_Common extends Home_Service_Base{
    
	function setLogin($userInfo){
		unset($userInfo['pwd']);
		$session = new My_Session_Namespace("admin_login");
		$session->user = $userInfo;
		return true;
	}
	
	#获取登陆
	function getLogined(){
		$session = new My_Session_Namespace("admin_login");
		return $session->user;
	}
	
	
	#获取用户有效的action节点
	function getValidAction($uid){
		if(!$uid) return array();
		$roles = Admin::dao()->getMasterrole()->gets(array("user_id"=>$uid));
		if(!$roles) return array();
		$paths = array();
		$actions=array();
		
		if($roles){
			foreach($roles as $v){
				$roleId = $v['role_id'];
				$actionsTmp = Admin::dao()->getRoleaction()->gets(array("role_id"=>$roleId));
				if($actionsTmp){
					foreach($actionsTmp as $v){
						$actions[] = $v['action_id'];
					}
				}
			}
			
			$actions = $actions ? array_unique($actions): array();
			if($actions){
				$actionifno = Admin::dao()->getActions()->gets(array("id"=>array("in", $actions)));
				if($actionifno){
					foreach($actionifno as $v){
						$paths[] = $v['path'];
					}
				}
			}
			
		}
		return $paths;
	}
	
	#后台登陆检查
	function checkAdminLogin() {
		//除了不需要检测登陆的页面外，都需要检查登陆,各app管理页面也要检测
		$appName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
		$controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$controllerPath = Zend_Controller_Front::getInstance()->getControllerDirectory($appName);
		$actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
		
		if ($this->isAdminController()) {
			$user = Admin::service ()->getCommon ()->getLogined ();
			if (! $user) {
				if (My_Tool::isAjax ()) {
					My_Tool::showJson ( - 1, "请先登陆!" );
				} else {
					echo "<script>parent.location.href=\"" . My_Tool::url ( "index/login", "admin" ) . "\";</script>";
				}
			} else {
				if ($user ['role'] == 10)
					return true;
				$path = $appName . "#" . $controllerName . "#" . $actionName;
				$paths = Admin::service ()->getCommon ()->getValidAction ( $user ['id'] );
				if ((!in_array ( $path, $paths )) && $user ['role'] < 9) {
					
					$currUrl = My_Tool::getCurrentUrl();
					$ansyUrl = My_Cache::get("My_Controller_Action_Helper_Asyncaction_url");
					//异步检查
					if($ansyUrl == $currUrl) return true;
					
					if (My_Tool::isAjax ()) {
						My_Tool::showJson ( - 1, "没有权限!" );
					} else {
						Admin_Tool::showMsg ( "没有权限!");
					}
				}
			}
		}
	}
	
	#是否是后台管理工具
	function isAdminController($appName="", $controllerName=""){
		$appName = $appName ? $appName : Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
		$controllerName = $controllerName ? $controllerName : Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$controllerPath = Zend_Controller_Front::getInstance()->getControllerDirectory($appName);
		$defaultAppName = Zend_Controller_Front::getInstance()->getDefaultModule();
		
		$arr = explode('-', $controllerName);
		if($arr){
			$controllerName = "";
			foreach($arr as $v){
				$controllerName .= ucfirst($v);
			}
		}
		$controllerName .= "Controller";
		
		if(!is_file($controllerPath . '/' . ucfirst($controllerName).".php")) return false;
		include_once $controllerPath . '/' . ucfirst($controllerName).".php";
		if($appName != $defaultAppName){
			$controllerName = ucfirst($appName)."_".$controllerName;
		}
		$parentName = get_parent_class ($controllerName);
		
		return $parentName == "Admin_Controller_Action" ? true:false;
	}
	
	/**
	 *
	 * 是否是核心app
	 * @return boolean
	 */
	function isCoreApp($appName){
	    $init = My_Config::getInstance()->getInit();
	    $coreApp = $init['app']['core'];
	    return in_array($appName,$coreApp);
	}
}