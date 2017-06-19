<div class="grow gmt60 gclear index-page">

	<div class="main score">
		<ul class="ul">
		  <?php if($this->tuijianinfo1):?>
		  <?php foreach ($this->tuijianinfo1 as $v):?>
			<li class="bm">
			<a title="<?php echo $v['title']?>"
				href="<?php echo $this->url("index/view/id/".$v['id'],"video");?>" class="entry_cover_link">
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
					<div class="rtop">
						<h3>
							<a title="<?php echo $v['title']?>" href="<?php echo $this->url("index/view/id/".$v['id'],"video");?>" ><?php echo $v['title']?></a>
						</h3>
						<p class="bio grey"><?php echo strip_tags($v['descr']);?></p>
					</div>
					<hr>
					<ul>
						<li><span class="grey">演员：</span><?php echo $v['role'];?></li>
						<li><span class="grey">地区：</span><?php echo $v['area'];?></li>
						<li><span class="grey">类型：</span><a
							href="<?php echo $this->url("index/list/id/".$v['tree_id'],"video");?>"
							target="_blank"><?php echo $v['tree']['name'];?></a></li>
						<li><span class="grey">上映：</span><?php echo $v['publish_date'];?></li>
					</ul>
				</div></li>
		<?php endforeach;?>
		<?php endif;?>
		<?php if($this->tuijianinfo2):?>
		  <?php foreach ($this->tuijianinfo2 as $v):?>
			<li class="sm"><a title="<?php echo $v['title']?>"
				href="<?php echo $this->url("index/view/id/".$v['id'],"video");?>">
					<div class="entry_cover  show_play">
						<img width="85" height="120" alt="<?php echo $v['title']?>"
							src="<?php echo My_Tool::getFace($v['face']);?>"
							class="cover_img">
						<div class="play_ico_middle"></div>
						<div style="width: 85px;" class="cv-title">在线观看</div>
                <?php if($v['grade']>0):?>
						<div class="score-small">
							<div class="medal <?php echo $v['grade']>8? "gold":"silver";?>">
								<span class="score"><span class="num nohilite"><?php echo $v['grade'];?></span>
							</div>
						</div>
                 <?php endif;?>
					</div>
			</a>
				<div class="bio">
					<strong><a title="<?php echo $v['title']?>"
						href="<?php echo $this->url("index/view/id/".$v['id'],"video");?>" style="font-size:12px"><?php echo $this->cut($v['title'],23,"...")?></a></strong>
				</div></li>
	<?php endforeach;?>
		<?php endif;?>
		</ul>
		<div class="more_data"></div>
			<div class="site-side-title">
		<h2>全部类型</h2>
	</div>
	
	<?php if($this->tree):?>
	<ul class="all-sites_index">
	<?php foreach ($this->tree as $v):?>
               <li>
	<a target="_blank" href="<?php echo $this->url("index/list/id/".$v['id'],"video");?>"><?php echo $v['name'];?></a></li>
	      		<li>
	 <?php endforeach;?>
	   </ul>
	 <?php endif;?>
	              	
	<div class="gspan-23">
	<?php if($this->list):?>
	<?php foreach ($this->list as $v):?>
                  <div class="article-list">
                    <div class="article-item">
                        <h3><a title="<?php echo $v['title'];?>" target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'],"video");?>">
                        		<?php echo $v['title'];?></a></h3>
                        <div class="article-desc">
                            <div class="article-pic entry_cover">
      <a title="<?php echo $v['title'];?>" target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'],"video");?>">
      <img  src="<?php echo My_Tool::getFace($v['face'],"160");?>">
      </a>
            <?php if($v['grade']>0):?>
      					<div class="score-small">
							<div class="medal <?php echo $v['grade']>8? "gold":"silver";?>">
								<span class="score"><span class="num nohilite"><?php echo $v['grade'];?></span>
							</div>
						</div>
             <?php endif;?>
                            </div>
                            <div class="article-summary">
        <?php echo My_Tool::substrtxt(strip_tags($v['content']),120,"...")?>
		<a href="<?php echo $this->url("index/view/id/".$v['id'],"video");?>" target="_blank">观看</a>
                                <div class="article-fun">
          &nbsp;发表于&nbsp;<?php echo My_Tool::qtime($v['created_at']);?>                                    
          							<p class="article-comments-num">
                                        <a target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'],"video");?>#comments">
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
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum,"home");?>
</div>
</div>
	<div class="side">
		<div class="side-title">
			<h2>推荐视频</h2>
		</div>
        <div style="clear:both;padding-top:2px">
<ul class="related_article" id="recommendArticle">

  <?php 
  	if($this->hotList):
  ?>
  <?php 
  	foreach($this->hotList as $v):
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
        </div>
        <div class="my-ad">
            <?php echo $this->ads(); ?>
        </div>
	</div>

</div>