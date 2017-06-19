<?php 
	echo $this->cplace("添加栏目");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("adm/index");?>" >栏目列表</a></li>
		<li><a href="<?php echo $this->url("adm/add-tree");?>">栏目添加</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="add-tree"  enctype="multipart/form-data"  method="post" action="<?php echo My_Tool::url("/adm/edit-tree")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>编辑栏目</caption>
<tr>
	<th colspan="2" class="th1">栏目名称:</th>
</tr>

<tr>
<td class="tablerow1 formrow">
<input type="text" name="name" value="<?php echo $this->name ? $this->name:$this->info['name']; ?>" >
</td>
<td class="tablerow1 tips">给栏目起个名字</td>
</tr>
<tr>
	<th colspan="2" class="th2">上一级栏目:</th>
</tr>
<tr>
		<td class="tablerow2 formrow">
<select name="pid">
	<option value='0'>根栏目</option>
	<?php if($this->treeList):?>
	<?php foreach ($this->treeList as $v):?>
	<option value='<?php echo $v['id'];?>' <?php echo $this->info['pid'] == $v['id'] ? "selected":"";  ?>  ><?php echo $v['name'];?></option>
	<?php endforeach;?>
	<?php endif;?>
</select>
		</td>
		<td class="tablerow2 tips"></td>
</tr>
<tr>
	<th colspan="2" class="th2">封面:</th>
</tr>
<tr>
		<td class="tablerow2 formrow">
<?php 
if($this->info['face']):
?>
<div>
<img src="<?php echo $this->img($this->info['face']."_48x48.jpg");?>" >
</div>
<?php endif;?>
<input type="file" name="face" value="" >
		</td>
		<td class="tablerow2 tips">只支持jpg,png,jpeg,bmp格式，大小不大于1M的图片</td>
</tr>
<tr>
	<th colspan="2" class="th1">简介:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<textarea rows="3" cols="80" name='descr'><?php echo $this->descr ? $this->descr:$this->info['descr'];?></textarea>
</td>
<td class="tablerow1 tips"></td>
</tr>

<tr>
	<th colspan="2" class="th2">顺序:</th>
</tr>

<tr>
		<td class="tablerow2 formrow">
<input type="text" name="fsort" value="<?php echo $this->fsort ? $this->fsort:$this->info['tree_sort']; ?>" >	
		</td>
		<td class="tablerow2 tips">数字越小越靠前</td>
</tr>
<tr>
	<td colspan="2" class="tablerow2">
	<input type="hidden" name="id" value="<?php echo $this->info['id']; ?>">
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
	</td>
</tr>
</table>
</form>