<?php

class Msg_IndexController extends My_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
//    	$this->_helper->layout()->disableLayout();
//    	$this->_helper->viewRenderer->setNoRender();
    	//$this->_helper->cache(array("index"), array("sss"));
//    	$this->_helper->Logined(array());
		$this->_helper->Logined(array("index", "delmsg", "add","notice","subreply","getnotice","marknoticeread"));
    }

     public function preDispatch(){
     }

     /********以下为自定义内容****************/
     #个人资料首页
	function indexAction(){
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		//分页
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		$obj = new Msg_Dao_Data();
		$sql = "
		SELECT SQL_CALC_FOUND_ROWS * FROM msg_data WHERE id=root_id AND ((uid='".$uid."' AND send_status = 1 AND msg_type=0) OR 
		(receive_uid = '".$uid."' AND receve_status = 1)) 
		ORDER BY created_at DESC  LIMIT ".$limit.", ".$pageSize."
		";
		
    	$this->view->list = $obj->selectAll($sql,array(),1);
    	$this->view->totalNum =  $obj->getTotal();
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	
    	if($this->view->list){
    		foreach($this->view->list as $k=>$v){
    			Msg::dao()->getData()->update(array("is_read"=>1),array("id"=>$v['id']));
    			$rootId = $v['id'];
    			$info = $obj->selectRow("SELECT * FROM msg_data WHERE root_id = '".$rootId."' ORDER BY created_at DESC LIMIT 1");
    			if($info['uid'] == $uid){
					$userinfo = User::dao()->getInfo()->get(array("id"=>$info['receive_uid']));
    				$info['user_receive'] = $userinfo;
    			}else{
    				$userinfo = User::dao()->getInfo()->get(array("id"=>$info['uid']));
	    			$info['user_send'] = $userinfo;
    			}
    			$this->view->list[$k]['info'] = $info;
    		}
    	}
    	
	}
	
	function getremindAction(){
		$this->_helper->viewRenderer->setNoRender();
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		
		$db = Msg::dao()->getData();
		$list = $db->gets(array("receive_uid"=>$uid, "receve_status"=>1, "is_read"=>0)," created_at DESC", 0,5,"",true);
		$count = $db->getTotal();
		$rs = array();
		if($list){
			foreach ($list as $v){
				$suid = $v['uid'];
				$userinfo = User::dao()->getInfo()->get(array("id"=>$suid));
				$url = My_Tool::url("/index/subreply/id/".$v['root_id'],"msg");
				$rs[]=array("user"=>$userinfo, "url"=>$url);
			}
			My_Tool::showJsonp(200, array("list"=>$rs,"count"=>$count));
		}
		My_Tool::showJsonp(200, '');
	}
	
	#通知
	function noticeAction(){
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		//分页
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		$obj = new Msg_Dao_Notice();
		
		$sql = "SELECT SQL_CALC_FOUND_ROWS a.*,b.is_read  FROM msg_notice a INNER JOIN msg_notice_read_log b
				ON a.id= b.notice_id WHERE b.uid='".$uid."' 
				ORDER BY a.created_at DESC LIMIT ".$limit.", ".$pageSize."";
    	$this->view->list = $obj->selectAll($sql, "", true);
    	$this->view->totalNum =  $obj->getTotal();
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	
	}
	
	//获取通知
	function getnoticeAction(){
		$this->_helper->viewRenderer->setNoRender();
		set_time_limit(0);
		ignore_user_abort(0);
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		//处理会员通知队列
    	Msg::service()->getCommon()->dealNoticeQueue($uid);
		
		$obj = new Msg_Dao_Notice();
		
		$sql = "SELECT SQL_CALC_FOUND_ROWS a.*,b.is_read  FROM msg_notice a INNER JOIN msg_notice_read_log b
				ON a.id= b.notice_id AND b.uid='".$uid."' WHERE  b.is_read = 0
				ORDER BY a.created_at DESC LIMIT 5 ";
    	$list = $obj->selectAll($sql,array(),true);
    	$count = (int) $obj->getTotal();
    	if($list){
    		foreach ($list as $k=>$v){
    			$list[$k]['format_url'] = My_Tool::url($v['url'],$v['url_app']);
    		}
    		My_Tool::showJsonp(200, array("list"=>$list,"count"=>$count));
    	}
    	My_Tool::showJsonp(200, array("list"=>array(),"count"=>0));
	}
	
	//通知已读
	function marknoticereadAction(){
		$this->_helper->viewRenderer->setNoRender();
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showJsonp(500, "");
		$info = Msg::dao()->getNotice()->get(array("id"=>$id));
		if(!$info) My_Tool::showJsonp(500, "");
		$where['uid'] = $uid;
		$where['notice_id'] = $id;
		Msg::dao()->getNoticereadlog()->update(array("is_read"=>1),$where);
		My_Tool::showJsonp(200, "");
	}
	
	
	#添加消息
	function addAction(){
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id']; 
		
		$this->view->uinfo = "";
		$id = (int) $this->getRequest()->getParam("id");
		if($id) $this->view->uinfo = User::dao()->getInfo()->get(array("id"=>$id));
		
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
	   		$receiver = $this->getRequest()->getParam("receiver");
	   		$content = $this->getRequest()->getParam("content");
//	   		$captcha = $this->getRequest()->getParam("captcha");
	   		
//	   		if($receiver == "" || $content == ""|| $captcha == "") My_Tool::showMsg("数据错误!");
//	   		if(!Home::service()->getCommon()->checkCaptcha($captcha)) My_Tool::showMsg("验证码错误!");
	   		if($receiver == "" || $content == "") My_Tool::showMsg("数据错误!");
	   		
	   		$receivers = explode(' ', $receiver);
	   		$noUser=array();
	   		foreach ($receivers as $v){
	   			if($v){
	   				$nickName = $v;
	   				$info = User::dao()->getInfo()->get(array("nickname"=>$nickName));
	   				if(!$info){
	   					$noUser[] = $nickName;
	   				}else{
	   					#发送消息
	   					Msg::service()->getCommon()->sendMsg($uid, $info['id'], $content);
	   				}
	   			}else{
	   				continue;
	   			}
	   		}
	   		$error = "操作成功";
	   		if($noUser){
	   			$error .= "<p>以下用户:</p><p>";
	   			foreach($noUser as $nv){
	   				$error .= $nv . ",";
	   			}
	   			$error = trim($error, ",")."</p>";
	   			$error .= "<p>不存在！</p>";
	   			My_Tool::showMsg($error);
	   		}
	   		 My_Tool::redirect(My_Tool::url("index/index"));
		}
	}
	
	#子回复
	function subreplyAction(){
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id']; 
		
		$id = (int) $this->getRequest()->getParam("id");
		$this->view->id = $id;
		$info = Msg::dao()->getData()->get(array("id"=>$id));
		$this->view->info = $info;
		if($info['uid'] == $uid){
			$userInfo = User::dao()->getInfo()->get(array("id"=>$info['receive_uid']));
		}else{
			$userInfo = User::dao()->getInfo()->get(array("id"=>$info['uid']));
		}
		$this->view->userInfo = $userInfo;
		#标记为已读,收件人才行
		Msg::dao()->getData()->update(array("is_read"=>1),array("root_id"=>$id,"receive_uid"=>$uid));
		#聊天记录
		//分页
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
    	$obj = new Msg_Dao_Data();
		$sql = "
	SELECT SQL_CALC_FOUND_ROWS * FROM msg_data WHERE root_id='".$id."' AND ((uid='".$uid."' AND send_status=1) OR  (receive_uid = '".$uid."' AND receve_status = 1))
	ORDER BY created_at DESC LIMIT ".$limit.", ".$pageSize."
		";
    	$this->view->list = $obj->selectAll($sql,array(),1);
    	$this->view->totalNum =  $obj->getTotal();
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	
		if($this->view->list){
    		foreach($this->view->list as $k=>$v){
    				$userinfo = User::dao()->getInfo()->get(array("id"=>$v['uid']));
	    			$this->view->list[$k]['user'] = $userinfo;
    		}
    	}
	}
	
	function addsubreplyAction(){
		$this->_helper->viewRenderer->setNoRender();
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id']; 
		
		$id = (int) $this->getRequest()->getParam("id");
		$rid = (int) $this->getRequest()->getParam("rid");
		$content = trim($this->getRequest()->getParam("content"));
		if(!$content) My_Tool::showMsg("内容不能为空",My_Tool::url("index/subreply/id/".$id));
		
		Msg::service()->getCommon()->sendMsg($uid, $rid, $content, $id);
		My_Tool::redirect(My_Tool::url("index/subreply/id/".$id));
	}
	
	#删除
	function delmsgAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showJsonp(500, '数据错误');
		$info = Msg::dao()->getData()->get(array("id"=>$id));
		if(!$info) My_Tool::showJsonp(500, '数据错误');
		$user =  User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		//收信箱删除
		if($info['receive_uid'] == $uid){
			Msg::dao()->getData()->update(array("receve_status"=>0),array("id"=>$id));
		}
		//发信箱删除
		if($info['uid'] == $uid){
			Msg::dao()->getData()->update(array("send_status"=>0),array("id"=>$id));
		}
		
		My_Tool::showJsonp(200, '删除成功!');
	}
	
	#删除
	function delmsgallAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id) My_Tool::showJsonp(500, '数据错误');
		$info = Msg::dao()->getData()->get(array("id"=>$id));
		if(!$info) My_Tool::showJsonp(500, '数据错误');
		$user =  User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		//收信箱删除
		if($info['receive_uid'] == $uid){
			Msg::dao()->getData()->update(array("receve_status"=>0),array("root_id"=>$info['root_id']));
		}
		//发信箱删除
		if($info['uid'] == $uid){
			Msg::dao()->getData()->update(array("send_status"=>0),array("root_id"=>$info['root_id']));
		}
		My_Tool::showJsonp(200, '删除成功!');
	}

	
}

