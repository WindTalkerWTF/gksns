<?php

class Video_IndexController extends My_Controller_Action
{

    public function init(){
    	$this->_helper->Logined(array("addreply", "recommend","deletereply"));
    }

    public function preDispatch(){}

     /********以下为自定义内容****************/
	function indexAction(){
	    //头条
	    $where=array();
	    $where['is_publish']=1;
	    $where['position'] = array("like","%,1,%");
	    $where['face'] = array("!=",'0');
	    $this->view->tuijianinfo1 = Video::service()->getCommon()->gets($where,"created_at DESC",0,2);
	    
	    $where=array();
	    $where['is_publish']=1;
	    $where['position'] = array("like","%,1,%");
	    $where['face'] = array("!=",'0');
	    $this->view->tuijianinfo2 = Video::service()->getCommon()->gets($where,"created_at DESC",2,6);
	    
	    $where=array();
	    $where['pid']= 0 ;
	    $this->view->tree = Video::dao()->getTree()->gets($where, "tree_sort ASC");
	    
	    $page = (int) $this->getRequest()->getParam("page");
	    $page = $page ? $page : 1;
	    $pageSize = 20;
	    
	    $limit = $pageSize * ($page-1);
	    
	    $where = array();
	    $where['is_publish'] = 1;
	    $where['face'] = array("!=",'0');
	    $info = Video::service()->getCommon()->gets($where, " position ASC, fsort DESC ", $limit, $pageSize,"",true);
	    
	    $this->view->list = $info["list"];
	    $this->view->totalNum =  $info["total"];
	    $this->view->page = $page;
	    $this->view->pageSize = $pageSize;
	    
	    //side
	   //最热视频
	   $where=array();
	   $where['is_publish'] = 1;
	   $this->view->hotList = Video::dao()->getList()->gets($where,"updated_at DESC ,view_number DESC",0,20);
	    
	}
	
	
	function listAction(){
		$id = (int) $this->getParam("id");
		
		$this->view->id = $id;
		
		$this->view->info = Video::dao()->getTree()->get(array("id"=>$id));
	
		
		$page =  (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
		$pageSize = 20;
		 
		$limit = $pageSize * ($page-1);
		 
		$where = array();
		$where["tree_id"] = $id;
		$where['is_publish'] = 1;
		$where['face'] = array("!=",'0');
		$info = Video::service()->getCommon()->gets($where, " position ASC, fsort DESC ", $limit, $pageSize,"",true);
		 
		$this->view->list = $info["list"];
		$this->view->totalNum =  $info["total"];
		$this->view->page = $page;
		$this->view->pageSize = $pageSize;
		
		//最热视频
		$where=array();
		$where['is_publish'] = 1;
		$where['tree_id'] = $id;
        $this->view->hotList = Video::dao()->getList()->gets($where,"updated_at DESC ,view_number DESC",0,20);
	}
	
	function viewAction(){
		$id = (int) $this->getParam("id");
		
		$this->view->id = $id;
		
		$info = Video::dao()->getList()->get(array("id"=>$id));
		
		if(!$info) $this->showMsg("数据不存在!");
		
		$detaiInfo = Video::dao()->getDetail()->gets(array("list_id"=>$id));
		$info['detail'] = $detaiInfo;
		
		$treeinfo = Video::dao()->getTree()->get(array("id"=>$info['tree_id']));
		$info['tree'] = $treeinfo;
		
		$this->view->info = $info;
		
		$treeId = $info['tree_id'];
		//上一篇
		$this->view->preinfo = Video::service()->getCommon()->getArcByCompare($id,$treeId, "<");
		//下一篇
		$this->view->nextinfo = Video::service()->getCommon()->getArcByCompare($id,$treeId, ">");
		//同博客
		$this->view->sameinfo = Video::service()->getCommon()->getArcsSameTree($id,$treeId);

        Video::dao()->getList()->inCrease("view_number",array("id"=>$id));
	}
	
	
	#添加回复
	function addreplyAction(){
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			My_Tool_Form::validate("videoeplyForm");
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
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['is_publish'] = Home::service()->getCommon()->contentNeedCheck();
			$insertId = Home::dao()->getReply()->insert($data);
			if($insertId){
				$number = getSysData('site.config.coin.reply.add');
				User::service()->getCommon()->addCoin($user['id'], $number, "博客回复奖励");
				#增加评论数
				Video::dao()->getList()->inCrease("reply_count",array("id"=>$id));
				#文章信息
				$info = Video::dao()->getList()->get(array("id"=>$id));
				#通知
				$atUsers = User_Tool::getAtUid($reply);
				#回复过的会员
				$sql=  "SELECT uid FROM home_reply WHERE mark = 'video#".$id."' AND uid != ".$user['id']." GROUP BY uid";
	 			$followUsers = Home::dao()->getReply()->selectAllByField($sql,"uid");
		 		$noticeUsersTmp = array_merge($atUsers,$followUsers,array($info['uid']));
 					//去重复
 					$noticeUsers = array_unique($noticeUsersTmp);
 					//剔除自己
 					$key = array_search($user['id'], $noticeUsers);
 					if($key !== false) unset($noticeUsers[$key]);
 					#评论在分页的页数
 					$tmpCount = Home::dao()->getReply()->getCount(array("mark"=>"video#".$id,"id"=>array("<=",$insertId)), " created_at ASC");
 					$page = $tmpCount%10 == 0 ? $tmpCount/10:ceil($tmpCount/10);
 					 
 					$sendTitle = "”".$user['nickname']."” 评论了视频  ”".$info['title']."”";
 					Msg::service()->getCommon()->sendNotice($sendTitle,"index/view/id/".$id."/page/".$page."#reply_".$insertId,"video",$noticeUsers);
                    #动态
                    User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_VIDEO_REPLY_ADD,
                    User_Service_Common::FEED_TYPE_NAME_VIDEO_REPLY_ADD,$info['title'],$reply,"index/view/id/".$id."/page/".$page."#reply_".$insertId,"video",$insertId);
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
		User::service()->getCommon()->delCoin($user['id'], $number, "视频评论删除");
		 
		#评论数减少
		Video::dao()->getList()->deCrement("reply_count",array("id"=>$info['ref_id'],"reply_count"=>array(">",0)));
		#文章信息
		$arcInfo = Video::dao()->getList()->get(array("id"=>$info['ref_id']));
		#动态
		User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_VIDEO_REPLY_DELETE,
			User_Service_Common::FEED_TYPE_NAME_VIDEO_REPLY_DELETE,$arcInfo['title'],$info['content'],"index/view/id/".$arcInfo['id'],"video",$id);
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
			
			$info = Video::dao()->getRecommendlog()->get(array("uid"=>$user['id'], "arc_id"=>$id));
			if($info) My_Tool::showJsonp(500, "每人每篇只能推荐一次!");
			$data['arc_id'] = $id;
			$data['uid'] = $user['id'];
			Video::dao()->getRecommendlog()->insert($data);
			#推荐自增
			Video::dao()->getList()->inCrease("recommend_count", array("id"=>$id));
			#动态
			User::service()->getCommon()->addFeed($user['id'],User_Service_Common::FEED_TYPE_VIDEO_RECOMEND,
			User_Service_Common::FEED_TYPE_NAME_VIDEO_RECOMEND,$this->view->info['title'],$this->view->info['descr'],"index/view/id/".$id,"video",$id);
	
			My_Tool::showJsonp(200, "推荐成功!");
	}
	
}

