<div class="side gspan-6"><span class="all_sites">
<?php if(!$this->id):?>
全部类型
<?php else:?>
<a href="<?php echo $this->url("/index/index", "site");?>">全部类型</a>
<?php endif;?>
</span>
<ul>
<?php 
if($this->tree):
foreach($this->tree as $v):
?>
	<li>
	<?php 
	if($v['id'] == $this->id):
	?>
	<?php 
		if($v['face']):
	?>
	<img 
		src="<?php echo $this->img($v['face']."_24x24.jpg");?>"
		alt="<?php echo $v['name'];?>" />
	<?php endif;?>
	<?php echo $v['name'];?>
	<?php else:?>
	<a href="<?php echo $this->url("/index/index/id/" . $v['id'], "site");?>">
	<img 
		src="<?php echo $this->img($v['face']."_24x24.jpg");?>"
		alt="<?php echo $v['name'];?>" /><?php echo $v['name'];?>
	</a>
	<?php endif;?>
	</li>
<?php 
endforeach;
endif;
?>
</ul>
</div>