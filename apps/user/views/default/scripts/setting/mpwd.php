<div class="grow gmt60 gpack settings-profile-page">
<?php echo $this->leftsettingmenu();?>
<div class="main gspan-24 gprefix-1">
<div class="gbtitle">
                    <h2>修改密码</h2>
</div>
<form id="mpwdfrm" class="email_verify content gprefix-2 gform" action="<?php echo $this->url("setting/mpwd", "user");?>" method="POST">
<label for="email">密码</label>
<div class="gform-box">
<input autofocus="" class="gstxt" id="oldpassword" maxlength="40" name="oldpassword" required="" type="password" value="">
<span class="oldpasswordnote tip"></span>
</div>
<label for="email">新密码</label>
<div class="gform-box">
<input autofocus="" class="gstxt" id="password" maxlength="40" name="password" required="" type="password" value="">
<span class="passwordnote tip"></span>
</div>

<label for="email">确认新密码</label>
<div class="gform-box">
<input autofocus="" class="gstxt" id="repassword" maxlength="40" name="repassword" required="" type="password" value="">
<span class="repasswordnote tip"></span>
</div>
<input class="gbtn-primary gform-submit btnpwd" type="button" value="提交" />
        </div>
</div>
<script>
//js开始    
$(function(){
	
	$("#oldpassword").blur(function(){
		var oldpassword = $("#oldpassword").val();
		if(!oldpassword){
			setNote("oldpasswordnote", "旧密码不能为空!");
		}else{
				$(".oldpasswordnote").hide();
		}
	});
	
	$("#password").blur(function(){
		var password = $("#password").val();
		if(!password){
			setNote("passwordnote", "新密码不能为空!");
		}else{
			if(password.length > 12 || password.length <6){
				setNote("passwordnote", "密码长度范围在6-12个字符!");
			}else{
				$(".passwordnote").hide();
			}
		}
	});
	$("#repassword").blur(function(){
		var repassword = $("#repassword").val();
		var password = $("#password").val();
		if(!repassword){
			setNote("repasswordnote", "请输入确定密码!");
		}else{
			if(password != repassword){
				setNote("repasswordnote", "两次输入的密码不相同!");
			}else{
				$(".repasswordnote").hide();
			}
		}
	});
	
	$(".btnpwd").click(function(){
		var oldpassword = $("#oldpassword").val();
		if(!oldpassword){
			setNote("oldpasswordnote", "旧密码不能为空!");
			return false;
		}else{
				$(".oldpasswordnote").hide();
				var repassword = $("#repassword").val();
				var password = $("#password").val();
				if(!repassword){
					setNote("repasswordnote", "请输入确定密码!");
				}else{
					if(password != repassword){
						setNote("repasswordnote", "两次输入的密码不相同!");
					}else{
						$(".repasswordnote").hide();
						$("#mpwdfrm").submit();
					}
				}	
		}
	})
	
	
})
</script>
