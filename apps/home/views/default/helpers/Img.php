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
class Home_View_Helper_Img
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
   
   
    public function img($imgPath){
    	return My_Tool::showImg($imgPath);
    }
}
