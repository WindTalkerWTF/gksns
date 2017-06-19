<?php

class User_IndexController extends My_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
//    	$this->_helper->layout()->disableLayout();
//    	$this->_helper->viewRenderer->setNoRender();
    	//$this->_helper->cache(array("index"), array("sss"));
//    	$this->_helper->Logined(array());
		$this->_helper->Logined(array("sign","setting", "logout",'dofollow','docancelfollow',"feeds"));
    }

     public function preDispatch(){
     	
     }

     /********以下为自定义内容****************/
     #个人资料首页
	function indexAction(){
		$id = $this->getRequest()->getParam("id");
		if(empty($id)) $id = 0;
		if(!preg_match("/^[\d]+$/",$id)){
			$userInfoTmp = User::dao()->getInfo()->get(array("nickname"=>$id));
			if(!$userInfoTmp) My_Tool::showMsg("页面不存在");
			$id = $userInfoTmp['id'];
		}
		
		if(!$id){
			$this->view->isMe=1;
			$userInfo = User::service()->getCommon()->getLogined();
			if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
			$id = $userInfo['id'];
		}
		else{
			$this->view->isMe=0;
		}
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		
		//日志
		$this->view->blog = Site::dao()->getArc()->gets(array("uid"=>$this->view->user['id']), "created_at DESC", 0, 5);
		//回答
		$this->view->answer = Home::dao()->getReply()->gets(array("uid"=>$this->view->user['id'],"arc_type"=>"ask"), "created_at DESC", 0, 5);
		if($this->view->answer){
			foreach ($this->view->answer as $k=>$v){
				$refId = $v['ref_id'];
				$answerInfo = Ask::dao()->getArc()->get(array("id"=>$refId));
				$this->view->answer[$k]['arc'] = $answerInfo;
			}
		}
		//动态
		$this->view->feed = User::dao()->getFeed()->gets(array("uid"=>$this->view->user['id'],"is_public"=>1), "created_at DESC", 0, 5);
		$this->view->seo = array("title"=>$this->view->user['nickname']."的个人主页");
	}
	
	
	#注册
	function regAction(){
		$this->_helper->layout()->setLayout("user_login_reg_layout");
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$username = trim($this->getRequest()->getParam("username"));
			$nickname = trim($this->getRequest()->getParam("nickname"));
			$pwd = $this->getRequest()->getParam("password");
			$repassword = $this->getRequest()->getParam("repassword");
			$captcha = $this->getRequest()->getParam("captcha");
			
			try{
				$db = Home::dao()->getCommon();
				$db->startTrans();
				
				if($username == "" || $nickname == ""|| $pwd == "" || $repassword == "" || $captcha == "") throw new My_Exception("数据错误!"); 
				
				if(!My_Tool::checkEmail($username)) throw new My_Exception("邮箱地址格式错误!"); 
				
				if(User::dao()->getInfo()->get(array("username"=>$username))) throw new My_Exception("邮箱账号已经被注册!"); 
				
				if(User::dao()->getInfo()->get(array("nickname"=>$nickname))) throw new My_Exception("昵称已经被别人占有!");
				
				if($pwd != $repassword) My_Tool::showMsg("两次密码输入不相同!");
				
				if(mb_strlen($nickname, "UTF-8") > 12 || mb_strlen($nickname, "UTF-8") < 2) throw new My_Exception("昵称长度有误!");
				
				if(!Home::service()->getCommon()->checkCaptcha($captcha,'reg')) throw new My_Exception("验证码错误!");
				
				$data['username'] = $username;
				$data['pwd'] = My_Tool::md5($pwd);
				$data['nickname'] = $nickname;
				
				$uid = User::dao()->getInfo()->insert($data);
				
				#生成统计表
				User::dao()->getStat()->insert(array("uid"=>$uid));

                if(getSysData("site.reg.sendemail")){
				    User::service()->getCommon()->setReg($username);
                }
			    $number = getSysData('site.config.coin.user.reg');
			    #积分增加
			    User::service()->getCommon()->addCoin($uid, $number, "注册赠送");
			    $db->commit();
                if(getSysData("site.reg.sendemail")){
			        My_Tool::showMsg("操作成功，一封验证Email地址的邮件已经发送到您的注册邮箱，请按照邮件上面的指示操作，完成注册");
                }else{
                   My_Tool::redirect(My_Tool::url("index/index",'user'));
                }
			}catch (Exception $e){
				My_Tool::showMsg($e->getMessage());
			}
		}
		$this->view->seo = array("title"=>"注册");
	}
	
	#登陆
	function loginAction(){
		$this->_helper->layout()->setLayout("user_login_reg_layout");
		//来源页
	 	$ref = $this->getRequest()->getParam("ref");

	 	if($ref){ 
	 		My_Tool_FlashMessage::set('login_ref', $ref);
	 	}else{
	 		$ref = My_Tool_FlashMessage::get('login_ref');
	 	}

	 	//登录状态跳到此页
		$ref = $ref ? rawurldecode($ref) : "/user/index/index";

		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$username = trim($this->getRequest()->getParam("username"));
			$pwd = $this->getRequest()->getParam("password");
			$captcha = $this->getRequest()->getParam("captcha");
			$remember = (int) $this->getRequest()->getParam("remember");
			
			if($username == "" || $pwd == "" || $captcha == "" ) My_Tool::showMsg("数据错误!");
			if(!Home::service()->getCommon()->checkCaptcha($captcha,"login")) My_Tool::showMsg("验证码错误!");

            if(My_Tool_Check::email($username)){
                $where['username'] = $username;
            }else{
                $where['nickname'] = $username;
            }
			$where['pwd'] = My_Tool::md5($pwd);
			$info = User::dao()->getInfo()->get($where);
			if($info){
                if($info['is_del']) $this->showMsg("登录失败,您的帐户已经被管理员屏蔽");

				//登录成功处理
				User::service()->getCommon()->setLogin($info, $remember);
				
				$checkTmp = User::dao()->getCoinlogs()->get(array("uid"=>$info['id'],"created_time"=>array("like",date('Y-m-d')."%")));
                $number = 0;
                $loginMsg="";
				if(!$checkTmp){
					//登录奖励
			    	$number = getSysData('site.config.coin.user.login');
                    if($number){
                        User::service()->getCommon()->addCoin($info['id'], $number, "每日登陆奖励");
                        $loginMsg .="每日首次登陆，获得".$number.getSysData("site.coin.name")."<br>";
                    }
				}

                if(getSysData("site.reg.sedemail")){
                    if(!$info['email_validate']){
                        $loginMsg .='你的邮箱地址还没有验证，请先认证!';
                        My_Tool::showMsg($loginMsg, My_Tool::url("setting/resendemail",'user'));
                    }
                }else{
                    My_Tool::redirect($ref);
                }
			}else{
				My_Tool::showMsg("账号或密码错误!", My_Tool::url("/index/login"));
				My_Tool_FlashMessage::set('login_ref', $ref);
			}		
		}
        $user = User::service()->getCommon()->getLogined();
        if($user) My_Tool::redirect("/");
		$this->view->seo = array("title"=>"登录");
	}
	
	function logout(){
		User::service()->getCommon()->logout();
	}
	
	#退出
	function logoutAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->logout();
		My_Tool::showMsg("成功退出!", My_Tool::url("/index/login"));
	}
	
	#找回密码
	function findpwdAction(){
		$this->_helper->layout()->setLayout("user_alone_layout");
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$username = trim($this->getRequest()->getParam("username"));
			$captcha = $this->getRequest()->getParam("captcha");
			if($username == "" || $captcha == "" )  My_Tool::showMsg("数据错误或数据过期!");
			if(!Home::service()->getCommon()->checkCaptcha($captcha)) My_Tool::showMsg("验证码错误!");
			if(!User::dao()->getInfo()->get(array("username"=>$username))) My_Tool::showMsg("邮箱地址不存在!");
			//写入token
			$idata['email'] = $username;
			$idata['token'] = My_Tool::md5("findpwd".uniqid().time());
			$idata['created_time'] = time();
			User::dao()->getFindpwdvalidate()->insert($idata);
			//发送验证邮件
			User::service()->getMail()->sendFindpwd($username, $idata['token']);
			My_Tool::showMsg("一封找回密码的邮件已经发送到填写的邮箱，请按照邮箱上面的指示操作,该邮件找回密码的有效时间为24小时，请尽快处理!");
		}
		$this->view->seo = array("title"=>"找回密码");
	}
	
	#验证email
	function checkemailAction(){
		$this->_helper->viewRenderer->setNoRender();
		$email = $this->getRequest()->getParam("email");
		$token = $this->getRequest()->getParam("token");
		
		//判断token
		$info  = User::dao()->getEmailvalidate()->get(array("email"=>$email, "token"=>$token));
		if(!$info) My_Tool::showMsg("数据有错误或已过期!");
		#删除验证
		User::dao()->getEmailvalidate()->delete(array("email"=>$email, "token"=>$token));
		#更新验证
		$updata['email_validate'] = 1;
		User::dao()->getInfo()->update($updata, array("username"=>$email));
        $userInfo = User::dao()->getInfo()->get(array("username"=>$email));
        User::service()->getCommon()->setLogin($userInfo);
		My_Tool::showMsg("恭喜,邮箱地址验证成功!");
	}
	
	#找回密码处理
	function resetpwdAction(){
			$email = $this->getRequest()->getParam("email");
			$token = $this->getRequest()->getParam("token");
			//判断token
			$info  = User::dao()->getFindpwdvalidate()->get(array("email"=>$email, "token"=>$token));
			if(!$info) My_Tool::showMsg("数据有错误或已过期!");
			if( time()-$info['created_time'] > 60*60*24)  My_Tool::showMsg("数据有错误或已过期!");
			$this->view->email = $email;
			$this->view->token = $token;
			if(My_Tool::isPost()){
				try{
					$db = Home::dao()->getCommon();
					$db->startTrans();
					$this->_helper->viewRenderer->setNoRender();
					$pwd = $this->getRequest()->getParam("password");
					$repassword = $this->getRequest()->getParam("repassword");
					//csrf 判断
					if(!My_Tool_Form::validate("resetpwd")) throw new My_Exception("数据错误或数据过期!");
					
					if($pwd != $repassword) throw new My_Exception("两次密码输入不相同!");
					
					#删除验证token
					User::dao()->getFindpwdvalidate()->delete(array("email"=>$email));
					#更改密码
					$update = array();
					$update['pwd'] = My_Tool::md5($pwd);
					User::dao()->getInfo()->update($update, array("username"=>$email));
					$db->commit();
				}catch (Exception $e){
					$db->rollback();
					My_Tool::showMsg($e->getMessage(), My_Tool::url("index/resetpwd/email/".$email."/token/".$token));
				}
				My_Tool::showMsg("更改成功，请登录!", My_Tool::url("index/login"));
			}
	}
	
	

	#验证验证码
	function validatecaptchaAction(){
		$this->_helper->viewRenderer->setNoRender();
		$captcha = $this->getRequest()->getParam("captcha");
        $key = $this->getRequest()->getParam("key");
		if(!$captcha) My_Tool::showJson(-1, "验证码为空!");
		if(Home::service()->getCommon()->checkCaptcha($captcha,$key)) My_Tool::showJson(0, "");
		 My_Tool::showJson(-1, "验证码错误!");
	}
	
	#检查用户名
	function checkusernameAction(){
		$this->_helper->viewRenderer->setNoRender();
		$username = trim($this->getRequest()->getParam("username"));
		if(!$username) My_Tool::showJson(-1, "邮箱地址为空!");
		if(!My_Tool::checkEmail($username)) My_Tool::showJson(-1, "邮箱地址格式有误!");
		
		$info = User::dao()->getInfo()->get(array("username"=>$username));
		if($info) My_Tool::showJson(-1, "邮箱地址已经被别人注册!");
	
		
		My_Tool::showJson(0, "");
	}
	
	
	
	#检查昵称
	function checknicknameAction(){
		$this->_helper->viewRenderer->setNoRender();
		$nickname = trim($this->getRequest()->getParam("nickname"));
		if(!$nickname) My_Tool::showJson(-1, "昵称为空!");
		$info = User::dao()->getInfo()->get(array("nickname"=>$nickname));
		if($info) My_Tool::showJson(-1, "昵称已经被占用!");
		if(preg_match("/^[0-9]+$/",$nickname)) My_Tool::showJson(-1, "昵称不能全为数字!");
		if(!preg_match("/^[\x80-\xff0-9A-Za-z]+$/",$nickname)) My_Tool::showJson(-1, "必须由字母，数字或中文组成!");
		
		My_Tool::showJson(0, "");
	}
	
	#博客
	function blogAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id){
			$userInfo = User::service()->getCommon()->getLogined();
			if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
			$id = $userInfo['id'];
		}
		$this->view->id = $id;
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		if(!$this->view->user) My_Tool::showMsg("页面不存在!");
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	$where = array("uid"=>$id);
    	$where['is_publish'] = 1;
    	
    	$info = Site::service()->getCommon()->getList($where, $limit, $pageSize, " created_at DESC");
    	$this->view->list = $info[0];
    	$this->view->totalNum =  $info[1];
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	$this->view->seo = array("title"=>$this->view->user['nickname']."的博客");
	}
	
	#回答
	function answerAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id){
			$userInfo = User::service()->getCommon()->getLogined();
			if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
			$id = $userInfo['id'];
		}
		$this->view->id = $id;
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		if(!$this->view->user) My_Tool::showMsg("页面不存在!");
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	
    	$obj = new Home_Dao_Reply();
    	$info = $obj->gets(array("uid"=>$id,"arc_type"=>"ask","is_publish"=>1), "created_at DESC", $limit, $pageSize);

		if($info){
			foreach ($info as $k=>$v){
				$refId = $v['ref_id'];
				$answerInfo = Ask::dao()->getArc()->get(array("id"=>$refId));
				$info[$k]['arc'] = $answerInfo;
			}
		}
		
		$this->view->list = $info;
    	$this->view->totalNum =  $obj->getTotal();
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
		$this->view->seo = array("title"=>$this->view->user['nickname']."的回答");
	}
	
	#提问
	function askAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id){
			$userInfo = User::service()->getCommon()->getLogined();
			if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
			$id = $userInfo['id'];
		}
		$this->view->id = $id;
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		if(!$this->view->user) My_Tool::showMsg("页面不存在!");
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	$where = array("uid"=>$id,"is_publish"=>1);
    	
    	$obj = new Ask_Dao_Arc();
    	$info = $obj->gets($where, "created_at DESC", $limit, $pageSize);
		
		$this->view->list = $info;
    	$this->view->totalNum =  $obj->getTotal();
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	$this->view->seo = array("title"=>$this->view->user['nickname']."的提问");
	}
	
	#帖子
	function postAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id){
			$userInfo = User::service()->getCommon()->getLogined();
			if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
			$id = $userInfo['id'];
		}
		$this->view->id = $id;
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		if(!$this->view->user) My_Tool::showMsg("页面不存在!");
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	$where = array("uid"=>$id,"is_publish"=>1);
    	
    	$list = $totalNum = 0;
    	list($list, $totalNum) = Group::service()->getCommon()->getGroupPosts($where, " created_at DESC", $limit, $pageSize);
    	$this->view->list = $list;
    	$this->view->totalNum = $totalNum;
		
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	$this->view->seo = array("title"=>$this->view->user['nickname']."的帖子");
	}
	
	#动态
	function feedAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id){
			$userInfo = User::service()->getCommon()->getLogined();
			if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
			$id = $userInfo['id'];
		}
		$this->view->id = $id;
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		if(!$this->view->user) My_Tool::showMsg("页面不存在!");
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	
    	$obj = new User_Service_Common();
    	$info = $totalNum = 0;
    	list($info, $totalNum) = $obj->getFeed(array("uid"=>$id,"is_public"=>1), "created_at DESC", $limit, $pageSize);
		$this->view->list = $info;
    	$this->view->totalNum =  $totalNum;
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	$this->view->seo = array("title"=>$this->view->user['nickname']."的动态");
	}
	
	#标签
	function tagAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id){
			$userInfo = User::service()->getCommon()->getLogined();
			if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
			$id = $userInfo['id'];
		}
		$this->view->id = $id;
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		if(!$this->view->user) My_Tool::showMsg("页面不存在!");
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	
    	$list = $totalNum = 0;
    	$where['uid'] = $id;
    	$obj = new Home_Dao_Tag();
    	$list = $obj->gets($where, " ask_count DESC " ,$limit, $pageSize, "", true);
    	$totalNum =  $obj->getTotal();
    	
    	$user = User::service()->getCommon()->getLogined();
    	$uid = isset($user['id']) ? $user['id'] : 0;
		if($list){
    		foreach ($list as $k=>$v){
    			$members = Ask::dao()->getTagfollow()->get(array("uid"=>$uid,"tag_id"=>$v['id']));
    			$list[$k]['hasFollow'] = $members ? 1 : 0;
    		}
    	}
    	
    	$this->view->me = $id == $uid  ? 1 : 0;
    	
		$this->view->list = $list;
    	$this->view->totalNum =  $totalNum;
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	$this->view->seo = array("title"=>$this->view->user['nickname']."的标签");
	}
	
	#群组
	function groupAction(){
        $id = (int) $this->getRequest()->getParam("id");
        if(!$id){
                $userInfo = User::service()->getCommon()->getLogined();
                if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
                $id = $userInfo['id'];
        }
        $this->view->id = $id;
        $this->view->user = User::service()->getCommon()->getUserInfo($id);
        if(!$this->view->user) My_Tool::showMsg("页面不存在!");

        $page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 32;
    	
    	$limit = $pageSize * ($page-1);
		
    	
    	$list = $totalNum = 0;
    	$where['uid'] = $id;
    	$obj = new Group_Dao_Info();
    	$sql = "SELECT SQL_CALC_FOUND_ROWS a.* FROM group_info a LEFT JOIN group_user b ON a.id = b.group_id WHERE b.uid = {$id}
    			AND a.group_status=1 ORDER BY b.user_type DESC,a.created_at DESC LIMIT {$limit},{$pageSize}";
    	$list = $obj->selectAll($sql,array(),true);
    	$totalNum =  $obj->getTotal();
    	
		$this->view->list = $list;
    	$this->view->totalNum =  $totalNum;
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	
    	$this->view->seo = array("title"=>$this->view->user['nickname']."的群组");
	}
	
	#关注
	function followAction(){
		$id = (int) $this->getRequest()->getParam("id");
		if(!$id){
			$userInfo = User::service()->getCommon()->getLogined();
			if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
			$id = $userInfo['id'];
		}
		$this->view->id = $id;
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		if(!$this->view->user) My_Tool::showMsg("页面不存在!");
		
		$user = User::service()->getCommon()->getLogined();
    	$uid = isset($user['id']) ? $user['id'] : 0;
		$this->view->isMe = $id == $uid  ? 1 : 0;
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	
    	$list = $totalNum = 0;
    	$where['uid'] = $id;
    	$obj = new User_Service_Common();
    	$list = $totalNum = 0;
    	$tmp = $obj->getFollow($where, " created_at DESC " ,$limit, $pageSize,true);
    	if($tmp) list($list, $totalNum) = $tmp;
//    	print_r($list);
		$this->view->list = $list;
    	$this->view->totalNum =  $totalNum;
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	
    	$this->view->seo = array("title"=>$this->view->user['nickname']."关注的会员");
	}
	
	#被关注
	function interestedAction(){
	    $id = (int) $this->getRequest()->getParam("id");
		if(!$id){
			$userInfo = User::service()->getCommon()->getLogined();
			if(!$userInfo) My_Tool::showMsg("请先登录", My_Tool::url("index/login"));
			$id = $userInfo['id'];
		}
		$this->view->id = $id;
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		if(!$this->view->user) My_Tool::showMsg("页面不存在!");
		
		$user = User::service()->getCommon()->getLogined();
    	$uid = isset($user['id']) ? $user['id'] : 0;
		$this->view->isMe = $id == $uid  ? 1 : 0;
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	
    	$list = $totalNum = 0;
    	$where['follow_uid'] = $id;
    	$obj = new User_Service_Common();
    	$list = $totalNum = 0;
    	$tmp = $obj->getToFollow($where, " created_at DESC " ,$limit, $pageSize,true);
    	if($tmp) list($list, $totalNum) = $tmp;
    	
		$this->view->list = $list;
    	$this->view->totalNum =  $totalNum;
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
		$this->view->seo = array("title"=>"关注".$this->view->user['nickname']."的会员");
	}
	
	#关注
	function dofollowAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$userInfo = User::service()->getCommon()->getLogined();
		$isFollow = User::dao()->getFollow()->get(array("uid"=>$userInfo['id'], "follow_uid"=>$id));
		if($isFollow) My_Tool::showJsonp(500, "已经关注过了，不能重复关注!");
		$data['uid'] = $userInfo['id'];
		$data['follow_uid'] = $id;
		User::dao()->getFollow()->insert($data);
		#统计数据
		User::dao()->getStat()->inCrease("follow_count", array("uid"=>$userInfo['id']));
		User::dao()->getStat()->inCrease("to_follow_count", array("uid"=>$id));
		My_Tool::showJsonp(200, "关注成功!");
	}
	
	
	#取消关注
	function docancelfollowAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$userInfo = User::service()->getCommon()->getLogined();
		$isFollow = User::dao()->getFollow()->get(array("uid"=>$userInfo['id'], "follow_uid"=>$id));
		if(!$isFollow) My_Tool::showJsonp(200, "取消关注成功!");
		$where['uid'] = $userInfo['id'];
		$where['follow_uid'] = $id;
		User::dao()->getFollow()->delete($where);
		#统计数据
		User::dao()->getStat()->deCrement("follow_count", array("uid"=>$userInfo['id'], "follow_count"=>array(">", 0)));
		User::dao()->getStat()->deCrement("to_follow_count", array("uid"=>$id, "follow_count"=>array(">", 0)));
		My_Tool::showJsonp(200, "取消关注成功!");
	}
	
	#达人
	function darenAction(){
		$this->_helper->layout()->setLayout("user_daren_layout");
		$this->view->tree = getSysData('site.config.daren');
		$t = $this->getRequest()->getParam("t",-1);
		if($t >=0 ) $t = array_search($t,$this->view->tree);
		$this->view->t = $t;
		
		$userInfo = User::service()->getCommon()->getLogined();
		$this->view->uid = isset($userInfo['id']) ? $userInfo['id']:0;
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 16;
    	
    	$limit = $pageSize * ($page-1);
		
    	$darenSql = "";
    	
    	if($t >= 0) $darenSql = " AND a.daren_tree LIKE '%,".$t.",%'";
    	
    	$list = $totalNum = 0;
    	$obj = new Home_Dao_Common();
    	$sql = "SELECT SQL_CALC_FOUND_ROWS a.* ,b.to_follow_count,b.blog_count FROM user_info a LEFT JOIN user_stat b ON a.id=b.uid 
    			WHERE a.daren_tree !='-1' {$darenSql} ORDER BY b.follow_count DESC LIMIT {$limit}, {$pageSize}";
    	$list = $obj->selectAll($sql,array(":daren_tree"=>$t),true);
    	$totalNum = $obj->getTotal();
    	if($list){
    		$uids = array();
    		foreach($list as $k=>$v){
    			$uids[] = $v['id'];
    			$list[$k]['isfollowed'] = 0;
    		}
    		$follows = User::dao()->getFollow()->gets(array("uid"=>$this->view->uid,"follow_uid"=>array("in",$uids)));
    		if($follows){
    		foreach($list as $k=>$v){
    			foreach ($follows as $fv){
    				if($v['id'] == $fv['follow_uid']){ 
    					$list[$k]['isfollowed'] = 1;
    				}
    			}
    		}
    	   }
    	}
		$this->view->list = $list;
    	$this->view->totalNum =  $totalNum;
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;	
    	//达人最新博客
    	$sql= "SELECT a.*,b.id as arc_id,b.title FROM site_arc b 
    			INNER JOIN user_info a ON a.id=b.uid WHERE a.daren_tree !='0' 
    			ORDER BY b.created_at DESC LIMIT 7 ";
    	$this->view->arc = $obj->selectAll($sql);
    	$this->view->seo = array("title"=>"全部达人");
	}
	
	/**
	 * 
	 * 我关注的动态
	 */
	function feedsAction(){
		$user = User::service()->getCommon()->getLogined();
		
		$page = (int) My_Tool::request("page");
    	$page = $page ? $page : 1;
    	$pageSize = 16;
    	
    	$limit = $pageSize * ($page-1);
		
		$sql = "SELECT a.*,c.nickname,c.face FROM user_feed a 
					INNER JOIN user_follow b ON b.follow_uid = a.uid AND b.uid = ".$user['id']."
					INNER JOIN user_info c ON a.uid = c.id ORDER BY a.created_at DESC LIMIT {$limit}, {$pageSize}
					";
		$obj = new Home_Dao_Common();
		$this->view->list = $obj->selectAll($sql, array(), true);
		$this->view->totalNum = $obj->getTotal();
		$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
    	
    	$this->view->follow = User::service()->getCommon()->getFollow(array("uid"=>$user['id']),0,100);
		$this->view->toFollow = User::service()->getCommon()->getToFollow(array("follow_uid"=>$user['id']), 0, 100);
		$this->view->userInfo = User::service()->getCommon()->getUserInfo($user['id']);
		$this->view->seo = array("title"=>"关注的人的动态");
	}
	
	
}

