<?php
class User_Service_Openlogin extends Home_Service_Base{
	
	function getQQconfig($callBackUrl=""){
		$qqk = getSysData('app.user.openlogin.qq.appkey');
		$qqs = getSysData('app.user.openlogin.qq.appsecret');
		$callBackUrl = $callBackUrl ? $callBackUrl : "/qqlogin/do";
		$domain = getSysData('site.config.domain');
		$scope='get_user_info,add_share';
		$callback_url = "www.".$domain.My_Tool::url($callBackUrl,"user");
		return array($qqk,$qqs,$scope,$callback_url);
	}
	
	function qqAccess($callBackUrl=""){
		list($qqk,$qqs,$scope,$callback_url) = $this->getQQconfig($callBackUrl);
		My_Tool::importOpen("weibo/QQPHP.class.php");
		$qq=new qqPHP($qqk, $qqs);
		$login_url=$qq->login_url($callback_url, $scope);
		My_Tool::redirect($login_url);
        exit;
	}
	
	function getQQAccessToken($code,$callBackUrl=""){
		list($qqk,$qqs,$scope,$callback_url) = $this->getQQconfig($callBackUrl);
		My_Tool::importOpen("weibo/QQPHP.class.php");
		$qq=new qqPHP($qqk, $qqs);
		return $qq->access_token($callback_url, $code);
	}
	
	function getQQInfo($accessToken,$callBackUrl=""){
		list($qqk,$qqs,$scope,$callback_url) = $this->getQQconfig($callBackUrl);
		My_Tool::importOpen("weibo/QQPHP.class.php");
		$qq=new qqPHP($qqk, $qqs,$accessToken);
		$qq_oid=$qq->get_openid();
		$openid=$qq_oid['openid']; //获取登录用户open id
		$result = $qq->get_user_info($openid);
		if(!isset($result['nickname'])) return My_Tool::errorReturn("登录失败");
		$result['openid'] = $openid;
		return $result;
	}
	
}