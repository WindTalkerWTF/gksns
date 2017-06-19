<?php
require_once ROOT_LIB . '/Open/Email.class.php';
class My_Tool_Email extends Email{
  static public function init($config = array()) 
    {
self::$config['SMTP_HOST']=getSysData('site.smtp.SMTP.HOST')?getSysData('site.smtp.SMTP.HOST'):'smtp.exmail.qq.com';//smtp服务器地址
self::$config['SMTP_PORT']=getSysData('site.smtp.SMTP.PORT')?getSysData('site.smtp.SMTP.PORT'):25;//smtp服务器端口
self::$config['SMTP_SSL']=getSysData('site.smtp.SMTP.SSL')?getSysData('site.smtp.SMTP.SSL'):false;//是否启用SSL安全连接	，gmail需要启用sll安全连接
self::$config['SMTP_USERNAME']=getSysData('site.smtp.SMTP.USERNAME')?getSysData('site.smtp.SMTP.USERNAME'):'';//smtp服务器帐号，如：你的qq邮箱
self::$config['SMTP_PASSWORD']=getSysData('site.smtp.SMTP.PASSWORD')?getSysData('site.smtp.SMTP.PASSWORD'):'';//smtp服务器帐号密码，如你的qq邮箱密码
self::$config['SMTP_AUTH']=getSysData('site.smtp.SMTP.AUTH')?getSysData('site.smtp.SMTP.AUTH'):true;//启用SMTP验证功能，一般需要开启
self::$config['SMTP_CHARSET']=getSysData('site.smtp.SMTP.CHARSET')?getSysData('site.smtp.SMTP.CHARSET'):'';//发送的邮件内容编码
self::$config['SMTP_FROM_TO']=getSysData('site.smtp.SMTP.FROMTO')?getSysData('site.smtp.SMTP.FROMTO'):'';//发件人邮件地址
self::$config['SMTP_FROM_NAME']=getSysData('site.smtp.SMTP.FROMNAME')?getSysData('site.smtp.SMTP.FROMNAME'):'管理员';//发件人姓名
self::$config['SMTP_DEBUG']=getSysData('site.smtp.SMTP.DEBUG')?getSysData('site.smtp.SMTP.DEBUG'):false;//是否显示调试信息

    }
}