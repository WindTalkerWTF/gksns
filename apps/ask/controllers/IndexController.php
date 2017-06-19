<?php

class Ask_IndexController extends My_Controller_Action
{

    public function init(){
   	 $this->_helper->Logined(array("add","addreply","doadd",'follow',"cancelfollow","deletereply"));
    }

    public function preDispatch(){}

     /********以下为自定义内容****************/
	function indexAction(){
		$t = (int) $this->getRequest()->getParam("t");
		$this->view->t = $t;
		$page = (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
    	$pageSize = 15;
    	
    	$limit = $pageSize * ($page-1);
    	$where['is_publish'] = 1;
    	
    	if(!$t) $orderBy = " last_action_at DESC, created_at DESC ";
    	if($t==1) $orderBy = " created_at DESC ";
    	if($t==2) $orderBy = " answer_count DESC ";
    	
    	$list = $totalNum = 0;
    	$obj = new Ask_Dao_Arc();
    	$list = $obj->gets($where, $orderBy ,$limit, $pageSize, "", true);
    	$totalNum =  $obj->getTotal();
    	
    	$this->view->list = $list;
    	$this->view->totalNum = $totalNum;
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	
    	#猜你喜欢的标签
		
    	$this->view->hot = Home::dao()->getTag()->gets(array(),"ask_count DESC",0,20);
    	
    	$this->view->seo = array("title"=>"所有问答|问答");
	}
	
	function viewAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showMsg("页面不存在");
		$info = Ask::dao()->getArc()->get(array("id"=>$id, "is_publish"=>1));
		$user = User::dao()->getInfo()->get(array("id"=>$info['uid']));
		if(!$info) My_Tool::showMsg("页面不存在");
		$info['user'] = $user;
		$cinfo = Home::dao()->getArc()->get(array("mark"=>"ask#".$id));
		$this->view->info = $info;
		$this->view->cinfo = $cinfo;
		$this->view->id = $id;
		
		$user =  User::service()->getCommon()->getLogined();
		$isFollow = 0;
		if($user){
			$uid = $user['id'];
			$finfo = Ask::dao()->getFollowlog()->get(array("uid"=>$uid, "arc_id"=>$id));
			$isFollow = $finfo ? 1 : 0;
		}
		$this->view->isFollow = $isFollow;
		#热门问答
		$obj = new Ask_Dao_Arc();
		$where['is_publish'] = 1;
		$where['id'] = array("<>", $id);
		$orderBy = " answer_count DESC ";
    	$hot = $obj->gets($where, $orderBy ,0, 20);
    	$this->view->hot = $hot;

		$userInfo = User::service()->getCommon()->getLogined();
		$isMe = 0;
		if($userInfo && $userInfo['id'] == $this->view->info['uid']){
			$isMe = 1;
		}
		$this->view->isMe = $isMe;
		
		$this->view->seo = array("title"=>$this->view->info['title']."|问答");
	}

	//编辑
	function editAction(){
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;

		$this->view->info = Ask::dao()->getArc()->get(array("id"=>$id));
		$this->view->content = Home::dao()->getArc()->get(array("mark"=>"ask#".$id));
		if(!$this->view->info || !$this->view->content) My_Tool::showMsg("页面不存在!");
		$user =  User::service()->getCommon()->getLogined();
		if($this->view->info['uid'] != $user['id']){
			My_Tool::showMsg("你没有权限进行此操作!");
		}
		$this->view->seo = array("title"=>"编辑问答|问答");
	}


