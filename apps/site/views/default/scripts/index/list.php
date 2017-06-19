<div class="main">
<?php if($this->info):?>
                <div class="site-main-title">
                    <div class="site-icon">
                        <img src="<?php echo $this->img($this->info['face']."_48x48.jpg"); ?>" width="68" height="55">
                    </div>
                    <div class="site-desc">
                        <h2><?php echo $this->info['name'];?></h2>
                        <p class="site-summary"><?php echo $this->info['descr'];?></p>
                    </div>
                </div>
 <?php endif;?>
 <?php if($this->list):?>
<?php foreach ($this->list as $v):?>
                <div class="article-list">
                    <div class="article-item">
                        <h3><a href="<?php echo $this->url("index/view/id/" . $v['id']);?>" target="_blank" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></h3>
                        <div class="article-desc">
                            <div class="article-pic">
      <a href="<?php echo $this->url("index/view/id/" . $v['id']);?>" target="_blank" title="<?php echo $v['title'];?>">
      <img 	width="166" height="129"
src="<?php echo My_Tool::getFace($v['face'],"160");?>"s>
      </a>
                            </div>
                            <div class="article-summary">
           <?php echo $v['descr'];?>
                                <a target="_blank" href="<?php echo $this->url("index/view/id/" . $v['id']);?>">阅读全文</a>
                                <div class="article-fun">
          <a href="<?php echo $this->url("index/index/id/" . $v['uid'], "user");?>" target="_blank" ><?php echo $v['user']['nickname'];?></a>
          &nbsp;发表于&nbsp;<?php echo My_Tool::qtime($v['created_at']);?>
                                    <p class="article-comments-num">
                                        <a href="<?php echo $this->url("index/view/id/" . $v['id']);?>#comments" target="_blank">
                                        <span class="article-fun-comments"></span>
                                        <?php echo $v['reply_count'];?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php endforeach;?>
<?php endif;?>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "site");?>
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
    