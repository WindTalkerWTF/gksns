<div class="grow blog-page"> 
<?php echo $this->leftmenu($this->id);?>
 <div class="main gprefix-1 gspan-25">
            
    <div class="main gprefix-1 gspan-24">
        <div class="gbtitle">
            <h2><a href="<?php echo $this->url("index/index/id/".$this->id,"user")?>">个人主页</a><span class="gbtitle-point-to">&gt;</span>被关注</h2>
            <span class="gbtitle-txt">(全部<span id="titleFollowingCount"><?php echo $this->user['to_follow_count'];?></span>人）</span>
        </div>
        <ul class="gfollow-list gprefix-1" id="followList">
            <?php if($this->list):?>
            <?php foreach ($this->list as $v):?>
            <li id="li_<?php echo $v['id'];?>">
                <div class="gfollow-head">
                    <a target="_blank" href="<?php echo $this->url("index/index/i/id/".$v['id'],"user");?>">
                        <img src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['id'],48);?>" width="48" height="48">
                    </a>
                </div>
                <div class="gfollow-details gpack">
                    <div class="gfollow-btns">
                    		<?php if($this->isMe):?>
                            <span ><a href="javascript:void 0;" class="cancelfollow" data-id="<?php echo $v['id'];?>" >移除被关注</a></span>
                            <?php endif;?>
                    </div>
                    <div class="gfollow-info">
                        <p>
                        <span><a target="_blank" href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>"><?php echo $v['nickname']?></a>
                        </span><span><?php echo isset($v['stat']['to_follow_count']) ? $v['stat']['to_follow_count'] : 0;?>人关注</span>
                        </p>
                        <p>
         <?php echo $v['sign'] ? $v['sign']:"";?>  
                        </p>
                    </div>
                </div>
            </li>
       <?php endforeach;?>
       <?php endif;?>
        </ul>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?>   
    </div>

        </div>
 </div>
 <script>
 	$(function(){
 		<?php if($this->isMe):?>
 	 	//取消关注
		$(".cancelfollow").each(function(){
			$(this).click(function(){
				var id = $(this).attr("data-id");
				ajax_get("<?php echo $this->url("index/docancelfollow/id/");?>"+id,function(a){
						if(a.code !=200){
							falert(a.msg);
						}else{
							$("#li_"+id).remove();
						}
					});
			});
		});
		<?php endif;?>
 	 });
 </script>