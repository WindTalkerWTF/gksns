<div class="main">
            <?php if($this->list):?>   
            <?php foreach ($this->list as $v):?>
               <div class="site-main-title">
		<a href="<?php echo $this->url("index/index/id/".$v['id'],"site");?>" target="_blank">
		<img
			src="<?php echo My_Tool::getFace($v['face'],"24");?>"
			width="24" height="24"></a>
		<h2><?php echo $v['name'];?></h2>
		<a href="<?php echo $this->url("index/index/id/".$v['id'],"site");?>" class="site-all">全部</a>
	</div>
	<div class="article-wrap">


		<div class="article-list">
		    <?php if($v['picArc']):?>
		    <?php $pic = $v['picArc'];?>
			<div class="article-item">
				<h3>
					<a href="<?php echo $this->url("index/view/id/".$pic['id'])?>" target="_blank"
						title="<?php echo $pic['title'];?>"><?php echo $pic['title'];?></a>
				</h3>
				<div class="article-desc">
					<div class="article-pic">
						<a href="<?php echo $this->url("index/view/id/".$pic['id'])?>" target="_blank"
							title="<?php echo $pic['title'];?>"><img
							src="<?php echo My_Tool::getFace($pic['face'],160)?>" width="166" height="119"></a>
					</div>
					<div class="article-summary">
						<?php echo $pic['descr']?>
						<a href="<?php echo $this->url("index/view/id/".$pic['id'])?>" target="_blank">阅读全文</a>

						<div class="article-fun">
							<a href="<?php echo $this->url("index/index/id/".$pic['user']['id'],"user")?>" target="_blank"
								title="<?php echo $pic['user']['nickname'];?>" ><?php echo $pic['user']['nickname'];?></a>
								&nbsp;发表于 &nbsp;<?php echo My_Tool::qtime($pic['created_at'])?>
							<p class="article-comments-num">
								<a href="<?php echo $this->url("index/view/id/".$pic['id'])?>#comments"
									target="_blank"> <span class="article-fun-comments"></span> <?php echo $pic['reply_count']?>
								</a>
							</p>
						</div>

					</div>
				</div>
			</div>
			<?php endif;?>
			<ul class="main-title-list">
                <?php if($v['otherList']):?>
                <?php foreach ($v['otherList'] as $ok=>$ov):?>
				<li <?php if($ok%2==0) echo ' class="even"'?>>
				<a href="<?php echo $this->url("index/view/id/".$ov['id'])?>"
					target="_blank" title="<?php echo $ov['title']?>">
					<?php echo mb_strlen($ov['title'],'utf-8')> 18?
					   mb_substr($ov['title'],0,18,'utf-8') : $ov['title'];
					?>
					</a>
					</li>
					<?php endforeach;?>
                <?php endif;?>
			</ul>
		</div>


	</div>
	   <?php endforeach;?>
        <?php endif;?>
	<a href="<?php echo $this->url("index/all","site");?>" class="more-articles">全部文章&gt;&gt;</a>
</div>

<div class="side">
	<div class="site-side-title">
		<h2>全部类型</h2>
		<a href="<?php echo $this->url("index/rss","home");?>" target="_blank"
			 class="gfr article-rss">
			订阅文章RSS <span class="gicon-rss"></span>
		</a>
	</div>
	<ul class="all-sites">
        <?php if($this->tree):?>
        <?php foreach ($this->tree as $v):?>
		<li><img src="<?php echo My_Tool::getFace($v['face']);?>" />
	<a href="<?php echo $this->url("index/index/id/".$v['id'],"site");?>" target="_blank"><?php echo $v['name'];?></a></li>
	      <?php endforeach;?>
        <?php endif;?>
	</ul>
    <div  class='my-ad'>
        <?php echo $this->ads(); ?>
    </div>
	<div class="site-side-title">
	<h2>推荐文章</h2>
	</div>
	<ul class="all-sites" id="recommendArticle">
	
	  <?php 
	  	if($this->hotgrouparc):
	  ?>
	  <?php 
	  	foreach($this->hotgrouparc as $v):
	  ?>
		<li><a href="<?php echo $this->url("index/view/id/".$v['id'],'group');?>" target="_blank">
		<?php echo mb_strlen($v['title'],'utf-8')>24 ? mb_substr($v['title'], 0,24):$v['title'];?>
		</a></li>
	<?php 
		endforeach;
	?>
	<?php endif;?>
	</ul>
		<div class="site-side-title">
	<h2>热门小组</h2>
	</div>
	<ul class="all-sites" id="recommendArticle">
	
	  <?php 
	  	if($this->hotgroup):
	  ?>
	  <?php 
	  	foreach($this->hotgroup as $v):
	  ?>
		<li><a href="<?php echo $this->url("index/g/id/".$v['id'],'group');?>" target="_blank">
		<?php echo mb_strlen($v['name'],'utf-8')>24 ? mb_substr($v['name'], 0,24):$v['name'];?>
		</a></li>
	<?php 
		endforeach;
	?>
	<?php endif;?>
	</ul>

</div>