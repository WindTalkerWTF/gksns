<div class="grow gmt60 tag-square-page">
    <div class="side gspan-10 gprefix-1">
        <form id="tagSearch" action="<?php echo $this->url("index/tag","search");?>" class="gsearch" method="get">
            <p>
            <input id="q" type="text" class="gsearch-txt" name="wd" maxlength="10" placeholder="搜索标签" />
            <input type="submit" value="搜索" class="gsearch-bt gicon-search" />
            </p>
        </form>
                <div class="side-title">
            <h2>近期活跃用户</h2>
        </div>
        <ul class="side-users">
          <?php if($this->arcInfo):?>
       <?php foreach($this->arcInfo as $v ):?>
            <li>
                <a href="<?php echo $this->url("index/index/id/".$v['user']['id'], "user");?>">
      <img src="<?php echo My_Tool::getFace($v['user']['face'],24);?>" width="24" height="24"><?php echo $v['user']['nickname'];?>
      			</a><?php echo $this->cut($v['user']['sign'],18);?>
            </li>
       <?php endforeach;?>
       <?php endif;?>
        </ul>
    </div>
    <div class="main gspan-21">
        <div class="main-title">
            <div class="main-title">
                <h1>标签广场</h1>
            </div>
            <ul class="gtabs">    
     <?php 
    	if(!$this->t):
    ?>
    <li class="gtabs-curr">热门标签</li>
    <?php else:?>
    <li><a href="<?php echo $this->url("tag/index");?>">热门标签</a></li>
    <?php endif;?>
    <?php 
    if($this->tree):
    ?>
    <?php 
    foreach ($this->tree as $v):
    ?>
    <?php 
    	if($v['id'] == $this->t):
    ?>
    <li class="gtabs-curr"><?php echo $v['name'];?></li>
    <?php else:?>
    <li><a href="<?php echo $this->url("tag/index/t/".$v['id']);?>"><?php echo $v['name'];?></a></li>
    <?php endif;?>
    <?php 
    endforeach;
    ?>
    <?php 
    endif;
    ?>
            </ul>
            <ul class="tag-list gpack followTag">
  <?php 
  	if($this->list):
  ?> 
  <?php 
  	foreach($this->list as $v):
  ?>
                <li>
                <div class="tag-list-options">
    <a target="_blank" href="<?php echo $this->url("/tag/view/t/".$v['name'], "ask");?>"><img src="<?php echo Ask_Tool::getFace($v['name']);?>" class="tag-icon" width="48" height="48"></a>
    <span id="span<?php echo $v['id']?>">
  	<?php 
    	if(!$v['hasFollow']):
    ?>
    <a class="gbtn-join-gray followBt" onclick="follow(<?php echo $v['id']?>)" href="javascript: void 0;">关注</a>
    <?php 
    	else:
    ?>
    <a class="quit-tag followBt" onclick="quite(<?php echo $v['id']?>)" href="javascript: void 0;">取消关注</a>
    <?php 
    	endif;
    ?>
    </span>                
                </div>
                <div class="tag-list-desc">
                    <p>
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/".$v['name']);?>"><?php echo $v['name']?></a>
                    <span><?php echo $v['ask_count']?>个问题</span>
                    <span><span  id="num<?php echo $v['id']?>"><?php echo $v['follow_count']?></span>个关注</span>
                    </p>
                    <p><?php echo stripslashes($v['descr']);?></p>
                </div>
                </li>
<?php 
	endforeach;
?>
<?php endif;?>
            </ul>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 
        </div>
    </div>
</div>
<script>
var follow_url = "<?php echo $this->url("tag/follow/");?>";
var cancelfollow_url = "<?php echo $this->url("tag/cancelfollow/");?>";
//js开始    
function follow(id){
	if(id){
		ajax_get(follow_url+"/id/"+id,function(a){
			if(a.code !=200){
				falert(a.msg);
			}else{
				$("#span"+id).html("<a class=\"quit-tag followBt\"  onclick=\"quite("+id+")\" href=\"javascript: void 0;\">取消关注</a>");
				var num = $("#num"+id).text();
				$("#num"+id).html(parseInt(num)+1);
			}
		});
	}
}

function quite(id){
	if(id){
		ajax_get(cancelfollow_url+"/id/"+id,function(a){
			if(a.code !=200){
				falert(a.msg);
			}else{
				$("#span"+id).html("<a class=\"gbtn-join-gray followBt\" onclick=\"follow("+id+")\"  href=\"javascript: void 0;\">关注</a>");
				var num = $("#num"+id).text();
				$("#num"+id).html(parseInt(num)-1);
			}
		});
	}
}

</script>
