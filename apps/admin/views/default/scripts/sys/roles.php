<?php 
	echo $this->cplace("角色管理");
?>
<form method="post" name="frm" action="<?php echo $this->url("sys/add-role");?>">
	<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
		<tr class="tr-3">
			<td class="tablerow2">
			角色名称 <input class="input" size="15" name="role" type="text" />
			<button class="button" type="submit" name="btnsubmit" value="yes">提交</button>
			</td>
		</tr>
	</table>
</form>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
<tr>
	<th width="40%" class="left" noWrap="noWrap">角色名称</th>
	<th>操作</th>
</tr>
		<?php if($this->list):?>
		<?php foreach ($this->list as $k=>$v):?>
		<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
			<td class="tablerow<?php echo $k%2==0 ? 1:2?>"><?php echo $v['name'];?></td>
			<td class="tablerow<?php echo $k%2==0 ? 1:2?>" align="center" noWrap="noWrap">
			<a href="<?php echo $this->url("sys/edit-role/id/" . $v['id']);?>"><strong>编辑</strong></a>
           | <a href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("sys/delete-role/id/" . $v['id']);?>';}"><strong>删除</strong></a>
           | <a href="<?php echo $this->url("sys/role-actions/id/" . $v['id']);?>"><strong>节点管理</strong></a>
			</td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
		<tr class="tr-3">
			<td class="tablerow1" colspan="3" align="right" id="pagecode">
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
		 </td>
		</tr>
	</table>