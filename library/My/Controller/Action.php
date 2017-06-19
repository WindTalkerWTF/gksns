<?php
abstract class My_Controller_Action extends Zend_Controller_Action
{
	function getParam($param,$default=null){
		return $this->getRequest()->getParam($param,$default);
	}
	
	function getParams(){
		return $this->getRequest()->getParams();
	}
	
	function p($param,$default=null){
		$filter = new Zend_Filter_HtmlEntities();
		$result = $this->getRequest()->getParam($param,$default);
		return $result ? $filter->filter($result):null;
	}
	
	
	function showMsg($msg='', $href='',$isJs=0, $goUrl="/index/msg",$appName="home"){
		My_Tool::showMsg($msg, $href,$isJs, $goUrl,$appName);
	}
	
	
	function getCookieParam($param,$default=""){
		return My_Tool::request($param,$default);
	}
	
	function url($str, $appName=0, $name = "default", $reset = true, $encode = true){
		return My_Tool::url($str,$appName,$name,$reset,$encode);
	}
	
	function isPost(){
		return My_Tool::isPost();
	}
	
	/**
	 * 
	 * 用jquery的ajax方法时有效
	 */
	function isAjax(){
		return My_Tool::isAjax();
	}
}

