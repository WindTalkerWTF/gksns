<div class="grow group-page">
<?php echo $this->leftmenu($this->user['id']);?>
<div class="main gprefix-1 gspan-25">
            
    <div class="gbtitle">
        <h2><a class="gbtitle-link" href="<?php echo $this->url("index/index/id/".$this->id,"user")?>">个人主页</a>
        <span class="entities">&gt;</span>小组<span class="gbtitle-more">（全部<?php echo $this->user['group_count'];?>个）</span></h2>
    </div>
    <div class="group-list gprefix-1 gsuffix-2 gclear">
        <?php if($this->list):?>
        <?php foreach($this->list as $v):?>
        <dl class="gpack_u">
            <dt><a target="_blank" title="<?php echo $v['name'];?>" href="<?php echo $this->url("index/g/id/".$v['id'],"group");?>">
            <img width="48" height="48" alt="<?php echo $v['name'];?>" src="<?php echo My_Tool::getFace($v['face'],48);?>"></a>
            </dt>
            <dd><a target="_blank" title="<?php echo $v['name'];?>" href="<?php echo $this->url("index/g/id/".$v['id'],"group");?>"><?php echo $v['name'];?></a></dd>
        </dl>
        <?php endforeach;?>
        <?php endif;?>
    </div>
    <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?>
        </div>
</div>