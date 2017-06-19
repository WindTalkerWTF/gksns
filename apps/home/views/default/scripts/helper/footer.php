 <div class="gbottom gclear">
    <div class="gbottom-nav">
        <a href="<?php echo $this->url("index/view/id/".getSysData('site.config.aboutme.id'),"group");?>">关于我们</a>
        <a href="<?php echo $this->url("tag/view/t/".getSysData('site.config.ask.helptag.id'),"ask");?>">帮助中心</a>
        <a href="<?php echo $this->url("index/view/id/".getSysData('site.config.relief.id'),"group");?>">免责声明</a>
        <h3><?php echo $this->url("index/view/id/".getSysData('site.config.linkman.id'),"group");?></h3>
        <a href="<?php echo $this->url("index/view/id/".getSysData('site.config.linkman.id'),"group");?>">联系我们</a>
    </div>
    <div class="gbottom-i">
   	 沪ICP备13025709号-1&nbsp;&nbsp;
	©2013<?php echo getSysData('site.config.siteName');?>&nbsp;
	运行时间：<?php echo My_Init::getInstance()->getTime()."秒"; ?>
	-- <a href="http://www.gk.com">Powered by gk.com</a>
	</div>
</div>
<script type="text/javascript">
function markNoticeRead(id){
	ajax_get("<?php echo $this->url("index/marknoticeread/id/","msg")?>"+id,function(a){
		if(a.code == '200'){
			  $("#li_"+id).removeClass("unread");
			  getNotice();
		  }
	});
}

$(function (){
    prettyPrint();
});
</script>
<?php echo $this->baiduStat;?>
<?php echo $this->cnzzStat;?>