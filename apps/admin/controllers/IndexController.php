<?php

class Admin_IndexController extends My_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
//    	$this->_helper->layout()->disableLayout();
//    	$this->_helper->viewRenderer->setNoRender();
    }

     public function preDispatch(){
     }

     /********以下为自定义内容****************/
     
     #首页
	function indexAction(){
		$this->view->user = Admin::service()->getCommon()->getLogined();
		if(!$this->view->user) My_Tool::redirect(My_Tool::url("index/login"));
		$this->_helper->layout()->disableLayout();
		
		//获取导航菜单
		$this->view->pmenu = Admin::dao()->getMenu()->gets(array('pid'=>0));
		if($this->view->pmenu){
			foreach($this->view->pmenu as $k=>$v){
				$id = $v['id'];
				$this->view->pmenu[$k]['cmenu'] = Admin::dao()->getMenu()->gets(array('pid'=>$id));
			}
		}
		
		//获取应用信息
		$this->view->appinfo = array();
		$appinfo= Admin::dao()->getAppinfo()->gets(array("state"=>1));
		if($appinfo){
			foreach($appinfo as $k=>$v){
						$appNameTmp = ucfirst($v['name'])."_Service_Common";
						$obj = new $appNameTmp;
						if(!method_exists($obj,"getAdmMenu")) continue;
						$menuArr = $obj->getAdmMenu();
						if(!$menuArr) continue;
						$this->view->appinfo[$k] = $v;
						$this->view->appinfo[$k]['menulist'] = $menuArr;
			}
		}
	}
	
	function loginAction(){
		$this->_helper->layout()->disableLayout();
	}
	
	function tologinAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->viewRenderer->setNoRender();
		$email = $this->getRequest()->getParam("email");
		$pwd = $this->getRequest()->getParam("pwd");
        $code = $this->getParam("captcha");
        if(!Home::service()->getCommon()->checkCaptcha($code)) Admin_Tool::showMsg("验证码错误!");
		if($email == "" || $pwd=="") Admin_Tool::showMsg("账号或密码为空!", My_Tool::url("index/login"));
		$where['username'] = $email;
		$where['pwd'] = My_Tool::md5($pwd);
		$info = User::dao()->getInfo()->get($where);
		if(!$info)  Admin_Tool::showMsg("账号或密码错误!", My_Tool::url("index/login"));
		if($info['role'] < 9) Admin_Tool::showMsg("登录失败!", My_Tool::url("index/login"));
        if($info['is_del']) $this->showMsg("登录失败,您的帐户已经被管理员屏蔽");
		//设置登陆判定数据
		Admin::service()->getCommon()->setLogin($info);
		
		My_Tool::redirect(My_Tool::url("index/index"));
	}
	
	
	function logoutAction(){
		$session = new My_Session_Namespace("admin_login");
		$session->user = '';
		echo "<script>parent.location.href=\"".My_Tool::url("index/login")."\";</script>";
		exit;
	}
	

	function msgAction(){
		
	}
	
}

