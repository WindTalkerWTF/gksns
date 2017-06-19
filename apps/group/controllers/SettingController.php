<?php
class Group_SettingController extends My_Controller_Action
{
	public function init(){
		$this->_helper->layout()->setLayout("group_setting_layout");
    	$this->_helper->Logined(array("index","dosaveinfo","domg","mg","docancelmg","removemember"));
    }
    
    #基本信息设置
    function indexAction(){
    	$id = (int) $this->getRequest()->getParam("id");
    	$this->view->id = $id;
    	if(!$id) My_Tool::showMsg("页面不存在");
		$user =  User::service()->getCommon()->getLogined();
    	$this->view->info = Group::dao()->getInfo()->get(array("id"=>$id));
    	if(!$this->view->info) My_Tool::showMsg("页面不存在");
    	if($this->view->info['uid'] != $user['id'])  My_Tool::showMsg("你没有权限进入此页");
    	$this->view->seo = array("title"=>"“".$this->view->info['name']."”小组基本信息设置|小组管理");
    }
    #处理基本信息设置
    function dosaveinfoAction(){
		$this->_helper->viewRenderer->setNoRender();
    	$id = (int) $this->getRequest()->getParam("id");
    	$this->view->id = $id;
    	if(!$id) My_Tool::showMsg("数据错误");
    	$this->view->info = Group::dao()->getInfo()->get(array("id"=>$id));
    	if(!$this->view->info) My_Tool::showMsg("页面不存在");
    	$name = trim($this->getRequest()->getParam("name"));
    	$introduction = trim($this->getRequest()->getParam("introduction"));
    	if(!$name) My_Tool::showMsg("小组名称不能为空","history.back()",1);
    	//判断小组名称是否重复
    	
    	$checkoinfo = Group::dao()->getInfo()->get(array("name"=>$name,"id"=>array("<>",$id)));
    	if($checkoinfo)  My_Tool::showMsg("小组名称重复!","history.back()",1);
    	$file = $_FILES['upload_file']['tmp_name'];
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
		$data['descr'] = $introduction;
		if($file) $data['face'] = $imgPath;
		Group::dao()->getInfo()->update($data,array("id"=>$id));
		My_Tool::showMsg("操作成功!",My_Tool::url("setting/index/id/".$id,"group"));
    }
    
    //会员管理
    function mgAction(){
    	$id = (int) $this->getRequest()->getParam("id");
    	$this->view->id = $id;
    	if(!$id) My_Tool::showMsg("数据错误");
    	$this->view->info = Group::dao()->getInfo()->get(array("id"=>$id));
    	if(!$this->view->info) My_Tool::showMsg("页面不存在");
    	
    	$user =  User::service()->getCommon()->getLogined();
    	$this->view->selfId = $user['id'];
    	$this->view->isCreator = 0;
    	if($this->view->info['uid'] == $user['id']){
    		$this->view->isCreator = 1;
    	}
        $userRight = Group::dao()->getUser()->get(array("group_id"=>$id,"uid"=>$user['id'],"user_type"=>array(">","8")));
    	if(!$this->view->isCreator && !$userRight) My_Tool::showMsg("你没有权限进入此页面");
    	
    	
    	$name = $this->getRequest()->getParam("name");
    	
    	$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 16;
    	
    	$limit = $pageSize * ($page-1);
		
    	$nameSql = "";
    	if($name) $nameSql = " AND b.name LIKE '%:name%'";
    	
    	$list = $totalNum = 0;
    	$obj = new Home_Dao_Common();
    	$sql = "SELECT SQL_CALC_FOUND_ROWS a.user_type,a.post_num,a.is_shutup,b.*,c.to_follow_count FROM group_user a INNER
				JOIN user_info b ON a.uid=b.id INNER JOIN user_stat c ON a.uid=c.uid WHERE a.group_id = ".$id."
    			{$nameSql}
    			ORDER BY a.user_type DESC,a.post_num DESC LIMIT {$limit}, {$pageSize}";
    	$list = $obj->selectAll($sql,array(":name"=>$name),true);
    	$totalNum = $obj->getTotal();
		$this->view->list = $list;
    	$this->view->totalNum =  $totalNum;
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;

    	$this->view->seo = array("title"=>"“".$this->view->info['name']."”小组管理员管理|小组管理");
    }
    
