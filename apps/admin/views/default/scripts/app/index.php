<?php 
	echo $this->cplace("app创建");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("/app/list");?>" onfocus="this.blur()">app列表</a></li>
		<li class="active"><a href="<?php echo $this->url("/app/index");?>" onfocus="this.blur()">创建app</a></li>
		<li><a href="<?php echo $this->url("/app/export");?>" onfocus="this.blur()">导出app</a></li>
		<li><a href="<?php echo $this->url("/app/import");?>" onfocus="this.blur()">导入app</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="index" method="post" action="<?php echo My_Tool::url("/app/index")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>app添加</caption>
<tr>
	<th colspan="2" class="th1">名称:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="name" value="<?php echo $this->name;?>" >
</td>
<td class="tablerow1 tips">请输入中文</td>
</tr>

<tr>
	<th colspan="2" class="th1">英文名称:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="aliname" value="<?php echo $this->aliname;?>" >
</td>
<td class="tablerow1 tips">请输入字母，数字，下划线,php内置的类名不要填写，如com</td>
</tr>

<tr>
	<th colspan="2" class="th1">作者:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="author" value="<?php echo $this->author;?>" >
</td>
<td class="tablerow1 tips"></td>
</tr>

<tr>
	<td colspan="2" class="tablerow1">
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提交</button>
	</td>
</tr>
</table>
</form>
