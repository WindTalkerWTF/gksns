<div class="cmts" id="comments">
<div class="cmts-title">
<div class="gfl"><?php echo $this->totalNum; ?>条评论</div>

</div>
<?php 
	if($this->totalNum):
?>
<ul class="cmts-list">
<?php 
	foreach($this->list as $v):
	$this->lou++;
?>
	<li id="reply_<?php echo $v['id']; ?>">
	<div class="cmt-img cmtImg pt-pic"><a
		href="<?php echo $this->url("index/index/id/". $v['uid'], "user");?>" title="<?php echo $v['user']['nickname'];?>" target="_blank">
		<img  src="<?php echo My_Tool::getFace($v['user']['face'],"48"); ?>" alt="<?php echo $v['user']['nickname'];?>">
	</a> <span class="cmt-floor"><?php echo $this->lou; ?>楼</span></div>
	<div class="pt-txt"><span class="cmt-info"><?php echo My_Tool::qtime($v['created_at']);?></span> <a
		class="cmt-author cmtAuthor" href="<?php echo $this->url("index/index/id/". $v['uid'], "user");?>"
		target="_blank"><?php echo $v['user']['nickname']?></a>

        <div class="cmt-content cmtContent">
            <?php echo $v['is_publish'] ? My_Tool::addUserLink($v['content']) : "<span style='color:#999;background:#f4f4f4;padding:5px;'>评论正在审核中..</span>";?>
            <?php if($v['is_publish']):?>
                <div class="cmt-content_hide" style="display:none" ><?php echo $v['content'];?></div>
            <?php endif;?>
        </div>
	<span class="cmt-do">
	<?php if($this->uid == $v['uid']):?>
        <a class="cmt-do-quote" href="javascript:void 0;" onclick="delreply('<?php echo $v['id']; ?>')" >删除</a>&nbsp;&nbsp;
    <?php endif?>
        <?php if($v['is_publish']):?>
            <?php if($this->uid != $v['uid']):?>
                <a class="cmt-do-quote" href="javascript:void 0" onclick="addReplay('<?php echo $v['id']; ?>')">评论</a>
            <?php endif?>
        <?php endif?>
	</span>
		</div>
	</li>
<?php 
endforeach;
?>
</ul>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "site","#comments");?>
<?php 
	endif;
?>
<?php 
if(!$this->user):
?>
<div id="commentsReplyer" class="cmts-do">
<p>请 <a
	href="<?php echo $this->url("index/login?ref=".urlencode(My_Tool::getCurrentUrl()), "user");?>">登录</a>
后发表评论，</p>
</div>
<?php 
else:
?>
<div class="cmts-do" id="commentsReplyer">       
<h3 id="replyer">你的评论</h3>
<?php echo My_Tool_Form::start("sitereplyForm", $this->url('index/addreply'),"post", array("id"=>"replyForm"));?>
  <div><textarea name="reply" id="reply" style="width:99%"></textarea></div>
<?php echo $this->keditor("reply");?>
<input type="hidden" name="mark" value="<?php echo $this->mark;?>">
 <span class="tip" id="draftTip"></span>
<?php echo $this->showcode();?>
<input type="button" value="发 布" class="gbtn-primary submit">
<?php echo My_Tool_Form::end();?>  
</div>
<?php 
endif;
?>
</div>
<script>
	$(function(){
		$(".submit").click(function(){
			var text = editor.text();
			if(!text){
				$("#draftTip").html("评论不能为空!");
				return false;
			}

			$("#replyForm").submit();
		});
	});
	function delreply(id){
		fconfirm("确定要删除吗?",function(){
			ajax_get("<?php echo $this->url("index/deletereply/id/");?>"+id, function(a){
				if(a.code == 200){
					$("#reply_"+id).remove();
				}else{
					falert(a.msg);
				}
			});
		});
		
	}

	function addReplay(id){
		var nickname = $("#reply_"+id+" .cmt-author").text();
		var content = $("#reply_"+id+" .cmt-content_hide").html();
		var str="<blockquote>引用@"+nickname+"&nbsp;的话："+content+"</blockquote><p></p>";
		editor.appendHtml(str);
		editor.focus();
		location.href="#commentsReplyer";
	}
</script>