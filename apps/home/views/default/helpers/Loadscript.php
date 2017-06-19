<?php
/**
 *
 * @author Administrator
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Loadscript helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Home_View_Helper_Loadscript {
	
	/**
	 * @var Zend_View_Interface 
	 */
	public $view;
	
	#加载
	function loadscript($path=''){
		
		if(!$path) return $this->mLoadjs();
		return $this->loadscriptTmp($path);
	}
	
	#加载实际
	function loadscriptTmp($path=''){
        if(!$path) return "";
		$baseUrl = $this->getBaseUrl();
		$baseUrl = $baseUrl."/res/";
		$path = $baseUrl . ltrim($path, "/");
		$fullPath = ROOT_DIR . $path;
		
		$v = getSysData('static_version');
		
//		$pathinfo = pathinfo($path);
//		$ext = isset($pathinfo['extension']) ? strtolower($pathinfo['extension']):"";
		$ext = explode('.', $path);
        $ext = $ext[count($ext)-1];
        if($ext == "js"){
			return "
			<script src=\"".$path."?v=".$v.".js\"></script>
			";
		}elseif($ext == "css"){
			return "
			<link rel=\"stylesheet\" type='text/css' href=\"".$path."?v=".$v.".css\"/>
			";
		}
	}
	
	
	#缓存结果
	function mLoadjs(){
		return $this->loadjs();
	}
	
	#创建默认js
 	public function loadjs(){
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$baseUrl = $this->getBaseUrl();
		
        $filePath = $baseUrl.'/res/asset/'.$request->getModuleName()."/js/". $request->getControllerName();
		$fileUri = $filePath . "/" . $request->getActionName() .'.js';
		

		$version = getSysData('static_version');
        return "
        <script src=\"".$fileUri."?v=" . $version .".js\"></script>
        ";
    }
	
    function getBaseUrl(){
    	$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
    	$baseUrl = str_replace("/index.php", "", $baseUrl);
    	return $baseUrl;
    }
	
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}
}
