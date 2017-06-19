<?php 
	echo My_Tool_Form::start("resetpwd", $this->url('index/resetpwd',"user"));
?>
<h1 class="heading">重新设置密码</h1>
<div class="formsect">
<div class="filed">
<div class="required">
<label for="password">新密码：&nbsp;&nbsp;&nbsp;&nbsp;</label> 
<input type="password" value="" class="gstxt" name="password" id="password">
</div>
<div class="tip passwordnote"><span><em></em></span></div>
</div>
<div class="filed">
<div class="required"><label for="repassword">确认密码：</label> <input
	type="password" value="" class="gstxt" name="repassword"
	id="repassword"></div>
<div class="tip repasswordnote"><span><em></em></span></div>
</div>
<div class="btnx">
<input  type="hidden" value="<?php echo $this->email;?>" name="email">
<input  type="hidden" value="<?php echo $this->token;?>" name="token">
<input class="btn btn-inverse" type="button" value="确认"></div>
</div>
<?php 
echo My_Tool_Form::end();
?>
<script>
//js开始 
$(function(){
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
	
	$(".btn-inverse").click(function(){
		var repassword = $("#repassword").val();
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
	})
	
})
	
</script>
