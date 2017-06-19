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
class Home_View_Helper_Ads
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
    public function ads($key=0){
    	$str[] =stripslashes(getSysData("site.ads.golbal"));
        return $str[$key];
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
