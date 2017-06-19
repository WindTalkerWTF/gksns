<?php echo $this->groupnav();?>

<div class="gwrap group-mine-page">
            <div class="gmain">
                    <ul class="gntabs">
                        
<li <?php if($this->t == 1) echo "class='gtabs-curr'";?>><a href="<?php echo $this->url("index/my/t/1");?>">新回复的帖子</a></li>

<li <?php if($this->t == 2) echo "class='gtabs-curr'";?>><a href="<?php echo $this->url("index/my/t/2");?>">新发布的帖子</a></li>

<li <?php if($this->t == 3) echo "class='gtabs-curr'";?>><a href="<?php echo $this->url("index/my/t/3");?>">我发布的帖子</a></li>

<li <?php if($this->t == 4) echo "class='gtabs-curr'";?>><a href="<?php echo $this->url("index/my/t/4");?>">我回复的帖子</a></li>

                    </ul>
                    <ul class="titles">
               <?php if($this->list):?>
               <?php foreach ($this->list as $v):?>
                            <li>
                            <h3 class="titles-txt">
      <a href="<?php echo $this->url("index/view/id/".$v['id']);?>" target="_blank"><?php echo $v['title'];?></a>
                            </h3>

                            <div class="post-time"><?php echo My_Tool::qtime($v['last_action_at'])?></div>

                            <div class="post-reply_num"><?php echo $v['reply_count'];?><span class="titles-comment-icon"></span></div>
                            <div class="post-author gellipsis">
                                <a href="<?php echo $this->url("/index/g/id/".$v['group_id']);?>" target="_blank"><?php echo $v['name'];?></a>
                            </div>
                            </li>
                 <?php endforeach;?>
                 <?php endif;?>
                    </ul>     
<?php  echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 
                </div>

                <div class="gside">
                    <div class="side-title">
                        <h2>我加入的小组</h2>
                        <a class="side-title-more" href="<?php echo $this->url("index/group","user");?>">[全部]</a>
                    </div>
                    <div class="side-block-box" id="myGroups">
                    <?php if($this->grouplist):?>
                    <?php foreach ($this->grouplist as $v):?>
                        <dl class="gpack_u">
                            
                            <dt>
                                <a title="eLibrary"  target="_blank" href="<?php echo $this->url("index/g/id/".$v['id']);?>">
                                    <img width="48" height="48" src="<?php echo My_Tool::getFace($v['face'],48)?>">
                                </a>
                            </dt>
                            <dd class="gpack_u-n">
                            <p class="gellipsis">
  <a target="_blank"  href="<?php echo $this->url("index/g/id/".$v['id']);?>"><?php echo $v['name'];?></a></p>
                            </dd>
                        </dl>
                     <?php endforeach;?>
                     <?php endif;?>   
                        </div>
    </div>
        </div>