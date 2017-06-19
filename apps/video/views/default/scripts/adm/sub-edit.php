<?php 
	echo $this->cplace("编辑子集");
?>
<div class="tab-box">
	<ul id="nav_tabs">
        <li><a href="<?php echo $this->url("adm/sub");?>" >子集列表</a></li>
        <li class="active"><a href="<?php echo $this->url("adm/sub-edit");?>">编辑子集</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="add-tree"  enctype="multipart/form-data"  method="post" action="<?php echo My_Tool::url("/adm/sub-edit")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>添加子集</caption>
<tr>
	<th colspan="2" class="th1">显示的number:</th>
</tr>

<tr>
<td class="tablerow1 formrow">
<input type="text" name="list_number" value="<?php echo $this->list_number ? $this->list_number:$this->info['list_number']; ?>" >
</td>
<td class="tablerow1 tips">显示的number</td>
</tr>

<tr>
	<th colspan="2" class="th2">网址:</th>
</tr>
<tr>
		<td class="tablerow2 formrow">
<input type="text" name="url" value="<?php echo $this->url ? $this->url:$this->info['url']; ?>" >
		</td>
		<td class="tablerow2 tips">网址</td>
</tr>

<tr>
	<th colspan="2" class="th2">顺序:</th>
</tr>

<tr>
		<td class="tablerow2 formrow">
<input type="text" name="fsort" value="<?php echo $this->fsort ? $this->fsort:$this->info['fsort']; ?>" >	
		</td>
		<td class="tablerow2 tips">数字越小越靠前</td>
</tr>
<tr>
	<td colspan="2" class="tablerow2">
	<input type="hidden" name="id" value="<?php echo $this->id;?>">
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
	</td>
</tr>
</table>
</form>