<?php if(Home::service()->getCommon()->needCheckCode()): ?>
    <div style="margin-top:10px;margin-bottom:10px;">
    <label for="captcha">验证码</label>
    <span style="margin-left: 10px;width: 523px;">
        <input style="width:80px;height:20px;" class="gbtxt" id="captcha" maxlength="4" name="captcha" type="text" value="">
        <img src="<?php echo $this->url("index/verify","home");?>" id="captchaimg" class="captcha" style="width:100px;height:25px;"><span>
            看不清<a id="captchaimga" href="javascript:void(0)">换一张</a></span>
        <span class="captchanote tip">
      拥有<?php echo getSysData("site.coin.name") ?>超过<?php echo getSysData("site.coin.needyanzheng") ?>将不用输入验证码
        </span>
    </span>
        <script>
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

            });
        </script>
    </div>
<?php endif;?>