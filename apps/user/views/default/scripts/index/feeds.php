 <div class="grow gmt60 wrap user-feeds-page">
        <div class="main gspan-21">
            <div class="gbtitle">
                <h2>我关注的动态</h2>
            </div>
          <?php if($this->list):?>
          <?php foreach ($this->list as $fv):?>
            <div class="gactive">
                <a href="<?php echo $this->url("index/index/id/".$fv['uid'],"user");?>" target="_blank" class="gactive-avatar">
                <img src="<?php echo My_Tool::getFace($fv['face']?$fv['face']:$fv['id']);?>" alt="Ent" width="48" height="48" /></a>
                <div class="gactive-combine">
                    <div class="gactive-indiv">
                        <div class="gactive-hd">
          <a target="_blank" href="<?php echo $this->url("index/index/id/".$fv['uid'],"user");?>"><?php echo $fv['nickname']?></a>
<?php echo $fv['feed_type_name']?>
<?php if($fv['url']):?>
    <a  class="gactive-hd-title" href="<?php echo $this->url($fv['url'],$fv['url_app']);?>" target="_blank">
                   	<?php echo $fv['feed_title'];?>
                   </a>
                    <?php else:?>
                    <?php echo $fv['feed_title'];?>
   <?php endif;?>
						</div>
                        <div class="gactive-bd">
                        <?php if($fv['feed_data']):?>
                       		<p><?php echo  stripslashes($fv['feed_data']);?></p>
                       <?php endif;?>
                            <span><?php echo My_Tool::qtime($fv['created_at'])?></span>
                        </div>
                    </div>
                    
                </div>
            </div>
            <?php endforeach;?>
           <?php endif;?>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?> 
        </div>
        <div class="side gspan-10 gprefix-1">
            <ul class="side-nav focus">
                <li class="gclear">
                    <a class="side-title" href="<?php echo $this->url("index/follow/id/".$this->userInfo['id'],"user");?>">关注<span class="side-title-more">（全部<?php echo $this->userInfo['follow_count']?>人）</span></a>
<?php 
if($this->follow):
?>
                    <p class="focus_list">
<?php foreach($this->follow as $v):?>
 <a href="<?php echo $this->url("index/index/id/".$v['id']);?>" target="_blank" alt="<?php echo $v['nickname']?>">
 <img alt="<?php echo $v['nickname']?>" src="<?php echo User_Tool::getFace($v['face']?$v['face']:$v['id'], 24);?>" />
 </a>
<?php endforeach;?>
                    </p>
<?php 
endif;
?> 
                </li>
                <li class="gclear">
 <a class="side-title" href="<?php echo $this->url("index/interested/id/".$this->userInfo['id'],"user");?>">被关注<span class="side-title-more">（全部<?php echo $this->userInfo['to_follow_count']?>人）</span></a>
<?php 
if($this->toFollow):
?>
           <p class="focused_list">
<?php foreach($this->toFollow as $v):?>
 <a href="<?php echo $this->url("index/index/id/".$v['id']);?>" target="_blank" alt="<?php echo $v['nickname']?>">
 <img alt="<?php echo $v['nickname']?>" src="<?php echo User_Tool::getFace($v['face']?$v['face']:$v['id'], 24);?>" />
 </a>
<?php endforeach;?>
    		</p>
<?php 
endif;
?> 
                </li>
            </ul>
            <div class="side-goto">
                想找更多人，去看看 <a href="<?php echo $this->url("index/daren","user");?>">全部达人</a>
            </div>
        </div>
    </div>