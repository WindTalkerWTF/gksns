<div class="grow me-posts-page">
<?php echo $this->leftmenu($this->user['id']);?>
<div class="main gprefix-1 gspan-25">
            
    <div class="gbtitle">
        <h2><a class="gbtitle-link" href="<?php echo $this->url("index/index/id/".$this->id,"user")?>">个人主页</a>
        <span class="entities">&gt;</span>帖子<span class="gbtitle-more">（全部<?php echo $this->user['group_arc_count'];?>个）</span></h2>
    </div>
    <ul class="titles gprefix-1 gsuffix-2">
      <?php if($this->list):?>  
      <?php foreach ($this->list as $v):?>
        <li>
            <h3 class="titles-txt"><a href="<?php echo $this->url("index/view/id/".$v['id'],"group");?>" target="_blank"><?php echo $v['title'];?></a></h3>
            <div class="titles-r-grey"><?php echo $v['reply_count'];?><span class="titles-comment-icon"></span></div>
            <p class="titles-b">
                <span class="titles-b-l">来自：<a href="<?php echo $this->url("index/index/id/".$v['user']['id']);?>" target="_blank"><?php echo $v['group']['name'];?></a> 小组</span>
                <span class="titles-b-r">最后回应：<?php echo My_Tool::qtime($v['last_action_at'])?></span>
            </p>
        </li>
      <?php endforeach;?>
      <?php endif;?>
    </ul>
    
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?>
        </div>
        </div>