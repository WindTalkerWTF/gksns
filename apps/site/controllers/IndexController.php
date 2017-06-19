<?php

class Site_IndexController extends My_Controller_Action
{

    public function init(){
    	$this->_helper->Logined(array("addreply", "recommend","deletereply","add","doadd","edit","doedit","delete"));
    }

    public function preDispatch(){}

     /********以下为自定义内容****************/

	function indexAction(){

	    $id = (int) $this->getRequest()->getParam("id");
	    if($id){
		    $this->view->info = Site::dao()->getTree()->get(array("id"=>$id));
	    	    $page = (int) My_Tool::request("page");
	    	    $page = $page ? $page : 1;
	    	    $pageSize = 10;

	    	    $limit = $pageSize * ($page-1);

	    	    $where = array();
	    	    if($id) $where['tree_id'] = $id;
	    	    $where['is_publish'] = 1;
	    	    $where['position'] = array("like","%,2,%");
	    	    $where['face'] = array("!=",'0');
	    	    $info = Site::service()->getCommon()->getList($where, $limit, $pageSize, " created_at DESC");
	    	    $this->view->list = $info[0];
	    	    $this->view->totalNum =  $info[1];
	    	    $this->view->page = $page;
	    	    $this->view->pageSize = $pageSize;

	    	    $this->view->seo = array("title"=>$this->view->info['name']);
	    }else{
		        $info = Site::service()->getCommon()->getHomeList();
	// 	        print_r($info);
		        $this->view->seo = array("title"=>"博客");
		        $this->view->list = $info;
	    }

	    $where = array();
	    $where['pid'] =   $id;

	    $this->view->tree = Site::dao()->getTree()->gets($where,"tree_sort ASC");
	    
	    //hotgrouparc
	    $where = array();
	    $where["is_publish"] = 1;
	    $where["arc_type"] = 0;
	    $grouparcids = Group::dao()->getArc()->getField("id", $where,true,"reply_count DESC",0,150);
	    $where = array();
	    $this->view->hotgrouparc = array();
	    if($grouparcids){
		    $randArr = array_rand($grouparcids,15);
		    
		    $where['id'] = array("IN",$randArr);
			$this->view->hotgrouparc = Group::dao()->getArc()->gets($where,"","","","",false);
	    }
		//hot goup
		$where = array();
		$where["group_status"] = 1;
		$where["group_type"] = 0;
		$groupids = Group::dao()->getInfo()->getField("id", $where,true,"arc_count DESC",0,150);
		$where = array();
		$this->view->hotgroup = array();
		if($groupids){
			$randArr = array_rand($groupids,15);
			
			$where['id'] = array("IN",$randArr);
			$this->view->hotgroup = Group::dao()->getInfo()->gets($where,"","","","",false);
		}
	    if($id){
	    	$this->render("list");
	    }else{
	        $this->render("index");
	    }

	}

	//添加
	function addAction(){
		$this->_helper->layout()->setLayout("user_layout");
		$this->view->seo = array("title"=>"博客");
	}

	//编辑
	function editAction(){
		$this->_helper->layout()->setLayout("user_layout");
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;

		$this->view->info = Site::dao()->getArc()->get(array("id"=>$id));
		$this->view->content = Home::dao()->getArc()->get(array("mark"=>"site#".$id));
		if(!$this->view->info || !$this->view->content) My_Tool::showMsg("页面不存在!");
		$user =  User::service()->getCommon()->getLogined();
		if($this->view->info['uid'] != $user['id']){
			My_Tool::showMsg("你没有权限进行此操作!");
		}
		$this->view->seo = array("title"=>"编辑博客");
	}

