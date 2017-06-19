<div class="grow gclear index-page">
        <div class="main">
            <div class="site-side-title">
                <h2>推荐视频</h2>
                <a href="<?php echo $this->url("index/index","video");?>" target="_blank"
                   class="gfr article-rss">
                    >>
                </a>
            </div>
            <ul class="ul">
                <?php if($this->video_arc):?>
                    <?php foreach ($this->video_arc as $v):?>
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
            <div class="clear"></div>
            <div class="site-side-title">
                <h2>最新问题</h2>
                <a href="<?php echo $this->url("index/index","ask");?>" target="_blank"
                   class="gfr article-rss">
                    >>
                </a>
            </div>
            <div class="yulist">
                <ul>
                    <?php
                    foreach($this->ask_arc as $av):
                        ?>
                        <li>
                            <a href="<?php echo $this->url("index/view/id/" . $av['id'],"ask");?>" target="_blank" title="<?php echo $av['title'];?>"><?php echo $this->cut($av['title'],58);?></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="clear"></div>
    	<div class="site-side-title">
		<h2>全部文章</h2>
		<a href="<?php echo $this->url("index/rss","home");?>" target="_blank"
			 class="gfr article-rss">
			订阅文章RSS <span class="gicon-rss"></span>
		</a>
	</div>
      <ul class="all-sites_index">
        <?php if($this->tree):?>
        <?php foreach ($this->tree as $v):?>
		<li><img src="<?php echo My_Tool::getFace($v['face']);?>" />
	<a href="<?php echo $this->url("index/index/id/".$v['id'],"site");?>" target="_blank"><?php echo $v['name'];?></a></li>
	      <?php endforeach;?>
        <?php endif;?>
	</ul>  
<!-- 动态开始 -->
<div class="gspan-23">
  <?php if($this->list):?>
<?php
      $tag = 0;
      $tag2=0;
      foreach ($this->list as $k=>$v):?>
<?php
          $tag2++;
?>
          <?php
    if($tag2%5 == 0):
 ?>
              <div class="yulist">
                    <ul>
                        <?php
                           $slice = $tag*6;
                            $arrTmp = array_slice($this->group_arc, $slice, 6);
                            $tag++;
                            foreach($arrTmp as $gv):
                        ?>
                            <li>
<a href="<?php echo $this->url("index/view/id/" . $gv['id'],"group");?>" target="_blank" title="<?php echo $gv['title'];?>"><?php echo $this->cut($gv['title'],58);?></a>
                            </li>
                         <?php endforeach;?>
                     </ul>
              </div>
<?php else: ?>
                <div class="article-list">
                    <div class="article-item">
                        <h3><a href="<?php echo $this->url("index/view/id/" . $v['id'],"site");?>" target="_blank" title="<?php echo $v['title'];?>"><?php echo $v['title'];?></a></h3>
                        <div class="article-desc">
                            <div class="article-pic">
      <a href="<?php echo $this->url("index/view/id/" . $v['id'],"site");?>" target="_blank" title="<?php echo $v['title'];?>">
      <img 	width="166" height="129"
src="<?php echo My_Tool::getFace($v['face'],"160");?>">
      </a>
                            </div>
                            <div class="article-summary">
           <?php echo $v['descr'];?>
                                <a target="_blank" href="<?php echo $this->url("index/view/id/" . $v['id'],"site");?>">阅读全文</a>
                                <div class="article-fun">
          <a href="<?php echo $this->url("index/index/id/" . @$v['uid'], "user");?>" target="_blank" ><?php echo @$v['user']['nickname'];?></a>
          &nbsp;发表于&nbsp;<?php echo My_Tool::qtime($v['created_at']);?>
                                    <p class="article-comments-num">
                                        <a href="<?php echo $this->url("index/view/id/" . $v['id'],"site");?>#comments" target="_blank">
                                        <span class="article-fun-comments"></span>
                                        <?php echo $v['reply_count'];?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php endif;?>
