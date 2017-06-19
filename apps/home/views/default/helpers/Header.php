<?php
/**
 *
 * @author kaihui_wang
 * @version 
 */
require_once 'Zend/View/Interface.php';
/**
 * Truncate helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Home_View_Helper_Header
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function header(){
    	$this->view->appName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
    	$this->view->controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    	$this->view->actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
    	
    	$this->view->user = User::service()->getCommon()->getLogined();
    	$defaultAppPath = Home::service()->getCommon()->getDefaultDirectory();
		return $this->view->render("/helper/header.php");
    }
    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
