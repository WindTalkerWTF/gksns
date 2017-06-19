        <div class="gtop-wp gsuffix-4">
            <div class="gtop pack gclear gmt20">
                <div class="gtop-main gfl">
                    <h1><?php echo $this->user['nickname'];?></h1>
                </div>
                
                <div class="gtop-side gfr" id="gtopBtns">
                   <?php 
                   	if(!$this->isMe):
                   ?>
                   <?php 
                   if(!$this->isFollow):
                   ?>
                  <a href="javascript: void 0;" class="gbtn-primary" id="followbtn" data-operation="follow" data-ukey="sbhkv5"/>+关注</a>
                  <?php else:?>
                  <a href="javascript: void 0;" id="cancelfollowbtn"  data-operation="follow" data-ukey="sbhkv5"/>取消关注</a>
                  <?php endif;?>
                  <?php endif;?>
                    <?php 
                    	if($this->isMe):
                    ?>
                    <a class="gbtn" href="<?php echo $this->url('/index/index', "msg");?>">站内信</a>
                    <?php 
                    	else:
                    ?>
                    <a class="gbtn" href="<?php echo $this->url('index/add/id/'.$this->user['id'], "msg");?>">给TA发信</a>
                    <?php endif;?>
                </div>
                
            </div>
        </div>
<div class="side gspan-6">
            <div class="side-head">
                <a href="<?php echo $this->url("index/index/id/".$this->user['id']);?>">
                    <img alt="<?php echo $this->user['nickname'];?>" width="160" height="160" src="<?php echo User_Tool::getFace($this->user['face']?$this->user['face']:$this->user['id'], 160);?>">
                </a>
            </div>
            <ul class="side-nav focus">
                <li class="gclear">
                    <a class="side-title" href="<?php echo $this->url("index/follow/id/".$this->user['id']);?>">关注<span class="side-title-more">（全部<?php echo $this->user['follow_count'];?>人）</span></a>
                    <p class="focus_list">
<?php 
if($this->follow):
?>
<?php foreach($this->follow as $v):?>
 <a href="<?php echo $this->url("index/index/id/".$v['id']);?>" target="_blank" alt="<?php echo $v['nickname']?>">
 <img alt="<?php echo $v['nickname']?>" src="<?php echo User_Tool::getFace($v['face']?$v['face']:$v['id'], 24);?>" />
 </a>
<?php endforeach;?>
<?php 
endif;
?>             
                    </p>
                </li>
 <li class="gclear">
  <a class="side-title" href="<?php echo $this->url("index/interested/id/".$this->user['id']);?>">被关注<span class="side-title-more">（全部<?php echo $this->user['to_follow_count'];?>人）</span></a>
    <p class="focused_list">
<?php 
if($this->toFollow):
?>
<?php foreach($this->toFollow as $v):?>
 <a href="<?php echo $this->url("index/index/id/".$v['id']);?>" target="_blank" alt="<?php echo $v['nickname']?>">
 <img alt="<?php echo $v['nickname']?>" src="<?php echo User_Tool::getFace($v['face']?$v['face']:$v['id'], 24);?>" />
 </a>
<?php endforeach;?>
<?php 
endif;
?>  
                    </p>
                </li>
            </ul>
            
            <ul class="side-nav">
                
                <li>
                    <a class="side-title" href="<?php echo $this->url("/index/blog/id/".$this->uid, "user");?>">
                        <span class="gicon-blog"></span>博客：
                        <span class="side-title-more"><?php echo $this->user['blog_count'];?>篇</span>
                    </a>
                </li>
                
                
                <li>
                    <a class="side-title" href="<?php echo $this->url("/index/answer/id/".$this->uid, "user");?>">
                        <span class="gicon-answer"></span>回答：
                        <span class="side-title-more"><?php echo $this->user['answer_count'];?>条</span>
                    </a>
                </li>
                
                
                <li>
                    <a class="side-title" href="<?php echo $this->url("/index/ask/id/".$this->uid, "user");?>">
                        <span class="gicon-question"></span>提问：
                        <span class="side-title-more"><?php echo $this->user['question_count'];?>条</span>
                    </a>
                </li>
                
                
                <li>
                    <a class="side-title" href="<?php echo $this->url("/index/post/id/".$this->uid, "user");?>">
                        <span class="gicon-post"></span>帖子：
                        <span class="side-title-more"><?php echo $this->user['group_arc_count'];?>个</span>
                    </a>
                </li>
                
            </ul>
            <ul class="side-nav">
                
                <li>
                    <a class="side-title" href="<?php echo $this->url("/index/feed/id/".$this->uid, "user");?>">
                        <span class="gicon-news"></span>动态：
                        <span class="side-title-more"><?php echo $this->user['feed_count'];?>条</span>
                    </a>
                </li>
                
                
                <li>
                    <a class="side-title" href="<?php echo $this->url("/index/tag/id/".$this->uid, "user");?>">
                        <span class="gicon-tag"></span>标签：
                        <span class="side-title-more"><?php echo $this->user['tag_count'];?>个</span>
                    </a>
                </li>
                
                
                <li>
                    <a class="side-title" href="<?php echo $this->url("/index/group/id/".$this->uid, "user");?>">
                        <span class="gicon-group"></span>小组：
                        <span class="side-title-more"><?php echo $this->user['group_count'];?>个</span>
                    </a>
                </li>
            </ul>
        </div>
        <script>
$(function(){
	$("#followbtn").click(function(){
		ajax_get("<?php echo $this->url("index/dofollow/id/".$this->uid);?>",function(a){
				if(a.code != 200){
					falert(a.msg);
				}else{
					location.reload();
				}
		});
	});
	//cancelfollowbtn
	$("#cancelfollowbtn").click(function(){
		ajax_get("<?php echo $this->url("index/docancelfollow/id/".$this->uid);?>",function(a){
				if(a.code != 200){
					falert(a.msg);
				}else{
					location.reload();
				}
		});
	});
})
        </script>