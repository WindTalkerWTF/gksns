<?php

class Group_AdmController extends Admin_Controller_Action
{

    public function init(){
    }

    public function preDispatch(){}

     /********以下为自定义内容****************/
	function indexAction(){
		$this->view->treeList = Home::dao()->getTree()->gets();
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
		$where = array();
		
	   	$id = (int) $this->getRequest()->getParam("id");
	   	if($id !='-1' && $id) $where['tree_id']  = $id;
	   	$this->view->id = $id;
	   	
	   	$name = trim($this->getRequest()->getParam("name"));
	   	if($name) $where['name']  = array("like", "%".$name."%");
	   	$this->view->name = $name;
	   	
	   	$groupStatus = (int) $this->getRequest()->getParam("group_status",-1);
	   	if($groupStatus != '-1') $where['group_status']  = $groupStatus;
	   	$this->view->groupStatus = $groupStatus;
		
	
		$obj = new Group_Dao_Info();
    	$this->view->list = $obj->gets($where, "id DESC" ,$limit, $pageSize, "", true);
    	$this->view->totalNum =  $obj->getTotal();
    	
    	if($this->view->list){
    		foreach($this->view->list as $k=>$v){
    			$uid = $v['uid'];
    			$user = User::dao()->getInfo()->get(array("id"=>$uid));
    			$this->view->list[$k]['user'] = $user;
    			$cate = Home::dao()->getTree()->get(array("id"=>$v['tree_id']));
    			$this->view->list[$k]['cate'] = $cate;
    		}
    	}
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
	}
	
	
	function groupAddAction(){
		$this->view->treeList = Home::dao()->getTree()->gets();
		
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$name = trim($this->getRequest()->getParam("name"));
			$descr = trim($this->getRequest()->getParam("descr"));
			$tree = (int) $this->getRequest()->getParam("tree");
			
			$status = (int) $this->getRequest()->getParam("status");
			
			$file = $_FILES['face']['tmp_name'];
			if(!$name) Admin_Tool::showAlert("名称必须填写!");
			$this->view->name = $name;
			$this->view->descr = $descr;
			$this->view->tree = $tree;
			$this->view->status = $status;
			
			if(!Admin_Tool::hasAlert()){
				if($file){
					//上传图片
					$savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "group" . DS . "face" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
					$imgPaths = Home::service()->getCommon()->upImg($savePath);
					$imgPath =  "/res/upload/group/face/" . date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
					//截图
					$oldPath = $savePath . $imgPaths[0]['savename'];
					Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24"));
				}
				$adminUser = Admin::service()->getCommon()->getLogined();
				$data['name'] = $name;
				$data['uid'] = $adminUser['id'];
				$data['descr'] = $descr;
				$data['tree_id'] = $tree;
				$data['group_status'] = $status;
				$data['created_at'] = date('Y-m-d H:i:s');
				
				if($file) $data['face'] = $imgPath;
				
				$insertId = Group::dao()->getInfo()->insert($data);
				#加入会员
				$idata['uid'] = $adminUser['id'];
				$idata['group_id'] = $insertId;
				$idata['user_type'] = 10;
				Group::dao()->getUser()->insert($idata);
				#人员数量自增
				Group::dao()->getInfo()->inCrease("user_number", array("id"=>$insertId));
				#会员小组自增
				if($status) User::service()->getCommon()->inCrField("group_count", $adminUser['id']);
				#tree 自增
				Home::dao()->getTree()->inCrease("group_count", array("id"=>$tree));



				Admin_Tool::showMsg("添加成功!", My_Tool::url("adm/index"));
				
			}
			
		}
	}
	
	
	function groupEditAction(){
		$this->view->treeList = Home::dao()->getTree()->gets();
		
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->info = Group::dao()->getInfo()->get(array("id"=>$id));
		if(!$this->view->info) Admin_Tool::showMsg("数据错误", My_Tool::url("adm/index") );
		$this->view->id = $id;
		
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$name = trim($this->getRequest()->getParam("name"));
			$descr = trim($this->getRequest()->getParam("descr"));
			$tree = (int) $this->getRequest()->getParam("tree");
			
			
			$status = (int) $this->getRequest()->getParam("status");
			
			$file = $_FILES['face']['tmp_name'];
			if(!$name) Admin_Tool::showAlert("名称必须填写!");
			$this->view->name = $name;
			$this->view->descr = $descr;
			$this->view->tree = $tree;
			$this->view->status = $status;
			
			if(!Admin_Tool::hasAlert()){
				if($file){
					//上传图片
					$savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "group" . DS . "face" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
					$imgPaths = Home::service()->getCommon()->upImg($savePath);
					$imgPath =  "/res/upload/group/face/" . date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
					//截图
					$oldPath = $savePath . $imgPaths[0]['savename'];
					Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24"));
				}
				
				$data['name'] = $name;
				$data['descr'] = $descr;
				$data['tree_id'] = $tree;
				$data['group_status'] = $status;
				
				if($file) $data['face'] = $imgPath;
				
				Group::dao()->getInfo()->update($data, array("id"=>$id));
				if($this->view->info['group_status']!=$status){
					if($status){ 
						User::service()->getCommon()->inCrField("group_count", $this->view->info['uid']);
					}else{
						User::service()->getCommon()->deCrField("group_count", $this->view->info['uid']);
					}
				}
				#tree 自增
				Home::dao()->getTree()->deCrement("group_count", array("id"=>$this->view->info['tree_id']));
				Home::dao()->getTree()->inCrease("group_count", array("id"=>$tree));
				
				Admin_Tool::showMsg("更新成功!", My_Tool::url("adm/index"));
				
			}
			
		}
	}
	
	
	function groupDelAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->info = Group::dao()->getInfo()->get(array("id"=>$id));
		if(!$this->view->info) Admin_Tool::showMsg("数据错误", My_Tool::url("adm/index") );
		Group::dao()->getInfo()->delete(array("id"=>$id));
		User::service()->getCommon()->deCrField("group_count", $this->view->info['uid']);
		Admin_Tool::showMsg("删除成功!", My_Tool::url("adm/index"));
	}
	//arc
	function contentListAction(){
		$id = (int) My_Tool::request("id");
		$this->view->id = $id;
		$title = trim($this->getRequest()->getParam("title"));
		$this->view->title = $title;
		$isPublish = (int) $this->getRequest()->getParam("is_publish", -1);
		$this->view->is_publish = $isPublish;
		
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
		if($id >0) $where = array("group_id"=>$id);
    	if($title) $where['title'] = array("like", "%".$title."%");
    	if($isPublish != "-1") $where['is_publish'] = $isPublish;
    	$obj = new Group_Dao_Arc();
    	$this->view->list = $obj->gets($where, "id DESC" ,$limit, $pageSize, "", true);

    	if($this->view->list){
    		foreach($this->view->list as $k=>$v){
    			$this->view->list[$k]['group'] = Group::dao()->getInfo()->get(array("id"=>$v['group_id']));
    			$this->view->list[$k]['user'] = User::dao()->getInfo()->get(array("id"=>$v['uid']));
    		}
    	}
//    	print_r($this->view->list);
    	$this->view->totalNum =  $obj->getTotal();
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
	}
	
	function contentEditAction(){
		$id = (int) My_Tool::request("id");
		$this->view->id = $id;

		$this->view->info = Group::dao()->getArc()->get(array("id"=>$id));
		$this->view->content = Home::dao()->getArc()->get(array("mark"=>"group#".$id));
		
		if(!$this->view->info ) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/content-list"));
		
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$title = trim($this->getRequest()->getParam("title"));
			$content = $this->getRequest()->getParam("content");
			if(!$title) Admin_Tool::showAlert("标题必须填写!");
			if(!$content) Admin_Tool::showAlert("内容必须填写!");
			$isPublish = (int) $this->getRequest()->getParam("is_publish");
			$positionArr = $this->getRequest()->getParam("position");
			$content = My_Tool::getContentImg($content, true);
            $file = $_FILES['face']['tmp_name'];
			$position = 0;
			if($positionArr){
				$position = ','.implode(',', $positionArr).',';
			}
			
			$this->view->title = $title;
			$this->view->contentTmp = $content;
			$this->view->is_publish = $isPublish;
			$this->view->position = $position;
			if(!Admin_Tool::hasAlert()){

                if($file){
                    //上传图片
                    $savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "group" . DS . "arc" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
                    $imgPaths = Home::service()->getCommon()->upImg($savePath);
                    $imgPath =  "/res/upload/group/arc/" . date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
                    //截图
                    $oldPath = $savePath . $imgPaths[0]['savename'];
                    Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24","330x330"));
                }

                if(!$imgPath){
                    $hrefs = My_Tool::getImgPath($content);
                    $imgPath = isset($hrefs[0]) ? $hrefs[0] :'';
                }
                $face = $imgPath;
				$data['title'] = $title;
				$data['is_publish'] = $isPublish;
				$data['position'] = $position;
				$data['last_action_at'] = date('Y-m-d H:i:s');
                $data['face'] = $face;

				Group::dao()->getArc()->update($data, array("id"=>$id));
				$aData['content'] = $content;
				Home::dao()->getArc()->update($aData, array("ref_id"=>$id, "arc_type"=>"group"));

                Home::service()->getCommon()->editTags($this->view->info['title'],$this->view->content['content'],
                    $title,$content,$id,2);

                if($isPublish){
                    Home::dao()->getTagext()->update(array("is_public"=>1),array("obj_type"=>2,"obj_id"=>$id));
                }else{
                    Home::dao()->getTagext()->update(array("is_public"=>0),array("obj_type"=>2,"obj_id"=>$id));
                }

				Admin_Tool::showMsg("编辑成功!", My_Tool::url("adm/content-list/id/". $this->view->info['group_id']));
			}
		}
	}
	function contentDeleteAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) My_Tool::request("id");
		$this->_delete($id);
		
		Admin_Tool::showMsg("删除成功!", My_Tool::url("adm/content-list"));
	}


    function _delete($id){
        try{
            $obj = new Group_Dao_Arc();
            $obj->startTrans();
            $info = Group::dao()->getArc()->get(array("id"=>$id));
            $content = Home::dao()->getArc()->get(array("mark"=>"group#".$id));

            if(!$info || !$content) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/content-list"));

            Group::dao()->getArc()->delete(array("id"=>$id));
            Home::dao()->getArc()->delete(array("id"=>$id, "arc_type"=>"group"));

            #统计
            User::service()->getCommon()->deCrField("group_arc_count", $info['uid']);
            Group::dao()->getInfo()->deCrement("arc_count", array("id"=>$info['group_id'],"arc_count"=>array(">",0)));

            Home::service()->getCommon()->deleteTags($info['title'],$content['content'],$id,2);
            $obj->commit();
        }catch(Exception $e){
            $obj->rollback();
        }
    }

	
	//发布
	function publishAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));
		$data['is_publish'] = 1;
		Group::dao()->getArc()->update($data, array("id"=>array("in",$ids)));
        Home::dao()->getTagext()->update(array("is_public"=>1),array("obj_type"=>2,"obj_id"=>array("in",$ids)));
		My_Tool::showJsonp(200, "");
	}
	
	//屏蔽
	function nopublishAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));
		$data['is_publish'] = 0;
		Group::dao()->getArc()->update($data, array("id"=>array("in",$ids)));
        Home::dao()->getTagext()->update(array("is_public"=>0),array("obj_type"=>2,"obj_id"=>array("in",$ids)));
		My_Tool::showJsonp(200, "");
	}
	
	//删除
	function deletesAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));

        foreach($ids as $id){
            $this->_delete($id);
        }

		My_Tool::showJsonp(200, "");
	}
}

