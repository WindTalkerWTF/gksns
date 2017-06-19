<?php

class Group_IndexController extends My_Controller_Action
{

    public function init(){
    	$this->_helper->Logined(array("my","new","deletereply", "donew", "addreply",'join', 'apply', "recommend","quite","recommendpost"));
    }

    public function preDispatch(){}
    

     /********以下为自定义内容****************/
	function indexAction(){
        $this->view->treeList = Home::dao()->getTree()->gets(array(),"tree_sort ASC");
        $this->view->t = (int) $this->getRequest()->getParam("t");

        $page = (int) $this->getRequest()->getParam("page");
        $page = $page ? $page : 1;
    	$pageSize = 20;
    	
    	$limit = $pageSize * ($page-1);
    	$where = array();
    	if($this->view->t) $where['tree_id'] = $this->view->t;
    	$where['group_status'] = 1;
    	
    	$orderBy = " arc_count DESC ";
    	
    	$list = $totalNum = 0;
    	list($list, $totalNum) = Group::service()->getCommon()->getPageGroups($where, $orderBy, $limit, $pageSize);
    	$this->view->list = $list;
    	$this->view->totalNum = $totalNum;
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	//近期热门小组
    	$orderBy = " arc_count DESC ";
    	$hot = Group::service()->getCommon()->getPageGroups($where, $orderBy, 0,10);
    	$this->view->hot = isset($hot[0]) ? $hot[0]:"";
    	//最新小组
    	$orderBy = " created_at DESC ";
    	$new = Group::service()->getCommon()->getPageGroups($where, $orderBy, 0,3);
    	$this->view->new = isset($new[0]) ? $new[0] : "";
    	

		$user = User::service()->getCommon()->getLogined();
		$this->view->uid = isset($user['id']) ? $user['id']:0;
    	$this->view->seo = array("title"=>"全部小组|小组");
	}
	
	function gAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showMsg('页面不存在');
		$where1['id'] = $id;
		$groupInfo = Group::dao()->getInfo()->get($where1);
		if(!$groupInfo) My_Tool::showMsg('页面不存在');
		if(!$groupInfo['group_status']) My_Tool::showMsg('页面不存在');

		$createrInfo = User::dao()->getInfo()->get(array("id"=>$groupInfo['uid']));
		$this->view->groupInfo = $groupInfo;
		$this->view->createrInfo = $createrInfo;
		//判断是否加入
		$isAdmin = 0;
		$isJoin = 0;
		$isCreator = 0;
		$uid = 0;
		$user =  User::service()->getCommon()->getLogined();
		if($user){
			$groupUserInfo = Group::dao()->getUser()->get(array("uid"=>$user['id'],"group_id"=>$id));
			if($groupUserInfo){ 
				$isJoin = 1;
				if($groupUserInfo['user_type'] > 8) $isAdmin = 1;
			}
			if($groupInfo['uid'] == $user['id']) $isCreator = 1;
			$uid = $user['id'];
		}
		
		//判断是否开放
		if($groupInfo['group_type'] && !$isJoin)  My_Tool::showMsg('该小组是私密小组,你还不是小组成员，没有权限访问该小组!');
		
		$this->view->isJoin = $isJoin;
		$this->view->isCreator = $isCreator;
		$this->view->isAdmin = $isAdmin;
		$this->view->uid = $uid;
		
		$t = (int) $this->getRequest()->getParam("t");
		$this->view->t = $t;
		$where['group_id'] = $id;
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where['is_publish'] = 1;
    	if($t) $where['position'] = array('!=',"0");
    	
    	$orderBy = "last_action_at DESC, created_at DESC ";
    	
    	$list = $totalNum = 0;
    	list($list, $totalNum) = Group::service()->getCommon()->getGroupPosts($where, $orderBy, $limit, $pageSize);
    	
    	$this->view->list = $list;
    	$this->view->totalNum = $totalNum;
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	//活跃会员
    	$userObj = new Group_Dao_User();
    	$sql= "SELECT b.nickname,b.id as uid,b.face FROM group_user a LEFT JOIN user_info b ON a.uid = b.id WHERE a.group_id='".$id."'
    			ORDER BY created_at DESC LIMIT 8";
    	$this->view->hotUser = $userObj->selectAll($sql);
    	//相关小组
		$grouObj = new Group_Dao_Info();
		$sql="SELECT * FROM group_info WHERE tree_id ='".$groupInfo['tree_id']."' AND id != '".$groupInfo['id']."' ORDER BY arc_count DESC LIMIT 8";
		$this->view->hotGroup = $grouObj->selectAll($sql);
		
