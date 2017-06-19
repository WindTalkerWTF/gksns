<?php 
	echo $this->cplace("自定义菜单管理");
?>
<form method="post" name="frm" action="<?php echo $this->url("menu/mg");?>">
	<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
		<tr class="tr-3">
			<td class="tablerow2"><b>增加一级菜单</b> 
		       名称 <input class="input" size="15" name="addname[]" type="text" />
		       排序<input class="input" size="15" name="addfsort[]" type="text" value="0"/>
		       <input size="15" name="addurl[]" type="hidden"  value="0"/>
		     <input size="15" name="addpid[]" type="hidden"  value="0"/>
			<button class="button" type="submit" name="btnsubmit" value="yes">提交</button>
			</td>
		</tr>
	</table>
</form>
<form method="post" name="frm" action="<?php echo $this->url("menu/mg");?>">
<div style="clear: both"></div>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
		<tr class="tr-1">
		<td class="tablerow1 tablerow" width="40%" noWrap="noWrap">名称</td>
		<td class="tablerow1 tablerow" width="30%">url</td>
		<td class="tablerow1 tablerow">排序</td>
	</tr>
	<?php if($this->list):?>
	<?php foreach($this->list as $k=>$v):?>
	<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<i id="toggle_1" class="toggle hide-icon" ></i>
		<input type="text" class="input" name="name[<?php echo $v['id'];?>]" value="<?php echo $v['name'];?>" >
		<a href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("menu/delete/id/" . $v['id']);?>';}"><img src='<?php echo $this->img("/res/asset/admin/images/wrong.gif");?>'></a>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
<input type="text" class="input" name="sort[<?php echo $v['id'];?>]" value="<?php echo $v['fsort'];?>" >	
		</td>
	</tr>
	<tbody id="groupbody_1">
	<?php 
	$ktag=0;
	foreach($v['child'] as $kv=>$av): 
	$ktag = $kv;
	?>
		<tr class="tr-<?php echo $kv%2==0 ? 1:2?>">
			<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
				<i class="tdline1 tdlast"></i>		
<input type="text" class="input" name="name[<?php echo $av['id'];?>]" value="<?php echo $av['name'];?>" >
<a href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("menu/delete/id/" . $av['id']);?>';}"><img src='<?php echo $this->img("/res/asset/admin/images/wrong.gif");?>'></a>
			</td>
			<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
<input type="text" class="input" name="url[<?php echo $av['id'];?>]" value="<?php echo $av['url'];?>" >
			</td>
			<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
<input type="text" class="input" name="sort[<?php echo $av['id'];?>]" value="<?php echo $av['fsort'];?>" >
			</td>
		</tr>
	<?php endforeach;?>
		<tr class="tr-<?php
		$ktag++;
		echo $ktag%2==0 ? 1:2;
		?>">
			<td class="tablerow<?php echo $ktag%2==0 ? 1:2?> tdborder">
				<i class="tdline1 tdlast"></i>
<input type="hidden" class="input" name="addpid[]" value="<?php echo $v['id'];?>" >	
<input type="text" class="input" name="addname[]" value="" >
			</td>
			<td class="tablerow<?php echo $ktag%2==0 ? 1:2?> tdborder">
<input type="text" class="input" name="addurl[]" value="" >
			</td>
			<td class="tablerow<?php echo $ktag%2==0 ? 1:2?> tdborder">
<input type="text" class="input" name="addsort[]" value="0" >
			</td>
		</tr>
	</tbody>
	<?php endforeach;?>
	<?php endif;?>
		<tr class="tr-3">
			<td class="tablerow1" colspan="3" align="right" id="pagecode">
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
		 </td>
		</tr>
		<?php if($this->list):?>
		<tr class="tr-3">
			<td class="tablerow2" align="center" colspan="3">
				<input type="hidden" name="id" value="<?php echo $this->id;?>" />
				<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
			</td>
		</tr>
		<?php endif;?>
	</table>
</form>