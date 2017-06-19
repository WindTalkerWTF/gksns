<?php 
	echo $this->cplace("app导入");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("/app/list");?>" onfocus="this.blur()">app列表</a></li>
		<li><a href="<?php echo $this->url("/app/index");?>" onfocus="this.blur()">创建app</a></li>
		<li><a href="<?php echo $this->url("/app/export");?>" onfocus="this.blur()">导出app</a></li>
		<li  class="active"><a href="<?php echo $this->url("/app/import");?>" onfocus="this.blur()">导入app</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="import" method="post" action="<?php echo My_Tool::url("/app/import")?>"  enctype="multipart/form-data">
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>app导入</caption>
<tr>
	<th colspan="2" class="th1">上传app压缩文件:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="file" name="file">
</td>
<td class="tablerow1 tips">上传app,zip格式压缩包</td>
</tr>

<tr>
	<td colspan="2" class="tablerow1">
<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">导入</button>
	</td>
</tr>
</table>
</form>
