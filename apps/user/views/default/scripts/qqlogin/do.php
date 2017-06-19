 <div class="gspan-19 gprefix-2 main">  
    <h1>欢迎加入<?php  echo getSysData('site.config.siteName'); ?></h1>
<form class="gform" id="regForm" action="<?php echo $this->url("qqlogin/reg");?>" method="POST">
<?php if($this->userInfo['figureurl_2']):?>
<div class="">
<label>头像</label>
<div class="gform-box">
<img src="<?php echo $this->userInfo['figureurl_2'];?>" >
</div>
<?php endif;?>
<div class="">
<label for="email">邮箱</label>
<div class="gform-box">
<input autofocus="" class="gstxt" id="username" maxlength="40" name="username" required="" type="text" value="">
<span class="usernamenote tip"></span>
</div>
<label for="email">昵称</label>
<div class="gform-box">
<input autofocus="" class="gstxt" id="nickname" maxlength="40" name="nickname" required="" type="text" value="<?php echo $this->userInfo['nickname'];?>">
<span class="nicknamenote tip"></span>
</div>
<label for="email">密码</label>
<div class="gform-box">
<input autofocus="" class="gstxt" id="password" maxlength="40" name="password" required="" type="password" value="">
<span class="passwordnote tip"></span>
</div>

<label for="email">确认密码</label>
<div class="gform-box">
<input autofocus="" class="gstxt" id="repassword" maxlength="40" name="repassword" required="" type="password" value="">
<span class="repasswordnote tip"></span>
</div>
      <p>
          <p>注册即同意本站<a href="<?php echo $this->url("index/view/id/".getSysData('site.config.reg.id'),"group");?>" target="_blank">注册条款</a></p>
          <input type="button" class="gform-submit greg-btn btn-Send" value="提交">
      </p>
</div>
</form>
</div>
<script>
//js开始   
function isValidMail(sText){
	var reMail = /^[a-z0-9]+([_\.-]*[a-z0-9]+)*@[a-z0-9]([-]?[a-z0-9]+)\.[a-z]{1,}(\.[a-z]{1,})?$/i;
	return reMail.test(sText);
}



$(function(){
	
	
	$("#username").blur(function(){
		var username = $("#username").val();
		if(!username){
			setNote("usernamenote", "邮箱地址不能为空!");
		}else{
			//email格式检测
			if(isValidMail(username)){
					$.post("<?php echo $this->url("index/checkusername","user");?>", {username:username}, function(a){
					if(a.code ==0){
						$(".usernamenote").hide();
					}else{
						setNote("usernamenote", a.msg);
					}
					
				}, "json");
			}else{
				setNote("usernamenote", "邮箱地址格式不正确!");
			}
		}
	});
	
	$("#nickname").blur(function(){
		var nickname = $("#nickname").val();
		if(!nickname){
			setNote("nicknamenote", "昵称不能为空");
		}else{
			if(nickname.length > 12 || nickname.length <2){
				setNote("nicknamenote", "昵称长度范围在2-12个字符!");
			}else{
				
				$.post("<?php echo $this->url("index/checknickname","user");?>", {nickname:nickname}, function(a){
					if(a.code ==0){
						$(".nicknamenote").hide();
					}else{
						setNote("nicknamenote", a.msg);
					}
				}, "json");
				
				
			}	
		}
	});
	
	$("#password").blur(function(){
		var password = $("#password").val();
		if(!password){
			setNote("passwordnote", "密码不能为空!");
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
	
	
	
	$(".btn-Send").click(function(){
		var username = $("#username").val();
		if(!username){
			setNote("usernamenote", "邮箱地址不能为空!");
			return false;
		}else{
			//email格式检测
			if(isValidMail(username)){
					$.post("<?php echo $this->url("index/checkusername","user");?>", {username:username}, function(a){
					if(a.code ==0){
						$(".usernamenote").hide();
						//昵称
						var nickname = $("#nickname").val();
						if(!nickname){
							setNote("nicknamenote", "昵称不能为空");
							return false;
						}else{
							if(nickname.length > 12 || nickname.length <2){
								setNote("nicknamenote", "昵称长度范围在2-12个字符!");
								return false;
							}else{
								
								$.post("<?php echo $this->url("index/checknickname","user");?>", {nickname:nickname}, function(a){
									if(a.code ==0){
										$(".nicknamenote").hide();
										//密码
										var password = $("#password").val();
										if(!password){
											setNote("passwordnote", "密码不能为空!");
											return false;
										}else{
											if(password.length > 12 || password.length <6){
												setNote("passwordnote", "密码长度范围在6-12个字符!");
												return false;
											}else{
												$(".passwordnote").hide();
												
												//重复密码
												var repassword = $("#repassword").val();
												var password = $("#password").val();
												if(!repassword){
													setNote("repasswordnote", "请输入确定密码!");
													return false;
												}else{
													if(password != repassword){
														setNote("repasswordnote", "两次输入的密码不相同!");
														return false;
													}else{
														$(".repasswordnote").hide();
														$("form").submit();
													}
												}
												
											}
										}
										
									}else{
										setNote("nicknamenote", a.msg);
										return false;
									}
								}, "json");
								
								
							}	
						}
						
						
					}else{
						setNote("usernamenote", a.msg);
						return false;
					}
					
				}, "json");
			}else{
				setNote("usernamenote", "邮箱地址格式不正确!");
				return false;
			}
		}
	});
	
	
});
</script>