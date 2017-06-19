<?php

class Admin_ReplyController extends Admin_Controller_Action
{

    public function init(){
    }

    public function preDispatch(){}

     /********以下为自定义内容****************/
	//评论列表 
	function replyListAction(){
		$content = trim($this->getRequest()->getParam("content"));
		$this->view->content = $content;
		
		$isPublish = (int) $this->getRequest()->getParam("is_publish", -1);
		$this->view->is_publish = $isPublish;
		
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
		$where = array();
    	if($content) $where['content'] = array("like", "%".$content."%");
    	if($isPublish != "-1") $where['is_publish'] = $isPublish;
//     	$where['arc_type'] = "site";
    	
    	$obj = new Home_Dao_Reply();
    	$this->view->list = $obj->gets($where, "id DESC" ,$limit, $pageSize, "", true);
    	$this->view->totalNum =  $obj->getTotal();
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
	}
	
	//评论发布(或解锁)
	function replyPublishAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids =  $this->getRequest()->getParam("id");
		$ids = explode(",", trim($ids, ','));
		if(!$ids) My_Tool::showJsonp(500, "数据错误!");
		
		$this->addReplyCount($ids);    
		
		$data['is_publish'] = 2;
		Home::dao()->getReply()->update($data, array("id"=>array("in",$ids)));
		My_Tool::showJsonp(200, "");
	}
	
	//评论(或加锁)
	function replyNopublishAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids =  $this->getRequest()->getParam("id");
		$ids = explode(",", trim($ids, ','));
		if(!$ids) My_Tool::showJsonp(500, "数据错误!");
		
		$this->deleteReplyCount($ids);
		
		$data['is_publish'] = 1;
		Home::dao()->getReply()->update($data, array("id"=>array("in",$ids)));
		My_Tool::showJsonp(200, "");
	}
	
	
	function deleteReplyCount($ids,$isDelete=0){
		$list = Home::dao()->getReply()->gets(array("id"=>array("in",$ids)));
		
		if($list){
			foreach ($list as $v){
				if($v['is_publish'] || $isDelete){
					if($v['arc_type'] == "ask"){
						Ask::dao()->getArc()->deCrement("answer_count",array("id"=>$v['ref_id']));
					}
			
					if($v['arc_type'] == "group"){
						Group::dao()->getArc()->deCrement("reply_count",array("id"=>$v['ref_id']));
					}
			
					if($v['arc_type'] == "site"){
						Site::dao()->getArc()->deCrement("reply_count",array("id"=>$v['ref_id']));
					}
			
					if($v['arc_type'] == "video"){
						Video::dao()->getList()->deCrement("reply_count",array("id"=>$v['ref_id']));
					}
				}
			}
		}
		return true;
	}
	
	
	function addReplyCount($ids){
		$list = Home::dao()->getReply()->gets(array("id"=>array("in",$ids)));
	
		if($list){
			foreach ($list as $v){
				if(!$v['is_publish']){
					if($v['arc_type'] == "ask"){
						Ask::dao()->getArc()->inCrease("answer_count",array("id"=>$v['ref_id']));
					}
						
					if($v['arc_type'] == "group"){
						Group::dao()->getArc()->inCrease("reply_count",array("id"=>$v['ref_id']));
					}
						
					if($v['arc_type'] == "site"){
						Site::dao()->getArc()->inCrease("reply_count",array("id"=>$v['ref_id']));
					}
						
					if($v['arc_type'] == "video"){
						Video::dao()->getList()->inCrease("reply_count",array("id"=>$v['ref_id']));
					}
				}
			}
		}
		return true;
	}
	
	function replyDeletesAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));
		
		$this->deleteReplyCount($ids,1);
		
		Home::dao()->getReply()->delete(array("id"=>array("in",$ids)));
		if(My_tool::isAjax()){
			My_Tool::showJsonp(200, "");
		}else{
			Admin_Tool::showMsg("删除成功",  My_Tool::url("reply/reply-list"));
		}
	}
	
	
	
	
}

