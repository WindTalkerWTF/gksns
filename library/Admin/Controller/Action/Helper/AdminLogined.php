<?php
/**
 * 
 * 检查后台登录
 * @author kaihui_wang
 *
 */
class Admin_Controller_Action_Helper_AdminLogined extends Zend_Controller_Action_Helper_Abstract {
    
	#获取外部传入数据
	function direct(){
		
	}
	
	function preDispatch(){
		Admin::service()->getCommon()->checkAdminLogin();
	}
	
}