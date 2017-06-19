<div class="grow search-page">
            <div class="main gspan-21 gsuffix-1">
                
                <ul class="items">
                    
<?php if($this->list):?>
<?php foreach($this->list as $v):?>
                    <li class="items-guy">
                        <a  target="_blank" href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>">
                        <img src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['id'], 48);?>" alt="" width="48" height="48" /></a>
                        <div>
 <a target="_blank" href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>">
  <?php echo $v['nickname'];?>
 </a>
                            <span><?php echo $v['to_follow_count'];?>人关注</span>
                            <p>
                      <?php echo $v['sign'];?>
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