	//处理编辑文章
	function doeditAction(){
		$this->_helper->viewRenderer->setNoRender();
		My_Tool_Form::validate("postEdit");
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;

		$this->view->info = Site::dao()->getArc()->get(array("id"=>$id));
		$this->view->content = Home::dao()->getArc()->get(array("mark"=>"site#".$id));
		if(!$this->view->info || !$this->view->content) My_Tool::showMsg("页面不存在!");
		$user =  User::service()->getCommon()->getLogined();
		if($this->view->info['uid'] != $user['id']){
			My_Tool::showMsg("你没有权限进行此操作!");
		}

		$title = trim($this->getRequest()->getParam("title"));
		$content = $this->getRequest()->getParam("content");
		$title = My_Tool::removeXss($title);
		$this->view->title = $title;
		$this->view->contentTmp = $content;

		if(!$title) My_Tool::showMsg("标题必须填写!");
				$initConfig = getInit();
		$wordCount = $initConfig['site']['title']['word']['count'];
		if(mb_strlen($title,"utf-8") <2 || mb_strlen($title,"utf-8")>$wordCount){
			My_Tool::showMsg("标题字数必须在2到".$wordCount."个字内!");
		}
		if(!My_Tool::removeXss($content)) My_Tool::showMsg("内容必须填写!");
		$content = My_Tool::getContentImg($content, true);
		$hrefs = My_Tool::getImgPath($content);
		$face = 0;
		if($hrefs) $face = $hrefs[0];
		$user = User::service()->getCommon()->getLogined();

		$descr = My_Tool::htmlCut(strip_tags($content), 100);

		$data['title'] = $title;
		$data['uid'] = $user['id'];
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['descr'] = $descr;
		if($face) $data['face'] = $face;
		Site::dao()->getArc()->update($data, array("id"=>$id));
		$aData['content'] = $content;
		Home::dao()->getArc()->update($aData, array("ref_id"=>$id, "arc_type"=>"site"));
        Home::service()->getCommon()->editTags($this->view->info['title'],$this->view->content['content'],
            $title,$content,$id,1);
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_SITE_EDIT,
		User_Service_Common::FEED_TYPE_NAME_SITE_EDIT,$title,$descr,"index/view/id/".$id,"site",$id);

