<div class="grow gmt60 gpack settings-profile-page">
<?php echo $this->leftsettingmenu();?>
            
            <div class="gspan-24 gprefix-1">
                <div class="gbtitle">
                    <h2>个人资料</h2>
                </div>
<form class="gprefix-1 gsuffix-2 gform" method="POST" action="<?php echo $this->url("setting/index", "user");?>" id="profile">                 
    
    <label for="gender">性别</label>
    
<div class="gform-box"> 
                <input id="gender-0" name="gender" type="radio" value="1" <?php if($this->user['sex'] == 1) echo "checked";?>>
    <label for="gender-0">男</label>
                <input id="gender-1" name="gender" type="radio" value="2" <?php if($this->user['sex'] == 2) echo "checked";?>>
    <label for="gender-1">女</label>     
       <input  id="gender-2" name="gender" type="radio" value="0" <?php if($this->user['sex'] == 0) echo "checked";?>>
    <label for="gender-2">保密</label>    
        </div>


                    
    <label for="area">所在地</label>
    

                    <div class="gform-box">
                        <select data-city="None" id="pro" name="pro">
                       		<?php 
                       			foreach ($this->pro as $v):
                       		?>
                       			<option value="<?php echo $v['id']?>" <?php echo $v['id'] == $this->curPro ? "selected" : "";?>><?php echo $v['name']?></option>
                       		<?php endforeach;?>
                        </select>
                        <select name="city" id="city">
                        	<option value="">请选择</option>
                        </select>
                        
    			<span class="areaNote tip"></span>

                    </div>
                        
                    <label append_br="False" for="introduction">个人签名</label>
                    <div class="gform-box" id="selfIntro">
                        <textarea class="gttxt" cols="40"   onkeyup="checkLength(this, 20, 'chLeft1');"  id="introduction" name="introduction" rows="2"
                        ><?php echo $this->user['sign'] ? $this->user['sign'] : "";?></textarea>
                        <div class="gform-box-count" id="wordCount"><small>文字最大长度: 20. 还剩: <span id="chLeft1"></span>.</small></div>
                    </div>
                    <input type="button" class="gbtn-primary gform-submit" value="保存" />
                </form>
            </div>
 </div>
<script>
	var ajax_getcity_url = "<?php echo $this->url("setting/getcitys", "user");?>";
	var selected_cityId = "<?php echo $this->user['cur_area'];?>";
	var ajax_check_nickname_url = "<?php echo $this->url("setting/checknewnickname", "user");?>";
	  //js开始    
	$(function(){
		$("#pro").change(function(){
			var proid = $("#pro option:selected").val();
			ajax_get(ajax_getcity_url + "/id/"+proid,function(a){
				if(a.code==200){
					var str = "";
					for(k in a['msg']){
						str += "<option value=\""+a['msg'][k]['id']+"\">"+a['msg'][k]['name']+"</option>";
					}
					$("#city").html(str);
				}
			});
		});

		$(".gform-submit").click(function(){

						var city = $("#city option:selected").val();
						if(!city){
							setNote("areaNote", "请选择所在地的城市!");
							return false;
						}else{
							$(".areaNote").hide();
						}
						
						$(".gform").submit();
				});

		getCitys(selected_cityId);
	});

	function getCitys(cityId){
		cityId = cityId || 0;
		var proid = $("#pro option:selected").val();
		ajax_get(ajax_getcity_url + "/id/"+proid,function(a){
			if(a.code==200){
				var str = "";
				for(k in a['msg']){
					var selected = "";
					if(a['msg'][k]['id'] == cityId) selected = "selected";
					str += "<option "+selected+" value=\""+a['msg'][k]['id']+"\">"+a['msg'][k]['name']+"</option>";
				}
				$("#city").html(str);
			}
		});
	}
</script>