    #设为管理员
    function domgAction(){
		$this->_helper->viewRenderer->setNoRender();
    	$id = (int) $this->getRequest()->getParam("id");
    	$gid = (int) $this->getRequest()->getParam("gid");
    	if(!$id) My_Tool::showJsonp("500","数据错误");
    	if(!$gid) My_Tool::showJsonp("500","数据错误");
    	$info = Group::dao()->getInfo()->get(array("id"=>$gid));
    	if(!$info) My_Tool::showJsonp("500","数据错误");
    	$user =  User::service()->getCommon()->getLogined();
    	if($info['uid'] != $user['id'])  My_Tool::showJsonp("500","你没有权限进行此项操作");
    	Group::dao()->getUser()->update(array("user_type"=>9),array("group_id"=>$gid,"uid"=>$id));
    	My_Tool::showJsonp("200");
    }
    
    #取消设为管理员
	function docancelmgAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
    	$gid = (int) $this->getRequest()->getParam("gid");
    	if(!$id) My_Tool::showJsonp("500","数据错误");
    	if(!$gid) My_Tool::showJsonp("500","数据错误");
    	$info = Group::dao()->getInfo()->get(array("id"=>$gid));
    	if(!$info) My_Tool::showJsonp("500","数据错误");
    	$user =  User::service()->getCommon()->getLogined();
    	if($info['uid'] != $user['id'])  My_Tool::showJsonp("500","你没有权限进行此项操作");
    	Group::dao()->getUser()->update(array("user_type"=>0),array("group_id"=>$gid,"uid"=>$id));
    	My_Tool::showJsonp("200","");
	}    
	
	#剔除会员
	function removememberAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
    	$gid = (int) $this->getRequest()->getParam("gid");
    	if(!$id) My_Tool::showJsonp("500","数据错误");
    	if(!$gid) My_Tool::showJsonp("500","数据错误");
    	$info = Group::dao()->getInfo()->get(array("id"=>$gid));
    	if(!$info) My_Tool::showJsonp("500","数据错误");
    	$user =  User::service()->getCommon()->getLogined();
    	$memberInfo = Group::dao()->getUser()->get(array("group_id"=>$gid,"uid"=>$user['id'],"user_type"=>array(">","8")));
    	if(!$memberInfo) My_Tool::showJsonp("500","你没有权限进行此项操作");  
    	Group::dao()->getUser()->delete(array("group_id"=>$gid,"uid"=>$id));
    	My_Tool::showJsonp("200","");
	}
	
	#屏蔽发言
	function shutupAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
    	$gid = (int) $this->getRequest()->getParam("gid");
    	if(!$id) My_Tool::showJsonp("500","数据错误");
    	if(!$gid) My_Tool::showJsonp("500","数据错误");
    	$info = Group::dao()->getInfo()->get(array("id"=>$gid));
    	if(!$info) My_Tool::showJsonp("500","数据错误");
    	$user =  User::service()->getCommon()->getLogined();
    	$memberInfo = Group::dao()->getUser()->get(array("group_id"=>$gid,"uid"=>$user['id'],"user_type"=>array(">","8")));
    	if(!$memberInfo) My_Tool::showJsonp("500","你没有权限进行此项操作");  
		Group::dao()->getUser()->update(array("is_shutup"=>1),array("group_id"=>$gid,"uid"=>$id));
    	My_Tool::showJsonp("200","");
	}
	
	#取消屏蔽发言
	function unshutupAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
    	$gid = (int) $this->getRequest()->getParam("gid");
    	if(!$id) My_Tool::showJsonp("500","数据错误");
    	if(!$gid) My_Tool::showJsonp("500","数据错误");
    	$info = Group::dao()->getInfo()->get(array("id"=>$gid));
    	if(!$info) My_Tool::showJsonp("500","数据错误");
    	$user =  User::service()->getCommon()->getLogined();
    	$memberInfo = Group::dao()->getUser()->get(array("group_id"=>$gid,"uid"=>$user['id'],"user_type"=>array(">","8")));
    	if(!$memberInfo) My_Tool::showJsonp("500","你没有权限进行此项操作");  
		Group::dao()->getUser()->update(array("is_shutup"=>0),array("group_id"=>$gid,"uid"=>$id));
    	My_Tool::showJsonp("200","");
	}
	
}