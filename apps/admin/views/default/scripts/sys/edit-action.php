<?php
$ref = My_Tool::url("sys/actions");
echo $this->cplace("节点编辑", array("后台列表"=>$ref));
?>
<form name="edit-action" method="post" action="<?php echo My_Tool::url("/sys/edit-action")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>节点编辑</caption>
<tr>
	<th colspan="2" class="th1">节点名称:</th>
</tr>

<tr>
<td class="tablerow1 formrow">
<input type="text" name="name" value="<?php echo $this->info['name']?>" >
</td>
<td class="tablerow1 tips">请根据节点作用，给节点起个合适的名字</td>
</tr>

<tr>
	<th colspan="2" class="th2">节点app名称:</th>
</tr>
<tr>
		<td class="tablerow2 formrow">
<input type="text" name="m" value="<?php echo $this->info['app']?>" >
		</td>
		<td class="tablerow2 tips">请填写节点app名称</td>
</tr>
<tr>
	<th colspan="2" class="th1">节点controller:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="c" value="<?php echo $this->info['controller']?>" >
</td>
<td class="tablerow1 tips">请填写节点controller名称</td>
</tr>

<tr>
	<th colspan="2" class="th2">节点action名称:</th>
</tr>

<tr>
		<td class="tablerow2 formrow">
<input type="text" name="a" value="<?php echo $this->info['action']?>" >	
		</td>
		<td class="tablerow2 tips">请填写节点action名称</td>
</tr>
<tr>
	<td colspan="2" class="tablerow2">
	<input type="hidden" name="id" value="<?php $this->id;?>" >
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
	</td>
</tr>
</table>
</form>