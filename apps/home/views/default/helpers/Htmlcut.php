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
class Home_View_Helper_Htmlcut
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function htmlcut($string, $length, $htmltags=",br,hr,input,img,p,div", $dot="..."){
		$str = My_Tool::htmlCut($string, $length, $htmltags);
		if($dot) $str .= $dot;
		return $str;
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
