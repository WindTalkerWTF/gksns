<?php if($this->list):?>
<?php foreach($this->list as $v):?>
<div class="answer" id="answer_<?php echo $v['id']?>">
            <div class="answer-digg digg">
                <a href="javascript:void 0;" id="supp_<?php echo $v['id']?>" data-operation="support" data-id="<?php echo $v['id']?>" class="answer-digg-up" title="支持（+1）"><?php echo $v['support_count'];?></a>
                <a href="javascript:void 0;"  id="aga_<?php echo $v['id']?>" data-operation="oppose" data-id="<?php echo $v['id']?>" class="answer-digg-dw" title="反对(-1)"><?php echo $v['against_count'];?></a>
            </div>
            <div class="answer-r">
                <div class="answer-t">
                    <a class="answer-img" href="<?php echo $this->url("/index/index/id/". $v['user']['id'], "user");?>" title="<?php echo $v['user']['nickname'];?>" target="_blank">
                        <img width="24" height="24" alt="<?php echo $v['user']['nickname'];?>" src="<?php echo User_Tool::getFace($v['user']['face'],"24");?>">
                    </a>
                    <p class="answer-usr">
<a class="answer-usr-name" href="<?php echo $this->url("/index/index/id/". $v['user']['id'], "user");?>" title="<?php echo $v['user']['nickname']?>" target="_blank"><?php echo $v['user']['nickname']?></a>
                    </p>
                    <p class="answer-date"><?php echo My_Tool::qtime($v['created_at'])?></p>
                </div>
    <div class="answer-txt answerTxt">
        <?php echo $v['is_publish'] ? My_Tool::addUserLink($v['content']) : "<span style='color:#999;background:#f4f4f4;padding:5px;'>评论正在审核中..</span>";?>
        <?php if($v['is_publish']):?>
            <div class="answer-txt-hide" style="display:none" ><?php echo $v['content'];?></div>
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
        </div>
<?php endforeach;?>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "ask","#answers");?>
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
        <div class="post_commet" id="answerReplyer"  >
            <h3 id="replyer">添加回答</h3>
  <?php if((!$this->isHelp) || $this->isAsker || $this->isAdmin):?>
   <?php echo My_Tool_Form::start("askreplyForm", $this->url('index/addreply')."#answerReplyer","post", array("id"=>"replyForm"));?>
    <textarea id="content" name="content" style="width:99%"></textarea>
    <?php echo $this->keditor("content");?>
<input type="hidden" name="mark" value="<?php echo $this->mark;?>">
<span class="tip" id="draftTip"></span>
      <?php echo $this->showcode();?>
  <input type="button" class="gbtn-primary submit" value="发 布">
<?php echo My_Tool_Form::end();?> 
   <?php else:?>
	本问题只能由提问者或者本站管理员才能回答
   <?php endif;?>
        </div>
<?php 
endif;
?>
<script>
$(function(){
	$(".submit").click(function(){
		var text = editor.text();
		if(!text){
			$("#draftTip").html("回答不能为空!");
			return false;
		}

		$("#replyForm").submit();
	});
});

	function delreply(id){
		fconfirm("确定要删除吗?",function(){
			ajax_get("<?php echo $this->url("index/deletereply/id/");?>"+id, function(a){
				if(a.code == 200){
					$("#answer_"+id).remove();
				}else{
					falert(a.msg);
				}
			});
		});
		
	}

	function addReplay(id){
		var nickname = $("#answer_"+id+" .answer-usr-name").text();
		var content = $("#answer_"+id+" .answer-txt-hide").html();
		var str="<blockquote>引用@"+nickname+"&nbsp;的话："+content+"</blockquote><p></p>";
		editor.appendHtml(str);
		editor.focus();
		location.href="#commentsReplyer";
	}
</script>