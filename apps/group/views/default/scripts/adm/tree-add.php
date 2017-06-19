<?php
	echo $this->cplace("添加栏目");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("adm/tree-list");?>" >栏目列表</a></li>
		<li><a href="<?php echo $this->url("adm/tree-add");?>">栏目添加</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="add-tree"  method="post" action="<?php echo My_Tool::url("/adm/tree-add")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>添加内容</caption>
<tr>
	<th colspan="2" class="th1">栏目:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="name" value="<?php echo $this->name ? $this->name:""; ?>"  style="width:600px;" >
</td>
</tr>
<tr>
	<th colspan="2" class="th1">顺序:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="sort" value="<?php echo $this->sort ? $this->sort:0; ?>"  style="width:600px;" >
</td>
</tr>
<tr>
	<td colspan="2" class="tablerow2">
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
	</td>
</tr>
</table>
</form>
