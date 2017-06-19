<div class="grow search-page">
            <div class="main gspan-21 gsuffix-1">
                
                <ul class="items">
                    
<?php if($this->list):?>
<?php foreach($this->list as $v):?>
                <li class="items-post">
                        <h2><span>[&nbsp;帖子&nbsp;]&nbsp;</span>
       <a target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'],"group");?>"><?php echo $v['title']?></a></h2>
                        <p><?php echo My_Tool::htmlCut(strip_tags($v['content']), 100)?></p>
                        <p>来自：<a target="_blank" href="<?php echo $this->url("index/g/id/".$v['group_id'],"group")?>"><?php echo $v['name']?></a>
                        &nbsp;小组&nbsp;&nbsp;<?php echo My_Tool::qtime($v['created_at'])?>
                        </p>
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