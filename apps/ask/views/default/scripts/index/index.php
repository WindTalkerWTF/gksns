<div class="gmt60 grow  ask-maylike-page">
    <div class="main gspan-21">
        <div class="ask-title gclear">
            <h2>问答</h2>
            <a href="<?php echo $this->url("index/add", "ask");?>" class="gbtn-primary" id="newPost">提问</a>
        </div>
        <ul class="gtabs">
    <?php 
    	if(!$this->t):
    ?>        
    <li class="gtabs-curr">你可能喜欢</li>
	<?php else:?>
	<li><a href="<?php echo $this->url("index/index", "ask");?>">你可能喜欢</a></li>
	<?php endif;?>
	
	<?php 
    	if($this->t == 1):
    ?>  
    <li class="gtabs-curr">最新问题</li>
    <?php else:?>
    <li><a href="<?php echo $this->url("index/index/t/1", "ask");?>">最新问题</a></li>
    <?php endif;?>
    
    <?php 
    	if($this->t == 2):
    ?>  
    <li class="gtabs-curr">热门问题</li>
    <?php else:?>
    <li><a href="<?php echo $this->url("index/index/t/2", "ask");?>">热门问题</a></li>
	<?php endif;?>
        </ul>
        <ul class="ask-list">
<?php 
	if($this->list):
?>
<?php 
	foreach ($this->list as $v):
?>
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
                    <p class="ask-list-tags">
                    标签：
                    <?php 
                    $tagArr = explode(',', trim($v['tag_name_path'],','));
                    if(isset($tagArr[0])):
                    ?>
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[0]);?>"><?php echo $tagArr[0];?></a>
                    <?php endif;?>
                    <?php 
                    if(isset($tagArr[1])):
                    ?>
                    <span class="split">|</span>
                    
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[1]);?>"><?php echo $tagArr[1];?></a>
                    
                    <?php endif;?>
                     <?php 
                    if(isset($tagArr[2])):
                    ?>
                    <span class="split">|</span>
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[2]);?>"><?php echo $tagArr[2];?></a>
                    <?php endif;?>
                    </p>
                    <span class="ask-list-time">
					<?php echo My_Tool::qtime($v['created_at'])?>
                    </span>
                </div>
            </div>
            </li>
<?php endforeach;?>
<?php endif;?>
        </ul>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 
    </div>
    <div class="side gspan-10 gprefix-1">
        <div class="side-nav">
            <p><a href="<?php echo $this->url("tag/index");?>">去标签广场 &gt;</a></p>
            
            <p><a href="<?php echo $this->url("index/ask","user");?>">去我的问答 &gt;</a></p>
            
        </div>
        
    <div class="side-title">
        
        <h2>猜你喜欢的标签</h2>
    </div>
    <div id="tags">
        
        <ul class="side-tags ">
        <?php 
        	if($this->hot):
        ?>
        <?php 
        	foreach($this->hot as $v):
        ?>
            <li>
            <a href="<?php echo $this->url("tag/view/t/".$v['name']);?>">
            <img src="<?php echo Ask_Tool::getFace($v['name'], 24); ?>" width="24" height="24"/><?php echo $v['name'];?></a><?php echo $v['ask_count'];?>个问题
            </li>
        <?php 
        	endforeach;
        ?>
		<?php 
			endif;
		?>
        </ul>
        
    </div>

        
    </div>
</div>