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
class Home_View_Helper_Cut
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
   
    /**
     * 
     * 文本截取
     * @param unknown_type $text
     * @param unknown_type $length
     */
    public function cut($text,$length,$tail="..."){
    	if(!$text) return false;
        $viewTitle = My_Tool::my_substr($text,0,$length);
        echo $viewTitle!=$text ? $viewTitle.$tail:$viewTitle;
//    	echo mb_strlen($text,'utf-8') > $length ? mb_substr($text, 0,$length,'utf-8').$tail:$text;
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
