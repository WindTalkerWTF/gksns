<?php 
	echo $this->cplace("角色设定");
?>
<form name="frm" method="post" action="<?php echo $this->url('/sys/master-role');?>">
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
		<tr class="tr-1">
		<td class="tablerow1 tablerow" noWrap="noWrap">角色名称列表</td>
	</tr>
	<?php if($this->list):?>
	<?php foreach($this->list as $k=>$v):?>
	<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<i id="toggle_1" class="tdline1 tdlast" ></i>
		<input type="checkbox" name="roleids[]" value="<?php echo $v['id'];?>"
			<?php if(in_array($v['id'], $this->ids)) echo "checked";?> 
		 >
		<?php echo $v['name'];?>
		</td>
	</tr>
	<?php endforeach;?>
	<?php endif;?>
		<tr class="tr-3">
			<td class="tablerow2" align="center" colspan="2">
				<input type="hidden" name="id" value="<?php echo $this->id;?>" />
				<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">提 交</button>
			</td>
		</tr>
	</table>
</form>