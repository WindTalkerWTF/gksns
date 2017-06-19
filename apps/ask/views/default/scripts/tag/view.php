<div class="grow gmt60 ask-tagcontent-page">
    <div class="main gspan-21">
        <div class="gbreadcrumb">
            <ul>
                <li>
                <a href="<?php echo $this->url("index/index", "ask");?>">问答</a>
                </li>
                <li>
                <a href="<?php echo $this->url("tag/index", "ask");?>">标签</a>
                </li>
                <li>
                生活
                </li>
            </ul>
        </div>
        <div class="main-tag">
            <div class="main-tag-info">
                <div class="main-tag-avatar">
                    <img src="<?php echo Ask_Tool::getFace($this->info['name']); ?>" id="tagAvatar" alt="生活" width="48" height="48">
                    
                </div>
                <div class="main-tag-title">
                    <h1><?php echo $this->info['name'];?></h1>
                    <p id="followCounter"><lable><?php echo $this->info['follow_count'];?></lable>人关注</p>
                    <span>
                    <?php if(!$this->isFollow):?>
                    <a href="javascript:void 0;" class="gbtn-primary" onclick="follow()"><b>+</b>&nbsp;关注</a>
                    <?php else:?>
                    <a href="javascript:void 0;" class="quit-tag" onclick="cancelfollow()">取消关注</a>
                    <?php endif;?>
                    </span>
                </div>
            </div>
            <div class="main-tag-board" id="boardEditor">
                <div id="tagDesc" class="main-board-editor">
                    <?php echo stripslashes($this->info['descr']);?>
                </div>
            </div>
        </div>
        
    <ul class="gtabs">
        
    <?php 
    	if(!$this->tp):
    ?>
    <li class="gtabs-curr">正在讨论</li>
    <?php 
    	else:
    ?>
     <li class="gtabs-curr"><a href="<?php echo $this->url("tag/view/t/". $this->info['name']);?>">正在讨论</a></li>
    <?php 
    	endif;
    ?>
    <?php 
    	if($this->tp == 1):
    ?>
    <li class="gtabs-curr">最热回答</li>
    <?php 
    	else:
    ?>
     <li class="gtabs-curr"><a href="<?php echo $this->url("tag/view/t/". $this->info['name']."/tp/1");?>">最热问答</a></li>
    <?php 
    	endif;
    ?>
    <?php 
    	if($this->tp == 2):
    ?>
    <li class="gtabs-curr">等待回答</li>
    <?php 
    	else:
    ?>
     <li class="gtabs-curr"><a href="<?php echo $this->url("tag/view/t/". $this->info['name']."/tp/2");?>">等待回答</a></li>
    <?php 
    	endif;
    ?>
    </ul>
    <ul class="ask-list">
        <?php if($this->list):?>
        <?php foreach($this->list as $v):?>
        <li>
        <div class="ask-list-nums">
            <p class="ask-focus-nums">
            <span class="num"><?php echo $v['follow_count']?></span>关注
            </p>
            <p class="ask-answer-nums">
            <span class="num"><?php echo $v['answer_count']?></span>回答
            </p>
        </div>
        <div class="ask-list-detials">
            <h2><a target="_blank" href="<?php echo $this->url("index/view/id/".$v['id']);?>"><?php echo $v['title'];?></a></h2>
            <div class="ask-list-legend">
                <p class="ask-list-tags">
                标签：
                	<?php 
                    $tagArr = explode(',', trim($v['tag_name_path'],','));
                    if(isset($tagArr[0]) && $tagArr[0]):
                    ?>
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/". $tagArr[0]);?>"><?php echo $tagArr[0];?></a>
                    <?php endif;?>
                    <?php 
                    if(isset($tagArr[1]) && $tagArr[1]):
                    ?>
                    |
                    
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/". $tagArr[1]);?>"><?php echo $tagArr[1];?></a>
                    
                    <?php endif;?>
                     <?php 
                    if(isset($tagArr[2]) && $tagArr[2]):
                    ?>
                    |
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/". $tagArr[2]);?>"><?php echo $tagArr[2];?></a>
                    <?php endif;?>
                    
                </p>
                <span class="ask-list-time">
                    <?php echo My_Tool::qtime($v['created_at']); ?>
                </span>
            </div>
        </div>
        </li>
        <?php endforeach;?>
        <?php endif;?>
    </ul>
    <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 
    </div>
    <div class="side gspan-10 gprefix-1">
         
        <div class="side-title"> 
            <h2>相关标签</h2>
        </div>
        <ul class="side-tags">
            <?php if($this->similaryTag):?>
            <?php foreach ($this->similaryTag as $v):?>
            <li>
            <a href="<?php echo $this->url("tag/view/t/".$v['name']);?>">
            <img src="<?php echo My_Tool::getFace($v['name'], 24);?>" width="24" height="24"><?php echo $v['name'];?></a><?php echo $v['ask_count'];?>个问题
            </li>
            <?php endforeach;?>
            <?php endif;?>
        </ul>
            <div class="side-title">
            <h2>近期活跃用户</h2>
        </div>
        <ul class="side-users">
       <?php if($this->arcInfo):?>
       <?php foreach($this->arcInfo as $v ):?>
            <li>
                <a href="<?php echo $this->url("index/index/id/".$v['user']['id'], "user");?>">
      <img src="<?php echo My_Tool::getFace($v['user']['face'],24);?>" width="24" height="24"><?php echo $v['user']['nickname'];?></a>
            </li>
       <?php endforeach;?>
       <?php endif;?>
        </ul>

    </div>
</div>
  <script>
  var follow_url = "<?php echo $this->url("tag/follow/id/".$this->id);?>";
  var cancelfollow_url = "<?php echo $this->url("tag/cancelfollow/id/".$this->id);?>";
  //js开始    
  function follow(){
  		ajax_get(follow_url, function(a){
  			if(a.code != 200){
  				falert(a.msg);
  			}else{
  	  			var num = $(".main-tag-title lable").text();
  	  	  		$(".main-tag-title lable").html(parseInt(num)+1);
  	  	  		var str = " <a href=\"javascript:void 0;\" class=\"quit-tag\" onclick=\"cancelfollow()\">取消关注</a>";
  	  	  	  	$(".main-tag-title span").html(str);
  			}
  		});
  	};
  	
  	//cancelfollowBt
  	
function cancelfollow(){
  		ajax_get(cancelfollow_url, function(a){
  			if(a.code != 200){
  				falert(a.msg);
  			}else{
  				var num = $(".main-tag-title lable").text();
  	  	  		$(".main-tag-title lable").html(parseInt(num)-1);
  	  	  		var str = "<a href=\"javascript:void 0;\" class=\"gbtn-primary\"  onclick=\"follow()\" id=\"followBt\"><b>+</b>&nbsp;关注</a>";
  	  	  	  	$(".main-tag-title span").html(str);
  			}
  		});
  	}
  </script>