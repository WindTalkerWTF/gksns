<?php 
	echo $this->cplace("app列表");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li  class="active"><a href="<?php echo $this->url("/app/list");?>" onfocus="this.blur()">app列表</a></li>
		<li><a href="<?php echo $this->url("/app/index");?>" onfocus="this.blur()">创建app</a></li>
		<li><a href="<?php echo $this->url("/app/export");?>" onfocus="this.blur()">导出app</a></li>
		<li><a href="<?php echo $this->url("/app/import");?>" onfocus="this.blur()">导入app</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
		<tr class="tr-1">
		<td class="tablerow1 tablerow" width="30%" noWrap="noWrap">App名称</td>
		<td class="tablerow1 tablerow" width="20%">AppID</td>
		<td class="tablerow1 tablerow" width="20%">模板</td>
		<td class="tablerow1 tablerow" width="10%">状态</td>
		<td class="tablerow1 tablerow">操作</td>
	</tr>
	<?php if($this->list):?>
	<?php foreach($this->list as $k=>$v):?>
	<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['view_name'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php echo $v['name'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<select name="tpl" id="tpl" app_name="<?php echo $v['name'];?>"  onchange="changetpl('<?php echo $v['name'];?>',this)">
			<?php foreach ($v['all_tpl'] as $tplv):?>
<option value="<?php echo $tplv; ?>" <?php echo $tplv == $v['tpl'] ? "selected" : "";?>><?php echo $tplv; ?></option>
			<?php endforeach;?>
				</select>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php echo $v['state'] ? "开启":"关闭"; ?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<a href="<?php echo $this->url("app/opener/id/" . $v['id']);?>"><strong><?php echo !$v['state'] ? "开启":"关闭"; ?></strong></a> | 
		<a href="javascript:if(confirm('确认卸载吗')){ location.href='<?php echo $this->url("app/delete/id/" . $v['id']);?>';}"><strong>卸载</strong></a>
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
	<script>
	  //js开始    
	function changetpl(name,obj){
		var tpl = $(obj).find("option:selected").val();
		ajax_post("<?php echo $this->url("app/savetpl","admin"); ?>",{name:name,tpl:tpl},function(a){
			if(a.code == 500){
				falert(a.msg);
			}else{
				location.assign(location);
			}
		});
	}
	</script>