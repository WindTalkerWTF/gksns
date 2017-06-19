<?php

class Admin_SysController extends Admin_Controller_Action
{

    public function init(){}

     public function preDispatch(){}

     /********以下为自定义内容****************/
    #节点管理
	function actionsAction(){
		//分页
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 20;
    	
    	$limit = $pageSize * ($page-1);
		
    	$where["app"] = "admin";
    	
    	$this->view->list = Admin::dao()->getActions()->gets($where, "id DESC" ,$limit, $pageSize);
    	$this->view->totalNum =  Admin::dao()->getActions()->getCount($where);
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
	}
	
	#编辑节点
	function editActionAction(){
		$id = (int) My_Tool::request("id");
		
		if(!$id) Admin_Tool::showMsg("数据不存在!", My_Tool::url("/sys/actions"));
		$this->view->info = Admin::dao()->getActions()->get(array("id"=>$id));
		if(!$this->view->info) Admin_Tool::showMsg("数据不存在!", My_Tool::url("/sys/actions"));
		$this->view->id = $id;
		
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$name = $this->getRequest()->getParam("name");
			$app = $this->getRequest()->getParam("m");
			$controller = $this->getRequest()->getParam("c");
			$action = $this->getRequest()->getParam("a");
			
			if(!$name || !$app || !$controller || !$action) Admin_Tool::showAlert("内容没有填写完整!", My_Tool::url("/sys/edit-action"));
			$path = strtolower($app)."#".strtolower($controller)."#".strtolower($action);
			$data['path'] = $path;
			$data['action'] = $action;
			$data['controller'] = $controller;
			$data['app'] = $app;
			$data['name'] = $name;
			Admin::dao()->getActions()->update($data, array("id"=>$id));
			Admin_Tool::showMsg("编辑成功", My_Tool::url("/sys/actions"));
		}
		
	}
	
	#删除节点
	function deleteRightAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) Admin_Tool::showMsg("数据不存在!", My_Tool::url("/sys/actions"));
		Admin::dao()->getActions()->delete(array("id"=>$id));
		Admin_Tool::showMsg("删除成功", My_Tool::url("/sys/action"));
	}
	
	#应用节点
	function appActionsAction(){
		Admin::service()->getSys()->scannerAppInfo();
		//分页
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	$where = array();
    	
    	$this->view->list = Admin::service()->getSys()->getActionsInfo($where, "id DESC" ,$limit, $pageSize);
    	$this->view->totalNum =  Admin::dao()->getAppinfo()->getCount($where);
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
	}
	
	#扫描节点
	function scannerActionsAction(){
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			set_time_limit(0);
			ignore_user_abort(0);
			#开始扫描
			try{
				Admin::service()->getSys()->scannerActions();
				My_Tool::showJson(200, "");
			}catch (Exception $e){
				My_Tool::showJson(500, $e->getMessage());
			}
		}
	}
	
	#角色
	function rolesAction(){
		//分页
		$page = (int) My_Tool::request("page");
		$page = $page ? $page : 1;
		$pageSize = 15;
		 
		$limit = $pageSize * ($page-1);
		
		$where = array();
		 
		$this->view->list = Admin::dao()->getRoles()->gets($where, "id DESC" ,$limit, $pageSize);
		$this->view->totalNum =  Admin::dao()->getRoles()->getCount($where);
		 
		$this->view->page = $page;
		$this->view->pageSize = $pageSize;
	}
	
	#添加角色
	function addRoleAction(){
		$this->_helper->viewRenderer->setNoRender();
		if(My_Tool::isPost()){
			$role = trim($this->getRequest()->getParam("role"));
			if(!$role) Admin_Tool::showAlert("角色名称为空", My_Tool::url("/sys/roles"));
			
			$data['name'] = $role;
			Admin::dao()->getRoles()->insert($data);
		}
		My_Tool::redirect(My_Tool::url("/sys/roles"));
	}
	
	#编辑
	function editRoleAction(){
		$id = (int) My_Tool::request("id");
		
		if(!$id) Admin_Tool::showMsg("数据不存在!", My_Tool::url("/sys/roles"));
		$this->view->info = Admin::dao()->getRoles()->get(array("id"=>$id));
		if(!$this->view->info) Admin_Tool::showMsg("数据不存在!", My_Tool::url("/sys/roles"));
		$this->view->id = $id;
		
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$name = trim($this->getRequest()->getParam("name"));
			$data['name'] = $name;
			Admin::dao()->getRoles()->update($data, array("id"=>$id));
			My_Tool::redirect(My_Tool::url("/sys/roles"));
		}
		
	}
	#删除角色
	function deleteRoleAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) Admin_Tool::showMsg("数据不存在!", My_Tool::url("/sys/roles"));
		Admin::dao()->getRoleaction()->delete(array("role_id"=>$id));
		Admin::dao()->getMasterrole()->delete(array("role_id"=>$id));
		Admin::dao()->getRoles()->delete(array("id"=>$id));
		Admin_Tool::showMsg("删除成功", My_Tool::url("/sys/roles"));
	}
	
	#角色节点管理
	function roleActionsAction(){
		$id = (int) My_Tool::request("id");
		$t = (int) My_Tool::request("t", 1);
		if(!$id) Admin_Tool::showMsg("数据不存在!", My_Tool::url("/sys/roles"));
		$this->view->id = $id;
		$listData = Admin::dao()->getRoleaction()->gets(array("role_id"=>$id));
		$ids=array();
		if($listData){
			foreach($listData as $v){
				$ids[] = $v['action_id'];
			}
		}
		$this->view->ids = $ids;
		$this->view->t = $t;
		if($t == 2){
			//app应用节点
			//分页
			$page = (int) My_Tool::request("page");
			$page = $page ? $page : 1;
			$pageSize = 15;
			 
			$limit = $pageSize * ($page-1);
			
			$where = array();
			 
			$this->view->list = Admin::service()->getSys()->getActionsInfo($where, "id DESC" ,$limit, $pageSize);
			$this->view->totalNum =  Admin::dao()->getAppinfo()->getCount($where);
			 
			$this->view->page = $page;
			$this->view->pageSize = $pageSize;
		}else{
			//后台节点
			//分页
			$page = (int) My_Tool::request("page");
			$page = $page ? $page : 1;
			$pageSize = 20;
			
			$limit = $pageSize * ($page-1);
				
			$where = array("app"=>"admin");
			
			$this->view->list = Admin::dao()->getActions()->gets($where, "id DESC" ,$limit, $pageSize);
			$this->view->totalNum =  Admin::dao()->getActions()->getCount($where);
			
			$this->view->page = $page;
			$this->view->pageSize = $pageSize;
		}
	}
	
	function deleteRoleActionAction(){
		$this->_helper->viewRenderer->setNoRender();
		$aid = (int) $this->getRequest()->getParam("aid");
		$rid = (int) $this->getRequest()->getParam("rid");
		if(!$aid || !$rid) My_Tool::showJson(500, "");
		Admin::dao()->getRoleaction()->delete(array("action_id"=>$aid, "role_id"=>$rid));
		My_Tool::showJson(200, "");
	}
	
	function addRoleActionAction(){
		$this->_helper->viewRenderer->setNoRender();
		$aid = (int) $this->getRequest()->getParam("aid");
		$rid = (int) $this->getRequest()->getParam("rid");
		if(!$aid || !$rid) My_Tool::showJson(500, "");
		Admin::dao()->getRoleaction()->insert(array("action_id"=>$aid, "role_id"=>$rid));
		My_Tool::showJson(200, "");
	}
	
	function mastersAction(){
		$user = trim($this->getRequest()->getParam("user"));
		$info = "";
		if($user){
			$sql = "SELECT * FROM user_info WHERE username='".$user."' OR nickname = '".$user."'";
			$info = User::dao()->getInfo()->selectRow($sql);
			$this->view->user = $user;
		}
		$this->view->info = $info;
	}
	
	
	function masterRoleAction(){
		$id = (int) My_Tool::request("id");
		if(!$id) Admin_Tool::showMsg("数据不存在!", My_Tool::url("/sys/masters"));
		//判断是否是管理员
		if(!User::service()->getCommon()->isAdmin($id))  Admin_Tool::showMsg("不是管理员不能进行此操作!", My_Tool::url("/sys/masters"));
		$this->view->id = $id;
		
		$listData = Admin::dao()->getMasterrole()->gets(array("user_id"=>$id));
		$ids=array();
		if($listData){
			foreach($listData as $v){
				$ids[] = $v['role_id'];
			}
		}
		$this->view->ids = $ids;
		
		$this->view->list = Admin::dao()->getRoles()->gets();
		
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$roleIds = $this->getRequest()->getParam("roleids");
			if(!$roleIds) Admin_Tool::showAlert("请至少选择一个角色!", My_Tool::url("/sys/masters"));
			//先删除
			Admin::dao()->getMasterrole()->delete(array("user_id"=>$id));
			foreach($roleIds as $v){
				$data['user_id'] = $id;
				$data['role_id'] = $v;
				Admin::dao()->getMasterrole()->insert($data);
			}
			Admin_Tool::showMsg("操作成功!", My_Tool::url("/sys/masters"));
		}
		
	}

	function masterSetAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) My_Tool::request("id");
		if(!$id) Admin_Tool::showMsg("数据不存在!", My_Tool::url("/sys/masters"));
		
		if(!User::service()->getCommon()->isAdmin($id)){
			$data['role'] = 9;
		}else{
			$data['role'] = 0;
		}
		User::dao()->getInfo()->update($data, array("id"=>$id));
		Admin_Tool::showMsg("操作成功!", My_Tool::url("/sys/masters"));
	}
	
	
	function cacheAction(){
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			Admin::service()->getSys()->clearCache();
			Admin::service()->getSys()->scannerActions();
			Admin_Tool::showMsg("缓存清空成功!");
		}
	}
	
	/**
	 * 设置
	 */
	function settingAction(){
		$allConfig = My::config()->getSysdata();
        $config = array();
        My_Tool::changeArray2One($allConfig,$config);
        $configInit = My::config()->getInit();
        $initArr = array();
        My_Tool::changeArray2One($configInit,$initArr);
        $config = array_merge($initArr,$config);
        $config['cache.memcache.server.ip'] =$config['cache.memcache.server.1.ip'];
        $config['cache.memcache.server.port'] =$config['cache.memcache.server.1.port'];
        $config['cache.memcache.server.weight'] =$config['cache.memcache.server.1.weight'];
		$this->view->config = $config;
	}

	/**
	 * 保存设置
	 */
	function dosettingAction(){
		$this->_helper->viewRenderer->setNoRender();
		$data = $_POST;
		if($data){
			foreach ($data as $k=>$v){
				if($k == "btnsubmit") continue;
                $k = str_replace('_','.',$k);
                if($k=="site.config.daren"){
                    saveSysData($k,$v);
			    }elseif($k == 'site.config.isrewrite'){
                    saveInit($k,$v);
                }elseif($k == 'session.handle'){
                    if($v =='memcache'){
                        if (extension_loaded('memcache')) {
                            saveInit($k,$v);
                        }
                    }else{
                        saveInit($k,$v);
                    }
			    }elseif($k == 'cache.handle'){
                    if($v =='memcache'){
                        if (extension_loaded('memcache')) {
                            saveInit($k,$v);
                        }
                    }else{
                        saveInit($k,$v);
                    }
                }
                elseif($k == 'session.domain'){
                    saveInit($k,$v);
                }
                elseif($k == 'cache.memcache.server.ip'){
                    saveInit("cache.memcache.server.1.ip",$v);
                }
                elseif($k == 'cache.memcache.server.port'){
                    saveInit("cache.memcache.server.1.port",$v);
                }else{
                    saveSysData($k,$v);
                }
			}
		}
		Home::service()->getCommon()->clearAllCache();
		$this->showMsg("操作成功!",My_Tool::url("sys/setting"));
	}

    function treeListAction(){
        $this->view->list = Home::dao()->getTree()->gets(array(),"tree_sort ASC");
    }
    function treeAddAction(){

        if(My_Tool::isPost()){
            $this->_helper->viewRenderer->setNoRender();
            $this->view->name = $this->getRequest()->getParam("name");
            $sort = (int) $this->getRequest()->getParam("sort");
            if(!$this->view->name) Admin_Tool::showMsg("栏目名称不能为空!", My_Tool::url("adm/tree-list") );
            $data['name'] = $this->view->name;
            $data['tree_sort'] = $sort;
            Home::dao()->getTree()->insert($data);

            Admin_Tool::showMsg("添加成功!", My_Tool::url("sys/tree-list"));
        }
    }
    function treeEditAction(){
        $id = (int) $this->getRequest()->getParam("id");
        $sort = (int) $this->getRequest()->getParam("sort");
        $this->view->info = Home::dao()->getTree()->get(array("id"=>$id));
        if(!$this->view->info) Admin_Tool::showMsg("数据错误", My_Tool::url("sys/tree-list") );
        $this->view->id = $id;
        if(My_Tool::isPost()){
            $this->_helper->viewRenderer->setNoRender();
            $this->view->name = $this->getRequest()->getParam("name");
            if(!$this->view->name) Admin_Tool::showMsg("栏目名称不能为空!", My_Tool::url("sys/tree-list") );
            $data['name'] = $this->view->name;
            $data['tree_sort'] = $sort;
            Home::dao()->getTree()->update($data, array("id"=>$id));

            Admin_Tool::showMsg("编辑成功!", My_Tool::url("sys/tree-list"));
        }
    }


    function treeDelAction(){
        $this->_helper->viewRenderer->setNoRender();
        $ids = $this->getRequest()->getParam("id");
        $ids = explode(",", trim($ids, ','));
        Home::dao()->getTree()->delete(array("id"=>array("in",$ids)));
        if(My_tool::isAjax()){
            My_Tool::showJsonp(200, "");
        }else{
            Admin_Tool::showMsg("删除成功",  My_Tool::url("sys/tree-list"));
        }
    }


    function tagListAction(){
        $this->view->treeList = Home::dao()->getTree()->gets();

        $name = trim($this->getRequest()->getParam("name"));
        $this->view->name = $name;

        $treeId = intval($this->getRequest()->getParam("treeid"));
        $this->view->treeid = $treeId;

        $page = (int) My_Tool::request("page");
        $page = $page ? $page : 1;
        $pageSize = 15;

        $limit = $pageSize * ($page-1);
        $where = array();
        if($name) $where['name'] = array("like", "%".$name."%");
        if($treeId !='-1' && $treeId) $where['tree_id'] = $treeId;

        $obj = new Home_Dao_Tag();
        $this->view->list = $obj->gets($where, "tree_id ASC, ask_count DESC" ,$limit, $pageSize, "", true);

        if($this->view->list){
            foreach($this->view->list as $k=>$v){
                $this->view->list[$k]['tree'] = Home::dao()->getTree()->get(array("id"=>$v['tree_id']));
            }
        }
//    	print_r($this->view->list);
        $this->view->totalNum =  $obj->getTotal();
        $this->view->page = $page;
        $this->view->pageSize = $pageSize;
    }

    function tagAddAction(){
        $this->view->treeList = Home::dao()->getTree()->gets();
        if(My_Tool::isPost()){
            $this->_helper->viewRenderer->setNoRender();
            $this->view->name = $this->getRequest()->getParam("name");
            $this->view->descr = $this->getRequest()->getParam("descr");
            $this->view->tagSort = (int) $this->getRequest()->getParam("tagSort");
            $this->view->treeid = intval($this->getRequest()->getParam("treeid"));
            if(!$this->view->name) Admin_Tool::showMsg("栏目名称不能为空!", My_Tool::url("sys/tag-list") );
            $adminUser = Admin::service()->getCommon()->getLogined();
            $data['name'] = strtoupper($this->view->name);
            $data['descr'] = $this->view->descr;
            $data['tag_sort'] = $this->view->tagSort;
            $data['tree_id'] = $this->view->treeid;
            $data['uid'] = $adminUser['id'];
            Home::dao()->getTag()->insert($data);

            #标签数目自增
            Home::dao()->getTree()->inCrease("tag_count",array("id"=>$this->view->treeid));
            #标签数自增
            User::dao()->getStat()->inCrease("tag_count",array("uid"=>$adminUser['id']));

            Admin_Tool::showMsg("添加成功!", My_Tool::url("sys/tag-list"));
        }
    }
    function tagEditAction(){
        $this->view->treeList = Home::dao()->getTree()->gets();

        $id = (int) $this->getRequest()->getParam("id");
        $this->view->info = Home::dao()->getTag()->get(array("id"=>$id));
        if(!$this->view->info) Admin_Tool::showMsg("数据错误", My_Tool::url("sys/tag-list") );
        $this->view->id = $id;
        if(My_Tool::isPost()){
            $this->_helper->viewRenderer->setNoRender();
            $this->view->name = $this->getRequest()->getParam("name");
            $this->view->descr = $this->getRequest()->getParam("descr");
            $this->view->tagSort = (int) $this->getRequest()->getParam("tagSort");
            $this->view->treeid = intval($this->getRequest()->getParam("treeid"));
            if(!$this->view->name) Admin_Tool::showMsg("栏目名称不能为空!", My_Tool::url("sys/tag-list") );
            $data['name'] = strtoupper($this->view->name);
            $data['descr'] = $this->view->descr;
            $data['tag_sort'] = $this->view->tagSort;
            $data['tree_id'] = $this->view->treeid;
            Home::dao()->getTag()->update($data, array("id"=>$id));

            #标签数目自增
            Home::dao()->getTree()->deCrement("tag_count",array("id"=>$this->view->info['tree_id'],"tag_count"=>array(">", 0)));
            Home::dao()->getTree()->inCrease("tag_count",array("id"=>$this->view->treeid));
            Admin_Tool::showMsg("编辑成功!", My_Tool::url("sys/tag-list"));
        }
    }

    function tagDelAction(){
        $this->_helper->viewRenderer->setNoRender();
        $ids = $this->getRequest()->getParam("id");
        if(!$ids) Admin_Tool::showMsg("数据错误",  My_Tool::url("sys/tag-list"));
        $ids = explode(",", trim($ids, ','));

        foreach ($ids as $id){
            $info = Home::dao()->getTag()->get(array("id"=>$id));
            #标签数自减
            User::dao()->getStat()->deCrement("tag_count",array("uid"=>$info['uid'],"tag_count"=>array(">", 0)));
            #标签数目自增
            Home::dao()->getTree()->deCrement("tag_count",array("id"=>$info['tree_id']));
        }

        Home::dao()->getTag()->delete(array("id"=>array("in",$ids)));
        if(My_tool::isAjax()){
            My_Tool::showJsonp(200, "");
        }else{
            Admin_Tool::showMsg("删除成功",  My_Tool::url("sys/tag-list"));
        }
    }


}

