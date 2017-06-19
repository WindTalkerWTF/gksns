<?php
class My_Controller_Action_Helper_Mypagehtml extends Zend_Controller_Action_Helper_Abstract {
    
	private $appName = null;
	private $controllerName = null;
	private $actionName = null;
	private $isTodo = 0;
	private $actions = null;
	
	function direct($actions){
		$this->actions = $actions;
	}
	
	function preDispatch(){
//		echo "pre";
		$this->actionName = $this->getRequest()->getActionName();
		
		if(in_array($this->actionName, $this->actions)){
			$this->appName = $this->getRequest()->getModuleName();
// 			ob_start();
			ob_start(array($this, '_flush'));
			$this->isTodo = 1;
		}
	}
	
	function postDispatch(){
		
		if($this->isTodo){
	   		ob_start(array($this, '_flush'));
	        ob_implicit_flush(false);
		}
	}
	
	function _flush($data){
		
		//网址处理
		$url = $_SERVER['REQUEST_URI'];
		$urlArr = array();
		$urlPath = "";
		$urlName="";
		$url = $url == "/" ? "" : $url;
		
		if($url){
			$urlArr = explode('/', $url);
			if(!isset($urlArr[2]) || !$urlArr[2]){
				$urlName = $this->actionName;
				$urlPath = strrpos($url, "/") == 0 ? $url."/":$url;
			}else{
				$urlName = end($urlArr);
				$urlPath = substr($url,0, strlen($url)-strlen($urlName));
			}
		}else{
			$urlName = "index";
		}
		$urlPath = ltrim($urlPath, "/");
//		return $urlPath;
		//网址处理
		$path =  ROOT_DIR . "/html/". $this->appName . "/" . $urlPath;
		mkdir($path, "0777", true);
		$filename = $path . $urlName . ".html";
		file_put_contents($filename, $data);
		return $filename;
//		return $data;
	}

}