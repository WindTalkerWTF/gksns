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
class Home_View_Helper_Showcode
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
   
    /**
     * 
     *  显示验证码
     */
    public function showcode(){
        return $this->view->render("/helper/showcode.php");
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
