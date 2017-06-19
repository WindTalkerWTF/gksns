<?php

class Ask_AdmController extends Admin_Controller_Action
{

    public function init(){
    }

    public function preDispatch(){}

     /********以下为自定义内容****************/
	function indexAction(){
		$title = trim($this->getRequest()->getParam("title"));
		$this->view->title = $title;
		
		$tag = trim($this->getRequest()->getParam("tag"));
		$this->view->tag = $tag;
		
		$isPublish = (int) $this->getRequest()->getParam("is_publish", -1);
		$this->view->is_publish = $isPublish;
		
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
		if($tag) $where = array("tag_name_path"=>array("like", "%,".$tag.",%"));
    	if($title) $where['title'] = array("like", "%".$title."%");
    	if($isPublish != "-1") $where['is_publish'] = $isPublish;

    	$obj = new Ask_Dao_Arc();
    	$this->view->list = $obj->gets($where, "id DESC" ,$limit, $pageSize, "", true);

    	if($this->view->list){
    		foreach($this->view->list as $k=>$v){
    			$this->view->list[$k]['user'] = User::dao()->getInfo()->get(array("id"=>$v['uid']));
    		}
    	}
//    	print_r($this->view->list);
    	$this->view->totalNum =  $obj->getTotal();
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
	}
	
	function contentEditAction(){
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->info = Ask::dao()->getArc()->get(array("id"=>$id));
		if(!$this->view->info) Admin_Tool::showMsg("数据错误", My_Tool::url("adm/index") );
		$this->view->content = Home::dao()->getArc()->get(array("arc_type"=>"ask","ref_id"=>$id));
		$this->view->id = $id;
		
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$title = trim($this->getRequest()->getParam("title"));
			$content = trim($this->getRequest()->getParam("content"));
			$tagNamePath = trim($this->getRequest()->getParam("tag_name_path"),',');
			
			$isPublish = (int) $this->getRequest()->getParam("is_publish");
			
			if(!$title) Admin_Tool::showAlert("标题必须填写!");
			if(!$tagNamePath) Admin_Tool::showAlert("标签必须必须填写!");
			
			$this->view->title = $title;
			$this->view->content = $content;
			$this->view->tag_name_path = $tagNamePath;
			$this->view->is_publish = $isPublish;
			
		    $tagArr = explode(',', $tagNamePath);
		    if(count($tagArr) > 3)  Admin_Tool::showAlert("标签个数不能大于3个!");
			
			if(!Admin_Tool::hasAlert()){
				
				$data['title'] = $title;
				$data['is_publish'] = $isPublish;
				$tagIdPath=",";
				foreach($tagArr as $k=>$v){
					$tagInfo = Home::dao()->getTag()->get(array("name"=>$v));
					$num = $k+1;
					if($tagInfo){
						$data['tag'.$num] = $tagInfo['id'];
						$tagIdPath .= $tagInfo['id'].",";
					}else{
						$TmpId = Home::dao()->getTag()->insert(array("name"=>$v));
						$data['tag'.$num] = $TmpId;
						$tagIdPath .= $TmpId.",";
					}
				}
				
				$data['tag_path'] = $tagIdPath;
				$data['tag_name_path'] = strtoupper(",".$tagNamePath.",");
				
				Ask::dao()->getArc()->update($data, array("id"=>$id));
				
				$aData['content'] = $content;
				Home::dao()->getArc()->update($aData, array("ref_id"=>$id, "arc_type"=>"ask"));
				
				Admin_Tool::showMsg("更新成功!", My_Tool::url("adm/index"));
				
			}
			
		}
	}
	function contentDeleteAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) My_Tool::request("id");
		$this->view->info = Ask::dao()->getArc()->get(array("id"=>$id));
		$this->view->content = Home::dao()->getArc()->get(array("mark"=>"ask#".$id));
		
		if(!$this->view->info || !$this->view->content) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/index"));
		
		Ask::dao()->getArc()->delete(array("id"=>$id));
		Home::dao()->getArc()->delete(array("ref_id"=>$id, "arc_type"=>"ask"));
		Home::dao()->getReply()->delete(array("ref_id"=>$id, "arc_type"=>"ask"));
		
		User::service()->getCommon()->deCrField("question_count", $this->view->info['uid']);
		
		Admin_Tool::showMsg("删除成功!", My_Tool::url("adm/index"));
	}
	
	
	//发布
	function publishAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));
		$data['is_publish'] = 1;
		Ask::dao()->getArc()->update($data, array("id"=>array("in",$ids)));
		My_Tool::showJsonp(200, "");
	}
	
	//草稿
	function nopublishAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));
		$data['is_publish'] = 0;
		Ask::dao()->getArc()->update($data, array("id"=>array("in",$ids)));
		My_Tool::showJsonp(200, "");
	}
	
	//删除
	function deletesAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));
		try{
    		$obj = new Ask_Dao_Arc();
    		$obj->startTrans();
    		#统计
    		if($ids){
    			foreach ($ids as $v){
    				$obj->getMasterDb()->exec("UPDATE user_stat SET answer_count = answer_count-1 WHERE uid = '".$v['uid']."' AND answer_count > 0");
    			}
    		}
    		$idStr = implode(",", $ids);
    		$obj->exec("DELETE FROM ask_arc WHERE id IN (".$idStr.")");
    		$obj->exec("DELETE FROM home_arc WHERE id IN (".$idStr.")");
    		
    		$obj->commit();
    		My_Tool::showJsonp(200, "");
		}catch (Exception $e){
		    $obj->rollback();
		}
	}
	

	
}

