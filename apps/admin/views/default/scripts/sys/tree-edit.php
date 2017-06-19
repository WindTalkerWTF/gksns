<?php
	echo $this->cplace("编辑栏目");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("sys/tree-list");?>" >栏目列表</a></li>
		<li><a href="<?php echo $this->url("sys/tree-add");?>">栏目添加</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="add-tree"  method="post" action="<?php echo $this->url("sys/tree-edit")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>编辑栏目</caption>
<tr>
	<th colspan="2" class="th1">栏目:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="name" value="<?php echo $this->name ? $this->name:$this->info['name']; ?>"  style="width:600px;" >
</td>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="sort" value="<?php echo $this->tree_sort ? $this->tree_sort:$this->info['tree_sort']; ?>"  style="width:600px;" >
</td>
</tr>
<tr>
	<td colspan="2" class="tablerow2">
	<input type="hidden" name="id" value="<?php echo $this->id;?>" >
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
	</td>
</tr>
</table>
</form>