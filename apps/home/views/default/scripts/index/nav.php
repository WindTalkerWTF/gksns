<div class="gheader-new">
    <div class="gh-wrap">
        <div class="gfl">
            <ul class="gh-nav">        
<li>
<a href="/"><span class="gnicon-home"></span><?php echo getSysData('site.config.siteName')?><b></b></a>
</li>
<li>
<a href="<?php echo $this->url("/index/index", "video");?>">视频<b></b></a>
</li>
<li>
<a href="<?php echo $this->url("/index/index", "site");?>">博客<b></b></a>
</li>
<li>
<a href="<?php echo $this->url("/index/all-view", "group");?>">小组<b class="gnarrow-up"></b></a>
</li>            
<li>
<a href="<?php echo $this->url("/index/index", "ask");?>">问答<b></b></a>
</li>
<li>
<a href="<?php echo $this->url("/index/daren", "user");?>">达人<b></b></a>
</li>
 </ul>
            <form action="<?php echo $this->url("index/index", "search");?>" method="get" id="search" class="gh-search">
                <p id="searchBox">
                    <input type="text" value="" maxlength="30" name="wd" class="gh-search-txt" id="searchTxt" placeholder="">
                    <input type="submit" value="搜索" class="gnicon-search">
                </p>
            </form>
<>      
 </div>
        
    
    <?php if(!$this->user):?>
    <div class="gh-login">
        	
        <a href="<?php echo $this->url("index/login", "user");?>">登录</a>
        <span class="split">|</span>
        <a href="<?php echo $this->url("index/reg", "user");?>">注册</a>
        <span class="split">|</span>
        <span style="color:#D0D0D0">联合登录：</span>
        <a href="<?php echo $this->url("qqlogin/do","user");?>" class="gcion_qq" title="用QQ帐号登录">&nbsp;&nbsp;</a>
        
    </div>
    <?php else:?>
        <ul class="gh-notice">
        <li>
            <a class="gh-i-me" title="<?php echo $this->user['nickname'];?>" href="<?php echo $this->url("index/index", "user");?>">
   <img width="24" height="24" src="<?php echo My_Tool::getFace($this->user['face'])?>">
               <?php echo $this->user['nickname'];?>
            </a>
        </li>
        <li id="gheaderNotice" class="">
            <a class="gh-i-notice" href="javascript:void 0;">
                <span class="gnicon-notice gfl"></span>
                <span id="noticeNum" class="gh-i-num">0</span>
            </a>
            <div style="display: none;" id="noticeBlock" class="gh-notice-panel">
                <div class="notice-content">
                    <div class="gh-i-popup-category">
                        <span class="gfl">通知</span>
                        <a class="gfr" href="<?php echo $this->url("index/notice", "msg");?>">全部通知</a>
                    </div>
                    <ul class="notice-list" id="notice-list"></ul>
                </div>
            </div>
        </li>
        <li id="gheaderRemind" class="">
            <a class="gh-i-remind" href="javascript:void 0;">
                <span class="gnicon-msg gfl"></span>
                <span id="totleNum" class="gh-i-num unread">0</span>
            </a>
            <div style="display:none" id="remindBlock" class="gh-remind-panel">
                <div class="remind-content">
                   <div class="gh-i-popup-category gh-msg-title">
                        <span class="gfl">站内信</span>
                        <a class="gfr" href="<?php echo $this->url("index/index", "msg");?>">全部站内信</a>
                    </div>
                    <ul class="remind-list" id="remind-list">
                    </ul>
                </div>
            </div>
        </li>
        <li id="gheaderSettings">
            <a class="gh-i-settings" href="javascript:void 0;">
                <span class="gnicon-set"></span>

            </a>
            <div id="settingsBlock" style="display:none;" class="gh-list">
                <ul>
                    <li><a href="<?php echo $this->url("setting/index", "user");?>">设置</a></li>
                    <li><a href="<?php echo $this->url("index/logout", "user");?>">退出</a></li>
                </ul>
            </div>
        </li>
   </ul>
    <?php endif;?>

    </div>
</div>
<script>
function getNotice(){
	ajax_get("<?php echo $this->url("index/getnotice","msg");?>", function(a){
			if(a.code==200){
				var list = a.msg['list'];
				var count = a.msg['count'];
				var str = "";
				$("#noticeNum").html(count);
				if(count >0){
				    $("#gheaderNotice").addClass("unread");
				}else{
					$("#gheaderNotice").removeClass("unread");
				}
				if(list){
					for(x in list){
str += "<li><p><a href=\""+list[x]['format_url']+"\" onclick=\"markNoticeRead("+list[x]['id']+")\" target=\"_blank\">"+list[x]['feed_title']+"</a></p></li>";
					}
					$("#notice-list").html(str);
				}else{
	
					$("#notice-list").html('');
				}
			}
		});
}

getNotice();
setInterval("getNotice()", 60000);

//消息
function getRemind(){
	ajax_get("<?php echo $this->url("index/getremind","msg");?>", function(a){
		if(a.code==200){
			var list = a.msg['list'];
			var count = a.msg['count'];
			var str = "";
			if(count >=0){
			    $("#gheaderRemind").addClass("unread");
			}else{
				$("#gheaderRemind").addClass("");
			}
			$("#totleNum").html(a.msg['count']);
			if(list){
				for(x in list){
str += "<li><p><a href=\""+list[x]['url']+"\"  target=\"_blank\">\""+list[x]['user']['nickname']+"\"给你发了一个消息</a></p></li>";
				}
				$("#remind-list").html(str);
			}else{
				$("#remind-list").html('');
			}
		}
	});
}
getRemind();
setInterval("getRemind()", 60000);


$(function(){
	//通知
	$("#gheaderNotice").hover(
			  function () {
				  $("#gheaderNotice").addClass("gactived");
					$("#noticeBlock").show();
			  },
			  function () {
				  $("#gheaderNotice").removeClass("gactived");
				$("#noticeBlock").hide();
			  }
	);
	
	//短信
	$("#gheaderRemind").hover(
			  function () {
				  $("#gheaderRemind").addClass("gactived");
					$("#remindBlock").show();
			  },
			  function () {
				  $("#gheaderRemind").removeClass("gactived");
					$("#remindBlock").hide();
			  }
	);
	
	//设置
	$("#gheaderSettings").hover(
			  function () {
				  $("#gheaderSettings").addClass("gactived");
					$("#settingsBlock").show();
			  },
			  function () {
				  $("#gheaderSettings").removeClass("gactived");
					$("#settingsBlock").hide();
			  }
	);
});

</script>