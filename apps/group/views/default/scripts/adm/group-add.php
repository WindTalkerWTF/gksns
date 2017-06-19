<?php
	echo $this->cplace("添加群组");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("adm/index");?>" >群组列表</a></li>
		<li><a href="<?php echo $this->url("adm/group-add");?>">群组添加</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="ss"   enctype="multipart/form-data"   action="<?php echo $this->url("adm/group-add");?>" method="post" >
	<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
	<caption>添加群组</caption>
	<tr>
		<th colspan="2" class="th1">群组名称:</th>
	</tr>
	<tr>
	<td class="tablerow1 formrow">
	<input type="text" name="name" value=""  style="width:600px;" >
	</td>
	</tr>
	
	<tr>
		<th colspan="2" class="th1">群组介绍:</th>
	</tr>
	<tr>
	<td class="tablerow1 formrow">
	<textarea rows="2" cols="200" name="descr" id="descr"></textarea>
	</td>
	</tr>
	
	<tr>
		<th colspan="2" class="th1">封面:</th>
	</tr>
	<tr>
	<td class="tablerow1 formrow">
	<input type="file" name="face" value=""  style="width:600px;" >
	</td>
	</tr>
	
	<tr>
		<th colspan="2" class="th1">栏目:</th>
	</tr>
	
	<tr>
		<td class="tablerow1 formrow">
			<select name="tree">
		<?php 
			if($this->treeList):
		?>
			<?php foreach ($this->treeList as $v):?>
				<option value="<?php echo $v['id'];?>" ><?php echo $v['name'];?></option>
			<?php endforeach;?>
		<?php endif;?>
			</select>
		</td>
	</tr>
	
	<tr>
		<th colspan="2" class="th1">群组状态:</th>
	</tr>
	<tr>
		<td colspan="2" class="th1">
<input type="radio" name="status" value="0" checked >关闭
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="status" value="1" >开启
		</td>
	</tr>	
	
	<tr>
		<td colspan="2" class="tablerow2">
		<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
		</td>
	</tr>
	</table>
</form>