	//处理编辑文章
	function doeditAction(){
		$this->_helper->viewRenderer->setNoRender();
		My_Tool_Form::validate("editAsk");
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;

		$this->view->info = Ask::dao()->getArc()->get(array("id"=>$id));
		$this->view->content = Home::dao()->getArc()->get(array("mark"=>"ask#".$id));
		if(!$this->view->info || !$this->view->content) My_Tool::showMsg("页面不存在!");
		$user =  User::service()->getCommon()->getLogined();
		if($this->view->info['uid'] != $user['id']){
			My_Tool::showMsg("你没有权限进行此操作!");
		}

		$question = trim($this->getRequest()->getParam("question"));
		if(!$question) My_Tool::showMsg("问题不能为空!");
		$content = trim($this->getRequest()->getParam("annotation"));
		$tags = trim($this->getRequest()->getParam("tags"));
		if(!$tags) My_Tool::showMsg("标签不能为空!");
		$content = My_Tool::getContentImg($content, true);
		$data['title'] = $question;
		$tagArr = explode(',', $tags);
		$tagPath=",";
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		if(isset($tagArr[0]) && $tagArr[0])
		{
			$tag1 = Ask::service()->getCommon()->getTagIdByTagName($tagArr[0], $uid);
			$data['tag1'] = $tag1;
			$tagPath .= $tag1.",";
		}
		if(isset($tagArr[1]) && $tagArr[1]){
			$tag2 = Ask::service()->getCommon()->getTagIdByTagName($tagArr[1], $uid);
			$data['tag2'] = $tag2;
			$tagPath .= $tag2.",";
		}
		if(isset($tagArr[2]) && $tagArr[2]) {
			$tag3 = Ask::service()->getCommon()->getTagIdByTagName($tagArr[2], $uid);
			$data['tag3'] = $tag3;
			$tagPath .= $tag3.",";
		}
		
		$data['uid'] = $user['id'];
		$data['is_publish'] = 1;
		$data['last_action_at'] = date('Y-m-d H:i:s');
		$data['tag_name_path'] = strtoupper($tags);
		$data['tag_path'] = $tagPath;
		Ask::dao()->getArc()->update($data,array("id"=>$id));
		$cdata['mark'] = "ask#".$id;
		$cdata['arc_type'] = "ask";
		$cdata['content'] = $content;
		Home::dao()->getArc()->update($cdata,array("arc_type"=>"ask","ref_id"=>$id));
		
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_QUESTION_EDIT,
		User_Service_Common::FEED_TYPE_NAME_ASK_QUESTION_EDIT,$question,My_Tool::htmlCut(strip_tags($content), 100),"index/view/id/".$id,"ask",$id);
		
