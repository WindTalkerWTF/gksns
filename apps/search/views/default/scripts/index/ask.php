<div class="grow search-page">
<div class="main gspan-21 gsuffix-1">

<ul class="items">
<?php if($this->list):?>
<?php foreach($this->list as $v):?>
<li class="items-post">
<h2><span>[&nbsp;问题&nbsp;]&nbsp;</span><a target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'],"ask");?>"><?php echo $v['title']?></a></h2>
<p></p>
<p>
标签:<?php 
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
&nbsp;&nbsp;&nbsp;<?php echo My_Tool::qtime($v['created_at'])?></p>
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