<div class="grow blog-page">
<?php echo $this->leftmenu($this->id);?>
<div class="main gprefix-1 gspan-25">
            
    <div class="gbtitle">
        <h2>
            <a class="gbtitle-link" href="<?php echo $this->url("index/index/id/".$this->id,"user")?>">个人主页</a>
  <span class="entities">&gt;</span><?php echo $this->user['nickname'];?>的博客<span class="gbtitle-more">（全部<?php echo $this->user['blog_count'];?>篇）</span>
        </h2>
		<?php if($this->isMe): ?>
        <a href="<?php echo $this->url("index/add","site");?>" class="gbtn-primary">添加博客</a>
		<?php endif; ?>
    </div>
    <ul class="blog_list">
	<?php if($this->list):?>
	<?php foreach ($this->list as $v):?>
        <li class="blog">
        <h3><a target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'],"site");?>"><?php echo $v['title'];?></a></h3>
            <p class="blog-meta"><?php echo My_Tool::qtime($v['created_at'])?></p>
            <p>
            <?php echo $v['descr'];?>
            <a target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'],"site");?>">查看全文</a></p>
        </li>
    <?php endforeach;?>
    <?php endif;?>
    </ul>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?>
</div>
</div>