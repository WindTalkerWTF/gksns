<?php 
	echo $this->cplace("角色节点管理");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li <?php echo $this->t==1 ? "class=\"active\"": "";?> ><a href="<?php echo $this->url("/sys/role-actions/t/1");?>" onfocus="this.blur()">后台节点</a></li>
		<li  <?php echo $this->t==2 ? "class=\"active\"": "";?> ><a href="<?php echo $this->url("/sys/role-actions/t/2");?>" onfocus="this.blur()">App节点</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
		<tr class="tr-1">
		<td class="tablerow1 tablerow" width="20%" noWrap="noWrap">App名称</td>
		<td class="tablerow1 tablerow" width="30%">AppID</td>
	</tr>
	<?php if($this->t == 2):?>
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
		</tr>
		<tbody id="groupbody_1">
		<?php foreach($v['actions'] as $kv=>$av): ?>
			<tr class="tr-<?php echo $kv%2==0 ? 1:2?>">
				<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
		<i class="tdline1 tdlast"></i>
		<input type="checkbox" name="actionids[]" value="<?php echo $av['id'];?>" 
		<?php if(in_array($av['id'], $this->ids)) echo "checked";?>  
		>
		<?php echo $av['name'];?>
				</td>
				<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
				<span class="span-input"><?php echo $av['path'];?></span>&nbsp;
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	<?php endforeach;?>
	<?php endif;?>
	<?php else:?>
		<tr class="tr-1">
			<td class="tablerow1 tdborder">
			<i id="toggle_1" class="toggle hide-icon" ></i>
			后台
			</td>
			<td class="tablerow1 tdborder">
			admin
			</td>
		</tr>
		<?php if($this->list):?>
		<tbody id="groupbody_1">
		<?php foreach($this->list as $kv=>$av): ?>
			<tr class="tr-<?php echo $kv%2==0 ? 1:2?>">
				<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
		<i class="tdline1 tdlast"></i>
		<input type="checkbox" name="actionids[]" value="<?php echo $av['id'];?>" 
		<?php if(in_array($av['id'], $this->ids)) echo "checked";?>  
		>
		<?php echo $av['name'];?>
				</td>
				<td class="tablerow<?php echo $kv%2==0 ? 1:2?> tdborder">
				<span class="span-input"><?php echo $av['path'];?></span>&nbsp;
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
		<?php endif;?>
	<?php endif;?>	
		<tr class="tr-3">
			<td class="tablerow1" colspan="2" align="right" id="pagecode">
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
		 </td>
		</tr>
		<tr class="tr-3">
			<td class="tablerow2" align="center" colspan="2">
				<input type="hidden" name="id" id="id" value="<?php echo $this->id;?>" />
			</td>
		</tr>
	</table>
	<script>
	  //js开始    
	$(function(){
		$("input[type='checkbox']").each(function(i){
			$(this).click(function(){
				var aid = $(this).val();
				var rid = $("#id").val();
				if(!$(this).attr("checked")){
					$.post("<?php echo $this->url("sys/delete-role-action","admin");?>",{aid:aid, rid:rid},function(){},"json");
				}else{
					$.post("<?php echo $this->url("sys/add-role-action","admin");?>",{aid:aid, rid:rid},function(){},"json");
				}
			});
		});
	})
	</script>