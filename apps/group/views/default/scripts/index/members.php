<div class="grow members-page">
<div class="side">
    <form id="memberSearch" action="<?php echo $this->url("index/user","search");?>" class="gsearch" method="get">
        <p>
        <input id="memberNick" type="text" class="gsearch-txt" name="wd" maxlength="20" placeholder="搜索此小组成员" value=""/>
        <input type="submit" value="搜索" class="gsearch-bt gicon-search" />
        </p>
    </form>
    <div class="side-back">
        <a href="<?php echo $this->url("index/g/id/".$this->info['id']);?>">返回<span><?php echo $this->info['name'];?></span>&nbsp;&gt;</a>
    </div>
</div>




<div class="main gspan-21">
<h1 class="gbtitle">
<a title="<?php echo $this->info['name'];?>" href="<?php echo $this->url("index/g/id/".$this->info['id']);?>">
<img witdh="24" height="24" src="<?php echo My_Tool::getFace($this->info['face']?$this->info['face']:$this->info['name'],24)?>" alt="<?php echo $this->info['name'];?>" />
</a><?php echo $this->info['name'];?>小组成员</h1>

    <h2 class="main-title">管理员<span>(<?php echo count($this->adminUser);?>)</span></h2>

    <div class="members admins gspan-20 groupMembers">
    <dl class="gpack_u">
    <dt>
        <a target="_blank" title="<?php echo $this->creator['nickname'];?>" href="<?php echo $this->url("index/index/id/".$this->creator['id'],"user");?>">
            <img width="48" height="48" alt="<?php echo $this->creator['nickname'];?>" src="<?php echo My_Tool::getFace($this->creator['face']?$this->creator['face']:$this->creator['id'],48)?>" />
        </a>
    </dt>
    <dd>
        <a target="_blank" title="<?php echo $this->creator['nickname'];?>" href="<?php echo $this->url("index/index/id/".$this->creator['id'],"user");?>"><?php echo $this->creator['nickname'];?></a>
        <span class="gicon-leader" title="组长">组长</span>
        </dd>
	</dl>
    <?php if($this->adminUser):?>
    <?php foreach($this->adminUser as $k=>$v):?>
	<dl class="gpack_u">
    <dt>
 <a target="_blank" title="<?php echo $v['nickname'];?>" href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>">
   <img width="48" height="48" alt="<?php echo $v['nickname'];?>" src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['id'],48)?>" />
 </a>
    </dt>
    <dd>
        <a target="_blank" title="<?php echo $v['nickname'];?>" href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>"><?php echo $v['nickname'];?></a>
        </dd>
	</dl>
	<?php endforeach;?>
	<?php endif;?>
    </div>
    <h2 class="main-title">成员<span>(<?php echo $this->totalNum;?>)</span></h2>
    <div class="members gspan-19 groupMembers">
<?php if($this->list):?>
<?php foreach($this->list as $v):?>
	<dl class="gpack_u">
    <dt>
 <a target="_blank" title="<?php echo $v['nickname'];?>" href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>">
   <img width="48" height="48" alt="<?php echo $v['nickname'];?>" src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['id'],48)?>" />
 </a>
    </dt>
    <dd>
        <a target="_blank" title="<?php echo $v['nickname'];?>" href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>"><?php echo $v['nickname'];?></a>
        </dd>
	</dl>
<?php endforeach;?>
<?php endif;?>	
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 
    </div>
</div>
</div>