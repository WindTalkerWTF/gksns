<div class="grow   gmt60 group-index-page">
        <div class="main gspan-21 gsuffix-1">
            <div class="gbtitle">
                <div class="gfl gbtitle-info">
<a href="<?php echo $this->url("index/g/id/".$this->groupInfo['id']);?>" class="pt-pic">
<img src="<?php echo $this->img($this->groupInfo['face']."_48x48.jpg");?>" alt="我爱解谜" width="48" height="48" />
</a>
                    <div class="pt-txt">
          <h1><?php echo $this->groupInfo['name'];?></h1>
  <p id="memberCounter"><span><?php echo $this->groupInfo['user_number'];?></span>人加入此小组</p>
                    </div>
                </div>
                
                <div class="gfr gbtitle-btns" id="groupjoin">
                <?php if(!$this->isAdmin):?>
                	<?php if(!$this->isJoin):?>
                    <a href="javascript:void 0; " class="gbtn-ext" id="joinBt" onclick="join();"; >加入小组</a>
                    <?php else:?>
                     <a href="javascript:void 0; " id="canceljoinBt" onclick="quite();";>退出小组</a>
                    <?php endif;?>
                <?php else:?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
					<a href="javascript:void 0;" id="trigger" rel="groupsettingmenu" title="管理小组">管理小组</a>
                <?php endif;?>
                </div>
                
            </div>
            <div class="main-body">
				
                <h2>黑板报</h2>
                <div class="blackboard">
                    <div><?php echo $this->groupInfo['descr'];?></div>
                    <p class="blackboard-title">
                    
                        <span>组长</span>
                        <a href="<?php echo $this->url("/index/index/id/". $this->createrInfo['id'], "user");?>">
                        <?php echo $this->createrInfo['nickname']; ?>
                        </a>
                    </p>
				</div>
				

                <div class="main-title">
                    
                    <h2>帖子列表</h2>
                    <a href="<?php echo $this->url("/index/new/id/".$this->groupInfo['id']);?>" class="gbtn" id="newPost">发新帖</a>
                    
                </div>

                
                <ul class="gtabs">
                    <?php 
                    	if($this->t):
                    ?>
                    <li ><a href="<?php echo $this->url("/index/g/id/".$this->groupInfo['id']);?>">全部帖子</a></li>
                    <li class="gtabs-curr">精华区</li>
                    <?php 
                    	else:
                    ?>
                    <li class="gtabs-curr">全部帖子</li>
                    <li><a href="<?php echo $this->url("/index/g/id/".$this->groupInfo['id']."/t/1");?>">精华区</a></li>
                    <?php endif;?>
                    
                </ul>
                <ul class="titles">
                <?php if($this->list):?>
                <?php foreach ($this->list as $v):?>
                    <li>
                        <h3 class="titles-txt">
                        <a href="<?php echo $this->url("/index/view/id/". $v['id'], "group");?>" target="_blank">
                   <?php if($v['position'] != '0') echo "[精]";?>     <?php echo $v['title'];?>
                        </a>
                        </h3>
                        <div class="titles-r-grey"><?php echo $v['reply_count'];?><span class="titles-comment-icon"></span></div>
                        <p class="titles-b">
                        
                            <span class="titles-b-l">发表：
                            <a href="<?php echo $this->url("/index/index/id/". $v['user']['id'], "user");?>" target="_blank">
                            <?php echo $v['user']['nickname']; ?>
                            </a>
                            </span>
                            <?php if(($this->isAdmin || ($this->uid == $v['uid'])) && My_Tool::canAdmin($v['created_at'])):?>
                        	<span class="titles-a-l">
                        	
                        	<a class="alight" href="<?php echo $this->url("/index/edit/id/". $v['id'], "group");?>">
                        	编辑
                        	</a>
                        	<span class="split">|</span>
                        	<a class="alight" href="javascript:fconfirm('确认要删除吗?',function(){location.href='<?php echo $this->url
				("index/delete/id/".$v['id'],
					"group");?>'})">
                        	删除
                        	</a>
                        	<?php if($this->isAdmin):?>
                        	<span class="split">|</span>
                        	<?php if($v['position'] == '0'):?>
                        <a class="alight" onclick="recommendpost(<?php echo $v['id'];?>)" href="javascript:;">
                        	加精华
                        	</a>
                        	<?php else:?>
                        	<a class="alight" onclick="cancelrecommendpost(<?php echo $v['id'];?>)" href="javascript:;">
                        	取消精华
                        	</a>
                        	<?php endif;?>
                        	<?php endif;?>
                        	</span>
                        	<?php endif;?>
                        <span class="titles-b-r">
                            最后回应：<?php echo My_Tool::qtime(strtotime($v['last_action_at']))?>
                        </span>
                        </p>
                    </li>
                <?php endforeach;?>
                <?php endif;?>
                </ul>
	<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 			       
            </div>
        </div>

        <div class="side gspan-9 gsuffix-1">
            
            
            <div class="side-title"><h2>小组活跃成员</h2></div>
            <div class="gpack">
                <?php if($this->hotUser):?>
                <?php foreach($this->hotUser as $v):?>
                <dl class="gpack_u">
                    <dt>
                    <a title="<?php echo $v['nickname'];?>" href="<?php echo $this->url("index/index/id/".$v['uid'],"user");?>">
                    <img width="48" height="48" src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['uid'],48);?>">
                    </a>
                    </dt>
                    <dd class="gpack_u-n">
                    <p>
                    <a title="<?php echo $v['nickname'];?>" href="<?php echo $this->url("index/index/id/".$v['uid'],"user");?>"><?php echo $v['nickname'];?></a>
                    </p>
                    </dd>
                </dl>
                <?php endforeach;?>
                <?php endif;?>
            </div>
            
            <p class="side-back"><a href="<?php echo $this->url("index/members/id/".$this->groupInfo['id']);?>">所有小组成员&nbsp;&nbsp;&gt;</a></p>
            
            <div class="side-title">
                
                <h2>相关小组</h2>
                
            </div>
            <div id="groups">
                
                <ul class="side-groups ">
                <?php if($this->hotGroup):?>
                <?php foreach ($this->hotGroup as $v):?>
                    <li>
                        <a class="pt-pic" href="<?php echo $this->url("index/g/id/".$v['id']);?>" title="<?php echo $v['name'];?>" target="_blank">
                        <img width="48" height="48" src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['name'],48);?>" alt="<?php echo $v['name'];?>" hoverboxadded="true">
                        </a>
                        <div class="pt-txt">
                            <h3><a href="<?php echo $this->url("index/g/id/".$v['id']);?>" target="_blank"><?php echo $v['name'];?></a></h3>
                            <span><?php echo $v['user_number'];?>人加入</span>
                            <div class="pt-txt-d">
                                <p class="gellipsis">
							<?php echo $v['descr'];?>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php endforeach;?>
                <?php endif;?>
                </ul>
                
            </div>
        </div>
    </div>
    <script>
	function join(){
            ajax_get("<?php echo $this->url("index/join/id/".$this->groupInfo['id']);?>",function(a){
						if(a.code !=200){
							falert(a.msg);
						}else{
							var str = "<a href=\"javascript:void 0; \" onclick=\"quite()\" id=\"canceljoinBt\" >退出小组</a>";
							$("#groupjoin").html(str);
							var num = parseInt($("#memberCounter span").text());
							$("#memberCounter span").html(num+1);
						}
             });
    }

       function quite(){
           fconfirm("确认要退出吗?",function(){
        	   ajax_get("<?php echo $this->url("index/quite/id/".$this->groupInfo['id']);?>",function(a){
      				if(a.code !=200){
      					falert(a.msg);
      				}else{
      					var str = "<a href=\"javascript:void 0; \" class=\"gbtn-ext\"  onclick=\"join()\"  id=\"joinBt\">加入小组</a>";
      					$("#groupjoin").html(str);
      					var num = parseInt($("#memberCounter span").text());
      					$("#memberCounter span").html(num-1);
      				}
         			});
           });
           
		}
    </script>
    <?php if($this->isAdmin):?>
   <div id="groupsettingmenu" class="popup" tabindex="2">
   		<b><s>&nbsp;</s></b>
		<ul>
		<?php if($this->isCreator): ?>
		<li><a href="<?php echo $this->url("setting/index/id/".$this->groupInfo['id'], "group");?>">基本设置</a></li>
		<?php endif;?>
		<li><a href="<?php echo $this->url("setting/mg/id/".$this->groupInfo['id'], "group");?>">成员管理</a></li>
		</ul>
 		</div>
 	<script>
 		$(function(){
 			$("#trigger").powerFloat();
 	 	});
 	</script>
 	<?php endif;?>
<script>
function recommendpost(id){
	ajax_post("<?php echo My_Tool::url("index/recommendpost","group"); ?>",{id:id},function(a){
		if(a.code==200){
			location.reload();
		}else{
			falert(a.msg);
		}
	});
}

function cancelrecommendpost(id){
	ajax_post("<?php echo My_Tool::url("index/cancelrecommendpost","group"); ?>",{id:id},function(a){
		if(a.code==200){
			location.reload();
		}else{
			falert(a.msg);
		}
	});
}
</script>