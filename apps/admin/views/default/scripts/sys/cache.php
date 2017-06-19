<?php 
	echo $this->cplace("清空缓存");
?>
<form name="export" method="post" action="<?php echo My_Tool::url("/sys/cache")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
<caption>清空缓存</caption>
<tr class="tr-3">
	<td class="tablerow1" colspan="5" align="left" id="showpage">
	<input type="submit" id="btn" class="btnsubmit" value="清空"/>
	</td>
</tr>
</table>
</form>