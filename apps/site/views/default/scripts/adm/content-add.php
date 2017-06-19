<?php
	echo $this->cplace("添加内容");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("adm/content-list");?>" >内容列表</a></li>
		<li  class="active"><a href="<?php echo $this->url("adm/content-add");?>">内容添加</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="add-tree"  enctype="multipart/form-data"   method="post" action="<?php echo My_Tool::url("/adm/content-add")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>添加内容</caption>
<tr>
	<th colspan="2" class="th1">栏目:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<select name="id">
	<?php 
		if($this->treeList):
	?>
	<?php foreach ($this->treeList as $v):?>
		<option value="<?php echo $v['id'];?>" <?php echo $this->id == $v['id'] ? "selected" : "";?> ><?php echo $v['name'];?></option>
	<?php endforeach;?>
	<?php endif;?>
</select>
</td>
</tr>
<tr>
	<th colspan="2" class="th1">标题:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="title" value="<?php echo $this->title ? $this->title:""; ?>"  style="width:600px;" >
</td>
</tr>
<?php 
	$posArr = explode(',', trim($this->position, ","));
?>
<tr>
<td class="tablerow1">
<input type="checkbox" name="position[]" id="position" value="1" <?php echo in_array(1, $posArr) ? "checked":"";?>>&nbsp;&nbsp;首页推荐
&nbsp;&nbsp;
<input type="checkbox" name="position[]" id="position" value="2"  <?php echo in_array(2, $posArr) ? "checked":"";?>>&nbsp;&nbsp;栏目推荐
</td>
</tr>
<tr>
	<th colspan="2" class="th1">简介:</th>
</tr>
<tr>
<td class="tablerow1">
	<?php echo $this->keditor("descr", 1) ?>
<textarea class="" id="descr" name="descr" style="width:85%;height:25px;"><?php echo $this->descr ? $this->descr:$this->info['descr']; ?></textarea>
</td>
</tr>
<tr>
	<th colspan="2" class="th1">封面:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="file" name="face" value="" >
</td>
</tr>
<tr>
	<th colspan="2" class="th1">内容:</th>
</tr>
<tr>
<td class="tablerow1">
<?php 
$content = $this->contentTmp ? $this->contentTmp : "";
?>
<?php echo $this->keditor("content", 1) ?>
<textarea class="" id="content" name="content" style="width:85%;height:300px;"><?php echo $content; ?></textarea>
</td>
</tr>
<tr>
<td class="tablerow1">
<input type="radio" name="is_publish" id="is_publish" value="1" <?php echo $this->is_publish ? "checked":"";?>>&nbsp;&nbsp;发布
&nbsp;&nbsp;
<input type="radio" name="is_publish" id="is_publish" value="0"  <?php echo !$this->is_publish ? "checked":"";?>>&nbsp;&nbsp;屏蔽
</td>
</tr>
<tr>
	<td colspan="2" class="tablerow2">
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
	</td>
</tr>
</table>
</form>