<?php
echo $this->cplace("标签管理");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("sys/tag-list");?>" >标签列表</a></li>
		<li><a href="<?php echo $this->url("sys/tag-add");?>">标签添加</a></li>
	</ul>
</div>
<form name="ss" action="<?php echo $this->url("sys/tag-list");?>" >
<div class="row-fluid">
  		    <div class="span3">
                    <div class="control-group">
              				<label class="control-label" for="inputEmail">名称</label>
			              <div class="controls">
			                <input type="text" id="name" name="name" value="<?php echo $this->name ? $this->name : '';?>" >
			              </div>
            		</div>
            </div>
          <div class="span3">
                    <div class="control-group">
              		<label class="control-label" for="inputEmail">栏目</label>
			              <div class="controls">
		<select name="treeid">
		<option value="-1" <?php echo $this->treeid == '-1' ? "selected" : "";?>>全部</option>
		<?php 
			if($this->treeList):
		?>
		<?php foreach ($this->treeList as $v):?>
			<option value="<?php echo $v['id'];?>" <?php echo $this->treeid == $v['id'] ? "selected" : "";?> ><?php echo $v['name'];?></option>
		<?php endforeach;?>
		<?php endif;?>
		</select>
			              </div>
            		</div>
            </div>
</div>

<div class="control-group">
            <div class="controls">
                <button name="btnSubmit" class="btn btn-primary" type="submit">查询</button>
            </div>
</div>
</form>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
	<tr>
		<td class="tablerow1 tablerow" width="5%" noWrap="noWrap">#</td>
		<td class="tablerow1 tablerow" width="10%" noWrap="noWrap">名称</td>
		<td class="tablerow1 tablerow" width="10%" noWrap="noWrap">栏目</td>
		<td class="tablerow1 tablerow" width="5%" noWrap="noWrap">排序</td>
		<td class="tablerow1 tablerow" width="10%" noWrap="noWrap">描述</td>
        <td class="tablerow1 tablerow" width="10%">博客数目</td>
        <td class="tablerow1 tablerow" width="10%">帖子数目</td>
        <td class="tablerow1 tablerow" width="10%">视频数目</td>
		<td class="tablerow1 tablerow" width="10%">问题数目</td>
		<td class="tablerow1 tablerow" width="15%">更新时间</td>
		<td class="tablerow1 tablerow">操作</td>
	</tr>
	<?php if($this->list):?>
	<?php foreach($this->list as $k=>$v):?>
	<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['id'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['name'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php echo $v['tree']['name'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php echo $v['tag_sort'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php echo $v['descr'];?>
		</td>
        <td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
            <?php echo $v['site_count'];?>
        </td>
        <td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
            <?php echo $v['group_count'];?>
        </td>
        <td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
            <?php echo $v['video_count'];?>
        </td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['ask_count'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php echo $v['created_at'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
<a href="<?php echo $this->url("tag/view/t/" . $v['name'],'ask');?>" target="_blank" ><i class="icon-eye-open"></i></a>
<a href="<?php echo $this->url("sys/tag-edit/id/" . $v['id']);?>" title="编辑" >
<i class="icon-pencil"></i></a>
<a  title="删除"
 href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("sys/tag-del/id/" . $v['id']);?>';}"
 ><i class="icon-trash"></i>
 </a>
		</td>
	</tr>
	<?php endforeach;?>
		<tr class="tr-3">
			<td class="tablerow1" colspan="100%" align="right" id="pagecode">
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
		 </td>
		</tr>
	<?php 
		endif;
	?>

</table>