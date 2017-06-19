<div class="grow gmt60 nuts-page">
    <?php echo $this->settingright($this->id);?>
    <div class="main gspan-21">
        <div class="main-title">
            <h1>"<?php echo $this->info['name']?>"小组管理</h1>
        </div>
        <ul class="gtabs gclear">
		<?php if($this->isCreator):?>
			<li><a href="<?php echo $this->url("setting/index/id/".$this->id,"group");?>">基本设置</a></li>
		<?php endif;?>
            <li>成员管理</li>
        </ul>
     <ul class="nut_list gpack" id="followNuts">
            <?php if($this->list):?>
            <?php foreach($this->list as $v):?>
            <li class="nut">
                <div class="nut-options">
                    <a href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>">
                    <img src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['id'],48);?>" width="48" height="48">
                    </a>
                    <?php if($v['user_type'] !=10):?>
                    <span id="span<?php echo $v['id']?>">
					<?php if($this->isCreator):?>
					<?php if($v['user_type'] == 9):?>
					<a onclick="cancelmg('<?php echo $v['id']?>')"  href="javascript: void 0;">取消管理员</a>
					<?php else:?>
					<a href="javascript:void 0 " class="pop" rel="groupsettingmenu<?php echo $v['id']?>">管理<span class="tri">▼</span></a>
					<?php endif;?>
					<?php else:?>
					 <?php if($v['user_type'] == 9):?>
					 管理员
					 <?php else:?>
					<a href="javascript:void 0 " class="pop" rel="groupsettingmenu<?php echo $v['id']?>">管理<span class="tri">▼</span></a>
                    <?php endif;?>
					<?php endif;?>
                   
                	</span>
                	<?php else:?>
                	创始人
                	<?php endif;?>
                </div>
                <div class="nut-desc">
                    <p><a href="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['id'],48);?>"><?php echo $v['nickname']?></a><span>
                    <?php echo $v['to_follow_count']?>人关注</span></p>
                    <?php echo $v['post_num']?>篇小组帖子
                </div>
            </li>
              
            <?php endforeach;?>
            <?php endif;?>
          
            
        </ul>
       <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "group");?>
    </div>
</div>
 <script>
 function follow(id){
	 ajax_get("<?php echo $this->url("setting/domg/gid/".$this->id."/id/");?>"+id,function(a){
			if(a.code != 200){
				falert(a.msg);
			}else{
				var str = "<a onclick=\"cancelmg("+id+")\"  href=\"javascript: void 0;\">取消管理员</a>";
				$("#span"+id).html(str);
			}
	});
}
 
 function cancelmg(id){
	 ajax_get("<?php echo $this->url("setting/docancelmg/gid/".$this->id."/id/");?>"+id,function(a){
			if(a.code != 200){
				falert(a.msg);
			}else{
				var str = "<a href=\"javascript:void 0 \"  class=\"pop\"  rel=\"groupsettingmenu"+id+"\">管理<span class=\"tri\">▼</span></a>";
				$("#span"+id).html(str);
				$(".pop").powerFloat();
			}
	});
}

 //剔除会员
 function removemember(id){
	 fconfirm("确认要剔除此会员?",function(){
		 ajax_get("<?php echo $this->url("setting/removemember/gid/".$this->id."/id/");?>"+id,function(a){
				if(a.code != 200){
					falert(a.msg);
				}else{
					location.reload();
				}
		});
	});
	
 }

 //屏蔽发言
 function shield(id){
	 fconfirm("确认要屏蔽此会员的发言?",function(){
		 ajax_get("<?php echo $this->url("setting/shutup/gid/".$this->id."/id/");?>"+id,function(a){
				if(a.code != 200){
					falert(a.msg);
				}else{
					location.reload();
				}
		});
	});
  }

 //取消屏蔽发言
 function unshield(id){
	 fconfirm("确认要屏蔽此会员的发言?",function(){
		 ajax_get("<?php echo $this->url("setting/unshutup/gid/".$this->id."/id/");?>"+id,function(a){
				if(a.code != 200){
					falert(a.msg);
				}else{
					location.reload();
				}
		});
	});
  }
 
	$(function(){
		$(".pop").powerFloat();
 	});
   </script>
<?php if($this->list):?>
<?php foreach($this->list as $v):?>
<div id="groupsettingmenu<?php echo $v['id']?>" class="popup">
<b><s>&nbsp;</s></b>
<ul>
<?php if($v['is_shutup']):?>
<li><a href="javascript:void 0;" onclick="unshield('<?php echo $v['id'];?>')">取消屏蔽发言</a></li>
<?php else:?>
<li><a href="javascript:void 0;" onclick="shield('<?php echo $v['id'];?>')">屏蔽发言</a></li>
<?php endif;?>
<li><a href="javascript:void 0;" onclick="removemember('<?php echo $v['id'];?>')">剔除会员</a></li>
<?php if($this->isCreator):?>
<li><a href="javascript:void 0;" onclick="follow('<?php echo $v['id'];?>')">设为管理员</a></li>
<?php endif;?>
</ul>
</div>
<?php endforeach;?>
<?php endif;?>