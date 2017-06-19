<?php

class Admin_MenuController extends Admin_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
//    	$this->_helper->layout()->disableLayout();
//    	$this->_helper->viewRenderer->setNoRender();
    	//$this->_helper->cache(array("index"), array("sss"));
    }

     public function preDispatch(){}

     /********以下为自定义内容****************/
    
	function indexAction(){
		//分页
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	$where['pid'] = 0;
    	
    	$this->view->list = Admin::dao()->getMenu()->gets($where, "fsort asc" ,$limit, $pageSize);
    	$this->view->totalNum =  Admin::dao()->getMenu()->getCount($where);
    	
    	if($this->view->list){
    		foreach($this->view->list as $k=>$v){
    			$this->view->list[$k]['child']=Admin::dao()->getMenu()->gets(array("pid"=>$v['id']), "fsort asc");
    		}
    	}
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
	}

	function mgAction(){
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$addName = $this->getRequest()->getParam("addname");
			$addFsort = $this->getRequest()->getParam("addfsort");
			$addUrl = $this->getRequest()->getParam("addurl");
			$addPid = $this->getRequest()->getParam("addpid");
			
			if($addName){
				foreach ($addName as $k=>$v){
					if($addUrl[$k] && $addPid[$k]==0 || !$v) continue;
					$data['name'] = $v;
					$data['url'] = $addUrl[$k];
					$data['pid'] = (int) $addPid[$k];
					$data['fsort'] = (int) $addFsort[$k];
					Admin::dao()->getMenu()->insert($data);
				}
			}
			
			$name = $this->getRequest()->getParam("name");
			$fsort = $this->getRequest()->getParam("sort");
			$url = $this->getRequest()->getParam("url");
			$pid = $this->getRequest()->getParam("pid");
			
			if($name){
				foreach($name as $k=>$v){
					if($url[$k] && $pid[$k]==0 || !$v) continue;
					$id = $k;
					$data['name'] = $v;
					$data['url'] = $url[$k];
					$data['pid'] = (int) $pid[$k];
					$data['fsort'] = (int) $fsort[$k];
					Admin::dao()->getMenu()->update($data, array('id'=>$id));
				}		
		}
		My_Tool::redirect(My_Tool::url('/menu/index'));			
	}
 }
 
  function deleteAction(){
  		$this->_helper->viewRenderer->setNoRender();
  		$id = (int) $this->getRequest()->getParam("id");
  		if(!$id)  Admin_Tool::showMsg("数据不存在!", My_Tool::url("/menu/index"));
  		Admin::dao()->getMenu()->delete(array("id"=>$id));
  		Admin::dao()->getMenu()->delete(array("pid"=>$id));
  		My_Tool::redirect(My_Tool::url('/menu/index'));
  }
 
	
	
}

