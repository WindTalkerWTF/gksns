<div class="grow gmt60 article-page">
	<div class="main gspan-23">
		<div class="gbreadcrumb">
			<ul>
				<li><a href="<?php echo $this->url("index/index", "site");?>">博客</a></li>
	<?php 
		if($this->info['tree']):
	?>
	<li><a
					href="<?php echo $this->url("index/list/id/" . $this->info['tree']['id'], "video");?>"><?php echo $this->info['tree']['name']?></a>
				</li>
	<?php endif;?>
	<li>
                     <?php echo $this->info['title'];?>
                    </li>
			</ul>
		</div>
		<div class="content">
			<div class="content-th">
				<h1 id="articleTitle"><?php echo $this->info['title'];?></h1>
				<div><?php echo $this->info['created_at'];?></div>
<?php 
$v = $this->info;
?>
<div class="bm2">
					<a title="<?php echo $v['title']?>"
						href="<?php echo $this->url("index/view/id/".$v['id'],"video");?>"
						class="entry_cover_link">
						<div class="entry_cover  show_play">
							<img width="120" height="170" alt="<?php echo $v['title']?>"
								src="<?php echo My_Tool::getFace($v['face']);?>"
								class="cover_img">
							<div class="play_ico_big"></div>
                            <?php if($v['grade']>0):?>
							<div class="score-middle">
								<div class="medal <?php echo $v['grade']>8? "gold":"silver";?>">
									<span class="score"><span class="num nohilite"><?php echo $v['grade'];?></span>
								
								</div>
							</div>
                            <?php endif;?>
						</div>
					</a>
					<div class="info">
						<ul>
							<li><span class="grey">导演：</span><?php echo $v['author'];?></li>
							<li><span class="grey">演员：</span><?php echo $v['role'];?></li>
							<li><span class="grey">地区：</span><?php echo $v['area'];?></li>
							<li><span class="grey">类型：</span><a
								href="<?php echo $this->url("index/list/id/".$this->info['tree_id'],"video");?>"
								target="_blank"><?php echo $this->info['tree']['name'];?></a></li>
							<li><span class="grey">上映：</span><?php echo $v['publish_date'];?></li>
							<li><span class="grey">查看人数：</span><?php echo $v['view_number'];?></li>
						</ul>
					</div>
				</div>
<div class="entry_video_list">
				<ul class="clearfix">
				<?php if($this->info['detail']):?>
				<?php foreach ($this->info['detail'] as $k=>$v):?>
					<li>
					<a href="<?php echo $v['url'];?>" title="<?php echo $v['list_number']?>" target="_blank">
					<?php echo $v['list_number']?>
					</a>
					</li>
				<?php endforeach;?>
			    <?php endif;?>
				</ul>
</div>
			</div>
			<div class="content-txt" id="articleContent">

				<div class="document">
<?php echo $this->info['content'];?>
</div>

			</div>
			<ul class="content-titles gclear">
				<li class="gfl gellipsis">上一篇：
	<?php if($this->preinfo):?>
	<a
					href="<?php echo $this->url("index/view/id/". $this->preinfo['id']);?>"><?php echo $this->preinfo['title'];?></a>
				</li>
	<?php endif;?>
	<li class="gfr gellipsis">下一篇：
	<?php if($this->nextinfo):?>
	<a
					href="<?php echo $this->url("index/view/id/". $this->nextinfo['id']);?>"><?php echo $this->nextinfo['title'];?></a>
				</li>
	<?php endif;?>
</ul>
			<div class="document-do gclear">
				<div id="share" class="gfl" data-author="小行踪" data-xlnickname="">
					<div class="bshare-custom">
						<a title="分享到QQ空间" class="bshare-qzone"></a> <a title="分享到新浪微博"
							class="bshare-sinaminiblog"></a> <a title="分享到人人网"
							class="bshare-renren"></a> <a title="分享到腾讯微博" class="bshare-qqmb"></a>
						<a title="分享到网易微博" class="bshare-neteasemb"></a> <a title="更多平台"
							class="bshare-more bshare-more-icon more-style-addthis"></a> <span
							class="BSHARE_COUNT bshare-share-count">0</span>
					</div>
                    <?php echo $this->recommend($this->info['id'],3); ?>
				</div>
				<script type="text/javascript" charset="utf-8"
					src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script>
				<script type="text/javascript" charset="utf-8"
					src="http://static.bshare.cn/b/bshareC0.js"></script>

			</div>
		</div>
<?php echo $this->myreply("video#". $this->id);?>
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
	<li><a href="<?php echo $this->url("index/view/id/".$v['id']);?>"
				target="_blank">
	<?php echo mb_strlen($v['title'],'utf-8')>24 ? mb_substr($v['title'], 0,24):$v['title'];?>
	</a></li>
<?php 
	endforeach;
?>
<?php endif;?>
</ul>
        <div   class='my-ad'>
            <?php echo $this->ads(); ?>
        </div>
	</div>
</div>