<div class="gspan-19 gprefix-2 main">    
    <h1>欢迎登录<?php  echo getSysData('site.config.siteName'); ?></h1>
    
    <form class="gform" id="loginForm" action="<?php echo $this->url("index/login");?>" method="POST">
       <div>
    <label for="email">邮箱/昵称</label>
    
<div class="gform-box">
            <input autofocus="" class="gstxt" id="username" maxlength="40" name="username" required="" type="text" value="">
            
            
    <span class="usernamenote tip"></span>
        </div>
    <label for="password">密码</label>
    
<div class="gform-box">
            <input class="gstxt" id="password" name="password" required="" type="password" value="">
            
            
    <span class="passwordnote tip"></span>
        </div>
  
    <p class="gform-box gform-rem">
        <input checked id="remember" name="remember" type="checkbox" value="1">
        
        <label for="permanent">记住我（网吧或别人的电脑请不要勾选）</label>
        
        <span class="tip"></span>
    </p>
    
<label for="captcha">验证码</label>
<div class="gform-box">
            <input class="gbtxt form-txt-vcode" id="captcha" maxlength="4" name="captcha" type="text" value="">
            <img src="<?php echo $this->url("index/verify","home");?>?key=login" id="captchaimg" class="captcha" style="width:100px;height:25px;"><span>
            看不清<a id="captchaimga" href="javascript:void(0)">换一张</a></span>
    <span class="captchanote tip"></span>
</div>
    

            <p>
                <input type="button" class="gform-submit greg-btn btn-Send" value="登录">
                <a class="gform-forget_pw" href="<?php echo My_Tool::url("/index/findpwd", "user");?>">忘记密码？</a>
            </p>
        </div>
    </form>
</div>
<script>
//js开始

//重载验证码
function fleshVerify(){
	var timenow = new Date().getTime();
	$("#captchaimg").attr("src", '<?php echo $this->url("index/verify","home");?>?key=login&'+timenow);
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
	
	
	 $("#password").blur(function(){
		var password = $("#password").val();
		if(!password){
			setNote("passwordnote", "密码不能为空!");
		}else{
			$(".passwordnote").hide();
		}
	});
	 
	 
	 $("#captcha").blur(function(){
		var captcha = $.trim($("#captcha").val());
		if(!captcha){
			setNote("captchanote", "验证码不能为空!");
		}else{
			$.post("<?php echo $this->url("index/validatecaptcha","user");?>", {captcha:captcha,key:'login'}, function(a){
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
				var password = $("#password").val();
				if(!password){
					setNote("passwordnote", "密码不能为空!");
				}else{
					$(".passwordnote").hide();
					var captcha = $.trim($("#captcha").val());
					if(!captcha){
						setNote("captchanote", "验证码不能为空!");
					}else{
						$.post("<?php echo $this->url("index/validatecaptcha","user");?>", {captcha:captcha,key:'login'}, function(a){
							if(a.code != 0 ){
								setNote("captchanote", a.msg);
							}else{
								$(".captchanote").hide();
								$("form").submit();
							}
						},"json");
					}
				}
			}
	});
		
	
	
});
</script>
