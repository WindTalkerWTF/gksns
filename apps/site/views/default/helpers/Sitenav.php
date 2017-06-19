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
class Home_View_Helper_Sitenav
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function sitenav(){
        $this->view->appName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
        $this->view->controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $this->view->actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        
        $tree = Site::dao()->getTree()->gets(array("pid"=>0),"tree_sort ASC" ,0,8);
        $this->view->tree = $tree;
        $this->view->id = (int) Zend_Controller_Front::getInstance()->getRequest()->getParam("id");
        
		return $this->view->render("/helper/sitenav.php");
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
