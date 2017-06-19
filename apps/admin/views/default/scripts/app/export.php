<?php 
	echo $this->cplace("app导出");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("/app/list");?>" onfocus="this.blur()">app列表</a></li>
		<li><a href="<?php echo $this->url("/app/index");?>" onfocus="this.blur()">创建app</a></li>
		<li  class="active"><a href="<?php echo $this->url("/app/export");?>" onfocus="this.blur()">导出app</a></li>
		<li><a href="<?php echo $this->url("/app/import");?>" onfocus="this.blur()">导入app</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="export" method="post" action="<?php echo My_Tool::url("/app/export")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>app导出</caption>
<tr>
	<th colspan="2" class="th1">选择app:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
	<?php if($this->app):?>
<select name="app" id="app">
		<?php foreach($this->app as $v):?>
	<option value="<?php echo $v['id'];?>"><?php echo $v['view_name'];?>[<?php echo $v['name'];?>]</option>
		<?php endforeach;?>
</select>
	<?php endif;?>
</td>
<td class="tablerow1 tips">请选择app,将导出zip格式压缩包</td>
</tr>

<tr>
	<td colspan="2" class="tablerow1">
<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">导出</button>
	</td>
</tr>
</table>
</form>
