<div class="grow gmt60 message-index-page">
<?php echo $this->leftmenu();?>
    
    <div class="gspan-24 gprefix-1 notice-page">
        <div class="gbtitle">
            <h2><a href="<?php echo $this->url("index/notice");?>">通知</a></h2>
        </div>
        <ul class="titles">
        		<?php if($this->list):?>
        		<?php foreach ($this->list as $v):?>
                    <li <?php if(!$v['is_read']):?>class="unread"<?php endif;?>  id="li_<?php echo $v['id'];?>">
                        <h3>
<a href="<?php echo $this->url($v['url'],$v['url_app']);?>" onclick="markNoticeRead(<?php echo $v['id'];?>)" target="_blank">
      <?php echo $v['feed_title'];?>
</a>
                        </h3>
                        <span class="titles-r"><?php echo My_Tool::qtime($v['created_at']);?></span>
                    </li>
               	<?php endforeach;?>
                <?php endif;?>
            
        </ul>
  <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "msg");?>
    </div>
</div>
<script>
function markNoticeRead(id){
	ajax_get("<?php echo $this->url("index/marknoticeread/id/","msg")?>"+id,function(a){
			if(a.code == 200){
				$("#li_"+id).removeClass("unread");
			}
	});
}
</script>