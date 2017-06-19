<?php
echo $this->cplace("内容管理");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("adm/content-list/id/". $this->id);?>" >内容列表</a></li>
		<!--<li><a href="<?php echo $this->url("adm/content-add/id/" . $this->id);?>">内容添加</a></li>-->
	</ul>
</div>
<form name="ss" action="<?php echo $this->url("adm/content-list");?>" >
<div class="row-fluid">
            <div class="span3">
                    <div class="control-group">
              		<label class="control-label" for="inputEmail">栏目</label>
			              <div class="controls">
		<select name="id">
		<option value="-1" <?php echo $this->id == '-1' ? "selected" : "";?>>全部</option>
		<?php 
			if($this->treeList):
		?>
		<?php foreach ($this->treeList as $v):?>
			<option value="<?php echo $v['id'];?>" <?php echo $this->id == $v['id'] ? "selected" : "";?> ><?php echo $v['name'];?></option>
		<?php endforeach;?>
		<?php endif;?>
		</select>
			              </div>
            		</div>
            </div>
  		    <div class="span3">
                    <div class="control-group">
              				<label class="control-label" for="inputEmail">标题</label>
			              <div class="controls">
			                <input type="text" id="title" name="title" value="<?php echo $this->title ? $this->title : '';?>" >
			              </div>
            		</div>
            </div>
            <div class="span3">
                    <div class="control-group">
              				<label class="control-label" for="inputEmail">状态</label>
			              <div class="controls">
			                <select name="is_publish">
			                	<option value="-1" <?php echo $this->is_publish == '-1' ? "selected":"";?>>全部</option>
			                	<option value="1" <?php echo $this->is_publish == '1' ? "selected":"";?>>已发布</option>
			                	<option value="0" <?php echo $this->is_publish == '0' ? "selected":"";?>>屏蔽</option>
			                </select>
			              </div>
            		</div>
            </div>
</div>

<div class="control-group">
            <div class="controls">
                <input type="hidden" name="page" value="1">
                <button name="btnSubmit" class="btn btn-primary" type="submit">查询</button>
            </div>
