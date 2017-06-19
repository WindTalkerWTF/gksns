<div class="grow ask-page">
<?php echo $this->leftmenu($this->user['id']);?>
<div class="main gprefix-1 gspan-25">
            
    <div class="gbtitle">
        <h2><a class="gbtitle-link" href="<?php echo $this->url("index/index/id/".$this->id,"user")?>">个人主页</a>
        <span class="entities">&gt;</span>提问<span class="gbtitle-more">（全部<?php echo $this->user['question_count'];?>个）</span></h2>
    </div>
    <ul class="ask-list">
       <?php if($this->list):?>
       <?php foreach ($this->list as $v):?>
        <li>
            <div class="ask-list-nums">
                <p class="ask-focus-nums">
                    <span class="num"><?php echo $v['follow_count'];?></span>关注
                </p>
                <p class="ask-answer-nums">
                    <span class="num"><?php echo $v['answer_count'];?></span>回答
                </p>
            </div>
            <div class="ask-list-detials">
                <h2><a target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'], "ask");?>"><?php echo $v['title'];?></a></h2>
                <div class="ask-list-legend">
                    <p class="ask-list-tags">标签：
					<?php 
                    $tagArr = explode(',', trim($v['tag_name_path'],','));
                    if(isset($tagArr[0])):
                    ?>
                    <span class="tag"><a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[0],"ask");?>"><?php echo $tagArr[0];?></a></span>
                    <?php endif;?>
                    <?php 
                    if(isset($tagArr[1])):
                    ?>
                    <span class="split">|</span>
                    
                    <span class="tag"><a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[1],"ask");?>"><?php echo $tagArr[1];?></a></span>
                    
                    <?php endif;?>
                     <?php 
                    if(isset($tagArr[2])):
                    ?>
                    <span class="split">|</span>
                    <span class="tag"><a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[2],"ask");?>"><?php echo $tagArr[2];?></a></span>
                    <?php endif;?>
                    </p>
                    <span class="ask-list-time">
                      <?php echo My_Tool::qtime($v['created_at']); ?>
                    </span>
                </div>
            </div>
        </li>
        <?php endforeach;?>
       <?php endif;?>
    </ul>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?>
        </div>
</div>