		$this->view->seo = array("title"=>$groupInfo['name']."|小组");
	}
	
	
	
	//查看
	function viewAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showMsg('页面不存在');
		$info = Group::service()->getCommon()->getArc($id);
		if(!$info) My_Tool::showMsg('页面不存在');
		$this->view->canPost = 0;
		$user =  User::service()->getCommon()->getLogined();
		$uid = isset($user['id']) ? $user['id']:0;
		//判断小组类型
		$groupInfo = Group::dao()->getInfo()->get(array("id"=>$info['group_id']));
		if($groupInfo){
			$gtype = $groupInfo['group_type'];
			$status =  $groupInfo['group_status'];
			if(!$status) My_Tool::showMsg('页面不存在');
			if($gtype){
				//私密小组，判断是否有权限
			    if(!$user) My_Tool::showMsg('该帖子所属小组是私密小组,你还不是小组成员，没有权限访问该帖子!'); 
			    $checkTmp = Group::dao()->getUser()->get(array("uid"=>$user['id'],"group_id"=>$info['group_id']));
			    if(!$checkTmp) My_Tool::showMsg('该帖子所属小组是私密小组,你还不是小组成员，没有权限访问该帖子!'); 
			    if(!$checkTmp['is_shutup']){
			    	$this->view->canPost = 1;
			    }
			}else{
				$this->view->canPost = 1;
			}
		}else{
			$this->view->canPost = 1;
		}

		$this->view->info = $info;
		$this->view->id = $id;
		
		//判断是否是小组管理员
		$isAdmin = Group::dao()->getUser()->get(array("group_id"=>$info['group_id'],"uid"=>$uid,"user_type"=>array(">",8)));
		$isAdmin = $isAdmin ? true :false;
		$this->view->isAdmin = $isAdmin;
		#小组热帖
		$where['group_id'] = $info['group_id'];
		$where['is_publish'] = 1;
		$where['id'] = array("<>", $id);
		$where['arc_type'] = array("<>", 1);
		$orderBy = " recommend_count DESC ";
		$hot = Group::service()->getCommon()->getGroupPosts($where, $orderBy, 0, 20);
		$this->view->hot = isset($hot[0]) ? $hot[0]:"";
