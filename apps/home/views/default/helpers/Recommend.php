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
class Home_View_Helper_Recommend
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
    public function recommend($id,$type){
        $list = array();
        $isMy = getSysData('site.my.recommend');
       if($isMy){
           $list = Home::service()->getCommon()->getRecommend($id,$type);
       }else{
           $objTmp = Home::service()->getCommon()->getTypeObj($type);
           if(!$objTmp) return "";
           list($obj,$urltype) = $objTmp;

           $this->view->urlType = $urltype;
           $this->view->rinfo = $obj->get(array("id"=>$id));
       }
        $this->view->list = $list;
        $this->view->isMy = $isMy;

        return $this->view->render("/helper/recommend.php");
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
