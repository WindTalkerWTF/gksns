<?php

class Search_IndexController extends My_Controller_Action
{

    public function init(){}

    public function preDispatch(){}

     /********以下为自定义内容****************/
	function indexAction(){
		$wd = trim($this->getRequest()->getParam("wd"));
		$this->view->wd = $wd;
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
    	$obj = new Home_Dao_Common();
    	$siteSql = $groupInfoSql = $groupArcSql = $userInfoSql = $askTagSql=$askArcSql="";
    	$this->view->list=0;
    	$this->view->totalNum = 0;
    	$this->view->page = 0;
    	$this->view->pageSize = $pageSize;
    	if($wd){
    		$siteSql = "WHERE title like '%".$wd."%' AND is_publish = 1 ";
    		$groupInfoSql = "WHERE name like '%".$wd."%' AND group_status = 1";
    		$groupArcSql = "WHERE title like '%".$wd."%' AND is_publish = 1";
    		$userInfoSql = "WHERE nickname like '%".$wd."%' ";
    		$askTagSql =  "WHERE name like '%".$wd."%' ";
    		$askArcSql = "WHERE title like '%".$wd."%' AND is_publish =1 ";
    	
   		$sql ="
   		(SELECT SQL_CALC_FOUND_ROWS id, 'site_arc' as type FROM site_arc {$siteSql} ORDER BY reply_count DESC) UNION ALL
   		(SELECT id, 'group_info' as type FROM group_info {$groupInfoSql} ORDER BY user_number DESC )  UNION ALL
   		(SELECT id, 'group_arc' as type FROM group_arc {$groupArcSql} ORDER BY reply_count DESC ) UNION ALL
   		(SELECT id, 'user' as type FROM user_info {$userInfoSql} ORDER BY id DESC ) UNION ALL
   		(SELECT id, 'home_tag' as type FROM home_tag {$askTagSql} ORDER BY ask_count DESC ) UNION ALL
   		(SELECT id, 'ask_arc' as type FROM ask_arc {$askArcSql} ORDER BY answer_count DESC) 
   		LIMIT {$limit},{$pageSize}
   		";
    	$this->view->list = $obj->selectAll($sql,"",true);
    	$this->view->totalNum = $obj->getTotal();
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	//处理
//    	print_r($this->view->list);
    	if($this->view->list){
    		foreach($this->view->list as $k=>$v){
    			$type = $v['type'];
    			$id = $v['id'];
    			if($type == 'site_arc'){
    				$sql="SELECT a.*,b.name FROM site_arc a LEFT JOIN site_tree b ON a.tree_id = b.id WHERE a.id= {$id}";
    				 $result = $obj->selectRow($sql);
    				 if($result) $result['title'] = str_ireplace($wd, "<strong>".$wd."</strong>",$result['title']);
    				 $this->view->list[$k]['body'] = $result;
    			}
    			
    		if($type == 'group_info'){
    				$sql="SELECT * FROM group_info  WHERE id= {$id}";
    				$result = $obj->selectRow($sql);
    				 if($result) $result['name'] = str_ireplace($wd, "<strong>".$wd."</strong>",$result['name']);
    				 $this->view->list[$k]['body'] = $result;
    			}
    			
    		if($type == 'group_arc'){
    				$sql="SELECT a.*,b.name,c.content,b.id as group_id FROM group_arc a LEFT JOIN group_info b ON a.group_id = b.id
    					 	LEFT JOIN home_arc c ON a.id=c.ref_id AND c.arc_type = 'group'
    						WHERE a.id= {$id}";
    				$result = $obj->selectRow($sql);
    				 if($result) $result['title'] = str_ireplace($wd, "<strong>".$wd."</strong>",$result['title']);
    				 $this->view->list[$k]['body'] = $result;
    			}
    			
    		if($type == 'user'){
    				$sql="SELECT a.*,b.to_follow_count FROM user_info a LEFT JOIN user_stat b ON a.id = b.uid WHERE a.id= {$id}";
    					 $result = $obj->selectRow($sql);
    				 if($result) $result['nickname'] = str_ireplace($wd, "<strong>".$wd."</strong>",$result['nickname']);
    				 $this->view->list[$k]['body'] = $result;
    			}
    		if($type == 'ask_tag'){
    				$sql="SELECT a.* FROM home_tag a  WHERE a.id= {$id}";
    					 $result = $obj->selectRow($sql);
    				 if($result) $result['name_view'] = str_ireplace($wd, "<strong>".$wd."</strong>",$result['name']);
    				 $this->view->list[$k]['body'] = $result;
    			}
    			
    		if($type == 'ask_arc'){
    				$sql="SELECT a.* FROM ask_arc a  WHERE a.id= {$id}";
    					 $result = $obj->selectRow($sql);
    				 if($result) $result['title'] = str_ireplace($wd, "<strong>".$wd."</strong>",$result['title']);
    				 $this->view->list[$k]['body'] = $result;
    			}
    		}
    	}
    	}
    	$this->view->seo = array("title"=>"全部搜索");
	}
	
