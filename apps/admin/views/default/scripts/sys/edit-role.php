<?php
$ref = My_Tool::url("sys/roles");
echo $this->cplace("角色编辑", array("列表"=>$ref));
?>
<form name="edit-role" method="post" action="<?php echo My_Tool::url("/sys/edit-role")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>角色编辑</caption>
<tr>
	<th colspan="2" class="th1">角色名称:</th>
</tr>

<tr>
<td class="tablerow1 formrow">
<input type="text" name="name" value="<?php echo $this->info['name']?>" >
</td>
<td class="tablerow1 tips">给角色起个合适的名字</td>
</tr>
<tr>
	<td colspan="2" class="tablerow2">
	<input type="hidden" name="id" value="<?php $this->id;?>" >
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
	</td>
</tr>
</table>
</form>