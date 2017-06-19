<?php 
	echo $this->cplace("栏目管理");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("adm/index");?>" >栏目列表</a></li>
		<li><a href="<?php echo $this->url("adm/add-tree");?>">栏目添加</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
		<tr class="tr-1">
		<td class="tablerow1 tablerow" width="5%" noWrap="noWrap">栏目ID</td>
		<td class="tablerow1 tablerow" width="60%" noWrap="noWrap">栏目名称</td>
		<td class="tablerow1 tablerow" width="5%">排序</td>
		<td class="tablerow1 tablerow" width="10%">简介</td>
		<td class="tablerow1 tablerow">操作</td>
	</tr>
	<?php if($this->list):?>
	<?php foreach($this->list as $kv=>$v):?>
	<tr class="tr-<?php echo $kv%2==0 ? 1:2?>">
		<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
		<?php echo $v['id'];?>
		</td>
		<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
			<a href="<?php echo $this->url("adm/content-list/id/".$v['id'] );?>"><?php echo $v['name'];?></a>
			<?php if($v['face']):?><img src="<?php echo $this->img($v['face']);?>" width="14" height="14"><?php endif;?>
		</td>
		<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
		<?php echo $v['tree_sort'];?>
		</td>
		<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
		<a class="pop_over" href="javascript:void(0);" data-content="<?php echo $v['descr'];?>"
		  data-original-title="简介"  data-placement="left"
		>
             <i class="icon-eye-open"></i>
		</a>
		
		</td>
		<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
<a href="<?php echo $this->url("adm/edit-tree/id/" . $v['id']);?>" title="编辑" >
<i class="icon-pencil"></i></a>
<a  title="删除"
 href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("adm/delete-tree/id/" . $v['id']);?>';}"
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
   <?php endif;?>
</table>