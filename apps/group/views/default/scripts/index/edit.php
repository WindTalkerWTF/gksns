<div class="grow  post-edit-page">
    <div class="main gspan-25 gsuffix-1">
        <div class="gbreadcrumb">
            <ul>
                <li>
                    <a href="<?php echo $this->url("index/index");?>">小组</a>
                </li>
                <li>
                    <a href="<?php echo $this->url("index/g/id/".$this->info['group_id']);?>"><?php echo
					$this->groupInfo['name'];?></a>
                </li>
                <li>    
                    编辑帖子
                </li>
            </ul>
        </div>
   <?php echo My_Tool_Form::start("gpostedit", $this->url("index/doedit","group"),"post", array("id"=>"postEdit","class"=>"gform"));?>
    <label for="title">标题</label> 
<div class="gform-box">
            <input class="gstxt" id="title" name="title" type="text" value="<?php echo $this->info['title']; ?>">
        </div>
    <label for="content">内容</label>
	<div class="gform-textarea">
			<?php echo $this->keditor("content");?>
            <textarea class="" id="content" name="content" style="height:450px;"><?php echo
	$this->content['content'];?> </textarea>
            <br />
    </div>
        <div class="gform-box">
            <input id="id" name="id" type="hidden" value="<?php echo $this->id;?>">
            <input type="submit" class="gbtn-submit" value="发布">
            <span class="tip" id="draftTip"></span>
        </div>
<?php echo My_Tool_Form::end();?>

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
			if(title.length <2 || title.length ><?php echo $wordCount  ?>){
				$("#draftTip").html("标题字数必须在2到<?php echo $wordCount  ?>个字内");
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