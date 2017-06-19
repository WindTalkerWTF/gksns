<div class="wrap grow gmt60 edit-blog-page">
    <div class="gspan-25 main">
        <div class="gtitle">
            <h2>添加博客</h2>

        </div>
<?php echo My_Tool_Form::start("postadd", $this->url("index/doadd","site"),"post", array("id"=>"postadd","class"=>"gform"));?>
			<p><span style="color:#999;font-size:12px;padding-left:50px;">(原创文章更容易被管理员推送到首页和栏目页)</span></p>
            <label for="title">标题</label>

            <div class="gform-box title" >
 <?php 
 $initConfig = getInit();
 $wordCount = $initConfig['site']['title']['word']['count'];
 ?>
 <input placeholder="请输入2到<?php echo  $wordCount;?>字内的标题" class="gstxt" id="title" name="title" type="text" value="" style="width: 500px;">

            </div>
            <label for="content">内容</label>

            <div class="gform-textarea">
				<?php echo $this->keditor("content") ?>
                <textarea id="content" name="content" style="height:400px;"></textarea>
            </div>
        <?php echo $this->showcode();?>
            <div class="gform-box"  style="float: right;margin-top:10px;">
                <span class="tip" id="draftTip"></span>
                <input type="button" class="gbtn-submit" value="发布">
            </div>
<?php echo My_Tool_Form::end();?>
    </div>
    <div class="gspan-4 gprefix-1">
        <a style="font-size:12px;" href="<?php echo $this->url("index/index","user"); ?>">返回我的主页 &gt;</a>
    </div>
</div>
<script>
  $(function(){
		$(".gbtn-submit").click(function(){
			var title = $.trim($("#title").val());
			
			if(!title){ 
				$("#draftTip").html("标题不能为空");
				return false;
			}
<?php 
				$initConfig = getInit();
		$wordCount = $initConfig['site']['title']['word']['count'];	
?>
			if(title.length <2 || title.length ><?php echo $wordCount ?>){
				$("#draftTip").html("标题字数必须在2到<?php echo $wordCount ?>个字内");
				return false;
			}

			var text = editor.text();
			if(!text){
				$("#draftTip").html("内容不能为空");
				return false;
			}

			$("#postadd").submit();
		});

	})
</script>