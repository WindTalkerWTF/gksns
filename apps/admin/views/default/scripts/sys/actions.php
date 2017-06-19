<?php 
	echo $this->cplace("节点管理");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("/sys/actions");?>" onfocus="this.blur()">后台节点管理</a></li>
		<li><a href="<?php echo $this->url("/sys/app-actions");?>" onfocus="this.blur()">App节点管理</a></li>
		<li><a href="<?php echo $this->url("/sys/scanner-actions");?>" onfocus="this.blur()">扫描节点</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<table cellspacing="0" cellpadding="3" align="center" border="0"
		class="tableborder">
		<tr>
			<th width="40%" class="left" noWrap="noWrap">节点名称</th>
			<th width="15%">节点path</th>
			<th>操作</th>
		</tr>
		<?php if($this->list):?>
		<?php foreach ($this->list as $k=>$v):?>
		<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
			<td class="tablerow<?php echo $k%2==0 ? 1:2?>"><?php echo $v['name'];?></td>
			<td class="tablerow<?php echo $k%2==0 ? 1:2?>" align="left" noWrap="noWrap"><?php echo $v['path'];?></td>
			<td class="tablerow<?php echo $k%2==0 ? 1:2?>" align="left" noWrap="noWrap">
			<a href="<?php echo $this->url("sys/edit-action/id/" . $v['id']);?>"><strong>编辑</strong></a>
           | <a href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("sys/delete-action/id/" . $v['id']);?>';}"><strong>删除</strong></a>
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