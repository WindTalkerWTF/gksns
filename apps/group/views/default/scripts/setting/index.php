<div class="grow gmt60 nuts-page">
    <?php echo $this->settingright($this->id);?>
    <div class="main gspan-21">
        <div class="main-title">
            <h1>"<?php echo $this->info['name']?>"小组管理</h1>
        </div>
        <ul class="gtabs gclear">
			<li  class="gtabs-curr">基本设置</li>
            <li><a href="<?php echo $this->url("setting/mg/id/".$this->id,"group");?>">成员管理</a></li>
        </ul>
     <form id="settingbase" class="gform" method="post" action="<?php echo $this->url("setting/dosaveinfo","group"); ?>">  
      <div class="gprefix-1">
                    <div class="gform-box" >
                        <span class="gform-box-left">小组类型:<?php if(!$this->info['group_type']):?>公开小组<?php else:?>私密小组<?php endif;?></span>
                    </div>
    <div class="gform-box">
    <label for="name">小组名称:</label>
<input  class="gbtxt" id="name" maxlength="30" name="name" type="text" value="<?php echo $this->info['name'];?>">
    <span class="tip"></span>
        </div>


<div class="gform-box">
<span class="gform-box-left">小组图标:</span>
<div class="gform-box-right" id="imgUpload">
<?php if($this->info['name']):?>
<div style=" padding-left:70px;">
<img src="<?php echo My_Tool::getFace($this->info['face'],48);?>" >
</div>
<?php endif;?>
<input type="file" id="trueFile" name="upload_file"/><br/>
<span id="uploadMsg">（支持png、jpg、gif图片格式，大小不要超过1M）</span>
</div>
</div>
                    
    <div class="gform-box">
    <label for="blackboard">小组介绍:</label>
   <textarea  onkeyup="checkLength(this, 100, 'chLeft1');"   class="gttxt" cols="48" id="blackboard" name="introduction"  rows="6"><?php echo $this->info['descr'];?></textarea>
    <br />
 <small>文字最大长度: 100. 还剩: <span id="chLeft1"></span>.</small>
        </div>
                    <div>
                        <div class="gform-box-right">
                            <input type="hidden" name="id" value="<?php echo $this->id; ?>" >
                            <input type="button" class="gbtn-primary submit" value="提交">
                            <span class="tip" id="draftTip"></span>
                        </div>
                    </div>
                </div>
       </form>
    </div>
</div>
 <script>
 $(function(){
		$(".submit").click(function(){
			var name = $.trim($("#name").val());
			if(!name){
				$("#draftTip").html("小组名称不能为空!");
				return false;
			}

			if(name.length <2 || name.length >10){
				$("#draftTip").html("小组名称必须在2到8个字以内!");
				return false;
			}

			var introduction = $.trim($("#blackboard").val());
			if(!introduction){
				$("#draftTip").html("小组介绍不能为空!");
				return false;
			}

			$("#settingbase").submit();
			
		});
	});
</script>