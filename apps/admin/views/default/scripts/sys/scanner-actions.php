<?php 
	echo $this->cplace("节点扫描");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="<?php echo $this->url("/sys/actions");?>" onfocus="this.blur()">后台节点管理</a></li>
		<li><a href="<?php echo $this->url("/sys/app-actions");?>" onfocus="this.blur()">App节点管理</a></li>
		<li  class="active"><a href="<?php echo $this->url("/sys/scanner-actions");?>" onfocus="this.blur()">扫描节点</a></li>
	</ul>
</div>
<div style="clear: both"></div>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
<tr class="tr-3">
	<td class="tablerow1" colspan="5" align="left" id="showpage">
	<input type="button" id="btn" class="btnsubmit" value="开始扫描"/>
	</td>
</tr>
</table>
<script>
	$(function(){
		$("#btn").click(function(){
			 var $loadContainer = $('.tablerow1');
             $loadContainer.fadeTo('fast', 0).loading({
                 'loadingClass': 'loading',
                 'loadingContent': '正在扫描...,(您也可以关闭此页面，程序将在后台运行)'
             });
			$.post("<?php echo $this->url('/sys/scanner-actions');?>", {}, function(a){
				if(a.code == '200'){
					$loadContainer.html('扫描完成.').fadeTo('fast', 1).loading({'stop': true});
				}else{
					$loadContainer.html('扫描失败:'+a.msg+'').fadeTo('fast', 1).loading({'stop': true});
				}
			}, "json");
		});
	});
</script>