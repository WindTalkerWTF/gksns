<?php
class User_Controller_Plugin_Autologin extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
            if(isDebug()) return true;
    		$appName = $request->getModuleName();
			
			//除了后台模块，其他模块都可以执行自动登录

			if($appName != "admin"){
				$user = User::service()->getCommon()->getLogined();
		    	if(!$user){
					//查看cookie里面的情况 ,是否有自动登录	
					$loginData = My_Tool_Cookie::get("autologin");
					
					if($loginData){
							#解密
							$config = My::config()->getInit();
							$key = $config['site']['salt']['key'];
							$loginData = My_Tool::authcode($loginData,$key);
							$loginData = unserialize($loginData);
							$uid = $loginData['uid'];
							$pwd = $loginData['pwd'];
							
							$info = User::dao()->getInfo()->get(array("id"=>$uid));
							
							if($info){
								if($info['pwd'] == $pwd){
									User::service()->getCommon()->setLogin($info);
								}
							}
					}
				}
			}
       
    }

}