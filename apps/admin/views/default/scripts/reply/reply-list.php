<?php
echo $this->cplace("评论管理");
?>
<script>
function unlock(id){
	if(id){
		ajax_get("<?php echo My_Tool::url("reply/reply-publish"); ?>/id/"+id, function(a){
			if(a.code=='200'){
				location.href=location.href;
			}else{
				falert(a.msg);
			}
		});
	}
}


function lock(id){
	if(id){
		ajax_get("<?php echo My_Tool::url("reply/reply-nopublish"); ?>/id/"+id, function(a){
			if(a.code=='200'){
				location.href=location.href;
			}else{
				falert(a.msg);
			}
		});
	}
}

</script>
<div class="tab-box">
	<ul id="nav_tabs">
		<li class="active"><a href="<?php echo $this->url("reply/reply-list/id/". $this->id);?>" >内容列表</a></li>
	</ul>
</div>
<form name="ss" method="get" action="<?php echo $this->url("reply/reply-list");?>" >
	<div class="row-fluid">
  		    <div class="span3">
                    <div class="control-group">
              				<label class="control-label" for="inputEmail">内容</label>
			              <div class="controls">
			                <input type="text" id="content" name="content" value="<?php echo $this->content ? $this->content : '';?>" >
			              </div>
            		</div>
            </div>
            <div class="span3">
                    <div class="control-group">
              				<label class="control-label" for="inputEmail">状态</label>
			              <div class="controls">
			                <select name="is_publish">
			                	<option value="-1" <?php echo $this->is_publish == '-1' ? "selected":"";?>>全部</option>
			                	<option value="0" <?php echo $this->is_publish == '0' ? "selected":"";?>>系统锁定</option>
			                	<option value="1" <?php echo $this->is_publish == '1' ? "selected":"";?>>管理员锁定</option>
			                	<option value="2" <?php echo $this->is_publish == '2' ? "selected":"";?>>已发布</option>
			                </select>
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
		<td class="tablerow1 tablerow" width="5%" noWrap="noWrap">
		选择
		</td>
		<td class="tablerow1 tablerow" width="5%" noWrap="noWrap">#</td>
		<td class="tablerow1 tablerow" width="50%" noWrap="noWrap">内容</td>
		<td class="tablerow1 tablerow" width="5%" noWrap="noWrap">原文</td>
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
			<?php echo $v['content'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<a href="<?php echo $this->url("index/view/id/".$v['ref_id'],$v["arc_type"]);?>"  target="_blank"  ><i class="icon-eye-open"></i></a>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
		<?php 
			if($v['is_publish'] ==2 ):
		?>
			<a href="javascript:void(0);" onclick="lock('<?php echo $v['id']; ?>')" >已发布</a>
		<?php elseif($v['is_publish'] ==1):?>
			<a href="javascript:void(0);"  onclick="unlock('<?php echo $v['id']; ?>')" >管理员锁定</a>
		<?php else:?>
			<a href="javascript:void(0);"  onclick="unlock('<?php echo $v['id']; ?>')" >系统锁定</a>
		<?php 
		endif;
		?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
			<?php echo $v['updated_at'];?>
		</td>
		<td class="tablerow<?php echo $k%2==0 ? 1:2?> tdborder">
<a  title="删除"
 href="javascript:if(confirm('确认删除吗')){ location.href='<?php echo $this->url("reply/reply-deletes/ids/" . $v['id']);?>';}"
 ><i class="icon-trash"></i>
 </a>
		</td>
	</tr>
	<?php endforeach;?>
	<tr class="tr-3">
		<td class="tablerow1" colspan="7">
			<input type="button" class="btn" value="全选" id="chooseAll">&nbsp;&nbsp;
			<input type="button" class="btn" value="发布" id="publish">&nbsp;&nbsp;
			<input type="button" class="btn" value="锁定" id="noPublish">&nbsp;&nbsp;
			<input type="button" class="btn" value="删除" id="deleteChoose">&nbsp;&nbsp;
		</td>
	</tr>
	<?php endif;?>
		<tr class="tr-3">
			<td class="tablerow1" colspan="7" align="right" id="pagecode">
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "admin");?>
		 </td>
		</tr>
</table>
<script>
$(function(){
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
		ajax_get("<?php echo My_Tool::url("reply/reply-deletes"); ?>/ids/"+ids, function(a){
			if(a.code==200){
				location.reload();
			}else{
				falert(a.msg);
			}
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
		ajax_get("<?php echo My_Tool::url("reply/reply-publish"); ?>/id/"+ids, function(a){
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
		ajax_get("<?php echo My_Tool::url("reply/reply-nopublish"); ?>/id/"+ids, function(a){
			if(a.code==200){
				location.reload();
			}else{
				falert(a.msg);
			}
		});
	});

	$("#chooseAll").click(function(){
		$('input[name="ids[]"]').each(function(){
			$(this).attr("checked", true);
		});
	});
	
});
</script>
