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
class Home_View_Helper_Footer
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function footer(){
    	$this->view->baiduStat = stripslashes(Home::service()->getCommon()->getSysData("site.stat_code.baidu"));
		$this->view->cnzzStat = stripslashes(Home::service()->getCommon()->getSysData("site.stat_code.cnzz"));
		return $this->view->render("/helper/footer.php");
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
