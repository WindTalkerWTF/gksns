<?php

class Install_IndexController extends My_Controller_Action
{

    public function init(){
    	
    }

    function installCheck(){
		if(isInstall()){
			header("Content-type: text/html; charset=utf-8");
			exit('网站已经安装，请删除data/install.lock文件，重新安装!');
		}
	}

     /********以下为自定义内容****************/
	function indexAction(){
		$this->installCheck();
	}
	
	function checkAction(){
		$this->installCheck();
		$paths = array(
				"data"=>array(ROOT_DIR."/data","执行linux命令:chmod -R 0777 data"),
				"res/upload"=>array(PUBLIC_DIR."/res/upload","执行linux命令:chmod -R 0777 res/upload"),
		        "configs"=>array(ROOT_DIR."/configs","执行linux命令:chmod -R 0777 configs"),
			);
		$result = array();
		foreach ($paths as $k=>$v){
			$mode = Install_Tool::fileModeInfo($v[0]);
			$result[$k] = array($mode,$v[1]);
		}
		$this->view->path = $result;
	}
	
	function configAction(){
		$this->installCheck();
		error_reporting(0);
		set_time_limit(0);
		if(My_Tool::isPost()){
			$dbHost = $this->getRequest()->getParam("DB_HOST");
			$dbPort = $this->getRequest()->getParam("DB_PORT");
			$dbName = $this->getRequest()->getParam("DB_NAME");
			$dbUser = $this->getRequest()->getParam("DB_USER");
			$dbPwd = $this->getRequest()->getParam("DB_PWD");
			
			$admin = $this->getRequest()->getParam("admin");
			$adminPwd = $this->getRequest()->getParam("adminPwd");
			
			$this->view->dbHost = $dbHost;
			$this->view->dbPort = $dbPort;
			$this->view->dbName = $dbName;
			$this->view->dbUser = $dbUser;
			$this->view->dbPwd = $dbPwd;
			$this->view->admin = $admin;
			$this->view->adminPwd = $adminPwd;
			
		   if(!$dbHost){
			 My_Tool_FlashMessage::set("mycmf_install","数据库地址为空!");
		    }elseif(!$dbPort){
				My_Tool_FlashMessage::set("mycmf_install","数据库端口为空!");
			}elseif(!$dbName){
				My_Tool_FlashMessage::set("mycmf_install","数据库名称为空!");
			}elseif(!$dbUser){
				My_Tool_FlashMessage::set("mycmf_install","数据库用户名为空!");
			}elseif(!$dbPwd){
				My_Tool_FlashMessage::set("mycmf_install","数据库密码为空!");
			}elseif(!$admin){
				My_Tool_FlashMessage::set("mycmf_install","管理员账户为空!");
			}elseif(!My_Tool_Check::email($admin)){
				My_Tool_FlashMessage::set("mycmf_install","管理员账户必须是邮箱地址!");
			}elseif(!$adminPwd){
				My_Tool_FlashMessage::set("mycmf_install","管理员密码为空!");
			}
			$obj = new Install_Service_Common();
			$result = $obj->checkDbConn($dbHost, $dbPort, $dbUser, $dbPwd, $dbName);
			if(!$result){
				My_Tool_FlashMessage::set("mycmf_install",My_Tool_Error::lastError());
			}

			if(!My_Tool_FlashMessage::has("mycmf_install")){
					$obj->install($dbHost, $dbPort, $dbUser, $dbPwd, $dbName);
					//更新配置
                    $salt = My_Tool::getRandomString(20);
                    $dataConfig=array();
                    $dataConfig['site.salt.key'] = $salt;
                    My_Config::getInstance()->save($dataConfig);
//					saveSysData('site.salt.key', $salt);
					//插入管理员数据
					$userObj = new User_Dao_Info();
					$data['username'] = $admin;
					$data['pwd'] = My_Tool::md5($adminPwd,$salt);
					$data['nickname'] = '管理员';
					$data['role'] = '10';
					$data['email_validate'] = '1';
					$id = $userObj->insert($data);
					//user state
					#生成统计表
					User::dao()->getStat()->insert(array("uid"=>$id));
                    $path = ROOT_DIR."/data/install.lock";
                    touch($path);
					if($id) My_Tool::redirect(My_Tool::url('index/success',"home"));
					My_Tool_FlashMessage::set("mycmf_install","未知错误请重试!");
			}
		}
		
	}
	
	
}

