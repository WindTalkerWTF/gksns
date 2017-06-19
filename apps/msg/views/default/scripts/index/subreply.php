<div class="grow gmt60 message-index-page">
<?php echo $this->leftmenu();?>
<div class="gspan-24 gprefix-1">
    <div class="gbtitle">
        <h2>
        <a href="<?php echo $this->url("index/index", "msg");?>">站内信</a>
        <span class="gbtitle-point-to">&gt;</span>
        你和"<?php echo $this->userInfo['nickname']?>"的对话
        </h2>
    </div>
    
    <div class="gprefix-3 gsuffix-5">
	   <?php if(!$this->info['msg_type']): ?>
        <form class="gform" method="POST" action="<?php echo $this->url("index/addsubreply",'msg');?>" id="newMessage">
    <label for="msg"></label>
			<div class="gform-box" style="padding-right:10px;">
<?php echo $this->keditor("content");?>
<textarea class="" id="content" name="content" style="width:99%"></textarea>
            <br />
            
    <span class="tip"></span>
        </div>
            <p class="main-form-submit">
            	<input type="hidden" id="id" name="id" value="<?php echo $this->id; ?>" >
            	<input type="hidden" id="rid" name="rid" value="<?php echo $this->userInfo['id']?>" >
                <input type="submit" class="gbtn-primary gform-submit" value="发送" />
            </p>
        </form>
        <?php endif; ?>
        <ul class="main-message" id="msgList">
        <?php 
        	if($this->list):
        ?>
        <?php
			foreach ($this->list as $v):
        ?>
            <li class="sent"  id="li_<?php echo $v['id'];?>">
                <div class="main-message-avatar">
                    <a href="<?php echo $this->url("index/index/id/".$v['uid'],"user");?>" target="_blank" title="<?php echo $v['user']['nickname'];?>">
                    <img src="<?php echo My_Tool::getFace($v['user']['face']?$v['user']['face']:$v['user']['id'],48);?>" width="48" height="48" alt="<?php echo $v['user']['nickname'];?>"></a>
                    <b class="arrow"><s class="arrow"></s></b>
                </div>
                <div class="main-message-content">
                    <p><a href="<?php echo $this->url("index/index/id/".$v['uid'],"user");?>" target="_blank"><?php echo $v['user']['nickname'];?></a>：
                    <?php echo $v['content'];?>
                    </p>
                    <p class="main-message-content-do">
                    <span class="gfl"><?php echo My_Tool::qtime($v['created_at']);?></span>
                    <span class="gfr"><a href="javascript: void 0; "  onclick="delReply(<?php echo $v['id'];?>)" >删除</a></span>
                    </p>
                </div>
            </li>
      <?php endforeach;?>
       <?php 
       	endif;
       ?>
        </ul>
  <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "msg");?>
    </div>
	</div>
</div>
<script>
function delReply(id){
	fconfirm("确认要删除吗?",function(){
		var url='<?php echo $this->url('index/delmsg/id/')?>'+id;
		ajax_get(url,function(a){
				if(a.code != 200){
					falert(a.msg);
				}else{
					$("#li_"+id).remove();
				}
				dclose();
			});
	});
}
</script>