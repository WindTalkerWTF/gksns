<div class="grow">
<?php echo $this->leftmenu($this->user['id']);?>
<div class="main gprefix-1 gspan-25">
            
    <div class="gbtitle">
        <h2><a class="gbtitle-link" href="<?php echo $this->url("index/index/id/".$this->id,"user")?>">个人主页</a>
        <span class="gbtitle-point-to">&gt;</span>动态</h2>
        <span class="gbtitle-txt">(全部<?php echo $this->user['feed_count'];?>条)</span>
    </div>
    <div class="gprefix-1 gsuffix-2">
        <?php if($this->list):?>
        <?php foreach($this->list as $v):?>
        <div class="gactive">
            <div class="gactive-hd">
  <?php echo $v['feed_type_name'];?>
  <?php if($v['url']):?>
  <a class="gactive-hd-title" target="_blank" href="<?php echo $this->url($v['url'],$v['url_app']);?>">
  <?php echo $v['feed_title'];?>
  </a>
  <?php else:?>
  "<?php echo $v['feed_title'];?>"
  <?php endif;?>
            </div>
            <div class="gactive-bd">
	<p><?php echo stripslashes($v['feed_data']);?></p>
                <span>
<?php echo My_Tool::qtime($v['created_at']);?>
                </span>
            </div>
        </div>
        <?php endforeach;?>
		<?php endif;?>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?>
    </div>
        </div>
</div>