	function siteAction(){
		$wd = trim($this->getRequest()->getParam("wd"));
		$this->view->wd = $wd;
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
    	$obj = new Home_Dao_Common();
    	$siteSql = "";
    	$this->view->list=0;
    	$this->view->totalNum = 0;
    	$this->view->page = 0;
    	$this->view->pageSize = $pageSize;
    	if($wd){
    	$siteSql = "WHERE title like '%".$wd."%' AND is_publish = 1 ";
   		$sql ="
   			SELECT SQL_CALC_FOUND_ROWS a.*,b.name FROM site_arc a LEFT JOIN site_tree b ON a.tree_id = b.id {$siteSql} ORDER BY reply_count DESC
   			LIMIT {$limit},{$pageSize}
   		";
    	$this->view->list = $obj->selectAll($sql,"",true);
    	$this->view->totalNum = $obj->getTotal();
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	if($this->view->list){
    		foreach($this->view->list as $k=>$v){
    			 $v['title'] = str_ireplace($wd, "<strong>".$wd."</strong>",$v['title']);
    			$this->view->list[$k]['title'] = $v['title'];
    		}
    	}
	}
	$this->view->seo = array("title"=>"文章搜索");
}
	
	function askAction(){
		$wd = trim($this->getRequest()->getParam("wd"));
		$this->view->wd = $wd;
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
    	$obj = new Home_Dao_Common();
    	$this->view->list=0;
    	$this->view->totalNum = 0;
    	$this->view->page = 0;
    	$this->view->pageSize = $pageSize;
    	if($wd){
   		$sql ="
   			SELECT SQL_CALC_FOUND_ROWS * FROM ask_arc  WHERE title like '%".$wd."%' AND is_publish =1  ORDER BY answer_count DESC
   			LIMIT {$limit},{$pageSize}
   		";
    	$this->view->list = $obj->selectAll($sql,"",true);
    	$this->view->totalNum = $obj->getTotal();
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	if($this->view->list){
    		foreach($this->view->list as $k=>$v){
    			 $v['title'] = str_ireplace($wd, "<strong>".$wd."</strong>",$v['title']);
    			$this->view->list[$k]['title'] = $v['title'];
    		}
    	}
	   }
	   $this->view->seo = array("title"=>"问题搜索");
	}
	
	function postAction(){
		$wd = trim($this->getRequest()->getParam("wd"));
		$this->view->wd = urldecode($wd);
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
    	$obj = new Home_Dao_Common();
    	$sql = "";
    	$this->view->list=0;
    	$this->view->totalNum = 0;
    	$this->view->page = 0;
    	$this->view->pageSize = $pageSize;
    	if($wd){
	   		$sql ="
	   			SELECT SQL_CALC_FOUND_ROWS a.*,b.name,c.content,b.id as group_id FROM group_arc a LEFT JOIN group_info b ON a.group_id = b.id   
	    		LEFT JOIN home_arc c ON a.id=c.ref_id AND c.arc_type = 'group' WHERE title like '%".$wd."%' AND is_publish = 1  
	    		ORDER BY reply_count DESC LIMIT {$limit},{$pageSize}
	   		";
	    	$this->view->list = $obj->selectAll($sql,"",true);
	    	$this->view->totalNum = $obj->getTotal();
	    	$this->view->page = $page;
	    	$this->view->pageSize = $pageSize;
	    	if($this->view->list){
	    		foreach($this->view->list as $k=>$v){
	    			 $v['title'] = str_ireplace($wd, "<strong>".$wd."</strong>",$v['title']);
	    			$this->view->list[$k]['title'] = $v['title'];
	    		}
	    	}
	   }
	    $this->view->seo = array("title"=>"帖子搜索");
	}
	