<?php endforeach;?>
<?php endif;?>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum,"home");?>
</div>
<!-- 动态结束-->
</div>
        <div class="side">
            <?php if(!$this->user):?>
            <div class="side-ext">
                <p>加入<?php  echo getSysData('site.config.siteName'); ?></p>
                <a href="<?php echo My_Tool::url("/index/reg", "user")?>">立即注册</a>
            </div>
            <?php endif;?>
    <?php if($this->user):?>
    
  	<div class="side-user gclear">
                <div class="user-header gclear">
                    <div class="user-info">
                        <a class="pt-pic" title="<?php echo $this->user['nickname'];?>" href="<?php echo $this->url("index/index/id/".$this->user['id'],"user");?>">
        <img width="40" height="40" alt="<?php echo $this->user['nickname'];?>" src="<?php echo My_Tool::getFace($this->user['face']?$this->user['face']:$this->user['id']);?>">
                        </a>
                        <p><?php echo $this->user['nickname'];?></p>
                    </div>
                    <div class="user-num">
                    	<p class="user-focus-num"><span><?php echo $this->user['coin'];?></span><img src="<?php echo $this->img("/res/style/css/img/fish.png");?>" ></p>
                        <p class="user-focus-num"><span><?php echo $this->user['follow_count'];?></span>关注</p>
                        <p class="user-focus-num"><span><?php echo $this->user['to_follow_count'];?></span>被关注</p>
                    </div>
                    <b class="garrow_up arrow1"></b>
                    <b class="garrow_up arrow2"></b>
                </div>
                <?php if($this->feed):?>
                <div class="user-asks">
                    <ul>
                <?php foreach($this->feed as $fv):?>
                    <li>
                    <p class="gellipsis">
                    <a target="_blank" href="<?php echo $this->url("index/index/id/".$fv['uid'],"user");?>"><?php echo $fv['nickname'];?></a>
                    <?php echo $fv['feed_type_name'];?>
                    <?php if($fv['url']):?>
                   <a href="<?php echo $this->url($fv['url'],$fv['url_app']);?>" target="_blank">
                   	<?php echo $fv['feed_title'];?>
                   </a>
                    <?php else:?>
                    <?php echo $fv['feed_title'];?>
                    <?php endif;?>
                    </p><span><?php echo My_Tool::qtime($fv['created_at'])?><span></span></span>
                    </li>
               <?php endforeach;?>
                    </ul>
                    <div class="user_into"><a href="<?php echo $this->url("index/feeds","user");?>">进入我关注的动态</a></div>
                </div>
                <?php endif;?>   
         </div> 
            
     <?php endif;?>
            <div  class='my-ad'>
                <?php echo $this->ads(); ?>
            </div>
            <div class="side-title-border gclear">
                <h2>热门标签</h2>

                <a id="refreshTags" href="<?php echo $this->url("tag/index","ask");?>" class="side-title-txt">更多标签</a>

            </div>
            <div id="hotTags" class="side-tag-wp"><ul class="side-tag gclear">
                    <?php if($this->tags):?>
                        <?php foreach ($this->tags as $v):?>
                            <li><a href="<?php echo $this->url("tag/view/t/".$v['name'],"ask");?>"><?php echo $v['name'];?></a></li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="side-title-border gclear">
                <h2>热门小组</h2>
                
                <a id="refreshTags" href="<?php echo $this->url("index/index","group");?>" class="side-title-txt">更多小组</a>
                
            </div>
            <?php if($this->groups):?>

            <div class="side-block-box" id="myGroups">
                <?php foreach ($this->groups as $v):?>
            <dl class="gpack_u">

                <dt>
                    <a title="eLibrary" target="_blank" href="<?php echo $this->url("index/g/id/".$v['id'],"group");?>">
                        <img width="48" height="48" src="<?php echo My_Tool::getFace($v['face'],48)?>">
                    </a>
                </dt>
                <dd class="gpack_u-n">
                    <p class="gellipsis">
                        <a target="_blank" href="<?php echo $this->url("index/g/id/".$v['id'],"group");?>"><?php echo $v['name'];?></a></p>
                </dd>
            </dl>
                <?php endforeach;?>
            </div>

            <?php endif;?>
            <div class="clear"></div>

                <div class="side-title gclear">
                <h2>最新评论</h2>
            </div>
            <div id="hotNuts">
                
 			<?php if($this->discuzfeed):?>
                <div class="user-feed">
                    <ul>
                <?php foreach($this->discuzfeed as $fv):?>
                    <li>
                    <p class="gellipsis">
                    <a target="_blank" href="<?php echo $this->url("index/index/id/".$fv['uid'],"user");?>"><?php echo $fv['nickname'];?></a>
                    <?php echo $fv['feed_type_name'];?>
                    <?php if($fv['url']):?>
                   <a href="<?php echo $this->url($fv['url'],$fv['url_app']);?>" target="_blank">
                   	<p><?php echo My_Tool::htmlCut(strip_tags($fv['feed_data']), 100,"...");?></p>
                   </a>
                    <?php else:?>
                    <p><?php echo My_Tool::htmlCut(strip_tags($fv['feed_data']), 100,"...");?></p>
                    <?php endif;?>
                    </p><span><?php echo My_Tool::qtime($fv['created_at'])?><span></span></span>
                    </li>
               <?php endforeach;?>
                    </ul>
                </div>
                <?php endif;?>
            </div>
            <div class="side-title gclear">
                <h2>友情链接</h2>
            </div>
            <?php echo $this->linked(); ?>
            </div>
        </div>