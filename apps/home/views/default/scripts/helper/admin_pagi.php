<?php 
if($this->pageCount):
$p = $this->current;

$end = $p+5;
$start = $p-5;
$end = $end > $this->pageCount ? $this->pageCount+1 : $end;
$start = $start < 1 ? 1 : $start;
?>
<var class="morePage">
<b>总页数：<?php echo $this->pageCount; ?></b><b>每页:<?php echo $this->pageSize; ?></b>
<kbd>
	<a href="<?php echo My_Tool::pagiUrl($this->previous, $this->pageCount);?>">上一页</a>
</kbd>
<code>
<?php
for($start; $start <$end ; $start++):
?>
	<a href="<?php echo My_Tool::pagiUrl($start, $this->pageCount); ?>" <?php echo $this->page == $start ? "class=\"current\"" : ""; ?>><?php echo $start; ?></a>
<?php endfor;?>
	</code>
<dfn>
<a href="<?php echo My_Tool::pagiUrl($this->next, $this->pageCount); ?>">下一页</a>
</dfn>
</var>
<?php 
endif;
?>