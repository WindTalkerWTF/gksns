<?php 
	echo $this->cplace("应用节点管理");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("/sys/actions");?>" onfocus="this.blur()">后台节点管理</a></li>
		<li class="active"><a href="<?php echo $this->url("/sys/app-actions");?>" onfocus="this.blur()">APP节点管理</a></li>
		<li><a href="<?php echo $this->url("/sys/scanner-actions");?>" onfocus="this.blur()">扫描节点</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
		<tr class="tr-1">
		<td class="tablerow1 tablerow" width="40%" noWrap="noWrap">App名称</td>
		<td class="tablerow1 tablerow" width="30%">AppID</td>
		<td class="tablerow1 tablerow">操作</td>
	</tr>
	<?php if($this->list):?>
	<?php foreach($this->list as $k=>$v):?>
	<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<i id="toggle_1" class="toggle hide-icon" ></i>
		<?php echo $v['view_name'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php echo $v['name'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		</td>
	</tr>
	<tbody id="groupbody_1">
	<?php foreach($v['actions'] as $kv=>$av): ?>
		<tr class="tr-<?php echo $kv%2==0 ? 1:2?>">
			<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
				<i class="tdline1 tdlast"></i>		
				<?php echo $av['name'];?>
			</td>
			<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
			<?php echo $av['path'];?>
			</td>
			<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
			<a href="<?php echo $this->url("sys/edit-action/id/" . $av['id']);?>"><strong>编辑</strong></a> | 
			<a href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("sys/delete-action/id/" . $av['id']);?>';}"><strong>删除</strong></a>
			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
	<?php endforeach;?>
	<?php endif;?>
		<tr class="tr-3">
			<td class="tablerow1" colspan="3" align="right" id="pagecode">
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
		 </td>
		</tr>
	</table>