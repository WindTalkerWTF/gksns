<?php
	echo $this->cplace("编辑内容");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("adm/content-list");?>" >内容列表</a></li>
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
<?php 
	$pos = $this->position ? $this->position : $this->info['position'];
	$posArr = explode(',', trim($pos, ","));
?>
<tr>
<td class="tablerow1">
<input type="checkbox" name="position[]" id="position" value="1" <?php echo in_array(1, $posArr) ? "checked":"";?>>&nbsp;&nbsp;首页推荐
&nbsp;&nbsp;
<input type="checkbox" name="position[]" id="position" value="2"  <?php echo in_array(2, $posArr) ? "checked":"";?>>&nbsp;&nbsp;栏目推荐
</td>
</tr>
    <tr>
        <th colspan="2" class="th1">封面:</th>
    </tr>
    <tr>
        <td class="tablerow1">
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
	<th colspan="2" class="th1">内容:</th>
</tr>
<tr>
<td class="tablerow1">
<?php
$content = $this->contentTmp ? $this->contentTmp :$this->content['content']; 
?>
<?php echo $this->keditor("content", 1) ?>
<textarea class="" id="content" name="content" style="width:85%;height:300px;"><?php echo $content; ?></textarea>
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