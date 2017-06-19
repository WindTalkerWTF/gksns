<?php

class Site_AdmController extends Admin_Controller_Action
{

    public function init(){
    }

    public function preDispatch(){}

     /********以下为自定义内容****************/
	function indexAction(){
		$this->view->list = Site::service()->getCommon()->getViewTrees();
	}
	
	#添加树
	function addTreeAction(){
		$this->view->treeList = Site::service()->getCommon()->getViewTrees();
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
			    $data['face'] = $imgPath;
			    $data['descr'] = $descr;
			    $data['pid'] = $pid;
			    $data['tree_sort'] = $fsort;
			    $data['created_at'] = date('Y-m-d H:i:s');
			    Site::dao()->getTree()->insert($data);
			    Admin_Tool::showMsg("操作成功!", My_Tool::url("adm/index"));
		    }
		}
	}
	
	//编辑tree
	function editTreeAction(){
		$id = (int) $this->getRequest()->getParam("id");
		
		if(!$id) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/index"));
		
		$this->view->info = Site::dao()->getTree()->get(array("id"=>$id));
	
		if(!$this->view->info) Admin_Tool::showMsg("数据不存在!", My_Tool::url("adm/index"));
		
		$this->view->treeList = Site::service()->getCommon()->getViewTrees();
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
			    Site::dao()->getTree()->update($data, array("id"=>$id));
			    Admin_Tool::showMsg("操作成功!", My_Tool::url("adm/index"));
		    }
		}
		
	}
	
	//删除tree
	function deleteTreeAction(){
		$this->_helper->viewRenderer->setNoRender();
	    $id = (int) $this->getRequest()->getParam("id");
		
		if(!$id) My_Tool::showMsg("数据错误!", My_Tool::url("adm/index"));
		
		$this->view->info = Site::dao()->getTree()->get(array("id"=>$id));
	
		if(!$this->view->info) Admin_Tool::showMsg("数据不存在!", My_Tool::url("adm/index"));
		
		Site::dao()->getTree()->delete(array("id"=>$id));
		
		Admin_Tool::showMsg("操作成功!", My_Tool::url("adm/index"));
	}
	
	#内容列表
	function contentListAction(){
		
		$this->view->treeList = Site::service()->getCommon()->getViewTrees();
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
			$ids = Site::service()->getCommon()->getChildTreeIds($id);
			$ids[] = $id;
			$where = array("tree_id"=>array("in", $ids));
		}
    	if($title) $where['title'] = array("like", "%".$title."%");
    	if($isPublish != "-1") $where['is_publish'] = $isPublish;
    	
    	$obj = new Site_Dao_Arc();
    	$this->view->list = $obj->gets($where, "is_publish DESC,id DESC" ,$limit, $pageSize, "", true);
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
	
	/**
	 *
	 * 选择树
	 */
	function selectTreeAction(){
	    $id = (int) $this->getRequest()->getParam("id");
	    $treeId = $this->getRequest()->getParam("treeId");
	    $this->view->id = $id;
	
	    $this->view->info = Site::dao()->getArc()->get(array("id"=>$id));
	    $this->view->content = Home::dao()->getArc()->get(array("mark"=>"site#".$id));
	
	    if(!$this->view->info || !$this->view->content || !$treeId) My_Tool::showJsonp(500,"数据错误!");
	
	    $data['tree_id'] = $treeId;
	    Site::dao()->getArc()->update($data, array("id"=>$id));
	    My_Tool::showJsonp(200,"操作成功!");
	}
	
	/**
	 * 推荐
	 */
	function recommendAction(){
		$this->_helper->viewRenderer->setNoRender();
	    $id = (int) $this->getRequest()->getParam("id");
	    $vl = (int) $this->getRequest()->getParam("vl");
	    $isAdd = (int) $this->getRequest()->getParam("isAdd");
	    $this->view->info = Site::dao()->getArc()->get(array("id"=>$id));
	    $this->view->content = Home::dao()->getArc()->get(array("mark"=>"site#".$id));
	    $positionArrTmp = array();
	    $positionArr = array();
	    if(!$this->view->info || !$this->view->content) My_Tool::showJsonp(500,"数据错误!");
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
	    Site::dao()->getArc()->update($data, array("id"=>$id));
	    My_Tool::showJsonp(200,"操作成功!");
	}
	
	//内容编辑
	function contentEditAction(){
		$this->view->treeList = Site::service()->getCommon()->getViewTrees();
	    $id = (int) My_Tool::request("id");
		$this->view->id = $id;

		$this->view->info = Site::dao()->getArc()->get(array("id"=>$id));
		$this->view->content = Home::dao()->getArc()->get(array("mark"=>"site#".$id));
		
		if(!$this->view->info || !$this->view->content) Admin_Tool::showMsg("数据错误!", My_Tool::url("adm/content-list"));
		
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$title = trim($this->getRequest()->getParam("title"));
			$content = $this->getRequest()->getParam("content");
			$file = $_FILES['face']['tmp_name'];
			if(!$title) Admin_Tool::showAlert("标题必须填写!");
			if(!$content) Admin_Tool::showAlert("内容必须填写!");
			$descr = $this->getRequest()->getParam("descr");
			$isPublish = (int) $this->getRequest()->getParam("is_publish");
			$positionArr = $this->getRequest()->getParam("position");
			$treeId = (int) $this->getRequest()->getParam("tree_id");
			$content = My_Tool::getContentImg($content, true);
			$position = 0;
			if($positionArr){
				$position = ','.implode(',', $positionArr).',';
			}
			
			$this->view->title = $title;
			$this->view->contentTmp = $content;
			$this->view->descr = $descr;
			$this->view->is_publish = $isPublish;
			$this->view->position = $position;
			$this->view->treeId = $treeId;
			if(!Admin_Tool::hasAlert()){
				if($file){
					//上传图片
					$savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "site" . DS . "arc" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
					$imgPaths = Home::service()->getCommon()->upImg($savePath);
					$imgPath =  "/res/upload/site/arc/" . date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
					//截图
					$oldPath = $savePath . $imgPaths[0]['savename'];
					Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24","330x330"));
				}
				
				
				if(!$descr) $descr = My_Tool::htmlCut(strip_tags($content), 100);
				if(!$imgPath){
					$hrefs = My_Tool::getImgPath($content);
				    $imgPath = isset($hrefs[0]) ? $hrefs[0] :'';
				}

				$data['title'] = $title;
				$data['descr'] = $descr;
				$data['tree_id'] = $treeId;
				$data['is_publish'] = $isPublish;
				$data['position'] = $position;
				
				if($imgPath) $data['face'] = $imgPath;
				Site::dao()->getArc()->update($data, array("id"=>$id));
				$aData['content'] = $content;
				Home::dao()->getArc()->update($aData, array("ref_id"=>$id, "arc_type"=>"site"));

                Home::service()->getCommon()->editTags($this->view->info['title'],$this->view->content['content'],
                    $title,$content,$id,1);

                if($isPublish){
                    Home::dao()->getTagext()->update(array("is_public"=>1),array("obj_type"=>1,"obj_id"=>$id));
                }else{
                    Home::dao()->getTagext()->update(array("is_public"=>0),array("obj_type"=>1,"obj_id"=>$id));
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
            $obj = new Site_Dao_Arc();
            $obj->startTrans();
            $info = Site::dao()->getArc()->get(array("id"=>$id));
            $content = Home::dao()->getArc()->get(array("mark"=>"site#".$id));

            if(!$info || !$content) return true;

            Site::dao()->getArc()->delete(array("id"=>$id));
            Home::dao()->getArc()->delete(array("id"=>$id, "arc_type"=>"site"));
            #增减统计数目
            User::service()->getCommon()->deCrField("blog_count", $info['uid']);

            Home::service()->getCommon()->deleteTags($info['title'],$content['content'],$id,1);

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
		Site::dao()->getArc()->update($data, array("id"=>array("in",$ids)));
        Home::dao()->getTagext()->update(array("is_public"=>1),array("obj_type"=>1,"obj_id"=>array("in",$ids)));
		My_Tool::showJsonp(200, "");
	}
	
	//草稿
	function nopublishAction(){
		$this->_helper->viewRenderer->setNoRender();
		$ids = $this->getRequest()->getParam("ids");
		$ids = explode(",", trim($ids, ','));
		$data['is_publish'] = 0;
		Site::dao()->getArc()->update($data, array("id"=>array("in",$ids)));
        Home::dao()->getTagext()->update(array("is_public"=>0),array("obj_type"=>1,"obj_id"=>array("in",$ids)));
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
	
	function darenAction(){
	    $siteConfig = getSysData('site.config.daren');
		$this->view->treeList = $siteConfig;
		$nickname = $this->getRequest()->getParam("nickname");
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->nickname = $nickname;
		$this->view->id = $id;
		
		$page = (int) My_Tool::request("page");
		$page = $page ? $page : 1;
		$pageSize = 15;
		 
		$limit = $pageSize * ($page-1);
		$where = array();
		
		if($id >= 0) $where['daren_tree'] = array("like","%,{$id},%");
		if($nickname) $where['nickname'] = array("like","%{$nickname}%");
		
		$obj = new User_Dao_Info();
		$this->view->list = $obj->gets($where, "id DESC" ,$limit, $pageSize, "", true);
		
		if($this->view->list){
			foreach ($this->view->list as $k=>$v){
				$darenTree = trim($v['daren_tree'],',');
				$darenTreeIds = explode(',', $darenTree);
				$darenTreeInfos = array();
				if($darenTreeIds){
					foreach ($darenTreeIds as $dk=>$dv){
					   if(isset($siteConfig[$dv])) $darenTreeInfos[$dv] = $siteConfig[$dv];
					}
				}
				$this->view->list[$k]['darenTreeInfo'] = $darenTreeInfos;
				$this->view->list[$k]['daren_tree'] = $v['daren_tree'] ? $v['daren_tree'] : "";
			}
		}
		$this->view->totalNum =  $obj->getTotal();
		$this->view->page = $page;
		$this->view->pageSize = $pageSize;
	}
	
	
	//更新达人
	function updateDarenAction(){
		$this->_helper->viewRenderer->setNoRender();
		$vl = trim($this->getRequest()->getParam("vl"));
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showJsonp(500,"数据为空!");
		$data['daren_tree'] = ",".$vl.",";
		$obj = new User_Dao_Info();
		$obj->update($data,array("id"=>$id));
		My_Tool::showJsonp(200,"");
	}
	
	
	
	
}

