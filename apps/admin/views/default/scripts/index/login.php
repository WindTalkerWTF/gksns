<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>登录管理中心 - Powered by PHPcom</title>
<?php 
echo $this->loadscript("/asset/admin/login.css");
?>
<script language="JavaScript">
if(self.parent.frames.length != 0) {
	self.parent.location=document.location;
}
</script>
</head>
<body>
<div id="login-header"></div>
<div id="login-main">
	<div class="leftbox"></div>
	<div class="loginbox">
		<div id="login-box">
            <h3 style="text-align: center">捷库sns后台管理</h3>
	 <?php 
    echo My_Tool_Form::start("loginfrm", $this->url('index/tologin',"admin"));
    ?>
            <table cellpadding="3" cellspacing="0" width="100%">
                <tbody>
                <tr><th>管理员：</th><td><div class="login-icon"><div class="name"></div><input class="input" name="email" tabindex="1" type="text"></div></td></tr>
                <tr><th>密　码：</th><td><div class="login-icon"><div class="pwd"></div><input class="input" name="pwd" tabindex="2" type="password"></div></td></tr>
                <tr><th>验证码：</th><td>
                        <div class="login-icon" style="background: none;border: none">
                        <input class="input" id="captcha" maxlength="4" name="captcha" type="text" value="" style="width:50px;">
     <img  src="<?php echo $this->url("index/verify","home");?>" id="captchaimg" class="captcha" style="width:80px;height:25px;vertical-align:middle;cursor: pointer ">
                         </div>
                </td>
                </tr>
                <tr><th></th><td><input class="submit-button" name="submit" value="ok" src="<?php echo $this->img("/res/asset/admin/images/login.gif");?>" type="image"></td></tr>
            </tbody></table>
 <?php
    echo My_Tool_Form::end();
?>
</div>
	</div>
	<div class="rightbox"></div>
</div>
<?php 
echo $this->loadscript("/js/jquery-1.7.2.min.js");
?>
<script>
    //js开始

    //重载验证码
    function fleshVerify(){
        var timenow = new Date().getTime();
        $("#captchaimg").attr("src", '<?php echo $this->url("index/verify","home");?>?'+timenow);
    }

    $("#captchaimg").click(function(){
        fleshVerify();
    });
</script>
</body>
</html>