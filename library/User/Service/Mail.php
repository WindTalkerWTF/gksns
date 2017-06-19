<?php
class User_Service_Mail extends Home_Service_Base{
	
	private  $config = array();
	
	#发送注册成功邮件
	function sendRegMail($email, $token){
		if(!$email || !$token) return false;
		My_Tool_Email::init();

		
		$str = "<h3>欢迎注册".getSysData('site.config.siteName')."(".getSysData('site.config.domain').")</h3>";
		$str .= "<p>恭喜你成为".getSysData('site.config.siteName')."会员，您的账号为:</p>";
		$str .= "<p>{$email}</p>";
		$str .= "<p>请点击下面的链接验证您的邮箱地址:</p>";
		$domain = getSysData('site.config.domain');
		$urlTmp = My_Tool::url("/index/checkemail/token/{$token}/email/{$email}","user");
		$url = "http://" . $domain .$urlTmp;
		$str .= "<p><a href=\"{$url}\" target=\"_blank\">{$url}</a></p>";
		$str .= "<p>(如果不能打开此链接，请将网址复制到浏览器的地址栏，来打开此页面)</p>";
		$title = "".getSysData('site.config.siteName')."账号注册成功及邮箱验证!";
		My_Tool_Email::send($email, $title, $str);
	}
	
	#找回密码
	function sendFindpwd($email, $token){
		if(!$email || !$token) return false;
		My_Tool_Email::init();
		$str = "<h3>".getSysData('site.config.siteName')."(".getSysData('site.config.domain').")找回密码</h3>";
		$str .= "<p>请点击下面的链接，到新打开的页面重新设置密码:</p>";
		$urlTmp = My_Tool::url("/index/resetpwd/token/{$token}/email/{$email}","user");
		$url = "http://" . getSysData('site.config.domain') . $urlTmp;
		$str .= "<p><a href=\"{$url}\" target=\"_blank\">{$url}</a></p>";
		$str .= "<p>(如果不能打开此链接，请将网址复制到浏览器的地址栏，来打开此页面)</p>";
		$title = "".getSysData('site.config.siteName')."找回密码!";
		My_Tool_Email::send($email, $title, $str);
	}
	
	
}