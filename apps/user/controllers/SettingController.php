<?php

class User_SettingController extends My_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
//    	$this->_helper->layout()->disableLayout();
//    	$this->_helper->viewRenderer->setNoRender();
    	//$this->_helper->cache(array("index"), array("sss"));
//    	$this->_helper->Logined(array());
		$this->_helper->layout()->setLayout("user_setting_layout");
		$this->_helper->Logined(array("index", "mpwd", "mface","externalAccount",'resendemail','doresendemail'));
    }

     public function preDispatch(){
     }

     /********以下为自定义内容****************/
     #个人资料首页
	function indexAction(){
		
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		
		if(My_Tool::isPost()){
			$gender = (int) $this->getRequest()->getParam("gender");
			$city = (int) $this->getRequest()->getParam("city");
			$introduction = $this->getRequest()->getParam("introduction");
			
			if(!$city) My_Tool::showMsg("数据错误!");
			
			if($introduction && (mb_strlen($introduction, "UTF-8") > 20)) My_Tool::showMsg("签名长度不能大于20字!");
			
			#更新
			$udata['sex'] = $gender;
			$udata['cur_area'] = $city;
			$udata['sign'] = strip_tags($introduction);
			
			User::dao()->getInfo()->update($udata, array("id"=>$uid));
			
			#更新session
			User::service()->getCommon()->updateUserSession($uid);
			My_Tool::showMsg("修改成功",My_Tool::url("setting/index","user"));
		}
		$this->view->user = User::dao()->getInfo()->get(array("id"=>$uid));
		$this->view->pro = Home::dao()->getArea()->gets(array("pid"=>0));
		
		$curPro = Home::dao()->getArea()->get(array("id"=>$this->view->user['cur_area']));
		$this->view->curPro = $curPro['pid'];
		
		
		$this->view->seo = array("title"=>"设置个人信息");
	}
	
	#ajax  获取城市
	function getcitysAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->getRequest()->getParam("id");
		$citys = Home::dao()->getArea()->gets(array("pid"=>$id));
		My_Tool::showJsonp(200, $citys);
	}
	
	#检查新昵称
	function checknewnicknameAction(){
		$this->_helper->viewRenderer->setNoRender();
		$user = User::service()->getCommon()->getLogined();
		$uid = $user['id'];
		$newnickname = trim($this->getRequest()->getParam("newnickname"));
		if(!$newnickname) My_Tool::showJsonp(-1, "昵称为空!");
		$info = User::dao()->getInfo()->get(array("nickname"=>$newnickname, "id"=>array("!=", $uid)));
		if($info) My_Tool::showJsonp(-1, "昵称已经被占用!");
		
		$oldUsername = User::dao()->getInfo()->getField("nickname", array("id"=>$uid));
			
		My_Tool::showJsonp(0, "");
	}

	#修改密码
	function mpwdAction(){
		$user = User::service()->getCommon()->getLogined();
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$oldpassword = $this->getRequest()->getParam("oldpassword");
			$password = $this->getRequest()->getParam("password");
			$repassword = $this->getRequest()->getParam("repassword");
			
			if($oldpassword == "" || $password == "" || $repassword == "" )  My_Tool::showMsg("数据错误!");
			if($password != $repassword) My_Tool::showMsg("两次密码输入不相同!");
			
			$info = User::dao()->getInfo()->get(array("id"=>$user['id'], "pwd"=>My_Tool::md5($oldpassword)));
			if(!$info)  My_Tool::showMsg("旧密码输入错误!", My_Tool::url("setting/mpwd"));
			
			#更新
			$udata['pwd'] = My_Tool::md5($password);
			User::dao()->getInfo()->update($udata, array("id"=>$user['id']));


			User::service()->getCommon()->logout();
			
			My_Tool::showMsg("更改成功,请重新登录!", My_Tool::url("index/login"));
		}
		$this->view->seo = array("title"=>"修改密码|设置个人信息");
	}
	
	#修改头像
	function mfaceAction(){
		$user = User::service()->getCommon()->getLogined();
		$uid =$user['id'];
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$imgPath ="";
			if($_FILES['upload_file']['tmp_name']){
				//上传图片
				$modeName = $this->getRequest()->getModuleName();
				$savePath = PUBLIC_DIR . DS . "res" . DS . "upload" . DS . $modeName . DS . "face" . DS . date("Y") . DS . date('m') . DS . date('d'). DS;
				$imgPaths = Home::service()->getCommon()->upImg($savePath);
				$imgPath =  "/res/upload/".$modeName ."/face/" .date("Y") . "/" . date('m') . "/" . date('d'). "/" . $imgPaths[0]['savename'];
				//截图
				$oldPath = $savePath . $imgPaths[0]['savename'];
				Home::service()->getCommon()->cutImg($oldPath, $oldPath, array("160x160","48x48", "24x24"));
				#保存到数据库

				$data['face'] = $imgPath;
				User::dao()->getInfo()->update($data, array("id"=>$uid));

				#更新session
				User::service()->getCommon()->updateUserSession($uid);

				My_Tool::redirect(My_Tool::url("setting/mface"));
			}
		}
		$this->view->user = User::dao()->getInfo()->get(array("id"=>$uid));
		$this->view->seo = array("title"=>"修改头像|设置个人信息");
	}
	
	#绑定帐号
	function externalAccountAction(){
		$user = User::service()->getCommon()->getLogined();
		$uid =$user['id'];
		$this->view->qqbind = User::dao()->getOpenlogin()->get(array("uid"=>$uid,"open_type"=>"QQ"));
	}

    #邮箱认证
    function resendemailAction(){
        $user = User::service()->getCommon()->getLogined();
        $user = User::dao()->getInfo()->get(array("id"=>$user['id']));
        $this->view->user = $user;
    }

    function doresendemailAction(){
        $user = User::service()->getCommon()->getLogined();
        $user = User::dao()->getInfo()->get(array("id"=>$user['id']));
        if($user['email_validate']){
            $this->showMsg("邮箱已经认证过了，不需要重新认证!","history.back();",1);
        }
        User::service()->getCommon()->setReg($user['username']);
        $this->showMsg("操作成功！","history.back();",1);
    }
}

