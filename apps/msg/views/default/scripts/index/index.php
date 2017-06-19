<div class="grow gmt60 message-index-page">
<?php echo $this->leftmenu();?>
<div class="gspan-24 gprefix-1">
    <div class="gbtitle">
        <h2><a href="<?php echo $this->url("index/index", "msg");?>">站内信</a></h2>
        <a href="<?php echo $this->url("index/add", "msg");?>" class="gbtn main-write">写信</a>
    </div>
	<ul class="gsuffix-2 main-message" id="msgList">
	<?php if($this->list):?>
	<?php foreach ($this->list as $v):?>
	<?php if(isset($v['info']['user_receive'])):?>
        <li id="li_<?php echo $v['id'];?>">
            <div class="pt-pic">
                <a href="<?php echo $this->url("index/index/id/".$v['info']['user_receive']['id'],"user");?>" target="_blank" title="<?php echo $v['info']['user_receive']['nickname'];?>">
                <img src="<?php echo My_Tool::getFace($v['info']['user_receive']['face']?$v['info']['user_receive']['face']:$v['info']['user_receive']['id'],48);?>" width="48" height="48" alt="<?php echo $v['info']['user_receive']['nickname'];?>"></a>
                
            </div>
            <div class="pt-txt">
                <p>发给<a href="<?php echo $this->url("index/index/id/".$v['info']['user_receive']['id'],"user");?>" target="_blank"><?php echo $v['info']['user_receive']['nickname'];?></a>：
                <?php echo $v['info']['content'];?></p>
                <p class="pt-txt-d">
                    <span class="gfl"><?php echo My_Tool::qtime($v['info']['created_at']);?>
                    </span>
                    <span class="gfr">
                        <a href="javascript: void 0; "  onclick="delReply(<?php echo $v['id'];?>)">删除</a>
                        <span class="gsplit msg-hover">|</span>
                        <?php if(!$v['msg_type']):?>
                        <a href="<?php echo $this->url("index/subreply/id/".$v['id']);?>">共<?php echo $v['sub_count'];?>封站内信</a>
                        <span class="gsplit">|</span>
                        <a href="<?php echo $this->url("index/subreply/id/".$v['id']);?>">回复</a>
                        <?php endif;?>
                    </span>
                </p>
            </div>
        </li>
       <?php else:?>
        <li id="li_<?php echo $v['id'];?>">
            <div class="pt-pic">
                <a href="<?php echo $this->url("index/index/id/".$v['info']['user_send']['id'],"user");?>" target="_blank" title="<?php echo $v['info']['user_send']['nickname'];?>">
                <img src="<?php echo My_Tool::getFace($v['info']['user_send']['face']?$v['info']['user_send']['face']:$v['info']['user_send']['id'],48);?>" width="48" height="48" alt="<?php echo $v['info']['user_send']['nickname'];?>"></a>
                
            </div>
            <div class="pt-txt">
                <p><a href="<?php echo $this->url("index/index/id/".$v['info']['user_send']['id'],"user");?>" target="_blank"><?php echo $v['info']['user_send']['nickname'];?></a>发给你：
                <?php echo $v['info']['content'];?></p>
                <p class="pt-txt-d">
                    <span class="gfl">
                    <?php echo My_Tool::qtime($v['info']['created_at']);?>
                     <?php 
	                	if(!$v['info']['is_read']):    
                    ?>
                    <font color=red>new!</font>
                    <?php 
                    	endif;
                    ?>
                    </span>
                    <span class="gfr">
                        <a href="javascript: void 0;" onclick="delReply(<?php echo $v['id'];?>)">删除</a>
                        <?php if(!$v['msg_type']):?>
                        <span class="gsplit msg-hover">|</span>
                        <a href="<?php echo $this->url("index/subreply/id/".$v['root_id']);?>">共<?php echo $v['sub_count'];?>封站内信</a>
                        <span class="gsplit">|</span>
                        <a href="<?php echo $this->url("index/subreply/id/".$v['root_id']);?>">回复</a>
                        <?php endif;?>
                    </span>
                </p>
            </div>
        </li>
        <?php endif;?>
    <?php endforeach;?>
	<?php endif;?>
    </ul>
  <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum,"msg");?>
</div>
</div>
<script>
function delReply(id){
	fconfirm("确认要删除吗?",function(){
		var url='<?php echo $this->url('index/delmsgall/id/')?>'+id;
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