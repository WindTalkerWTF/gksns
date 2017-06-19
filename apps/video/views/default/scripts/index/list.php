<div class="grow gmt60 gclear index-page">
	<div class="main score">
			<div class="site-side-title">
		<h2>
		<?php echo $this->id?$this->info['name']:"全部类型";?>
		</h2>
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
      <img width="166" height="129" s="" src="<?php echo My_Tool::getFace($v['face'],"160");?>">
      </a>
            <?php if($v['grade']>0):?>
      					<div class="score-small">
							<div class="medal gold">
								<em>总分</em><span class="score"><span class="num nohilite"><?php echo $v['grade'];?></span>
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
        <div  class='my-ad'>
            <?php echo $this->ads(); ?>
        </div>
	</div>

</div>