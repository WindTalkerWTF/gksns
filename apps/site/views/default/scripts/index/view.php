<div class="grow gmt60 article-page">
<div class="main gspan-21">
<div class="gbreadcrumb">
<ul>
	<li><a href="<?php echo $this->url("index/index", "site");?>">博客</a></li>
	<?php 
		if($this->info['tree']):
	?>
	<?php foreach($this->info['tree'] as $v):?>
	<li><a
		href="<?php echo $this->url("index/index/id/" . $v['id'], "site");?>"><?php echo $v['name']?></a>
	</li>
	<?php endforeach;?>
	<?php endif;?>
	<li>
                     <?php echo $this->info['title'];?>
                    </li>
</ul>
</div>
<div class="content">
<div class="content-th">
<h1 id="articleTitle"><?php echo $this->info['title'];?></h1>
<div class="content-th-info"><a title="<?php echo $this->info['user']['nickname'];?>"
	href="<?php echo $this->url("index/index/id/".$this->info['uid'], "user");?>"><?php echo $this->info['user']['nickname'];?></a>
<span><?php echo $this->info['created_at'];?></span></div>
</div>
<div class="content-txt" id="articleContent">

<div class="document">
<?php echo $this->info['arc']['content'];?>
</div>

<div class="post-do" id="controlPanel">
<?php if($this->isMe): ?>
<p class="control-btns">
<a href="<?php echo $this->url("index/edit/id/".$this->info['id'],"site");?>">编辑</a><span class="split">|</span>
<a id="deleteBlog"  href="javascript:fconfirm('确认要删除吗?',function(){location.href='<?php echo $this->url
("index/delete/id/".$this->info['id'],
	"site");?>'})">删除</a>
</p>
<?php endif; ?>

本文由<a title="<?php echo $this->info['user']['nickname'];?>"
      href="<?php echo $this->url("index/index/id/".$this->info['uid'], "user");?>"><?php echo $this->info['user']['nickname'];?></a>授权
	（<a href="/">
	<?php 
		echo getSysData('site.config.siteName');
	?>
	</a>）
	发表，文章著作权为原作者所有。
</div>

</div>
<ul class="content-titles gclear">
	<li class="gfl gellipsis">上一篇：
	<?php if($this->preinfo):?>
	<a
		href="<?php echo $this->url("index/view/id/". $this->preinfo['id']);?>"><?php echo $this->preinfo['title'];?></a></li>
	<?php endif;?>
	<li class="gfr gellipsis">下一篇：
	<?php if($this->nextinfo):?>
	<a
		href="<?php echo $this->url("index/view/id/". $this->nextinfo['id']);?>"><?php echo $this->nextinfo['title'];?></a></li>
	<?php endif;?>
</ul>
<div class="document-do gclear">
<div id="share" class="gfl" data-author="小行踪" data-xlnickname="">
<div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone"></a>
<a title="分享到新浪微博" class="bshare-sinaminiblog"></a>
<a title="分享到人人网" class="bshare-renren"></a>
<a title="分享到腾讯微博" class="bshare-qqmb"></a>
<a title="分享到网易微博" class="bshare-neteasemb"></a>
<a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a>
<span class="BSHARE_COUNT bshare-share-count">0</span>
</div>
<?php echo $this->recommend($this->info['id'],1); ?>
</div>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
<div class="gfr">
<?php if(!$this->isMe): ?>
<a id="recommendBt" href="javascript:void 0;" class="gbtn">推荐&nbsp;
<span id="recommendnum"><?php echo $this->info['recommend_count'];?></span></a> 
<?php endif;?>
    <?php if(!User::service()->getCommon()->getLogined()): ?>
        <a href="<?php echo $this->url("index/login","user"); ?>" class="gbtn-ext">发表评论</a>
    <?php else: ?>
        <a href="#commentsReplyer" class="gbtn-ext">发表评论</a>
    <?php endif;?>
</div>
</div>
</div>
<?php echo $this->myreply("site#". $this->id);?>
</div>
<div class="side  sideBar gspan-10 gprefix-1">
<div class="side-title">
<h2>同主题博客</h2>
</div>
<ul class="related_article" id="recommendArticle">

  <?php 
  	if($this->sameinfo):
  ?>
  <?php 
  	foreach($this->sameinfo as $v):
  ?>
	<li><a href="<?php echo $this->url("index/view/id/".$v['id']);?>" target="_blank">
	<?php echo mb_strlen($v['title'],'utf-8')>24 ? mb_substr($v['title'], 0,24):$v['title'];?>
	</a></li>
<?php 
	endforeach;
?>
<?php endif;?>
</ul>
    <div  class='my-ad'>
        <?php echo $this->ads(); ?>
    </div>
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
</script>