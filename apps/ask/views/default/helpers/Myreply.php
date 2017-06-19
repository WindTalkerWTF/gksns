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
class Ask_View_Helper_Myreply
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
    	
    	$info = $obj->gets(array("mark"=>$mark), "reply_score desc", $limit, $pageSize, "", true);
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
    	
    	//判断是否是帮助中心
    	$tmpArr = explode("#", $mark);
    	$arcId = (int) $tmpArr[1];
    	
    	$isHelp = 0;
    	$isAsker = 0;
    	$helpStr = ",".getSysData("site.config.ask.helptag.id").",";
    	$checkTmp = Ask::dao()->getArc()->get(array("id"=>$arcId));
    	if($checkTmp){
    		if(stristr($checkTmp['tag_path'], $helpStr)){
    			$isHelp = 1;
    		}
    		
    		if($checkTmp['uid'] == $this->view->uid){
    			$isAsker = 1;
    		}
    	}
    	
    	$this->view->isHelp = $isHelp;
    	$this->view->isAsker = $isAsker;
    	
    	$this->view->isAdmin = $this->view->user['role'] > 8 ? 1:0;
    	
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
