<div class="grow gmt60 group-post-content-page">
    <div class="main gspan-22 gsuffix-1">
        <div class="gbreadcrumb">
            <ul>
                <li>
                    <a href="<?php echo $this->url("index/index");?>">小组</a>
                </li>
                <li>
                    <a href="<?php echo $this->url("index/g/id/". $this->info['group']['id']);?>"><?php echo $this->info['group']['name'];?></a>
                </li>
                <li>
                    <a href="<?php echo $this->url("index/view/id/". $this->info['id']);?>"><?php echo stripslashes($this->info['title']);?></a>
                </li>
            </ul>
        </div>
    
    
    <div class="post">
        <h1 id="articleTitle"><?php echo stripslashes($this->info['title']);?></h1>
        <div class="gpack post-txt">
            <div class="post-info">
                <p class="gfl">
                <a id="articleAuthor" href="<?php echo $this->url("/index/index/id/". $this->info['user']['id'], "user");?>" title="<?php echo $this->info['user']['id'];?>" target="_blank"><?php echo $this->info['user']['nickname'];?></a>
                </p>
                <p class="gfr"><?php echo My_Tool::qtime($this->info['created_at'])?></p>
            </div>
            <div id="articleContent" class="post-detail">
			<?php echo $this->info['arc']['content'];?>
            </div>
        </div>
        <div class="post-do" id="controlPanel">
			<?php if(($this->isMe || $this->isAdmin) && My_Tool::canAdmin($this->info['created_at'])): ?>
            <p class="control-btns">
                <a href="<?php echo $this->url("index/edit/id/".$this->info['id'],
					"group");?>">编辑</a><span class="split">|</span>
                <a id="deleteBlog"  href="javascript:fconfirm('确认要删除吗?',function(){location.href='<?php echo $this->url
				("index/delete/id/".$this->info['id'],
					"group");?>'})">删除</a>
					<?php if($this->isAdmin):?>
					<span class="split">|</span>
					<?php if($this->info['position'] == '0'):?>
                        <a class="alight" onclick="recommendpost(<?php echo $this->info['id'];?>)" href="javascript:;">
                        	加精华
                        	</a>
                        	<?php else:?>
                        	<a class="alight" onclick="cancelrecommendpost(<?php echo $this->info['id'];?>)" href="javascript:;">
                        	取消精华
                        	</a>
                    <?php endif;?>
                    <?php endif;?>
            </p>
			<?php endif; ?>
        </div>
        <?php echo $this->recommend($this->info['id'],2); ?>
    </div>
    <div class="document-do">
	<div id="share" class="gfl" data-author="小行踪" data-xlnickname="">
<div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone"></a>
<a title="分享到新浪微博" class="bshare-sinaminiblog"></a>
<a title="分享到人人网" class="bshare-renren"></a>
<a title="分享到腾讯微博" class="bshare-qqmb"></a>
<a title="分享到网易微博" class="bshare-neteasemb"></a>
<a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a>
<span class="BSHARE_COUNT bshare-share-count">0</span>
</div>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
        </div>	
        <div id="share" class="gfl"></div>
		
        <div class="gfr">
			<?php if(!$this->isMe):?>
            <a href="javascript:void 0;" class="gbtn" id="recommendBt">推荐&nbsp;<span id="recommendnum"><?php echo $this->info['recommend_count'];?></span></a>
            <?php endif;?>
            <?php if(!User::service()->getCommon()->getLogined()): ?>
                <a href="<?php echo $this->url("index/login","user"); ?>" class="gbtn-ext">发表评论</a>
            <?php else: ?>
                <a href="#commentsReplyer" class="gbtn-ext">发表评论</a>
            <?php endif;?>
        </div>
    </div>
   <?php echo $this->myreply("group#". $this->info['id'],$this->canPost);?>
    </div>
    
    <div class="side sideBar gspan-10">
        <div class="side-title"><h2>本帖来自</h2></div>
        <div class="gpack side-source">
            <a class="pt-pic" href="<?php echo $this->url('index/g/id/'. $this->info['group']['id']);?>" title="<?php echo $this->info['group']['name']?>" target="_blank"><img width="48" height="48" src="<?php echo My_Tool::getFace($this->info['group']['face'],48); ?>" ></a>
            <div class="pt-txt">
                <h3><a href="<?php echo $this->url('index/g/id/'. $this->info['group']['id']);?>" target="_blank"><?php echo $this->info['group']['name'];?></a></h3>
                <p class="pt-txt-d"><?php echo $this->info['group']['user_number']?$this->info['group']['user_number']:0;?>人加入</p>
            </div>
        </div>
        <div class='my-ad'>
            <?php echo $this->ads(); ?>
        </div>
        <div class="side-title"><h2>小组热帖推荐</h2></div>
        <ul class="side-hotest" id="recommendHotPosts">
           <?php if($this->hot): ?> 
           <?php foreach($this->hot as $v):?>
            <li>
            <a href="<?php echo $this->url("index/view/id/". $v['id']);?>" class="post-title" target="_blank">
            <?php echo $v['title'];?>
            </a>
            <p class="side-hotest-l">作者：<a href="<?php echo $this->url("index/index/id/".$v['user']['id'], "user");?>" target="_blank"><?php echo $v['user']['nickname']?></a></p>
            </li>
           <?php endforeach;?>
            <?php endif;?>
        </ul>

    </div>
</div>
<script>
var remend_url = "<?php echo $this->url("index/recommend/id/".$this->id);?>";
//js开始    
$(function(){
	$("#recommendBt").click(function(){
		ajax_get(remend_url, function(a){
			if(a.code != 200){
				falert(a.msg);
			}else{
				var num = parseInt($("#recommendnum").text());
				$("#recommendnum").html(num+1);
			}
		});
	});
	
});

function recommendpost(id){
	ajax_post("<?php echo My_Tool::url("index/recommendpost","group"); ?>",{id:id},function(a){
		if(a.code==200){
			location.reload();
		}else{
			falert(a.msg);
		}
	});
}

function cancelrecommendpost(id){
	ajax_post("<?php echo My_Tool::url("index/cancelrecommendpost","group"); ?>",{id:id},function(a){
		if(a.code==200){
			location.reload();
		}else{
			falert(a.msg);
		}
	});
}
</script>