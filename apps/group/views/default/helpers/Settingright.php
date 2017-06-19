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
class Group_View_Helper_Settingright
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function settingright($id){
		$this->view->id = $id;
    	//最新小组帖子
    	$this->view->arc = Group::dao()->getArc()->gets(array(),"reply_count DESC",0,7);
    	if($this->view->arc){
    		foreach ($this->view->arc as $k=>$v){
    			$uid = $v['uid'];
    			$uinfo = User::dao()->getInfo()->get(array("id"=>$uid));
    			$this->view->arc[$k]['user'] = $uinfo;
    		}
    	}
		return $this->view->render("/helper/settingright.php");
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
