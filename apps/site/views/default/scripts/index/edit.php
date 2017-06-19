<div class="wrap grow gmt60 edit-blog-page">
    <div class="gspan-25 main">
        <div class="gtitle">
            <h2>编辑博客</h2>
        </div>
<?php echo My_Tool_Form::start("postEdit", $this->url("index/doedit","site"),"post", array("id"=>"postEdit","class"=>"gform"));?>
            <label for="title">标题</label>

            <div class="gform-box">
                <input autofocus="" class="gstxt" id="title" name="title" type="text" value="<?php echo
					$this->info['title'];?>"
					   style="width: 500px;">
            </div>
            <label for="content">内容</label>

            <div class="gform-textarea" >
				<?php echo $this->keditor("content") ?>
         <textarea class="" id="content" name="content" style="height:400px;"><?php echo $this->content['content']; ?></textarea>

            </div>
            <div class="gform-box" style="float: right;margin-top:10px;">
				<input type="hidden" id="id" name="id" value="<?php echo $this->id; ?>">
				<span class="tip" id="draftTip"></span>
                <input type="button" class="gbtn-submit" value="提交">
            </div>
<?php echo My_Tool_Form::end();?>
    </div>
    <div class="gspan-4  gprefix-1">
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

			$("#postEdit").submit();
		});

	})
</script>