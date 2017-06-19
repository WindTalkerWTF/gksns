  <div class="side gspan-10 gprefix-1">
        <div class="side-nav">
            <p><a href="<?php echo $this->url("index/g/id/".$this->id,"group");?>">返回小组&nbsp;&gt;</a></p>
        </div>
        <div class="side-title">
            <h2>最新小组热帖</h2>
        </div>
        <ul class="side-blog">
	<?php if($this->arc):?>
	<?php foreach ($this->arc as $v):?>
            <li>
            <h3 class="side-blog-title"><a href="<?php echo $this->url("index/view/id/".$v['id'],"group");?>">
            <?php echo $v['title'];?></a></h3>
            <p class="side-blog-author">作者：<a href="<?php echo $this->url("index/index/id/".$v['user']['id'],"user");?>" 
            title="<?php echo $v['user']['nickname']?>" target="_blank"><?php echo $v['user']['nickname']?></a></p>
            </li>
     <?php endforeach;?>
    <?php endif;?>
        </ul>
    </div>