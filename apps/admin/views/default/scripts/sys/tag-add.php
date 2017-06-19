<?php
	echo $this->cplace("添加标签");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("sys/tag-list");?>" >标签列表</a></li>
		<li class="active"><a href="<?php echo $this->url("sys/tag-add");?>">标签添加</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="add-tree"  method="post" action="<?php echo $this->url("sys/tag-add")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>添加标签</caption>
<tr>
	<th colspan="2" class="th1">栏目:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
		<select name="treeid">
		<?php 
			if($this->treeList):
		?>
		<?php foreach ($this->treeList as $v):?>
			<option value="<?php echo $v['id'];?>" <?php echo $this->treeid == $v['id'] ? "selected" : "";?> ><?php echo $v['name'];?></option>
		<?php endforeach;?>
		<?php endif;?>
		</select>
</td>
</tr>
<tr>
	<th colspan="2" class="th1">名称:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="name" value="<?php echo $this->name ? $this->name:""; ?>"  style="width:600px;" >
</td>
</tr>
<tr>
	<th colspan="2" class="th1">描述:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="descr" name="descr" value="<?php echo $this->descr ? $this->descr:""; ?>"  style="width:600px;" >
</td>
</tr>
<tr>
	<th colspan="2" class="th1">排序:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="tagSort" value="<?php echo $this->tagSort ? $this->tagSort:""; ?>"  style="width:600px;" >
</td>
</tr>

<tr>
	<td colspan="2" class="tablerow2">
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
	</td>
</tr>
</table>
</form>
