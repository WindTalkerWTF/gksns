<div class="grow search-page">
            <div class="main gspan-21 gsuffix-1">
        
        <ul class="group_list gpack">
<?php if($this->list):?>
<?php foreach($this->list as $v):?>
            <li class="group"> 
                <div class="group-options">
                    <a href="<?php echo $this->url("index/g/id/".$v['id'],"group");?>">
            <img src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['id'], 48);?>" class="group-icon" width="48" height="48">
            		</a>
                </div>
                <div class="group-desc">
                    <p>
                        <a href="<?php echo $this->url("index/g/id/".$v['id'],"group");?>"><?php echo $v['name'];?></a>
                        <span><?php echo $v['user_number'];?>人加入</span>
                    </p>
                    <p>
                    <?php echo $v['descr'];?>
                    </p>
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