<?php
	echo $this->cplace("编辑内容");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("adm/content-list");?>" >内容列表</a></li>
		<li  class="active"><a href="<?php echo $this->url("adm/content-add");?>">内容添加</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="add-tree"  enctype="multipart/form-data"   method="post" action="<?php echo My_Tool::url("/adm/content-edit")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>编辑内容</caption>
<tr>
	<th colspan="2" class="th1">栏目:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<select name="pid">
	<?php 
		$treeId = $this->treeId ? $this->treeId : $this->info['tree_id'];
		if($this->treeList):
	?>
	<?php foreach ($this->treeList as $v):?>
		<option value="<?php echo $v['id'];?>" <?php echo $treeId == $v['id'] ? "selected" : "";?> ><?php echo $v['name'];?></option>
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
<input type="text" name="title" value="<?php echo $this->title ? $this->title:$this->info['title']; ?>"  style="width:600px;" >
</td>
</tr>
<?php 
	$pos = $this->position ? $this->position : $this->info['position'];
	$posArr = explode(',', trim($pos, ","));
?>
<tr>
<td class="tablerow1">
<input type="checkbox" name="position[]" id="position" value="1" <?php echo in_array(1, $posArr) ? "checked":"";?>>&nbsp;&nbsp;首页头条
&nbsp;&nbsp;
<input type="checkbox" name="position[]" id="position" value="2"  <?php echo in_array(2, $posArr) ? "checked":"";?>>&nbsp;&nbsp;栏目推荐
</td>
</tr>
<tr>
	<th colspan="2" class="th1">简介:</th>
</tr>
<tr>
<td class="tablerow1">
<textarea class="" id="descr" name="descr" style="width:85%;height:25px;"><?php echo $this->descr ? $this->descr:$this->info['descr']; ?></textarea>
</td>
</tr>
<tr>
	<th colspan="2" class="th1">内容:</th>
</tr>
<tr>
<td class="tablerow1">
<?php
$content = $this->content ? $this->content :$this->info['content']; 
?>
<?php echo $this->keditor("content", 1) ?>
<textarea class="" id="content" name="content" style="width:85%;height:300px;"><?php echo $content; ?></textarea>
</td>
</tr>
<tr>
	<th colspan="2" class="th1">封面:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<?php 
if($this->info['face']):
?>
<div>
<img src="<?php echo $this->img($this->info['face']."_48x48.jpg");?>" >
</div>
<?php endif;?>
<input type="file" name="face" value="" >
</td>
</tr>

<tr>
	<th colspan="2" class="th1">导演:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="author" value="<?php echo $this->author ? $this->author:$this->info['author']; ?>" >
</td>
</tr>

<tr>
	<th colspan="2" class="th1">主演:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="role" value="<?php echo $this->role ? $this->role:$this->info['role']; ?>" >
</td>
</tr>

<tr>
	<th colspan="2" class="th1">上映日期:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="publish_date" value="<?php echo $this->publish_date ? $this->publish_date:$this->info['publish_date']; ?>" >
</td>
</tr>

<tr>
	<th colspan="2" class="th1">地区:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="area" value="<?php echo $this->area ? $this->area:$this->info['area']; ?>" >
</td>
</tr>

<tr>
	<th colspan="2" class="th1">排序:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="fsort" value="<?php echo $this->fsort ? $this->fsort:$this->info['fsort']; ?>" >
</td>
</tr>
<tr>
	<th colspan="2" class="th1">分数:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="grade" value="<?php echo $this->grade ? $this->grade:$this->info['grade']; ?>" >
</td>
</tr>

<tr>
	<th colspan="2" class="th1">类型:</th>
</tr>
<tr>
<td class="tablerow1">
<input type="text" name="ftype" value="<?php echo $this->ftype ? $this->ftype:$this->info['ftype']; ?>" >
</td>
</tr>

<tr>
<td class="tablerow1">
<input type="radio" name="is_publish" id="is_publish" value="1"  <?php
$isPublish = $this->is_publish ? $this->is_publish : $this->info['is_publish'];
echo $isPublish ?"checked": "";
?>>&nbsp;&nbsp;发布
&nbsp;&nbsp;
<input type="radio" name="is_publish" id="is_publish" value="0"  <?php 
$isPublish = $this->is_publish ? $this->is_publish : $this->info['is_publish'];
echo !$isPublish ?"checked": "";?>>&nbsp;&nbsp;屏蔽
</td>
</tr>
<tr>
	<td colspan="2" class="tablerow2">
	<input type="hidden" name="id" value="<?php echo $this->id; ?>">
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
	</td>
</tr>
</table>
</form>