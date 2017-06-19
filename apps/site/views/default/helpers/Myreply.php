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
class Site_View_Helper_Myreply
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function myreply($mark){
    	$this->view->appName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
    	$this->view->controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    	$this->view->actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
    	
    	$this->view->user = User::service()->getCommon()->getLogined();
    	$this->view->uid = isset($this->view->user['id']) ? $this->view->user['id'] :0;
    	
    	$page = (int) Zend_Controller_Front::getInstance()->getRequest()->getParam("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
    	
    	$obj = new Home_Dao_Reply();
    	
    	$info = $obj->gets(array("mark"=>$mark), "created_at ASc", $limit, $pageSize, "", true);
    	$count = $obj->getTotal();
    	
    	if($info){
    		$uids = array();
    		foreach ($info as $v){
    			$uids[] = $v['uid'];
    		}
    		
    		$users = User::dao()->getInfo()->gets(array("id"=>array("in", $uids)));
    		foreach ($info as $k=>$v){
    			foreach ($users as $uv){
    				if($v['uid'] == $uv['id']){
    					$info[$k]['user'] = $uv;
    				}
    			}
    		}
    	}
    	
    	$this->view->list = $info;
    	$this->view->totalNum = $count;
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	$this->view->lou = ($page-1)*$pageSize;
    	$this->view->mark = $mark;
		return $this->view->render("/helper/myreply.php");
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