		My_Tool::redirect(My_Tool::url("/index/view/id/".$id),"ask");
	}

	//删除
	function deleteAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;

		$this->view->info = Ask::dao()->getArc()->get(array("id"=>$id));
		if(!$this->view->info ) My_Tool::showMsg("页面不存在!");
		$user =  User::service()->getCommon()->getLogined();
		if($this->view->info['uid'] != $user['id']){
			My_Tool::showMsg("你没有权限进行此操作!");
		}
		Ask::dao()->getArc()->delete(array("id"=>$id));
		Home::dao()->getArc()->delete(array("ref_id"=>$id, "arc_type"=>"ask"));
		Home::dao()->getReply()->delete(array("ref_id"=>$id, "arc_type"=>"ask"));
		
		
        $number = getSysData("site.config.coin.ask.arc.delete");
        User::service()->getCommon()->delCoin($user['id'], $number, "删除提问");
		
		#增减统计数目
		User::service()->getCommon()->deCrField("question_count", $this->view->info['uid']);
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_QUESTION_DELETE,
		User_Service_Common::FEED_TYPE_NAME_ASK_QUESTION_DELETE,$this->view->info['title'],"","","",$id);
		
		My_Tool::showMsg("删除成功", My_Tool::url("index/index","ask"));
	}


	//关注
	function followAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->info = Ask::dao()->getArc()->get(array("id"=>$id));
		if(!$this->view->info) My_Tool::showJsonp(500, "数据不存在!");
		#推荐
		$user =  User::service()->getCommon()->getLogined();
		
		$info = Ask::dao()->getFollowlog()->get(array("uid"=>$user['id'], "arc_id"=>$id));
		if($info) My_Tool::showJsonp(500, "你已经关注该问答了，不能重复关注!");
		$data['arc_id'] = $id;
		$data['uid'] = $user['id'];
		Ask::dao()->getFollowlog()->insert($data);
		#关注自增
		Ask::dao()->getArc()->inCrease("follow_count", array("id"=>$id));
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_QUESTION_FOLLOW,
		User_Service_Common::FEED_TYPE_NAME_ASK_QUESTION_FOLLOW,$this->view->info['title'],"","index/view/id/".$id,"ask",$id);
		
		 My_Tool::showJsonp(200, "关注成功!");
	}
	
	#取消关注
	function cancelfollowAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->info = Ask::dao()->getArc()->get(array("id"=>$id));
		if(!$this->view->info) My_Tool::showJsonp(500, "数据不存在!");
		#推荐
		$user =  User::service()->getCommon()->getLogined();
		
		$info = Ask::dao()->getFollowlog()->get(array("uid"=>$user['id'], "arc_id"=>$id));
		if($info){
			Ask::dao()->getFollowlog()->delete(array("uid"=>$user['id'], "arc_id"=>$id));
			#关注自减
			Ask::dao()->getArc()->deCrement("follow_count", array("id"=>$id,"follow_count"=>array(">",0)));
			#动态
			User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_QUESTION_CANCELFOLLOW,
			User_Service_Common::FEED_TYPE_NAME_ASK_QUESTION_CANCELFOLLOW,$this->view->info['title'],"","index/view/id/".$id,"ask",$id);
		
		}
		
		 My_Tool::showJsonp(200, "取消关注成功!");
	}
	
	function addAction(){
		$this->view->seo = array("title"=>"新问题|问答");
	}
	
		#添加回复
    function addreplyAction(){
    	$this->_helper->viewRenderer->setNoRender();
	 	if(My_Tool::isPost()){
	 		My_Tool_Form::validate("askreplyForm");
	 		$ref = My_Tool::getRef();
	 		$reply = trim($this->getRequest()->getParam("content"));
	 		$mark = trim($this->getRequest()->getParam("mark"));
            Home::service()->getCommon()->checkCode();
	 		if(!My_Tool::removeXss($reply)) My_Tool::showMsg("回答不能为空!", $ref);
	 		if(!$mark) My_Tool::showMsg("数据错误!", $ref);
	 		$reply = My_Tool::getContentImg($reply, true);
	 		$user = User::service()->getCommon()->getLogined();
	 		$data['uid'] = $user['id'];
	 		$data['mark'] = $mark;
	 		list($type, $id) = explode("#", $mark);
	 		$data['ref_id'] = $id;
	 		$data['content'] = $reply;
	 		$data['arc_type'] = $type;
	 		$data['created_at'] = date('Y-m-d H:i:s');
	 		$data['is_publish'] = Home::service()->getCommon()->contentNeedCheck();
	 		$insertId = Home::dao()->getReply()->insert($data);
	 		if($insertId){
    			$number = getSysData("site.config.coin.ask.reply.add");
    			User::service()->getCommon()->addCoin($user['id'], $number, "回答问题奖励");
		 		#增加评论数
		 		Ask::dao()->getArc()->inCrease("answer_count",array("id"=>$id));
		 		Ask::dao()->getArc()->update(array("last_action_at"=>date('Y-m-d H:i:s')), array("id"=>$id));
		 		User::service()->getCommon()->inCrField("answer_count", $user['id']);

                $arcInfo = Ask::dao()->getArc()->get(array("id"=>$id));
				#通知
	 			$atUsers = User_Tool::getAtUid($reply);
	 			#回复过的会员
	 			$sql=  "SELECT uid FROM home_reply WHERE mark = 'ask#".$id."' AND uid != ".$user['id']." GROUP BY uid";
	 			$replyUsers = Home::dao()->getReply()->selectAllByField($sql,"uid");
	 			#关注的人
	 			$sql = "SELECT uid FROM ask_follow_log WHERE arc_id = ".$id." AND uid != ".$user['id']." ";
	 			$followUsers = Home::dao()->getCommon()->selectAllByField($sql,"uid");
	 			
	 			$arcInfoIds = $arcInfo['uid'] != $user['id'] ? array($arcInfo['uid']) :array();
	 			
	 			$noticeUsersTmp = array_merge($atUsers,$replyUsers,$followUsers,$arcInfoIds);
	 			//去重复
	 			$noticeUsers = array_unique($noticeUsersTmp);
	 			//剔除自己
	 			$key = array_search($user['id'], $noticeUsers);
	 			if($key !== false) unset($noticeUsers[$key]);
	 			$sendTitle = "”".$user['nickname']."“ 回答了问题  ”".$arcInfo['title']."”";
	 			
	 			#回答即是关注
	 			if(!in_array($user['id'], $followUsers)){
		 			Ask::dao()->getFollowlog()->insert(array("uid"=>$user['id'],"arc_id"=>$id));
		 			#关注自增
					Ask::dao()->getArc()->inCrease("follow_count", array("id"=>$id));
	 			}

	 			#评论在分页的页数
		 		$tmpCount = Home::dao()->getReply()->getCount(array("mark"=>"ask#".$id,"id"=>array("<=",$insertId)), " created_at ASC");
		 		$page = $tmpCount%10 == 0 ? $tmpCount/10:ceil($tmpCount/10);
	 			
	 			Msg::service()->getCommon()->sendNotice($sendTitle,"index/view/id/".$id."/page/".$page."#answer_".$insertId,"ask",$noticeUsers);

                #动态
                User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_REPLY_ADD,
                    User_Service_Common::FEED_TYPE_NAME_ASK_REPLY_ADD,$arcInfo['title'],$reply,"index/view/id/".$id."/page/".$page."#answer_".$insertId,"ask",$insertId);
				
	 		}
	 		My_Tool::redirect($ref);
	 	}
	 	My_Tool::redirect($ref);
    }
	
    //添加处理
	function doaddAction(){
		$this->_helper->viewRenderer->setNoRender();
        Home::service()->getCommon()->checkCode();
		My_Tool_Form::validate("newAsk");
		$question = trim($this->getRequest()->getParam("question"));
		if(!My_Tool::removeXss($question)) My_Tool::showMsg("问题不能为空!");
		if(mb_strlen($question,'utf-8') <5 || mb_strlen($question,'utf-8') >40) My_Tool::showMsg("标题字数必须在2到40个字内");
		$content = trim($this->getRequest()->getParam("annotation"));
		$tags = trim($this->getRequest()->getParam("tags"));
		if(!$tags) My_Tool::showMsg("标签不能为空!");
		$content = My_Tool::getContentImg($content, true);
		$data['title'] = $question;
		$tagArr = explode(',', $tags);
		$tagPath=",";
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		if(isset($tagArr[0]) && $tagArr[0])
		{
			$tag1 = Ask::service()->getCommon()->getTagIdByTagName($tagArr[0], $uid);
			$data['tag1'] = $tag1;
			$tagPath .= $tag1.",";
		}
		if(isset($tagArr[1]) && $tagArr[1]){
			$tag2 = Ask::service()->getCommon()->getTagIdByTagName($tagArr[1], $uid);
			$data['tag2'] = $tag2;
			$tagPath .= $tag2.",";
		}
		if(isset($tagArr[2]) && $tagArr[2]) {
			$tag3 = Ask::service()->getCommon()->getTagIdByTagName($tagArr[2], $uid);
			$data['tag3'] = $tag3;
			$tagPath .= $tag3.",";
		}
		
		$data['uid'] = $user['id'];
		$data['is_publish'] = 1;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['last_action_at'] = date('Y-m-d H:i:s');
		$data['tag_name_path'] = strtoupper($tags);
		$data['tag_path'] = $tagPath;
		$insertId = Ask::dao()->getArc()->insert($data);
		if($insertId){
			$cdata['mark'] = "ask#".$insertId;
			$cdata['arc_type'] = "ask";
			$cdata['ref_id'] = $insertId;
			$cdata['content'] = $content;
			$cdata['created_at'] = date('Y-m-d H:i:s');
			Home::dao()->getArc()->insert($cdata);
			User::service()->getCommon()->inCrField("question_count", $user['id']);
			

            $number = getSysData("site.config.coin.ask.arc.add");
            User::service()->getCommon()->delCoin($user['id'], $number, "提出问题花去");
			
			#动态
			User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_QUESTION_ADD,
			User_Service_Common::FEED_TYPE_NAME_ASK_QUESTION_ADD,$question,My_Tool::htmlCut(strip_tags($content), 100),
			"index/view/id/".$insertId,"ask",$insertId);
			
			My_Tool::redirect(My_Tool::url("/index/view/id/".$insertId));
		}else{
			My_Tool::showMsg('添加失败，请重试，或与管理员联系');
		}
		
	}
	
	#回复顶
	function replygoodAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showJsonp(500, "数据错误");
		$user = User::service()->getCommon()->getLogined();
		$uid=$user['id'];
		$reply = Home::dao()->getReply()->get(array("id"=>$id));
		if(!$reply) My_Tool::showJsonp(500, "数据错误");
		if($reply['uid'] == $uid) My_Tool::showJsonp(500, "不能顶或踩自己的回答!");
		
		$tmp = Ask::dao()->getReplylog()->get(array("uid"=>$uid,"reply_id"=>$id));
		if($tmp) My_Tool::showJsonp(500, "只能顶或踩一次!");
	
		
		$data['uid'] = $uid;
		$data['reply_id'] = $id;
		$data['reply_type'] = 1;
		Ask::dao()->getReplylog()->insert($data);
		
		Home::dao()->getReply()->inCrease("support_count", array("id"=>$id));
		
        Home::service()->getCommon()->dealVoteScore($id);
			#动态
		$tmpCount = Home::dao()->getReply()->getCount(array("mark"=>"ask#".$reply['ref_id'],"id"=>array("<=",$reply['ref_id'])), " created_at ASC");
		$page = $tmpCount%10 == 0 ? $tmpCount/10:ceil($tmpCount/10);
		 		
	    $info = Group::dao()->getArc()->get(array("id"=>$reply['ref_id']));
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_REPLY_GOOD,
		User_Service_Common::FEED_TYPE_NAME_ASK_REPLY_GOOD,$info['title'],"","index/view/id/".$reply['ref_id']."/page/".$page."#reply_".$reply['ref_id'],"ask",$id);
		
		 My_Tool::showJsonp(200, "ok");
	}
	
	#回复踩
	function replybadAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showJsonp(500, "数据错误");
		
		$user = User::service()->getCommon()->getLogined();
		$uid=$user['id'];
		
		$reply = Home::dao()->getReply()->get(array("id"=>$id));
		if(!$reply) My_Tool::showJsonp(500, "数据错误");
		if($reply['uid'] == $uid) My_Tool::showJsonp(500, "不能顶或踩自己的回答!");
		
		$tmp = Ask::dao()->getReplylog()->get(array("uid"=>$uid,"reply_id"=>$id));
		if($tmp) My_Tool::showJsonp(500, "只能踩或顶一次!");
		
		$data['uid'] = $uid;
		$data['reply_id'] = $id;
		$data['reply_type'] = 0;
		Ask::dao()->getReplylog()->insert($data);
		
		Home::dao()->getReply()->inCrease("against_count", array("id"=>$id));
        Home::service()->getCommon()->dealVoteScore($id);
		 My_Tool::showJsonp(200, "ok");
	}
	
	#删除回复
	function deletereplyAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id= (int) $this->getRequest()->getParam("id");
    	$info = Home::dao()->getReply()->get(array("id"=>$id));
    	if(!$info)  My_Tool::showJsonp(500, "数据错误!");
    	$user =  User::service()->getCommon()->getLogined();
    	if($info['uid'] !=$user['id'])   My_Tool::showJsonp(500, "你没有权限删除别人的评论!");
    	Home::dao()->getReply()->delete(array("id"=>$id));
    	
    	$number = getSysData("site.config.coin.ask.reply.delete");
    	User::service()->getCommon()->addCoin($user['id'], $number, "删除回答");
    	
    	#回答数减少
    	 Ask::dao()->getArc()->deCrement("answer_count",array("id"=>$info['ref_id'],"answer_count"=>array(">",0)));
    	#动态
 		$arcInfo = Ask::dao()->getArc()->get(array("id"=>$info['ref_id']));
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_ASK_REPLY_DELETE,
		User_Service_Common::FEED_TYPE_NAME_ASK_REPLY_DELETE,$arcInfo['title'],$info['content'],"","",$id);
    	 My_Tool::showJsonp(200, "删除成功!");
	}

	
}

