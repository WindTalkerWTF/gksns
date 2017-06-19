<div class="grow search-page">
            <div class="main gspan-21 gsuffix-1">
                
                <ul class="items">
                    
<?php if($this->list):?>
<?php foreach($this->list as $v):?>
					 <li>
                <div class="tag-list-options">
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/".$v['name'],"ask");?>">
                    <img src="<?php echo My_Tool::getFace($v['name'], 48);?>" class="tag-icon" width="48" height="48"></a>
                </div>
                <div class="tag-list-desc">
                    <p>
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/".$v['name'],"ask");?>"><?php echo $v['fname'];?></a>
                    <span><?php echo $v['follow_count'];?>人关注</span>
                    <span><?php echo $v['ask_count'];?>个问题</span>
                    </p>
                    <p></p>
                </div>
            		</li>
<?php endforeach;?>
<?php endif;?>
                </ul>
                
 	<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 	

            </div>
            <div class="side gspan-10">
                <a target="_blank" class="side-link" href="<?php echo $this->url("tag/index", "ask");?>">找标签？去标签广场&nbsp;&gt;</a>
                <a target="_blank" class="side-link" href="<?php echo $this->url("index/index", "group");?>">找小组？去小组广场&nbsp;&gt;</a>
            </div>
        </div>