		My_Tool::redirect(My_Tool::url("index/view/id/".$id));
	}

	//删除
	function deleteAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;

		$this->view->info = Site::dao()->getArc()->get(array("id"=>$id));
		if(!$this->view->info ) My_Tool::showMsg("页面不存在!");
		$user =  User::service()->getCommon()->getLogined();
		if($this->view->info['uid'] != $user['id']){
			My_Tool::showMsg("你没有权限进行此操作!");
		}
		Site::dao()->getArc()->delete(array("id"=>$id));
		Home::dao()->getArc()->delete(array("ref_id"=>$id, "arc_type"=>"site"));
		Home::dao()->getReply()->delete(array("ref_id"=>$id, "arc_type"=>"site"));

        $this->view->content = Home::dao()->getArc()->get(array("mark"=>"site#".$id));
        Home::service()->getCommon()->deleteTags($this->view->info['title'],$this->view->content['content'],$id,1);

    	$number = getSysData('site.config.coin.site.arc.delete');
    	User::service()->getCommon()->delCoin($user['id'], $number, "删除博客");

		#增减统计数目
		User::service()->getCommon()->deCrField("blog_count", $this->view->info['uid']);
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_SITE_DELETE,
		User_Service_Common::FEED_TYPE_NAME_SITE_DELETE,$this->view->info['title'],$this->view->info['descr'],"","",$id);

		My_Tool::showMsg("删除成功", My_Tool::url("index/index","site"));
	}

	//处理添加
	function doaddAction(){
		$this->_helper->viewRenderer->setNoRender();
		My_Tool_Form::validate("postadd");
        Home::service()->getCommon()->checkCode();
		$title = trim($this->getRequest()->getParam("title"));
		$content = $this->getRequest()->getParam("content");

		$this->view->title = $title;
		$this->view->contentTmp = $content;

		$title = My_Tool::removeXss($title);

		if(!$title) My_Tool::showMsg("标题必须填写!");
		if(!My_Tool::removeXss($content)) My_Tool::showMsg("内容必须填写!");
		
		$initConfig = getInit();
		$wordCount = $initConfig['site']['title']['word']['count'];
		if(mb_strlen($title,"utf-8") <2 || mb_strlen($title,"utf-8")>$wordCount){
			My_Tool::showMsg("标题字数必须在2到".$wordCount."个字内!");
		}

		$content = My_Tool::getContentImg($content, true);
		$hrefs = My_Tool::getImgPath($content);
		$face = 0;
		if($hrefs) $face = $hrefs[0];
		$user = User::service()->getCommon()->getLogined();

		$descr = My_Tool::htmlCut(strip_tags($content), 100);

		$data['title'] = $title;
		$data['tree_id'] = 0;
		$data['uid'] = $user['id'];
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['descr'] = $descr;
		if($face) $data['face'] = $face;
		$data['is_publish'] = 1;
		if($user['role'] >8) $data['position'] = ",1,";
		$id = Site::dao()->getArc()->insert($data);

		$aData['mark'] = "site#" . $id;
		$aData['arc_type'] = "site";
		$aData['ref_id'] = $id;
		$aData['content'] = $content;
		$aData['created_at'] = date('Y-m-d H:i:s');
		Home::dao()->getArc()->insert($aData);

        Home::service()->getCommon()->addTags($title,$content,$id,1);

    	$number = getSysData('site.config.coin.site.arc.add');
    	#积分增加
    	User::service()->getCommon()->addCoin($user['id'], $number, "博客奖励");
		#增减统计数目
		User::service()->getCommon()->inCrField("blog_count", $user['id']);
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_SITE_ADD,
		User_Service_Common::FEED_TYPE_NAME_SITE_ADD,$title,$descr,"index/view/id/".$id,"site",$id);
		My_Tool::redirect(My_Tool::url("index/view/id/".$id));
	}

	function viewAction(){
		$this->_helper->layout()->setLayout("site_alone_layout");

		$id = (int) $this->getRequest()->getParam("id");

		$this->view->info = Site::service()->getCommon()->getArc($id);
		if(!$this->view->info) My_Tool::showMsg("页面不存在!");
		$this->view->id = $id;
		$this->view->lastTreeName = "";
		if(isset($this->view->info)){
			$this->view->lastTreeName = $this->view->info['tree'][count($this->view->info['tree'])-1]['name'];
		}

		        $userInfo = User::service()->getCommon()->getLogined();
		        $this->view->userInfo = $userInfo;

		$isMe = 0;
		if($userInfo && ($userInfo['id'] == $this->view->info['uid'])){
			$isMe = 1;
		}
		$this->view->isMe = $isMe;

		$treeId = $this->view->info['tree_id'];
		//上一篇
		$this->view->preinfo = Site::service()->getCommon()->getArcByCompare($id,$treeId, "<");
		//下一篇
		$this->view->nextinfo = Site::service()->getCommon()->getArcByCompare($id,$treeId, ">");
		//同博客
		$this->view->sameinfo = Site::service()->getCommon()->getArcsSameTree($id,$treeId);

		#浏览自增
		Site::dao()->getArc()->inCrease("view_count", array("id"=>$id));

		$this->view->seo = array("title"=>$this->view->info['title']);
	}

    #添加回复
    function addreplyAction(){
	 	if(My_Tool::isPost()){
	 		$this->_helper->viewRenderer->setNoRender();
	 		My_Tool_Form::validate("sitereplyForm");
	 		$ref = My_Tool::getRef()."#commentsReplyer";
	 		$reply = trim($this->getRequest()->getParam("reply"));
	 		$mark = trim($this->getRequest()->getParam("mark"));
            Home::service()->getCommon()->checkCode();
	 		if(!My_Tool::removeXss($reply)) My_Tool::showMsg("输入数据不能为空!", $ref);
	 		if(!$mark) My_Tool::showMsg("数据错误!", $ref);
	 		$reply = My_Tool::getContentImg($reply, true);
	 		$user = User::service()->getCommon()->getLogined();
	 		$data['uid'] = $user['id'];
	 		$data['mark'] = $mark;
	 		list($type, $id) = explode("#", $mark);
	 		$data['ref_id'] = $id;
	 		$data['content'] = $reply;
	 		$data['arc_type'] = $type;
	 		$data['is_publish'] = Home::service()->getCommon()->contentNeedCheck();
	 		$data['created_at'] = date('Y-m-d H:i:s');
	 		$insertId = Home::dao()->getReply()->insert($data);
	 		if($insertId){
    			$number = getSysData('site.config.coin.reply.add');
    			User::service()->getCommon()->addCoin($user['id'], $number, "博客回复奖励");
		 		#增加评论数
		 		Site::dao()->getArc()->inCrease("reply_count",array("id"=>$id));
		 		#文章信息
		 		$info = Site::dao()->getArc()->get(array("id"=>$id));


	 			#通知
	 			$atUsers = User_Tool::getAtUid($reply);
	 			#回复过的会员
	 			$sql=  "SELECT uid FROM home_reply WHERE mark = 'site#".$id."' AND uid != ".$user['id']." GROUP BY uid";
	 			$followUsers = Home::dao()->getReply()->selectAllByField($sql,"uid");
	 			$noticeUsersTmp = array_merge($atUsers,$followUsers,array($info['uid']));
	 			//去重复
	 			$noticeUsers = array_unique($noticeUsersTmp);
	 			//剔除自己
	 			$key = array_search($user['id'], $noticeUsers);
	 			if($key !== false) unset($noticeUsers[$key]);
	 			#评论在分页的页数
		 		$tmpCount = Home::dao()->getReply()->getCount(array("mark"=>"site#".$id,"id"=>array("<=",$insertId)), " created_at ASC");
		 		$page = $tmpCount%10 == 0 ? $tmpCount/10:ceil($tmpCount/10);

	 			$sendTitle = "”".$user['nickname']."” 评论了文章  ”".$info['title']."”";
	 			Msg::service()->getCommon()->sendNotice($sendTitle,"index/view/id/".$id."/page/".$page."#reply_".$insertId,"site",$noticeUsers);

                #动态
                User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_SITE_REPLY_ADD,
                    User_Service_Common::FEED_TYPE_NAME_SITE_REPLY_ADD,$info['title'],$reply,"index/view/id/".$id."/page/".$page."#reply_".$insertId,"site",$id);
	 		}
	 		My_Tool::redirect($ref);
	 	}
	 	My_Tool::redirect($ref);
    }

    //删除评论
    function deletereplyAction(){
    	$this->_helper->viewRenderer->setNoRender();
    	$id= (int) $this->getRequest()->getParam("id");
    	$info = Home::dao()->getReply()->get(array("id"=>$id));
    	if(!$info)  My_Tool::showJsonp(500, "数据错误!");
    	$user =  User::service()->getCommon()->getLogined();
    	if($info['uid'] !=$user['id'])   My_Tool::showJsonp(500, "你没有权限删除别人的评论!");
    	Home::dao()->getReply()->delete(array("id"=>$id));

    	$number = getSysData('site.config.coin.reply.delete');
    	User::service()->getCommon()->delCoin($user['id'], $number, "博客回复删除");

    	#评论数减少
    	Site::dao()->getArc()->deCrement("reply_count",array("id"=>$info['ref_id'],"reply_count"=>array(">",0)));
    	#文章信息
		 $arcInfo = Site::dao()->getArc()->get(array("id"=>$info['ref_id']));
    	#动态
	User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_SITE_REPLY_DELETE,
	User_Service_Common::FEED_TYPE_NAME_SITE_REPLY_DELETE,$arcInfo['title'],$info['content'],"index/view/id/".$arcInfo['id'],"site",$id);
    	My_Tool::showJsonp(200, "删除成功!");
    }

    //推荐
	function recommendAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->info = Site::service()->getCommon()->getArc($id);
		if(!$this->view->info) My_Tool::showJsonp(500, "数据不存在!");
		#推荐
		$user =  User::service()->getCommon()->getLogined();

		$info = Site::dao()->getRecommendlog()->get(array("uid"=>$user['id'], "arc_id"=>$id));
		if($info) My_Tool::showJsonp(500, "每人每篇只能推荐一次!");
		$data['arc_id'] = $id;
		$data['uid'] = $user['id'];
		Site::dao()->getRecommendlog()->insert($data);
		#推荐自增
		Site::dao()->getArc()->inCrease("recommend_count", array("id"=>$id));
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_SITE_RECOMEND,
		User_Service_Common::FEED_TYPE_NAME_SITE_RECOMEND,$this->view->info['title'],$this->view->info['descr'],"index/view/id/".$id,"site",$id);

		 My_Tool::showJsonp(200, "推荐成功!");
	}

	//所有文章
	function allAction(){
		$this->_helper->layout()->setLayout("user_daren_layout");
		$page = (int) My_Tool::request("page");
	    	$page = $page ? $page : 1;
	    	$pageSize = 10;

	    	$limit = $pageSize * ($page-1);

	    	$where = array();

	    	$info = Site::service()->getCommon()->getList($where, $limit, $pageSize, " created_at DESC");
	    	$this->view->list = $info[0];
	    	$this->view->totalNum =  $info[1];
	    	$this->view->page = $page;
	    	$this->view->pageSize = $pageSize;

    	//活跃达人
		$sql = "SELECT a.*,b.to_follow_count FROM user_info a LEFT JOIN user_stat b ON a.id=b.uid
				ORDER BY b.blog_count DESC LIMIT 5";
		$obj = new Home_Dao_Common();
		$this->view->daren = $obj->selectAll($sql);

    	$this->view->seo = array("title"=>"所有博客");
	}

}

