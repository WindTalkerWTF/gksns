<div class="grow gmt60 nuts-page">
    <div class="side gspan-10 gprefix-1">
        <div class="side-nav">
            <p><a href="<?php echo $this->url("index/all","site");?>">查看全部博客&nbsp;&gt;</a></p>
            <p><a target="_blank" href="<?php echo $this->url("index/view/id/27","ask");?>">申请成为<?php  echo getSysData('site.config.siteName'); ?>达人&nbsp;&gt;</a></p>
            
        </div>
        <div class="side-title">
            <h2>最新达人博客</h2>
        </div>
        <ul class="side-blog">
	<?php if($this->arc):?>
	<?php foreach ($this->arc as $v):?>
            <li>
            <h3 class="side-blog-title"><a href="<?php echo $this->url("index/view/id/".$v['arc_id'],"site");?>">
            <?php echo $v['title'];?></a></h3>
            <p class="side-blog-author">作者：<a href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>" 
            title="<?php echo $v['nickname']?>" target="_blank"><?php echo $v['nickname']?></a></p>
            </li>
     <?php endforeach;?>
    <?php endif;?>
        </ul>
    </div>
    <div class="main gspan-21">
        <div class="main-title">
            <h1><?php  echo getSysData('site.config.siteName'); ?>达人</h1>
        </div>
        <ul class="gtabs gclear">
            <?php if($this->t == -1):?>
			<li  class="gtabs-curr">全部</li>
			<?php else:?>
            <li><a href="<?php echo $this->url("index/daren","user");?>">全部</a></li>
            <?php endif;?>
			<?php if($this->tree):?>
			<?php foreach ($this->tree as $k=>$v):?>
			<?php if($this->t == $k):?>
			<li  class="gtabs-curr"><?php echo $v?></li>
			<?php else:?>
            <li><a href="<?php echo $this->url("index/daren/t/".$v,"user");?>"><?php echo $v?></a></li>
            <?php endif;?>
            <?php endforeach;?>
  			<?php endif;?>
        </ul>
        <ul class="nut_list gpack" id="followNuts">
            <?php if($this->list):?>
            <?php foreach($this->list as $v):?>
            <li class="nut">
                <div class="nut-options">
                    <a href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>">
                    <img src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['id'],48);?>" width="48" height="48">
                    </a>
                    <?php if($this->uid != $v['id']):?>
                    <span id="span<?php echo $v['id']?>">
                    <?php if(isset($v['isfollowed']) && $v['isfollowed']):?>
                    <a onclick="cancelfollow('<?php echo $v['id']?>')"  href="javascript: void 0;">取消关注</a>
                    <?php else:?>
                    <a class="gbtn-join-gray" onclick="follow('<?php echo $v['id']?>')" href="javascript: void 0;">关注</a>
                    <?php endif;?>
                	</span>
                	<?php endif;?>
                </div>
                <div class="nut-desc">
                    <p><a href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>"><?php echo $v['nickname']?></a><span>
                    <?php echo $v['to_follow_count']?>人关注</span></p>
                    <a href="<?php echo $this->url("index/blog/id/".$v['id']);?>"><?php echo $v['blog_count']?>篇博客</a>
                </div>
            </li>
            <?php endforeach;?>
            <?php endif;?>
          
            
        </ul>
       <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?>

    </div>
</div>
 <script>
 function follow(id){
	 ajax_get("<?php echo $this->url("index/dofollow/id/");?>"+id,function(a){
			if(a.code != 200){
				falert(a.msg);
			}else{
				var str = "<a onclick=\"cancelfollow("+id+")\"  href=\"javascript: void 0;\">取消关注</a>";
				$("#span"+id).html(str);
			}
	});
}
 
 function cancelfollow(id){
	 ajax_get("<?php echo $this->url("index/docancelfollow/id/");?>"+id,function(a){
			if(a.code != 200){
				falert(a.msg);
			}else{
				var str = " <a class=\"gbtn-join-gray\" onclick=\"follow("+id+")\"  href=\"javascript: void 0;\">关注</a>";
				$("#span"+id).html(str);
			}
	});
}

        </script>