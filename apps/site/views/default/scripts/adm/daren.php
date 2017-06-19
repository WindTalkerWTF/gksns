<?php
echo $this->cplace("达人管理");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("adm/daren");?>" >达人列表</a></li>
	</ul>
</div>
<form name="ss" action="<?php echo $this->url("adm/daren");?>" >
<div class="row-fluid">
            <div class="span3">
                    <div class="control-group">
              		<label class="control-label" for="inputEmail">达人栏目</label>
			              <div class="controls">
		<select name="id">
		<option value="-1" <?php echo $this->id == '-1' ? "selected" : "";?>>全部</option>
		<?php 
			if($this->treeList):
		?>
		<?php foreach ($this->treeList as $k=>$v):?>
			<option value="<?php echo $k;?>" <?php echo $this->id == $k ? "selected" : "";?> ><?php echo $v;?>[<?php echo $k;?>]</option>
		<?php endforeach;?>
		<?php endif;?>
		</select>
			              </div>
            		</div>
            </div>
  		    <div class="span3">
                    <div class="control-group">
              				<label class="control-label" for="inputEmail">会员昵称</label>
			              <div class="controls">
			                <input type="text" id="nickname" name="nickname" value="<?php echo $this->nickname ? $this->nickname : '';?>" >
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
		<td class="tablerow1 tablerow" width="10%" noWrap="noWrap">昵称</td>
		<td class="tablerow1 tablerow" width="60%" noWrap="noWrap">达人头衔</td>
		<td class="tablerow1 tablerow">达人栏目id(以逗号隔开)</td>
	</tr>
		<?php if($this->list):?>
	<?php foreach($this->list as $k=>$v):?>
	<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['id'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['nickname'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php if($v['darenTreeInfo']):
			      $k=0;
			?>
			<?php foreach($v['darenTreeInfo'] as $dk=>$dv):?>
			<?php if($k !=0 ) echo ",";?>
			<?php echo $dv;?>[<?php echo $dk;?>]
			<?php $k++;?>
			<?php endforeach;?>
			<?php endif;?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<input type="text" name="daren" id="daren" value="<?php echo trim($v['daren_tree'],",");?>" data-id=<?php echo $v['id'];?> onblur="updateDaren(this)">
		</td>
	</tr>
	<?php endforeach;?>
	<?php endif;?>
		<tr class="tr-3">
			<td class="tablerow1" colspan="4" align="right" id="pagecode">
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
		 </td>
		</tr>
</table>
<script>
var publishUrl = "<?php echo My_Tool::url("adm/publish"); ?>";
var nopublishUrl =  "<?php echo My_Tool::url("adm/nopublish"); ?>";
var deletesUrl =  "<?php echo My_Tool::url("adm/deletes"); ?>";
//js开始    
$(function(){

	$("#chooseAll").click(function(){
		$('input[name="ids[]"]').each(function(){
			$(this).attr("checked", true);
		});
	});
});

function updateDaren(obj){
	var vl = $.trim($(obj).val());
	var id = $(obj).attr("data-id");
	if(vl){
		ajax_post("<?php echo $this->url("Adm/update-daren");?>",{vl:vl,id:id},function(a){
				if(a.code == 500){
					falert(a.msg);
				}else{
					location.reload();	
				}
		});
	}
}
</script>
