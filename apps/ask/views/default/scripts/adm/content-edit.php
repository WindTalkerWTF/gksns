<?php
	echo $this->cplace("编辑内容");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("adm/index");?>" >内容列表</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<form name="edit-tree"   enctype="multipart/form-data"  method="post" action="<?php echo My_Tool::url("/adm/content-edit")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption>编辑内容</caption>
<tr>
	<th colspan="2" class="th1">标题:</th>
</tr>
<tr>
<td class="tablerow1">
<input type="text" name="title" value="<?php echo $this->title ? $this->title:$this->info['title']; ?>" style="width:600px;" >
</td>
</tr>
<tr>
	<th colspan="2" class="th1">内容:</th>
</tr>
<tr>
<td class="tablerow1">
<?php
$content = $this->content['content'] ? $this->content['content'] :$this->content['content']; 
?>
<?php echo $this->keditor("content", 1) ?>
<textarea class="" id="content" name="content" style="width:85%;height:300px;"><?php echo $content; ?></textarea>
</td>
</tr>

<tr>
	<th colspan="2" class="th1">Tag:</th>
</tr>
<tr>
<td class="tablerow1">
<input type="text" name="tag_name_path" value="<?php echo $this->tag_name_path ? $this->tag_name_path:trim($this->info['tag_name_path'],','); ?>" style="width:300px;" >
(最多三个标签,用","号隔开)
</td>
</tr>

<tr>
<td class="tablerow1">
<input type="radio" name="is_publish" id="is_publish" value="1" <?php
$isPublish = $this->is_publish ? $this->is_publish : $this->info['is_publish'];
echo $isPublish ?"checked": "";
?>>&nbsp;&nbsp;发布
&nbsp;&nbsp;
<input type="radio" name="is_publish" id="is_publish" value="0" <?php 
$isPublish = $this->is_publish ? $this->is_publish : $this->info['is_publish'];
echo !$isPublish ?"checked": "";?>>&nbsp;&nbsp;草稿
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