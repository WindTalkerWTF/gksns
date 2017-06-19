<?php
class Ask_TagController extends My_Controller_Action
{
	
 	public function init(){
 		$this->_helper->Logined(array('follow',"cancelfollow"));
 	}

    public function preDispatch(){}

     /********以下为自定义内容****************/
    
	function indexAction(){
		$t = (int) $this->getRequest()->getParam("t");
		$this->view->t = $t;
		
		$tree = Home::dao()->getTree()->gets(array()," tree_sort ASC");
		$this->view->tree = $tree;
		
		$where = array();
		
		if($t) $where['tree_id'] = $t;
		
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 16;
    	
    	$limit = $pageSize * ($page-1);
    	
    	$orderBy = " tag_sort DESC , ask_count DESC ";
    	
    	$list = $totalNum = 0;
    	$obj = new Home_Dao_Tag();
    	$list = $obj->gets($where, $orderBy ,$limit, $pageSize, "", true);
    	$totalNum =  $obj->getTotal();
    	
    	$user = User::service()->getCommon()->getLogined();
    	$uid = isset($user['id']) ? $user['id'] :0;
    	$this->view->uid = $uid;
		if($list){
    		foreach ($list as $k=>$v){
    			$members = Ask::dao()->getTagfollow()->get(array("uid"=>$uid,"tag_id"=>$v['id']));
    			$list[$k]['hasFollow'] = $members ? 1 : 0;
    		}
    	}
    	
    	$this->view->list = $list;
    	$this->view->totalNum = $totalNum;
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	
    	#近期活跃用户
    	$tagWhere['is_publish'] = 1;
    	$sql = "SELECT * FROM ask_arc WHERE is_publish = 1 GROUP BY uid ORDER BY follow_count DESC LIMIT 15";
		$arcInfo = Ask::dao()->getArc()->selectAll($sql);
		if($arcInfo){
			foreach($arcInfo as $k=>$v){
				$arcInfo[$k]['user'] = User::service()->getCommon()->getUserInfo($v['uid']);
			}
		}
		$this->view->arcInfo = $arcInfo;
		
		$this->view->seo = array("title"=>"全部标签|标签");
	}
	
	
	function viewAction(){
		$tp = intval($this->getRequest()->getParam("tp"));
		$this->view->tp = $tp;
		
		$t = trim($this->getRequest()->getParam("t"));
		$this->view->t = $t;
		
		if(!$t) My_Tool::showMsg("页面不存在!");
		$info = Home::dao()->getTag()->get(array("name"=>strtoupper($t)));
		$this->view->info = $info;
		if(!$info) My_Tool::showMsg("页面不存在!"); 
		$this->view->id = $info['id'];
		
		$where = array();
		
		$where['tag_path'] = array("like","%,".$info['id'].",%");
		$where['is_publish'] = 1;
		
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$orderBy = "  last_action_at DESC , answer_count DESC";
    	if($tp == 1) $orderBy = " answer_count DESC , last_action_at DESC ";
    	if($tp == 2) $orderBy = " answer_count ASC , created_at DESC ";
    	
    	$list = $totalNum = 0;
    	$obj = new Ask_Dao_Arc();
    	$list = $obj->gets($where, $orderBy ,$limit, $pageSize, "", true);
    	$totalNum =  $obj->getTotal();
    	
    	$this->view->list = $list;
    	$this->view->totalNum = $totalNum;
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	
    	#是否关注
    	$user =  User::service()->getCommon()->getLogined();
		$isFollow = 0;
		if($user){
    		$tagFollowInfo = Ask::dao()->getTagfollow()->get(array("tag"=>$t,"uid"=>$user['id']));
    		$isFollow = $tagFollowInfo ? 1 : 0;
		}
		$this->view->isFollow = $isFollow;
		#相关标签
		$treeId = $info['tree_id'];
		$wheresimi['tree_id'] = $treeId;
		$wheresimi['id'] = array("<>", $info['id']);
		$similaryTag = Home::dao()->getTag()->gets($wheresimi, "follow_count DESC", 0, 10);
		$this->view->similaryTag = $similaryTag;
		#近期活跃用户
		$tagId = $info['id'];
		$tagWhere['tag_path'] = array("like","%,".$info['id'].",%");
		$tagWhere['is_publish'] = 1;
		$arcInfo = Ask::dao()->getArc()->gets($tagWhere, "follow_count DESC" ,0, 5);
		if($arcInfo){
			foreach($arcInfo as $k=>$v){
				$arcInfo[$k]['user'] = User::service()->getCommon()->getUserInfo($v['uid']);
			}
		}
		$this->view->arcInfo = $arcInfo;
		
		$this->view->seo = array("title"=>$info['name']."|标签");
	}
	
	//关注
	function followAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->info = Home::dao()->getTag()->get(array("id"=>$id));
		if(!$this->view->info) My_Tool::showJsonp(500, "数据不存在!");
		#推荐
		$user =  User::service()->getCommon()->getLogined();
		
		$info = Ask::dao()->getTagfollow()->get(array("uid"=>$user['id'], "tag_id"=>$id));
		if($info) My_Tool::showJsonp(500, "你已经关注该标签了，不能重复关注!");
		$data['tag_id'] = $id;
		$data['tag'] = $this->view->info['name'];
		$data['uid'] = $user['id'];
		Ask::dao()->getTagfollow()->insert($data);
		#关注自增
		Home::dao()->getTag()->inCrease("follow_count", array("id"=>$id));
		
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_TAG_FOLLOW,
		User_Service_Common::FEED_TYPE_NAME_ASK_TAG_FOLLOW,$this->view->info['name'],"","tag/view/t/".$this->view->info['name'],"ask",$id);
		
		My_Tool::showJsonp(200, "关注成功!");
	}
	
	#取消关注
	function cancelfollowAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->info = Home::dao()->getTag()->get(array("id"=>$id));
		if(!$this->view->info) My_Tool::showJsonp(500, "数据不存在!");
		#推荐
		$user =  User::service()->getCommon()->getLogined();
		
		$info = Ask::dao()->getTagfollow()->get(array("uid"=>$user['id'], "tag_id"=>$id));
		if($info){
			Ask::dao()->getTagfollow()->delete(array("uid"=>$user['id'], "tag_id"=>$id));
			#关注自减
			Home::dao()->getTag()->deCrement("follow_count", array("id"=>$id,"follow_count"=>array(">",0)));
			
				#动态
			User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_TAG_CANCELFOLLOW,
			User_Service_Common::FEED_TYPE_NAME_ASK_TAG_CANCELFOLLOW,$this->view->info['name'],"","","",$id);
			
		}
		
		 My_Tool::showJsonp(200, "取消关注成功!");
	}
	
	
	//标签列表
	function tagssearchAction(){
		$this->_helper->viewRenderer->setNoRender();
		header("content-type:text/javascript");
		$term = $this->getRequest()->getParam("term");
		$term = strtoupper(urldecode($term));
		if(!$term){ echo My_Tool::jsonencode(array());exit;}
		$result = Home::dao()->getTag()->gets(array("name"=>array("like","%".$term."%")),"ask_count DESC, tag_sort DESC", 0, 8);
		if(!$result) { echo My_Tool::jsonencode(array());exit;}
		$rs = array();
		foreach ($result as $v){
			$rs[] = $v['name'];
		}
   		echo My_Tool::jsonencode($rs);
   		exit;
	}	
	
}