</div>
</form>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
	<tr>
		<td class="tablerow1 tablerow" width="5%" noWrap="noWrap">
		选择
		</td>
		<td class="tablerow1 tablerow" width="5%" noWrap="noWrap">#</td>
		<td class="tablerow1 tablerow" width="10%" noWrap="noWrap">栏目</td>
		<td class="tablerow1 tablerow" width="15%" noWrap="noWrap">推荐</td>
		<td class="tablerow1 tablerow" width="30%" noWrap="noWrap">标题</td>
		<td class="tablerow1 tablerow" width="5%">状态</td>
		<td class="tablerow1 tablerow" width="15%">更新时间</td>
		<td class="tablerow1 tablerow">操作</td>
	</tr>
		<?php if($this->list):?>
	<?php foreach($this->list as $k=>$v):?>
	<tr class="tr-<?php echo $k%2==0 ? 1:2?>">
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<input type="checkbox" name="ids[]" value="<?php echo $v['id'];?>" >
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php echo $v['id'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<select id="listId<?php echo $v['id'];?>" onchange="selectTree('<?php echo $v['id'];?>')"  style="width:100px;">
		<option value="-1" <?php echo $this->id == '-1' ? "selected" : "";?>>未选择</option>
		<?php 
			if($this->treeList):
		?>
		<?php foreach ($this->treeList as $tv):?>
			<option value="<?php echo $tv['id'];?>" <?php echo $v['tree_id'] == $tv['id'] ? "selected" : "";?> ><?php echo $tv['name'];?></option>
		<?php endforeach;?>
		<?php endif;?>
		</select>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
<input type="checkbox" name="position_index"  onclick="recommend(this,<?php echo $v['id'];?>,1)" value="1" <?php echo in_array(1, $v['p']) ? "checked":"";?>>&nbsp;&nbsp;首页推荐
&nbsp;&nbsp;
<input type="checkbox" name="position_tree"  onclick="recommend(this,<?php echo $v['id'];?>,2)" value="2"  <?php echo in_array(2, $v['p']) ? "checked":"";?>>&nbsp;&nbsp;栏目推荐
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<a href="<?php echo $this->url("adm/content-edit/id/" . $v['id']);?>" title="编辑" ><?php echo $v['title'];?></a>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php 
			if($v['is_publish']):
		?>
			<i class="icon-ok"></i>
		<?php else:?>
			<i class="icon-remove"></i>
		<?php 
		endif;
		?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php echo $v['updated_at'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
<a href="<?php echo $this->url("index/view/id/" . $v['id']);?>" target="_blank"><i class="icon-eye-open"></i></a>
<a href="<?php echo $this->url("adm/content-edit/id/" . $v['id']);?>" title="编辑" >
<i class="icon-pencil"></i></a>
<a  title="删除"
 href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("adm/content-delete/id/" . $v['id']);?>';}"
 ><i class="icon-trash"></i>
 </a>
		</td>
	</tr>
	<?php endforeach;?>
	<tr class="tr-3">
		<td class="tablerow1" colspan="9">
			<input type="button" class="btn" value="全选" id="chooseAll">&nbsp;&nbsp;
			<input type="button" class="btn" value="发布" id="publish">&nbsp;&nbsp;
			<input type="button" class="btn" value="屏蔽" id="noPublish">&nbsp;&nbsp;
			<input type="button" class="btn" value="删除" id="deleteChoose">&nbsp;&nbsp;
		</td>
	</tr>
	<?php endif;?>
		<tr class="tr-3">
			<td class="tablerow1" colspan="100%" align="right" id="pagecode">
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
		 </td>
		</tr>
</table>
<script>
var publishUrl = "<?php echo My_Tool::url("adm/publish"); ?>";
var nopublishUrl =  "<?php echo My_Tool::url("adm/nopublish"); ?>";
var deletesUrl =  "<?php echo My_Tool::url("adm/deletes"); ?>";

function selectTree(id){
	
	if(id){
		var treeId = $("#listId"+id+" option:selected").val();
		if(treeId>0){
		ajax_post("<?php echo My_Tool::url("adm/select-tree");?>",{id:id,treeId:treeId},function(a){
					if(a.code == 500){
						falert(a.msg);
					}
			});
		}
	}
}

function recommend(obj,id,vl){
	var isAdd = 1;
    if(!$(obj).is(":checked")) {
    	isAdd = 0;
    }
	if(id){
		ajax_post("<?php echo My_Tool::url("adm/recommend");?>",{id:id,vl:vl,isAdd:isAdd},function(a){
					if(a.code == 500){
						falert(a.msg);
					}
			});
	} 
}
//js开始    
$(function(){

	$("#chooseAll").click(function(){
		$('input[name="ids[]"]').each(function(){
			$(this).attr("checked", true);
		});
	});
	
	$("#publish").click(function(){
		var ids = "";
		$("input[name='ids[]']").each(function(){ 
			if($(this).attr("checked") == "checked"){
				ids+=$(this).val()+","; 
			}
	     }) 
	     if(!ids){ falert("请选择一个内容");return false;}
		ajax_get(publishUrl+"/ids/"+ids, function(a){
			if(a.code==200){
				location.reload();
			}else{
				falert(a.msg);
			}
		});
	});
	
	$("#noPublish").click(function(){
		var ids = "";
		$("input[name='ids[]']").each(function(){ 
			if($(this).attr("checked") == "checked"){
				ids+=$(this).val()+","; 
			}
	     }) 

	     if(!ids){ falert("请选择一个内容");return false;}
		ajax_get(nopublishUrl+"/ids/"+ids, function(a){
			if(a.code==200){
				location.reload();
			}else{
				falert(a.msg);
			}
		});
	});
	
	$("#deleteChoose").click(function(){
		if(!confirm("确认要删除吗?")){
			return false;
		 }
		var ids = "";
		$("input[name='ids[]']").each(function(){ 
			if($(this).attr("checked") == "checked"){
				ids+=$(this).val()+","; 
			}
	     }) 
	     if(!ids){ falert("请选择一个内容");return false;}
		ajax_get(deletesUrl+"/ids/"+ids, function(a){
			if(a.code==200){
				location.reload();
			}else{
				falert(a.msg);
			}
		});
	});
	
});
</script>