//		print_r($this->view->hot);
		$userInfo = User::service()->getCommon()->getLogined();
        $this->view->userInfo = $userInfo;
		$isMe = 0;
		if($userInfo && $userInfo['id'] == $this->view->info['uid']){
			$isMe = 1;
		}
		$this->view->isMe = $isMe;

		
		//seo
		$this->view->seo=array("title"=>stripslashes($info['title'])."|小组");
	}

	//删除
	function deleteAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;

		$this->view->info = Group::dao()->getArc()->get(array("id"=>$id));
		if(!$this->view->info ) My_Tool::showMsg("页面不存在!");
		$user =  User::service()->getCommon()->getLogined();
		//判断是否是小组管理员
		$isAdmin = Group::dao()->getUser()->get(array("group_id"=>$this->view->info['group_id'],"uid"=>$user['id'],"user_type"=>array(">",8)));
		if($this->view->info['uid'] != $user['id'] && !$isAdmin){
			My_Tool::showMsg("你没有权限进行此操作!");
		}
		Group::dao()->getArc()->delete(array("id"=>$id));
		Home::dao()->getArc()->delete(array("ref_id"=>$id, "arc_type"=>"group"));
		Home::dao()->getReply()->delete(array("ref_id"=>$id, "arc_type"=>"group"));
		
    	$number = getSysData("site.config.coin.group.arc.delete");
    	User::service()->getCommon()->delCoin($user['id'], $number, "小组帖子删除");
		
		#增减统计数目
		User::service()->getCommon()->deCrField("group_arc_count", $this->view->info['uid']);
		Group::dao()->getUser()->deCrement("post_num",array("group_id"=>$this->view->info['group_id'],"uid"=>$this->view->info['uid'],"post_num"=>array(">",0)));
                Group::dao()->getInfo()->deCrement("arc_count",array("id"=>$this->view->info['group_id'],"arc_count"=>array(">",0)));
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_GROUP_POST_DELETE,
		User_Service_Common::FEED_TYPE_NAME_GROUP_POST_DELETE,$this->view->info['title'],"","","",$id);

        $this->view->content = Home::dao()->getArc()->get(array("mark"=>"group#".$id));
        Home::service()->getCommon()->deleteTags($this->view->info['title'],$this->view->content['content'],$id,2);

		My_Tool::showMsg("删除成功", My_Tool::url("index/index","group"));
	}

	//编辑
	function editAction(){
		$this->_helper->layout()->setLayout("user_layout");
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;

		$this->view->info = Group::dao()->getArc()->get(array("id"=>$id));
		$this->view->content = Home::dao()->getArc()->get(array("mark"=>"group#".$id));
		if(!$this->view->info || !$this->view->content) My_Tool::showMsg("页面不存在!");
		$user =  User::service()->getCommon()->getLogined();
		//判断是否是小组管理员
		$isAdmin = Group::dao()->getUser()->get(array("group_id"=>$this->view->info['group_id'],"uid"=>$user['id'],"user_type"=>array(">",8)));
		if(($this->view->info['uid'] != $user['id']) && !$isAdmin){
			My_Tool::showMsg("你没有权限进行此操作!");
		}
		$this->view->groupInfo = Group::dao()->getInfo()->get(array("id"=>$this->view->info['group_id']));
		
		$this->view->seo = array("title"=>"文章编辑|小组");
	}

	//处理编辑文章
	function doeditAction(){
		$this->_helper->viewRenderer->setNoRender();
		My_Tool_Form::validate("gpostedit");
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;

		$this->view->info = Group::dao()->getArc()->get(array("id"=>$id));
		$this->view->content = Home::dao()->getArc()->get(array("mark"=>"group#".$id));
		if(!$this->view->info || !$this->view->content) My_Tool::showMsg("页面不存在!");

		$user =  User::service()->getCommon()->getLogined();
		//判断是否是小组管理员
		$isAdmin = Group::dao()->getUser()->get(array("group_id"=>$this->view->info['group_id'],"uid"=>$user['id'],"user_type"=>array(">",8)));
		if($this->view->info['uid'] != $user['id'] && !$isAdmin){
			My_Tool::showMsg("你没有权限进行此操作!");
		}

		$title = trim($this->getRequest()->getParam("title"));
		$content = $this->getRequest()->getParam("content");
		$content = My_Tool::getContentImg($content, true);
		$this->view->title = $title;
		$this->view->contentTmp = $content;

		$title = My_Tool::removeXss($title);
		if(!$title) My_Tool::showMsg('标题必须填写', My_Tool::url("index/edit/id/".$id));
		$initConfig = getInit();
		$wordCount = $initConfig['site']['title']['word']['count'];
		if(mb_strlen($title,"utf-8") <2 || mb_strlen($title,"utf-8")>$wordCount){
			My_Tool::showMsg("标题字数必须在2到".$wordCount."个字内!");
		}
		if(!My_Tool::removeXss($content)) My_Tool::showMsg("内容必须填写!");

		$user = User::service()->getCommon()->getLogined();

		$data['title'] = $title;
		$data['created_at'] = date('Y-m-d H:i:s');
        $hrefs = My_Tool::getImgPath($content);
        $face = 0;
        if($hrefs) $face = $hrefs[0];
        $data['face'] = $face;
		Group::dao()->getArc()->update($data, array("id"=>$id));
		$aData['content'] = $content;

		Home::dao()->getArc()->update($aData, array("ref_id"=>$id, "arc_type"=>"group"));

        Home::service()->getCommon()->editTags($this->view->info['title'],$this->view->content['content'],
            $title,$content,$id,2);

		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_GROUP_POST_EDIT,
		User_Service_Common::FEED_TYPE_NAME_GROUP_POST_EDIT,$title,"","index/view/id/".$id,"group",$id);
		
		My_Tool::redirect(My_Tool::url("index/view/id/".$id));
	}

	//推荐
	function recommendAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->info = Group::dao()->getArc()->get(array("id"=>$id));
		if(!$this->view->info) My_Tool::showJsonp(500, "数据不存在!");
		#推荐
		$user =  User::service()->getCommon()->getLogined();
		
		$info = Group::dao()->getRecommendlog()->get(array("uid"=>$user['id'], "arc_id"=>$id));
		if($info) My_Tool::showJsonp(500, "每人每篇只能推荐一次!");
		$data['arc_id'] = $id;
		$data['uid'] = $user['id'];
		Group::dao()->getRecommendlog()->insert($data);
		#推荐自增
		Group::dao()->getArc()->inCrease("recommend_count", array("id"=>$id));
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_GROUP_POST_RECOMMENG,
		User_Service_Common::FEED_TYPE_NAME_GROUP_POST_RECOMMENG,$this->view->info['title'],"","index/view/id/".$id,"group",$id);
		My_Tool::showJsonp(200, "推荐成功!");
	}
	
	//所有帖子
	function allViewAction(){
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where['is_publish'] = 1;
    	$where['arc_type'] = array("<>",1);
    	
    	$orderBy = " last_action_at DESC, created_at DESC ";
    	
    	$list = $totalNum = 0;
    	list($list, $totalNum) = Group::service()->getCommon()->getGroupPosts($where, $orderBy, $limit, $pageSize);
    	
    	$this->view->list = $list;
    	$this->view->totalNum = $totalNum;
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	
    	//近期热门小组
    	$whereg['group_status'] = 1;
    	$orderBy = " arc_count DESC ";
    	$hotg = Group::service()->getCommon()->getPageGroups($whereg, $orderBy, 0,10);
    	$this->view->hotg = isset($hotg[0]) ? $hotg[0]:"";
    	
    	//热门帖子
    	$where['is_publish'] = 1;
    	$orderBy = " reply_count DESC";
    	$hotPosts = Group::service()->getCommon()->getGroupPosts($where, $orderBy, 0, 3);
    	$this->view->hot = isset($hotPosts[0]) ? $hotPosts[0]:"";
//    	print_r($this->view->hotg);
		$this->view->seo = array("title"=>"小组所有帖子|小组");
	}
	
	//发新贴
	function newAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showMsg('页面不存在');
		$info = Group::dao()->getInfo()->get(array("id"=>$id));
		if(!$info) My_Tool::showMsg('页面不存在');
		$this->view->id = $id;
		$this->view->info = $info;
		
		$user = User::service()->getCommon()->getLogined();
		//判断是否是会员
		$checkInfo = Group::dao()->getUser()->get(array("uid"=>$user['id'],"group_id"=>$id));
		if(!$checkInfo) My_Tool::showMsg('你没有加入该小组，不能发帖');
		if($checkInfo['is_shutup']) My_Tool::showMsg("你已经被本小组管理员禁言，暂时不能发表文章");
		
		$this->view->seo = array("title"=>"发新帖|小组");
	}
	//发帖处理
	function donewAction(){
		$this->_helper->viewRenderer->setNoRender();
        Home::service()->getCommon()->checkCode();
		My_Tool_Form::validate("gpostadd");
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showMsg('页面不存在');
		$info = Group::dao()->getInfo()->get(array("id"=>$id));
		if(!$info) My_Tool::showMsg('页面不存在');
		$user = User::service()->getCommon()->getLogined();
		//判断是否是会员
		$checkInfo = Group::dao()->getUser()->get(array("uid"=>$user['id'],"group_id"=>$id));
		if(!$checkInfo) My_Tool::showMsg('你没有加入该小组，不能发帖');
		if($checkInfo['is_shutup']) My_Tool::showMsg("你已经被本小组管理员禁言，暂时不能发表文章");
		
		$title  = trim($this->getRequest()->getParam("title"));
		$content  = trim($this->getRequest()->getParam("content"));
		
		$title = My_Tool::removeXss($title);
		$initConfig = getInit();
		$wordCount = $initConfig['site']['title']['word']['count'];
		if(!$title) My_Tool::showMsg('标题必须填写', My_Tool::url("index/new/id/".$id));
		if(mb_strlen($title,"utf-8") <2 || mb_strlen($title,"utf-8")>$wordCount){
			My_Tool::showMsg("标题字数必须在2到".$wordCount."个字内!");
		}
		if(!My_Tool::removeXss($content)) My_Tool::showMsg('内容必须填写', My_Tool::url("index/new/id/".$id));
		$content = My_Tool::getContentImg($content, true);

        $hrefs = My_Tool::getImgPath($content);
        $face = 0;
        if($hrefs) $face = $hrefs[0];

		$data['title'] = $title;
		$data['group_id'] = $id;
		$data['uid'] = $user['id'];
		$data['is_publish'] = 1;
        $data['face'] =$face;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['last_action_at'] = date('Y-m-d H:i:s');
		$data['arc_type'] = $info['group_type']?1:0;
		$insertId = Group::dao()->getArc()->insert($data);
		if($insertId){
			$cdata['mark'] = "group#".$insertId;
			$cdata['arc_type'] = "group";
			$cdata['ref_id'] = $insertId;
			$cdata['content'] = $content;
			$cdata['created_at'] = date('Y-m-d H:i:s');
			Home::dao()->getArc()->insert($cdata);
			
    		$number = getSysData('site.config.coin.group.arc.add');
    		User::service()->getCommon()->addCoin($user['id'], $number, "添加小组帖子奖励");
			
			#增减统计数目
			User::service()->getCommon()->inCrField("group_arc_count", $user['id']);
			Group::dao()->getUser()->inCrease("post_num",array("group_id"=>$id,"uid"=>$user['id']));
            Group::dao()->getInfo()->inCrease("arc_count",array("id"=>$id));
			#动态
			User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_GROUP_POST_ADD,
			User_Service_Common::FEED_TYPE_NAME_GROUP_POST_ADD,$title,My_Tool::htmlCut(strip_tags($content), 100),"index/view/id/".$insertId,"group",$insertId);
			
			#群组会员
 			$sql=  "SELECT uid FROM group_user WHERE uid != ".$user['id']." AND group_id = {$id} GROUP BY uid";
 			$noticeUsers = Home::dao()->getCommon()->selectAllByField($sql,"uid");
 			
 			$sendTitle = "”".$user['nickname']."” 发布了帖子  ”".$title."”";
 			Msg::service()->getCommon()->sendNotice($sendTitle,"index/view/id/".$insertId,"group",$noticeUsers);
            //tag
            Home::service()->getCommon()->addTags($title,$content,$insertId,2);

		}
		My_Tool::redirect(My_Tool::url("index/view/id/".$insertId));
	}
	
	#添加回复
    function addreplyAction(){
	 	if(My_Tool::isPost()){
	 		$this->_helper->viewRenderer->setNoRender();
	 		My_Tool_Form::validate("greplyForm");
	 		$ref = My_Tool::getRef()."#commentsReplyer";
	 		$reply = trim($this->getRequest()->getParam("reply"));
	 		$mark = trim($this->getRequest()->getParam("mark"));
            Home::service()->getCommon()->checkCode();
	 		if(!$reply) My_Tool::showMsg("输入数据不能为空!", $ref);
	 		if(!$mark) My_Tool::showMsg("数据错误!", $ref);
	 		$user = User::service()->getCommon()->getLogined();
	 		list($type, $id) = explode("#", $mark);
	 		#帖子信息
		 	$info = Group::dao()->getArc()->get(array("id"=>$id));
		 	//判断是否是会员
			$checkInfo = Group::dao()->getUser()->get(array("uid"=>$user['id'],"group_id"=>$info['group_id']));
			if(!$checkInfo) My_Tool::showMsg('你没有加入该小组，不能发帖');
			if($checkInfo['is_shutup']) My_Tool::showMsg("你已经被本小组管理员禁言，暂时不能发表文章");
			$reply = My_Tool::getContentImg($reply, true);
		
		 	$data['uid'] = $user['id'];
	 		$data['mark'] = $mark;
	 		$data['ref_id'] = $id;
	 		$data['content'] = $reply;
	 		$data['arc_type'] = $type;
	 		$data['created_at'] = date('Y-m-d H:i:s');
	 		$data['is_publish'] = Home::service()->getCommon()->contentNeedCheck();
	 		$insertId = Home::dao()->getReply()->insert($data);
	 		if($insertId){
    			$number = getSysData('site.config.coin.reply.add');
    			User::service()->getCommon()->addCoin($user['id'], $number, "回复小组帖子奖励");
		 		#增加评论数
		 		Group::dao()->getArc()->inCrease("reply_count",array("id"=>$id));
		 		Group::dao()->getArc()->update(array("last_action_at"=>date('Y-m-d H:i:s')), array("id"=>$id));
		 		#评论在分页的页数
		 		$tmpCount = Home::dao()->getReply()->getCount(array("mark"=>"group#".$id,"id"=>array("<=",$insertId)), " created_at ASC");
		 		$page = $tmpCount%10 == 0 ? $tmpCount/10:ceil($tmpCount/10);


				#通知
	 			$atUsers = User_Tool::getAtUid($reply);
	 			#回复过的会员
	 			$sql=  "SELECT uid FROM home_reply WHERE mark = 'group#".$id."' AND uid != ".$user['id']." GROUP BY uid";
	 			$followUsers = Home::dao()->getReply()->selectAllByField($sql,"uid");
	 			$infoIds = array($info['uid']);
	 			$noticeUsersTmp = array_merge($atUsers,$followUsers,$infoIds);
	 			//去重复
	 			$noticeUsers = array_unique($noticeUsersTmp);
	 			//剔除自己
	 			$key = array_search($user['id'], $noticeUsers);
	 			if($key !== false) unset($noticeUsers[$key]);
	 			$sendTitle = "”".$user['nickname']."” 评论了小组帖子 ”".$info['title']."”";
	 			Msg::service()->getCommon()->sendNotice($sendTitle,"index/view/id/".$id."/page/".$page."#reply_".$insertId,"group",$noticeUsers);

                #动态
                User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_GROUP_REPLY_ADD,
                    User_Service_Common::FEED_TYPE_NAME_GROUP_REPLY_ADD,$info['title'],$reply,"index/view/id/".$id."/page/".$page."#reply_".$insertId,"group",$insertId);
	 		}
	 		My_Tool::redirect($ref);
	 	}
	 	My_Tool::redirect($ref);
    }
    
	//所有小组用户
	function membersAction(){
		$id = intval($this->getRequest()->getParam("id"));
    	if(!$id) My_Tool::showMsg("数据错误", My_Tool::url("index/index"));
    	$info = Group::dao()->getInfo()->get(array("id"=>$id));
    	if(!$info || !$info['group_status'])  My_Tool::showMsg("小组不存在", My_Tool::url("index/index"));
    	$this->view->info = $info;
    	#创始人
    	$this->view->creator = User::dao()->getInfo()->get(array("id"=>$info['uid']));
    	
    	#管理员
    	$obj = new Group_Dao_User();
    	$adminUserSql = "SELECT b.* FROM group_user a INNER JOIN user_info b ON a.uid=b.id WHERE a.group_id = :group_id  
    					AND a.user_type = 9 
    					ORDER BY a.created_at ASC ";
    	$this->view->adminUser = $obj->selectAll($adminUserSql, array("group_id"=>$id));
    	
    	#普通成员
    	$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
		
    	$obj = new Group_Dao_User();
    	$userSql = "
    		SELECT SQL_CALC_FOUND_ROWS b.* FROM group_user a INNER JOIN user_info b ON a.uid=b.id WHERE a.group_id = :group_id
    		AND a.user_type = 0 
    		ORDER BY a.created_at ASC LIMIT ".$limit." ,".$pageSize."
    	";
    	$list = $obj->selectAll($userSql, array("group_id"=>$id), true);
    	
    	$this->view->list = $list;
    	$this->view->totalNum = $obj->getTotal();
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	
    	$this->view->seo = array("title"=>"“".$info['name']."”小组所有用户|小组");
	}
    
    #申请创建小组
    function applyAction(){
    	$this->view->seo = array("title"=>"申请创建小组|小组");
    }
    
    //处理申请创建小组
    function doapplyAction(){
		$this->_helper->viewRenderer->setNoRender();
    	My_Tool_Form::validate("newGroup");
    	$area = (int) $this->getRequest()->getParam("area");
    	$name = $this->getRequest()->getParam("name");
    	$introduction = trim($this->getRequest()->getParam("introduction"));
    	$annotation = trim($this->getRequest()->getParam("annotation"));
    	$contact = trim($this->getRequest()->getParam("contact"));
    	$file = $_FILES['upload_file']['tmp_name'];
    	if(!$name) My_Tool::showMsg("小组名称不能为空!","history.back()",1);
    	if(!$introduction) My_Tool::showMsg("介绍不能为空!","history.back()",1);
    	if(!$annotation) My_Tool::showMsg("申请理由不能为空!","history.back()",1);
    	if(!$contact) My_Tool::showMsg("QQ不能为空!","history.back()",1);
    	if(!$file) My_Tool::showMsg("小组图标需要上传!","history.back()",1);
    	
    	//判断小组名称是否重复
    	$checkoinfo = Group::dao()->getInfo()->get(array("name"=>$name));
    	if($checkoinfo)  My_Tool::showMsg("小组名称重复!","history.back()",1);
    	
    	
    	$user =  User::service()->getCommon()->getLogined();
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
		$data['uid'] = $user['id'];
		$data['descr'] = $introduction;
		$data['tree_id'] = 0;
		$data['group_status'] = 0;
		$data['apply_result'] = $annotation;
		$data['contact'] = $contact;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['group_type'] = $area;
		
		if($file) $data['face'] = $imgPath;
		
		$id = Group::dao()->getInfo()->insert($data);
		if($id){
			#添加成员
			$idata['uid'] = $user['id'];
			$idata['group_id'] = $id;
			$idata['user_type'] = 10;
			Group::dao()->getUser()->insert($idata);
			Group::dao()->getInfo()->inCrease("user_number",array("id"=>$id));
			
			#动态
			User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_GROUP_APPLY,
			User_Service_Common::FEED_TYPE_NAME_GROUP_APPLY, $name,"","","",$id);
			
			My_Tool::showMsg("申请成功,管理员会在5个工作日内审核你的申请，审核结果将通过站内信通知你，请耐心等待!");
		}else{
			My_Tool::showMsg("操作失败，请重试或与管理员联系!");
		}
				
   	}
    
 	#加入小组
    function joinAction(){
    	$this->_helper->viewRenderer->setNoRender();
    	$id = intval($this->getRequest()->getParam("id"));
    	if(!$id) My_Tool::showJsonp(500, "数据错误");
    	$info = Group::dao()->getInfo()->get(array("id"=>$id));
    	if(!$info)  My_Tool::showJsonp(500, "小组不存在");
    	//判断是否是官方小组

    	$mygid = getSysData('site.config.group.my.id');
    	
    	$user = User::service()->getCommon()->getLogined();
    	$uid = $user['id'];
    	
    	if($mygid == $id && $user['role'] < 9){
    		My_Tool::showJsonp(500, "此小组是'官方小组'只能是本站管理员才能加入");
    	}
    	
    	$infoCheck = Group::dao()->getUser()->get(array("uid"=>$uid, "group_id"=>$id));
    	if($infoCheck)  My_Tool::showJsonp(500, "你已加入该小组,不能重复加入");
    	//判断是否是私密群
    	if($info['group_type'])  My_Tool::showJsonp(100, "该小组是私密小组请填写申请资料!");
    	$data['uid'] = $uid;
    	$data['group_id'] = $id;
    	Group::dao()->getUser()->insert($data);
    	
    	User::service()->getCommon()->inCrField("group_count", $uid);
    	#统计
    	Group::dao()->getInfo()->inCrease("user_number",array("id"=>$id));
    	#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_GROUP_JOIN,
		User_Service_Common::FEED_TYPE_NAME_GROUP_JOIN,$info['name'],"","index/g/id/".$id,"group",$id);
    	My_Tool::showJsonp(200, "加入成功");
    }
    
    #私有群加入小组
    function  privatejoinAction(){
    	$this->_helper->viewRenderer->setNoRender();
    	$id = intval($this->getRequest()->getParam("id"));
    	if(!$id) My_Tool::showJsonp(500, "数据错误");
    	$info = Group::dao()->getInfo()->get(array("id"=>$id));
    	if(!$info)  My_Tool::showJsonp(500, "小组不存在");
    	$user = User::service()->getCommon()->getLogined();
    	$uid = $user['id'];
    	$infoCheck = Group::dao()->getUser()->get(array("uid"=>$uid, "group_id"=>$id));
    	if($infoCheck)  My_Tool::showJsonp(500, "你已加入该小组,不能重复加入");
    	$reason = trim($this->getRequest()->getParam("reason"));
    	if(!$reason) My_Tool::showJsonp(500, "申请资料不能为空");
    	#发送短消息
    	$reason = My_Tool::removeXss($reason);
    	$content = "<h3>申请加入小组[<a href=\"".My_Tool::url("index/g/id/".$info['id'],"group")."\" target=\"_blank\" >".$info['name']."</a>]</h3>";
    	$content .= "<p>理如下:</p>";
    	$content .= "<div>“".$reason."”</div>";
    	$content .= "<p><a href=\"".My_Tool::url("index/agree/id/".$uid."/gid/".$info['id'],"group")."\" >同意</a></p>";
    	
    	Msg::service()->getCommon()->sendMsg($uid, $info['uid'], $content,0,1);
    	
    	My_Tool::showJsonp(200, "你的申请已通知小组创始人，请耐心等待消息");
    	
    }
    
    function agreeAction(){
    	$this->_helper->viewRenderer->setNoRender();
    	$gid = (int) $this->getRequest()->getParam("gid");
    	$id = (int) $this->getRequest()->getParam("id");
    	if(!$id) My_Tool::showMsg("数据错误","history.back()",1);
    	if(!$gid) My_Tool::showMsg("数据错误","history.back()",1);
    	$info = Group::dao()->getInfo()->get(array("id"=>$gid));
    	if(!$info) My_Tool::showMsg("小组不存在","history.back()",1);
    	$user = User::service()->getCommon()->getLogined();
    	$uid = $user['id'];
    	if($info['uid']!=$uid) My_Tool::showMsg('你没有权限进行此操作',"history.back()",1);
    	$infoCheck = Group::dao()->getUser()->get(array("uid"=>$id, "group_id"=>$gid));
    	if($infoCheck)  My_Tool::showMsg("该会员已加入该小组,不能重复加入","history.back()",1);
    	$data['uid'] = $id;
    	$data['group_id'] = $gid;
    	Group::dao()->getUser()->insert($data);
    	User::service()->getCommon()->inCrField("group_count", $id);
		#统计
    	Group::dao()->getInfo()->inCrease("user_number",array("id"=>$gid));
    	#发送消息
    	$content = "恭喜你，你被批准加入小组[<a href=\"".My_Tool::url("index/g/id/".$info['id'],"group")."\" target=\"_blank\" >".$info['name']."</a>]";
    	Msg::service()->getCommon()->sendMsg($uid, $id, $content,0,1);
    	My_Tool::showMsg("操作成功!","history.back()",1);
    }
    
	#退出小组
    function quiteAction(){
    	$this->_helper->viewRenderer->setNoRender();
    	$id = intval($this->getRequest()->getParam("id"));
    	if(!$id) My_Tool::showJsonp(500, "数据错误");
    	$info = Group::dao()->getInfo()->get(array("id"=>$id));
    	if(!$info)  My_Tool::showJsonp(500, "小组不存在");
    	$user =  User::service()->getCommon()->getLogined();
    	Group::dao()->getUser()->delete(array("uid"=>$user['id'],"group_id"=>$id));
    	User::service()->getCommon()->inCrField("group_count", $user['id']);
    	#统计
    	Group::dao()->getInfo()->deCrement("user_number",array("id"=>$id,"user_number"=>array(">",0)));
    	#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_GROUP_QUITE,
		User_Service_Common::FEED_TYPE_NAME_GROUP_QUITE,$info['name'],"","index/g/id/".$id,"group",$id);
		
    	My_Tool::showJsonp(200, "退出成功");
    }
	
    //删除回复
    function deletereplyAction(){
    	$this->_helper->viewRenderer->setNoRender();
    	$id= (int) $this->getRequest()->getParam("id");
    	$info = Home::dao()->getReply()->get(array("id"=>$id));
    	if(!$info)  My_Tool::showJsonp(500, "数据错误!");
    	$user =  User::service()->getCommon()->getLogined();
    	if($info['uid'] !=$user['id'])   My_Tool::showJsonp(500, "你没有权限删除别人的评论!");
    	Home::dao()->getReply()->delete(array("id"=>$id));
    	

    	$number = getSysData('site.config.coin.reply.delete');
    	User::service()->getCommon()->delCoin($user['id'], $number, "删除小组帖子回复");
    	
    	#评论数减少
    	 Group::dao()->getArc()->deCrement("reply_count",array("id"=>$id,"reply_count"=>array(">",0)));
    	 $arcInfo = Group::dao()->getArc()->get(array("id"=>$info['ref_id']));
    	#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_GROUP_REPLY_DELETE,
		User_Service_Common::FEED_TYPE_NAME_GROUP_REPLY_DELETE,$arcInfo['title'],$info['content'],"index/view/id/".$info['id'],"group",$id);
    	 
    	 My_Tool::showJsonp(200, "删除成功!");
    }
    //我的小组
    function myAction(){
        $t = (int) $this->getParam("t",1);
        $this->view->t = $t;
        $page = (int) $this->getRequest()->getParam("page");
        $page = $page ? $page : 1;
        $pageSize = 20;
         
        $limit = $pageSize * ($page-1);
        
        $user = User::service()->getCommon()->getLogined();
        $uid = $user['id'];
        //新回复的帖子
        if($t == 1){
        	$sql = "SELECT a.*,g.name FROM group_arc a INNER JOIN home_reply r ON a.id=r.ref_id and r.arc_type='group' 
        	        INNER JOIN group_info g ON  g.id = a.group_id 
        	        GROUP BY a.group_id ORDER BY r.created_at DESC LIMIT {$limit},{$pageSize} ";
        	$db = Group::dao()->get();
        	$list = $db->selectAll($sql,array(),true);
        	$totalNum = $db->getTotal();
        }
        //新发布的帖子
        if($t == 2){
            $sql = "SELECT a.*,g.name FROM group_arc a
            INNER JOIN group_info g ON  g.id = a.group_id
            ORDER BY created_at DESC LIMIT {$limit},{$pageSize} ";
            $db = Group::dao()->get();
            $list = $db->selectAll($sql,array(),true);
            $totalNum = $db->getTotal();
        }
        
        //我回复的帖子
        if($t == 4){
            $sql = "SELECT a.*,g.name FROM group_arc a INNER JOIN home_reply r ON a.id=r.ref_id and r.arc_type='group'
            INNER JOIN group_info g ON  g.id = a.group_id
            WHERE r.uid = '{$uid}' GROUP BY  a.group_id ORDER BY r.created_at DESC LIMIT {$limit},{$pageSize} ";
            $db = Group::dao()->get();
            $list = $db->selectAll($sql,array(),true);
            $totalNum = $db->getTotal();
        }
        //我发布的帖子
        if($t == 3){
            $sql = "SELECT a.*,g.name FROM group_arc a
            INNER JOIN group_info g ON  g.id = a.group_id
            WHERE a.uid = '{$uid}' ORDER BY created_at DESC LIMIT {$limit},{$pageSize} ";
            $db = Group::dao()->get();
            $list = $db->selectAll($sql,array(),true);
            $totalNum = $db->getTotal();
        }
        
        
        $this->view->list = $list;
        $this->view->totalNum = $totalNum;
         
        $this->view->page = $page;
        $this->view->pageSize = $pageSize;
        
        //我加入的小组
        $obj = new Group_Dao_Info();
        $sql = "SELECT SQL_CALC_FOUND_ROWS a.*,b.uid FROM group_info a LEFT JOIN group_user b ON a.id = b.group_id WHERE b.uid = {$uid}
        AND a.group_status=1 ORDER BY b.user_type DESC,a.created_at DESC LIMIT 24";
        $grouplist = $obj->selectAll($sql,array());
//         print_r($grouplist);
        $this->view->grouplist = $grouplist;
    }
    
    //推荐
    function recommendpostAction(){
    	$this->_helper->viewRenderer->setNoRender();
    	$id = (int) $this->getParam("id");
    	$user =  User::service()->getCommon()->getLogined();
    	$info = Group::dao()->getArc()->get(array("id"=>$id));
    	if(!$info){
    		My_Tool::showJsonp(500,"文章不存在");
    	}
    	//判断是否是小组管理员
    	$isAdmin = Group::dao()->getUser()->get(array("group_id"=>$info['group_id'],"uid"=>$user['id'],"user_type"=>array(">",8)));
    	if(!$isAdmin){
    		My_Tool::showJsonp(500,"你没有权限进行此操作!");
    	}
    	
    	$poArr = array();
    	$poArr = explode(",",trim($info['position'],","));
    	$poArr[] = 2;
    	$result = array_unique($poArr);
    	$poStr = ",".trim(implode(",",$result),',').",";
    	Group::dao()->getArc()->update(array("position"=>$poStr),array("id"=>$id));
    	My_Tool::showJsonp(200,"操作成功");
    }
    
    //取消推荐
    function cancelrecommendpostAction(){
    	$this->_helper->viewRenderer->setNoRender();
    	$id = (int) $this->getParam("id");
    	$user =  User::service()->getCommon()->getLogined();
    	$info = Group::dao()->getArc()->get(array("id"=>$id));
    	if(!$info){
    		My_Tool::showJsonp(500,"文章不存在");
    	}
    	//判断是否是小组管理员
    	$isAdmin = Group::dao()->getUser()->get(array("group_id"=>$info['group_id'],"uid"=>$user['id'],"user_type"=>array(">",8)));
    	if(!$isAdmin){
    		My_Tool::showJsonp(500,"你没有权限进行此操作!");
    	}
    	 
    	Group::dao()->getArc()->update(array("position"=>"0"),array("id"=>$id));
    	My_Tool::showJsonp(200,"操作成功");
    }
	
}

