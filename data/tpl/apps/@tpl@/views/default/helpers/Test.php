<?php
require_once 'Zend/View/Interface.php';
/**
 * Truncate helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class @Tpl@_View_Helper_Test
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function test(){
    	//return $this->view->render("/helper/leftmenu.php");
		return "@Tpl@ test";
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
