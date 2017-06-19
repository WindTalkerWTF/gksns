<?php
class User_QqloginController extends My_Controller_Action{
	const WEIBO_LOGIN_ACCESS_TOKEN = "QQ_LOGIN_ACCESS_TOKEN";
	private $sessionObj = null;
	public function init(){
		$this->sessionObj = new My_Session_Namespace(self::WEIBO_LOGIN_ACCESS_TOKEN);
		$this->_helper->Logined(array("bind", "unbind"));
	}
	
	function doAction(){
		$code = $this->getRequest()->getParam("code");
		if(!$code){
			User::service()->getOpenlogin()->qqAccess();
		}
		$result= User::service()->getOpenlogin()->getQQAccessToken($code);
		if(!isset($result['access_token']))  User::service()->getOpenlogin()->qqAccess();
		
		$this->sessionObj->loginsession = $result;
		$accessToken  = $result['access_token'];
		$userInfo = User::service()->getOpenlogin()->getQQInfo($accessToken);
		if(!$userInfo)  $this->showMsg("登录失败!");
		$openid = $userInfo['openid'];
		$findwhere['obj_id'] = $openid;
		$findwhere['open_type'] = "QQ";
		
		$openinfo = User::dao()->getOpenlogin()->get($findwhere);
		if($openinfo){
			$user = User::service()->getCommon()->getUserInfo($openinfo['uid']);
            if($user['is_del'])  $this->showMsg("登录失败,您的帐户已经被管理员屏蔽!");
			if(!$user) $this->showMsg("登录失败!");
			User::service()->getCommon()->setLogin($user);
			My_Tool::redirect("/user/index/index");
		}
		//判断昵称是否存在
		$this->sessionObj->qquserinfo = $userInfo;
		$this->view->userInfo = $userInfo;
	}
	
	function regAction(){
		$qquserinfo = $this->sessionObj->qquserinfo;

		if(!$qquserinfo) User::service()->getOpenlogin()->qqAccess();
		$this->_helper->viewRenderer->setNoRender();
		$username = trim($this->getRequest()->getParam("username"));
		$nickname = trim($this->getRequest()->getParam("nickname"));
		$pwd = $this->getRequest()->getParam("password");
		$repassword = $this->getRequest()->getParam("repassword");
			
		if($username == "" || $nickname == ""|| $pwd == "" || $repassword == "") My_Tool::showMsg("数据错误!");
			
		if(!My_Tool::checkEmail($username)) My_Tool::showMsg("邮箱地址格式错误!");
			
		if(User::dao()->getInfo()->get(array("username"=>$username))) My_Tool::showMsg("邮箱账号已经被注册!");
			
		if(User::dao()->getInfo()->get(array("nickname"=>$nickname))) My_Tool::showMsg("昵称已经被别人占有!");
			
		if($pwd != $repassword) My_Tool::showMsg("两次密码输入不相同!");
			
		if(mb_strlen($nickname, "UTF-8") > 12 || mb_strlen($nickname, "UTF-8") < 2) My_Tool::showMsg("昵称长度有误!");	
			
		$data['username'] = $username;
		$data['pwd'] = My_Tool::md5($pwd);
		$data['nickname'] = $nickname;
			
		$uid = User::dao()->getInfo()->insert($data);
			
		#生成统计表
		User::dao()->getStat()->insert(array("uid"=>$uid));
	   
	    #第三方登录
	    $openloginData['uid']  = $uid;
	    $openloginData['obj_id']  = $qquserinfo['openid'];
	    $openloginData['open_type']  = "QQ";
	    $openloginData['created_at']  = date('Y-m-d H:i:s');
	    User::dao()->getOpenlogin()->insert($openloginData);
	    	
		User::service()->getCommon()->setReg($username);
			
		$number = getSysData('site.config.coin.user.reg');
		#积分增加
		User::service()->getCommon()->addCoin($uid, $number, "注册赠送");
	
		#更新头像
		$imgfile = @file_get_contents($qquserinfo['figureurl_2']);
		$savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . "user" . DS . "face" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
		if(!is_dir($savePath)) mkdir($savePath, 0777, true);
		$imgPath = $savePath.$qquserinfo['openid'].".jpg";
		file_put_contents($imgPath, $imgfile);
		
		Home::service()->getCommon()->cutImg($imgPath, $imgPath, array("160x160","48x48", "24x24"));
		#保存到数据库
		$imgsavePath =  "/res/upload/user/face/" .date("Y") . "/" . date('m') . "/" . date('d'). "/" . $qquserinfo['openid'].".jpg";
		$data['face'] = $imgsavePath;
		User::dao()->getInfo()->update($data, array("id"=>$uid));
		#更新session
		User::service()->getCommon()->updateUserSession($uid);
		
	    My_Tool::redirect("/");
	}
	
	
	function bindAction(){
		$code = $this->getRequest()->getParam("code");
		$callbackUrl = "qqlogin/bind";
		if(!$code){
			User::service()->getOpenlogin()->qqAccess($callbackUrl);
		}
		$result= User::service()->getOpenlogin()->getQQAccessToken($code,$callbackUrl);
		if(!isset($result['access_token']))  User::service()->getOpenlogin()->qqAccess($callbackUrl);
		
		$this->sessionObj->loginsession = $result;
		$accessToken  = $result['access_token'];
		$userInfo = User::service()->getOpenlogin()->getQQInfo($accessToken,$callbackUrl);
		if(!$userInfo) $this->showMsg("绑定失败!");
		$openid = $userInfo['openid'];
		$findwhere['obj_id'] = $openid;
		$findwhere['open_type'] = "QQ";
		
		$openinfo = User::dao()->getOpenlogin()->get($findwhere);
		if($openinfo) $this->showMsg("该账户已经绑定了其他账户,请将先解绑，然后重试~");
		$user = User::service()->getCommon()->getLogined();
		$uid =$user['id'];
		
		$insertData['uid'] = $uid;
		$insertData['obj_id'] = $openid;
		$insertData['open_type'] = "QQ";
		$insertData['created_at'] = date('Y-m-d H:i:s');
		
		User::dao()->getOpenlogin()->insert($insertData);
		
		$this->showMsg("绑定成功~",My_Tool::url("setting/external-account","user"));
	}
	
	function unbindAction(){
		$this->_helper->viewRenderer->setNoRender();
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		if(!$user['email_validate']) $this->showMsg("邮箱没有认证，不能解除绑定!");
		User::dao()->getOpenlogin()->delete(array("uid"=>$uid,"open_type"=>"QQ"));
		$this->showMsg("解绑成功~",My_Tool::url("setting/external-account","user"));
	}
	
}