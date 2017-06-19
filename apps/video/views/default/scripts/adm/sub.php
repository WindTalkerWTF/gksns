<?php
echo $this->cplace("子集管理");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("adm/sub/id/". $this->id);?>" >子集列表</a></li>
		<li><a href="<?php echo $this->url("adm/sub-add/id/" . $this->id);?>">子集添加</a></li>
	</ul>
</div>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
	<tr>
		<td class="tablerow1 tablerow" width="10%" noWrap="noWrap">顺序</td>
		<td class="tablerow1 tablerow" width="50%" noWrap="noWrap">网址</td>
		<td class="tablerow1 tablerow" width="10%">排序</td>
		<td class="tablerow1 tablerow">操作</td>
	</tr>
		<?php if($this->list):?>
	<?php foreach($this->list as $k=>$v):?>
	<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
	<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['list_number'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['url'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['fsort'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
<a href="<?php echo $this->url("adm/sub-edit/id/" . $v['id']);?>" title="编辑" >
<i class="icon-pencil"></i></a>
<a  title="删除"
 href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("adm/sub-delete/id/" . $v['id']);?>';}"
 ><i class="icon-trash"></i>
 </a>
		</td>
	</tr>
	<?php endforeach;?>
	<?php endif;?>
		<tr class="tr-3">
			<td class="tablerow1" colspan="100%" align="right" id="pagecode">
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
		 </td>
		</tr>
</table>
