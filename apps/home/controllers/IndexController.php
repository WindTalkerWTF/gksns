<?php

class IndexController extends My_Controller_Action
{

    public function init()
    {

    }

     public function preDispatch(){
     }

     /********以下为自定义内容****************/
     #首页
	function indexAction(){
        if(!My_Init::$isInstall){
            My_Tool::redirect("index.php/install/index/index");
            exit;
        }
	   $this->view->user = array();
	   $user = User::service()->getCommon()->getLogined();
	   if($user){
	   		$this->view->user = User::service()->getCommon()->getUserInfo($user['id']);
	   }
	    
		//文章列表
		 $this->view->recommond = Site::dao()->getArc()->gets(array("is_publish"=>1),"created_at DESC",0,8);
		
    	$obj = new Home_Dao_Common();
		//热门标签
		$this->view->tags = Home::dao()->getTag()->gets(array(),"ask_count DESC",0,20);
		//动态
		if($user){
			$sql = "SELECT a.*,c.nickname FROM user_feed a 
					INNER JOIN user_follow b ON b.follow_uid = a.uid AND b.uid = ".$user['id']."
					INNER JOIN user_info c ON a.uid = c.id ORDER BY a.created_at DESC LIMIT 3
					";
			$this->view->feed = $obj->selectAll($sql);
		}
		
		$page = (int) (int) $this->getRequest()->getParam("page");
		$page = $page ? $page : 1;
		$pageSize = 20;
		
		$limit = $pageSize * ($page-1);
		 
		$where = array();
		$where['is_publish'] = 1;
		$where['position'] = array("like","%,1,%");
		$where['face'] = array("!=",'0');
		$info = Site::service()->getCommon()->getList($where, $limit, $pageSize, " created_at DESC");
		$this->view->list = $info[0];
		$this->view->totalNum =  $info[1];
		$this->view->page = $page;
		$this->view->pageSize = $pageSize;
		
		$this->view->tree = Site::dao()->getTree()->gets(array("pid"=>0),"tree_sort ASC");
		
		//最新评论
		$sql = "SELECT a.*,c.nickname FROM user_feed a
					INNER JOIN user_info c ON a.uid = c.id 
					WHERE a.feed_type in ('SITE_REPLY_ADD','GROUP_REPLY_ADD','VIDEO_REPLY_ADD')
					ORDER BY a.created_at DESC LIMIT 20
					";
		$this->view->discuzfeed = $obj->selectAll($sql);
	   
		//热门小组
		$this->view->groups = Group::dao()->getInfo()->gets(array("group_status"=>1),"arc_count DESC",0,20);
// 		print_r($this->view->groups);
        //小组帖子展示
        $this->view->group_arc = Group::dao()->getArc()->gets(array("is_publish"=>1),"created_at DESC,reply_count DESC",$page,18);
        //问答
        $this->view->ask_arc = Ask::dao()->getArc()->gets(array("is_publish"=>1),"created_at DESC,answer_count DESC",$page,6);
        //视频
        $this->view->video_arc = Video::dao()->getlist()->gets(array("is_publish"=>1,"position"=>array("like","%,1,%")),"created_at DESC,reply_count DESC",0,6);
	}
	
	function rssAction(){
	    header('Content-type:application/xml; charset=utf-8');
	    $this->_helper->layout()->disableLayout();
	    $this->view->list = Site::dao()->getArc()->gets(array("is_publish"=>1,'position'=>array("like","%,1,%")),"created_at DESC",0,100);
	}
	
	function navAction(){
	    $this->_helper->layout()->disableLayout();
	    $this->view->appName = $this->getRequest()->getModuleName();
	    $this->view->controllerName = $this->getRequest()->getControllerName();
	    $this->view->actionName = $this->getRequest()->getActionName();
	     
	    $this->view->user = User::service()->getCommon()->getLogined();
	    $defaultAppPath = Home::service()->getCommon()->getDefaultDirectory();
	}
	
	
	function msgAction(){
		$this->view->ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
		$this->_helper->layout()->setLayout("home_showmsg_layout");
		
		$this->view->seo = array("title"=>"消息提醒");
	}
	
    #验证码
    public function verifyAction(){
        $key = $this->getRequest()->getParam("key");
    	My_Tool::importOpen("php_verify" . DS . "verify.php");
    	//调用上面定义的验证码类 来生产验证码
		YL_Security_Secoder::$useNoise = true;  //是否启用噪点  
		YL_Security_Secoder::$useCurve = false;   //是否启用干扰曲线
		YL_Security_Secoder::entry($key);
    	exit;
    }

    function successAction(){
        $this->_helper->layout()->setLayout("install_success_layout");
    }


    function upimgAction(){
        $file = $_FILES['imgFile']['tmp_name'];
        if($file){
            //上传图片
            $savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "ked" . DS . "img" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
            $imgPaths = Home::service()->getCommon()->upImg($savePath,1);
            $imgPath =  "/res/upload/ked/img/" . date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
            //截图
            $oldPath = $savePath . $imgPaths[0]['savename'];
            Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24","330x330"));
           echo  json_encode(array('error' => 0, 'url' => $imgPath));exit;
        }
        echo json_encode(array('error' => 1, 'message' => "上传为空!"));exit;
    }
}

