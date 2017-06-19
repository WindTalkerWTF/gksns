<div class="wrap grow gmt60 gpack">
<div class="gspan-21 gprefix-2 main">
<h1>找回密码</h1>
<form class="gform" id="forgotPassword" action="<?php echo $this->url("index/findpwd", "user");?>" method="POST">
<div class="">
<p class="reg-summary">请输入你的注册邮箱，系统将发出一封验证邮件，通过验证邮件就可以重新设置密码了</p>

<label for="email">邮箱</label>

<div class="gform-box"><input autofocus="" class="gstxt" id="username"
	maxlength="40" name="username" required="" type="text" value=""> <span
	class="tip usernamenote"></span></div>

<label for="captcha">验证码</label>
<div class="gform-box">
            <input class="gbtxt form-txt-vcode" id="captcha" maxlength="4" name="captcha" type="text" value="">
            <img src="<?php echo $this->url("index/verify","home");?>" id="captchaimg" class="captcha" style="width:100px;height:25px;"><span>
            看不清<a id="captchaimga" href="javascript:void(0)">换一张</a></span>
    <span class="captchanote tip"></span>
</div>

<p><input type="button" class="gbtn-primary btn-Send" value="确定"></p>
</div>
</form>
</div>
</div>
<script>
//js开始
//重载验证码
function fleshVerify(){
	var timenow = new Date().getTime();
	$("#captchaimg").attr("src", '<?php echo $this->url("index/verify","home");?>?'+timenow);
}
$(function(){
	$("#captchaimg").click(function(){
		fleshVerify();
	});	
	$("#captchaimga").click(function(){
		fleshVerify();
	});	
	
	$("#username").blur(function(){
		var username = $("#username").val();
		if(!username){
			setNote("usernamenote", "邮箱地址不能为空!");
		}else{
			$(".usernamenote").hide();
		}
	});
	
	 $("#captcha").blur(function(){
			var captcha = $.trim($("#captcha").val());
			if(!captcha){
				setNote("captchanote", "验证码不能为空!");
			}else{
				$.post("<?php echo $this->url("index/validatecaptcha","user");?>", {captcha:captcha}, function(a){
					if(a.code != 0 ){
						setNote("captchanote", a.msg);
					}else{
						$(".captchanote").hide();
					}
				},"json");
			}
			
		});
	
		$(".btn-Send").click(function(){
			var username = $("#username").val();
			if(!username){
				setNote("usernamenote", "邮箱地址不能为空!");
				return false;
			}else{
					$(".usernamenote").hide();
					var captcha = $.trim($("#captcha").val());
					if(!captcha){
						setNote("captchanote", "验证码不能为空!");
					}else{
						$.post("<?php echo $this->url("index/validatecaptcha","user");?>", {captcha:captcha}, function(a){
							if(a.code != 0 ){
								setNote("captchanote", a.msg);
							}else{
								$(".captchanote").hide();
								$("form").submit();
							}
						},"json");
					}
				
			}
	});
	
});
</script>