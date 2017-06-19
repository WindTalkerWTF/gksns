<?php 
if($this->pageCount && $this->pageCount > 1):
$p = $this->current;

$end = $p+5;
$start = $p-5;
$end = $end > $this->pageCount ? $this->pageCount+1 : $end;
$start = $start < 1 ? 1 : $start;
?>
<ul class="gpages">
<?php if($this->page >1):?>
<li><a href="<?php echo My_Tool::pagiUrl($this->previous, $this->pageCount); ?><?php echo $this->urlExt?$this->urlExt:"";?>">上一页</a></li>
<?php endif;?>
<?php
for($start; $start <$end ; $start++):
?>
	<li>
<?php if($this->page == $start):?>
<span><?php echo $start; ?></span>
<?php else:?>
<a href="<?php echo My_Tool::pagiUrl($start, $this->pageCount); ?>"><?php echo $start; ?></a></li>
<?php endif;?>

<?php endfor;?>
	<li><span>...</span></li>
<?php if($this->next > $this->page):?>
	<li><a href="<?php echo My_Tool::pagiUrl($this->next, $this->pageCount); ?><?php echo $this->urlExt?$this->urlExt:"";?>">下一页</a></li>
	<li><a href="<?php echo My_Tool::pagiUrl($this->pageCount, $this->pageCount); ?><?php echo $this->urlExt?$this->urlExt:"";?>">末页</a></li>
<?php endif;?>
</ul>
<?php 
endif;
?>