	function tagAction(){
		$wd = trim($this->getRequest()->getParam("wd"));
		$this->view->wd = urldecode($wd);
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
    	$obj = new Home_Dao_Common();
    	$sql = "";
    	$this->view->list=0;
    	$this->view->totalNum = 0;
    	$this->view->page = 0;
    	$this->view->pageSize = $pageSize;
    	if($wd){
	   		$sql ="
	   			SELECT SQL_CALC_FOUND_ROWS * FROM home_tag  WHERE name like '%".$wd."%' 
	    		ORDER BY ask_count DESC LIMIT {$limit},{$pageSize}
	   		";
	    	$this->view->list = $obj->selectAll($sql,"",true);
	    	$this->view->totalNum = $obj->getTotal();
	    	$this->view->page = $page;
	    	$this->view->pageSize = $pageSize;
	    	if($this->view->list){
	    		foreach($this->view->list as $k=>$v){
	    			 $name = str_ireplace($wd, "<strong>".$wd."</strong>",$v['name']);
	    			$this->view->list[$k]['fname'] = $name;
	    		}
	    	}
	   }
	   $this->view->seo = array("title"=>"标签搜索");
	}
	
	function userAction(){
		$wd = trim($this->getRequest()->getParam("wd"));
		$this->view->wd = urldecode($wd);
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
    	$obj = new Home_Dao_Common();
    	$sql = "";
    	$this->view->list=0;
    	$this->view->totalNum = 0;
    	$this->view->page = 0;
    	$this->view->pageSize = $pageSize;
    	if($wd){
	   		$sql ="
	   			SELECT SQL_CALC_FOUND_ROWS a.*,b.to_follow_count FROM user_info a LEFT JOIN 
	   			user_stat b ON a.id = b.uid WHERE a.nickname like '%".$wd."%' LIMIT {$limit},{$pageSize}
	   		";
	    	$this->view->list = $obj->selectAll($sql,"",true);
	    	$this->view->totalNum = $obj->getTotal();
	    	$this->view->page = $page;
	    	$this->view->pageSize = $pageSize;
	    	if($this->view->list){
	    		foreach($this->view->list as $k=>$v){
	    			 $name = str_ireplace($wd, "<strong>".$wd."</strong>",$v['nickname']);
	    			$this->view->list[$k]['nickname'] = $name;
	    		}
	    	}
	   }
	   $this->view->seo = array("title"=>"会员搜索");
	}
	
	function groupAction(){
		$wd = trim($this->getRequest()->getParam("wd"));
		$this->view->wd = urldecode($wd);
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
    	$obj = new Home_Dao_Common();
    	$sql = "";
    	$this->view->list=0;
    	$this->view->totalNum = 0;
    	$this->view->page = 0;
    	$this->view->pageSize = $pageSize;
    	if($wd){
	   		$sql ="
	   			SELECT SQL_CALC_FOUND_ROWS * FROM group_info WHERE name like '%".$wd."%' AND group_status = 1 LIMIT {$limit},{$pageSize}
	   		";
	    	$this->view->list = $obj->selectAll($sql,"",true);
	    	$this->view->totalNum = $obj->getTotal();
	    	$this->view->page = $page;
	    	$this->view->pageSize = $pageSize;
	    	if($this->view->list){
	    		foreach($this->view->list as $k=>$v){
	    			 $name = str_ireplace($wd, "<strong>".$wd."</strong>",$v['name']);
	    			$this->view->list[$k]['name'] = $name;
	    		}
	    	}
	   }
	   $this->view->seo = array("title"=>"小组搜索");
	}
	
}

