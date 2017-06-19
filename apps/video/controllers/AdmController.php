<?php

class Video_AdmController extends Admin_Controller_Action
{

    public function init(){
    }

    public function preDispatch(){}

     /********以下为自定义内容****************/
/********以下为自定义内容****************/
	function indexAction(){
		$this->view->list = Video::service()->getCommon()->getViewTrees();
	}
	
	#添加树
	function addTreeAction(){
		$this->view->treeList = Video::service()->getCommon()->getViewTrees();
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$name = trim($this->getRequest()->getParam("name"));
			$descr = $this->getRequest()->getParam("descr");
			$pid = (int) $this->getRequest()->getParam("pid");
		    $fsort = (int) $this->getRequest()->getParam("fsort");
		    if(!$name) Admin_Tool::showAlert("名称不能为空!");
		    $imgPath ="";
		    if($_FILES['face']['tmp_name']){
				//上传图片
				$savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "video" . DS . "tree" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
				$imgPaths = Home::service()->getCommon()->upImg($savePath);
				$imgPath =  "/res/upload/video/tree/" . date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
				//截图
				$oldPath = $savePath . $imgPaths[0]['savename'];
				Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24"));
		    }
			if(!Admin_Tool::hasAlert()){
			    $data['name'] = $name;
			    $data['face'] = $imgPath;
			    $data['descr'] = $descr;
			    $data['pid'] = $pid;
			    $data['tree_sort'] = $fsort;
			    $data['created_at'] = date('Y-m-d H:i:s');
			    Video::dao()->getTree()->insert($data);
			    Admin_Tool::showMsg("操作成功!", My_Tool::url("adm/index"));
		    }
		}
	}
	
	//编辑tree
	function editTreeAction(){
		$id = (int) $this->getRequest()->getParam("id");
		
		if(!$id) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/index"));
		
		$this->view->info = Video::dao()->getTree()->get(array("id"=>$id));
	
		if(!$this->view->info) Admin_Tool::showMsg("数据不存在!", My_Tool::url("adm/index"));
		
		$this->view->treeList = Video::service()->getCommon()->getViewTrees();
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$name = trim($this->getRequest()->getParam("name"));
			$descr = $this->getRequest()->getParam("descr");
			$pid = (int) $this->getRequest()->getParam("pid");
		    $fsort = (int) $this->getRequest()->getParam("fsort");
		    if(!$name) Admin_Tool::showAlert("名称不能为空!");
		   
		    $imgPath ="";
		    if($_FILES['face']['tmp_name']){
		    	//上传图片
					$savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "site" . DS . "tree" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
					$imgPaths = Home::service()->getCommon()->upImg($savePath);
					$imgPath =  "/res/upload/site/tree/" . date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
					//截图
					$oldPath = $savePath . $imgPaths[0]['savename'];
					Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24"));
		    }
			 if(!Admin_Tool::hasAlert()){
			    $data['name'] = $name;
			    if($imgPath) $data['face'] = $imgPath;
			    $data['descr'] = $descr;
			    $data['pid'] = $pid;
			    $data['tree_sort'] = $fsort;
			    $data['created_at'] = date('Y-m-d H:i:s');
			    Video::dao()->getTree()->update($data, array("id"=>$id));
			    Admin_Tool::showMsg("操作成功!", My_Tool::url("adm/index"));
		    }
		}
		
	}
	
	//删除tree
	function deleteTreeAction(){
		$this->_helper->viewRenderer->setNoRender();
	    $id = (int) $this->getRequest()->getParam("id");
		
		if(!$id) My_Tool::showMsg("数据错误!", My_Tool::url("adm/index"));
		
		$this->view->info = Video::dao()->getTree()->get(array("id"=>$id));
	
		if(!$this->view->info) Admin_Tool::showMsg("数据不存在!", My_Tool::url("adm/index"));
		
		Video::dao()->getTree()->delete(array("id"=>$id));
		
		Admin_Tool::showMsg("操作成功!", My_Tool::url("adm/index"));
	}
	
	/**
	 * 内容列表
	 */
	function contentListAction(){
		$this->view->treeList = Video::service()->getCommon()->getViewTrees();
		$id = (int) My_Tool::request("id");
		
		$this->view->id = $id;
		$title = trim($this->getRequest()->getParam("title"));
		$this->view->title = $title;
		$isPublish = (int) $this->getRequest()->getParam("is_publish", -1);
		$this->view->is_publish = $isPublish;
		
		if(!$id) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/index"));
		
		$page = (int) My_Tool::request("page",1);
		$page = $page ? $page : 1;
		$pageSize = 10;
		 
		$limit = $pageSize * ($page-1);
		$where = array();
		if($id != '-1') {
			$ids = Video::service()->getCommon()->getChildTreeIds($id);
			$ids[] = $id;
			$where = array("tree_id"=>array("in", $ids));
		}
		if($title) $where['title'] = array("like", "%".$title."%");
		if($isPublish != "-1") $where['is_publish'] = $isPublish;
		$obj = Video::dao()->getList();
		$this->view->list = $obj->gets($where, "tree_id ASC,id DESC" ,$limit, $pageSize, "", true);
		if($this->view->list){
			foreach($this->view->list as $k=>$v){
				$this->view->list[$k]['p'] = explode(',', trim($v['position'],','));
				$this->view->list[$k]['tree'] = Site::dao()->getTree()->get(array("id"=>$v['tree_id']));
			}
		}
		$this->view->totalNum =  $obj->getTotal();
		$this->view->page = $page;
		$this->view->pageSize = $pageSize;
	}
	
	//内容添加
	function contentAddAction(){
	
		$this->view->treeList = Video::service()->getCommon()->getViewTrees();
		$pid = (int) My_Tool::request("id");
		$this->view->id = $pid;
	
		if(!$pid) Admin_Tool::showMsg("数据错误!", Admin_Tool::url("adm/content-add"));
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$title = trim($this->getRequest()->getParam("title"));
			$file = $_FILES['face']['tmp_name'];
			$descr = $this->getRequest()->getParam("descr");
			$isPublish = (int) $this->getRequest()->getParam("is_publish");
			$positionArr = $this->getRequest()->getParam("position");
			$author = $this->getParam("author");
			$role = $this->getParam("role");
			$publish_date = $this->getParam("publish_date");
			$area = $this->getParam("area");
			$fsort = $this->getParam("fsort");
			$ftype = $this->getParam("ftype");
			$grade = $this->getParam("grade");
			$content = $this->getParam("content");
				
			$position = 0;
			if($positionArr){
				$position = ','.implode(',', $positionArr).',';
			}
            $grade = number_format(floatval($grade),1);
            $this->view->title = $title;
			$this->view->author = $author;
			$this->view->role = $role;
			$this->view->publish_date = $publish_date;
			$this->view->area = $area;
			$this->view->fsort = $fsort;
			$this->view->descr = $descr;
			$this->view->is_publish = $isPublish;
			$this->view->position = $position;
			$this->view->ftype = $ftype;
			$this->view->grade = $grade;
			$this->view->content = $content;
			
				
			if(!$title) Admin_Tool::showAlert("标题必须填写!");
			if(!$descr) Admin_Tool::showAlert("简介必须填写!");
			$content = My_Tool::getContentImg($content, true);
			if(!Admin_Tool::hasAlert()){
				$imgPath = 0;
				if($file){
					//上传图片
					$savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "video" . DS . "arc" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
					$imgPaths = Home::service()->getCommon()->upImg($savePath);
					$imgPath =  "/res/upload/video/arc/" . date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
					//截图
					$oldPath = $savePath . $imgPaths[0]['savename'];
					Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24","330x330","120x170"));
				}
	
	
				$adminUser = Admin::service()->getCommon()->getLogined();
	
				if(!$imgPath){
					$hrefs = My_Tool::getImgPath($descr);
					$imgPath = isset($hrefs[0]) ? $hrefs[0] :'';
				}
	
				$data['title'] = $title;
				$data['role'] = $role;
				$data['author'] = $author;
				$data['publish_date'] = $publish_date;
				$data['area'] = $area;
				$data['fsort'] = $fsort;
				$data['tree_id'] = $pid;
				$data['uid'] = $adminUser['id'];
				$data['grade'] = $grade;
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['content'] = $content;
				if($imgPath) $data['face'] = $imgPath;
				$data['descr'] = $descr;
				$data['ftype'] = $ftype;
				$data['position'] = $position;
				$data['is_publish'] = $isPublish;
				$data['updated_at'] = date('Y-m-d H:i:s');
				$id = Video::dao()->getList()->insert($data);

                Home::service()->getCommon()->addTags($title,$content,$id,3);
	
				Admin_Tool::showMsg("添加成功!", My_Tool::url("adm/content-list/id/" . $pid));
			}
		}
	}
	
	//内容编辑
	function contentEditAction(){
		$this->view->treeList = Video::service()->getCommon()->getViewTrees();
		$id = (int) My_Tool::request("id");
		$this->view->id = $id;
		
		$pid = (int) My_Tool::request("pid");
		$this->view->pid = $pid;
	
		$this->view->info = Video::dao()->getList()->get(array("id"=>$id));
		
		if(!$this->view->info) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/content-list"));
	
		if(My_Tool::isPost()){
		
			$this->_helper->viewRenderer->setNoRender();
			$title = trim($this->getRequest()->getParam("title"));
			$file = $_FILES['face']['tmp_name'];
			$descr = $this->getRequest()->getParam("descr");
			$isPublish = (int) $this->getRequest()->getParam("is_publish");
			$positionArr = $this->getRequest()->getParam("position");
			$author = $this->getParam("author");
			$role = $this->getParam("role");
			$publish_date = $this->getParam("publish_date");
			$area = $this->getParam("area");
			$fsort = $this->getParam("fsort");
			$ftype = $this->getParam("ftype");
			$grade = $this->getParam("grade");
			$content = $this->getParam("content");
				
			$position = 0;
			if($positionArr){
				$position = ','.implode(',', $positionArr).',';
			}
            $grade = number_format(floatval($grade),1);
			$this->view->title = $title;
			$this->view->author = $author;
			$this->view->role = $role;
			$this->view->publish_date = $publish_date;
			$this->view->area = $area;
			$this->view->fsort = $fsort;
			$this->view->descr = $descr;
			$this->view->is_publish = $isPublish;
			$this->view->position = $position;
			$this->view->ftype = $ftype;
			$this->view->grade = $grade;
			$this->view->content = $content;
				
			if(!$title) Admin_Tool::showAlert("标题必须填写!");
			if(!$descr) Admin_Tool::showAlert("简介必须填写!");
			$content = My_Tool::getContentImg($content, true);
			if(!Admin_Tool::hasAlert()){
				$imgPath = 0;
				if($file){
					//上传图片
					$savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "video" . DS . "arc" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
					$imgPaths = Home::service()->getCommon()->upImg($savePath);
					$imgPath =  "/res/upload/video/arc/" . date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
					//截图
					$oldPath = $savePath . $imgPaths[0]['savename'];
					Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24","330x330","120x170"));
				}
	
	
				$adminUser = Admin::service()->getCommon()->getLogined();
	
				if(!$imgPath){
					$hrefs = My_Tool::getImgPath($descr);
					$imgPath = isset($hrefs[0]) ? $hrefs[0] :'';
				}
	
				$data['title'] = $title;
				$data['role'] = $role;
				$data['author'] = $author;
				$data['publish_date'] = $publish_date;
				$data['area'] = $area;
				$data['fsort'] = $fsort;
				$data['tree_id'] = $pid;
				$data['grade'] = $grade;
				$data['content'] = $content;
				$data['uid'] = $adminUser['id'];
				$data['created_at'] = date('Y-m-d H:i:s');
				if($imgPath) $data['face'] = $imgPath;
				$data['descr'] = $descr;
				$data['ftype'] = $ftype;
				$data['position'] = $position;
				$data['is_publish'] = $isPublish;
				$data['updated_at'] = date('Y-m-d H:i:s');
				
				Video::dao()->getList()->update($data, array("id"=>$id));

                Home::service()->getCommon()->editTags($this->view->info['title'],$this->view->info['content'],
                    $title,$content,$id,3);

                if($isPublish){
                    Home::dao()->getTagext()->update(array("is_public"=>1),array("obj_type"=>3,"obj_id"=>$id));
                }else{
                    Home::dao()->getTagext()->update(array("is_public"=>0),array("obj_type"=>3,"obj_id"=>$id));
                }
				
				Admin_Tool::showMsg("编辑成功!", My_Tool::url("adm/content-list/id/". $this->view->info['tree_id']));
			}
		}
	
	}
	
	
	
	//内容删除
	function contentDeleteAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) My_Tool::request("id");

        $this->_delete($id);
		 
		Admin_Tool::showMsg("删除成功!", My_Tool::url("adm/content-list"));
	}

    function _delete($id){
        try{
            $obj = new Video_Dao_List();
            $obj->startTrans();
            $this->view->info = Video::dao()->getList()->get(array("id"=>$id));

            if(!$this->view->info) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/content-list"));

            Video::dao()->getList()->delete(array("id"=>$id));
            Video::dao()->getDetail()->delete(array("list_id"=>$id));

            Home::service()->getCommon()->deleteTags($this->view->info['title'],$this->view->info['content'],$id,3);

            $obj->commit();
        }catch (Exception $e){
            $obj->rollback();
        }
    }
	
	/**
	 *
	 * 选择树
	 */
	function selectTreeAction(){
		$id = (int) $this->getRequest()->getParam("id");
		$treeId = $this->getRequest()->getParam("treeId");
		$this->view->id = $id;
	
		$this->view->info = Site::dao()->getArc()->get(array("id"=>$id));
	
		if(!$this->view->info ||!$treeId) My_Tool::showJsonp(500,"数据错误!");
	
		$data['tree_id'] = $treeId;
		Video::dao()->getList()->update($data, array("id"=>$id));
		My_Tool::showJsonp(200,"操作成功!");
	}
	
	//发布
	function publishAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));
		$data['is_publish'] = 1;
		Video::dao()->getList()->update($data, array("id"=>array("in",$ids)));
        Home::dao()->getTagext()->update(array("is_public"=>1),array("obj_type"=>3,"obj_id"=>array("in",$ids)));
		My_Tool::showJsonp(200, "");
	}
	
	//草稿
	function nopublishAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));
		$data['is_publish'] = 0;
		Video::dao()->getList()->update($data, array("id"=>array("in",$ids)));
        Home::dao()->getTagext()->update(array("is_public"=>0),array("obj_type"=>3,"obj_id"=>array("in",$ids)));
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
	
	
	function recommendAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$vl = (int) $this->getRequest()->getParam("vl");
		$isAdd = (int) $this->getRequest()->getParam("isAdd");
		$this->view->info = Video::dao()->getList()->get(array("id"=>$id));
        
		$positionArrTmp = array();
		$positionArr = array();
		if(!$this->view->info) My_Tool::showJsonp(500,"数据错误!");
		if($this->view->info['position']) $positionArr = explode(',', trim($this->view->info['position'],','));
		if($isAdd){
			$positionArr[] = $vl;
			$positionArrTmp = array_unique($positionArr);
		}else{
			unset($positionArr[array_search($vl,$positionArr)]);
			$positionArrTmp= $positionArr;
		}
		 
		if($positionArrTmp) {
			$data['position'] = ','.implode(',', $positionArrTmp).',';
		}else{
			$data['position'] = '';
		}
		Video::dao()->getList()->update($data, array("id"=>$id));
		My_Tool::showJsonp(200,"操作成功!");
	}
	
	function subAction(){
		$id = (int) My_Tool::request("id");

		$this->view->id = $id;
		
		if(!$id) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/index"));
		
		$page = (int) My_Tool::request("page",1);
		$page = $page ? $page : 1;
		$pageSize = 10;
			
		$limit = $pageSize * ($page-1);
		$where = array();
		$where['list_id'] = $id;
		$obj = Video::dao()->getDetail();
		$this->view->list = $obj->gets($where, "id DESC" ,$limit, $pageSize, "", true);
		$this->view->totalNum =  $obj->getTotal();
		$this->view->page = $page;
		$this->view->pageSize = $pageSize;
	}
	
	function subAddAction(){
		$list_id = (int) My_Tool::request("id");
		if(!$list_id) $this->showMsg("参数错误");
		$this->view->list_id = $list_id;
		
		if(My_Tool::isPost()){
			$list_number =  $this->getParam("list_number");
			$url = $this->getParam("url");
			$fsort = (int) $this->getParam("fsort");
			
			$data['list_number'] = $list_number;
			$data['url'] = $url;
			$data['fsort'] = $fsort;
			$data['list_id'] = $list_id;
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			Video::dao()->getDetail()->insert($data);
			Admin_Tool::showAlert("操作成功!",My_Tool::url("adm/sub"));
		}
		
	}
	
	function subEditAction(){
		$id = (int) $this->getParam("id");
        if(!$id) $this->showMsg("参数错误");
		$this->view->id = $id;
		
		$this->view->info = Video::dao()->getDetail()->get(array("id"=>$id));
		
		if(!$this->view->info) Admin_Tool::showAlert("数据不存在!",My_Tool::url("adm/sub"));
		if(My_Tool::isPost()){
			$list_number =  $this->getParam("list_number");
			$url = $this->getParam("url");
			$fsort = (int) $this->getParam("fsort");
				
			$data['list_number'] = $list_number;
			$data['url'] = $url;
			$data['fsort'] = $fsort;
			$data['updated_at'] = date('Y-m-d H:i:s');
			Video::dao()->getDetail()->update($data,array("id"=>$id));
			Admin_Tool::showAlert("操作成功!",My_Tool::url("adm/sub"));
		}
	
	}
	
	function subDeleteAction(){
		$id = (int) $this->getParam("id");
	
		$this->view->info = Video::dao()->getDetail()->get(array("id"=>$id));
	
		if(!$this->view->info) My_Tool::showJsonp(500, "数据不存在!");
		if(My_Tool::isPost()){
			Video::dao()->getDetail()->delete(array("id"=>$id));
			My_Tool::showJsonp(200,"操作成功!");
		}
	
	}
	
	
}

