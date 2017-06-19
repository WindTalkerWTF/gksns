<?php
/**
 * 
 * 检查登录
 * @author kaihui_wang
 *
 */
class User_Controller_Action_Helper_Logined extends Zend_Controller_Action_Helper_Abstract {
	private $actionName = null;
	private $actions = null;
	
	#获取外部传入数据
	function direct($actions){
		$this->actions = $actions;
	}
	
	function preDispatch(){
		$this->actionName = $this->getRequest()->getActionName();
		if(in_array($this->actionName, $this->actions)){
			//执行前检查
			$backurl = My_Tool::url("index/login","user");
			$user = User::service()->getCommon()->getLogined();
			$ref = rawurlencode(My_Tool::getRef());
			$backurl = $ref ? $backurl."?ref=".$ref : $backurl;
			if(!$user){
				if(My_Tool::isAjax()){
					My_Tool::showJsonp(500, "请先登录!&nbsp;&nbsp;<a href='".$backurl."'>点击登录<\/a>");
				}else{
					My_Tool::showMsg("请先登录!",$backurl);
				}
			}
		}
	}
	
}