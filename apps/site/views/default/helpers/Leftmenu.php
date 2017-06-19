<?php
require_once 'Zend/View/Interface.php';
/**
 * Truncate helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Site_View_Helper_Leftmenu
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function leftmenu(){
    	$this->view->tree = Site::dao()->getTree()->gets(array("pid"=>0));
    	$this->view->id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
		return $this->view->render("/helper/leftmenu.php");
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
