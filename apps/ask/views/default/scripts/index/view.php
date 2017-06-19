 <div class="grow gmt60 ask-content-page">
        <div class="main gspan-21">
            <div class="gbreadcrumb">
                <ul>
                    <li>
                        <a href="<?php echo $this->url("index/index");?>">问答</a>
                    </li>
                    <li>
                    <?php echo stripslashes($this->info['title']);?>
                    </li>
                </ul>
            </div>
             
    
    <div class="post">
        <div class="post-title">
            <h1 id="articleTitle"><?php echo stripslashes($this->info['title']);?></h1>
            
        </div>
        
        
        <p class="post-tags tags" id="tags">
        	 <?php 
                    $tagArr = explode(',', trim($this->info['tag_name_path'],','));
                    if(isset($tagArr[0])):
                    ?>
                    <span class="tag"><a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[0]);?>"><?php echo $tagArr[0];?></a></span>
                    <?php endif;?>
                    <?php 
                    if(isset($tagArr[1])):
                    ?>
                    <span class="split">|</span>
                    
                    <span class="tag"><a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[1]);?>"><?php echo $tagArr[1];?></a></span>
                    
                    <?php endif;?>
                     <?php 
                    if(isset($tagArr[2])):
                    ?>
                    <span class="split">|</span>
                    <span class="tag"><a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[2]);?>"><?php echo $tagArr[2];?></a></span>
                    <?php endif;?>
           </p>
        
        <div class="post-detail" id="articleContent">
            <p id="questionDesc">
            <?php echo $this->cinfo['content'];?>
            </p>
        </div>
        <div class="cmtsBody" id="questionCmts">
            <div class="cmts-t cmtsTitle">
				<?php if($this->isMe): ?>
                <p style="float:left">
                    <a href="<?php echo $this->url("index/edit/id/".$this->info['id'],
						"ask");?>">编辑</a><span class="split">|</span>
                    <a id="deleteBlog"  href="javascript:fconfirm('确认要删除吗?',function(){location.href='<?php echo $this->url
					("index/delete/id/".$this->info['id'],
						"ask");?>'})">删除</a>
                </p>
				<?php endif; ?>
                <p class="gfr">
                    <span class="post-user">
                        
                        <a id="articleAuthor" href="<?php echo $this->url("/index/index/id/". $this->info['user']['id'], "user");?>" target="_blank"><?php echo $this->info['user']['nickname'];?></a>
                        
                    </span>
                    <span class="post-date">发表于&nbsp;&nbsp;<?php echo My_Tool::qtime($this->info['created_at'])?></span>
                </p>

            </div>
        </div>
        
    </div>
    <div class="document-do">
        <div class="gfr">

  <span class="focused-num" id="followNum"><span id="follownum"><?php echo $this->info['follow_count']?></span>人关注</span>
  <span id="followdiv">
  <?php if(!$this->isMe): ?>
  <?php if(!$this->isFollow):?>
  <a href="javascript:void 0;" id="followBt"  class="gbtn-primary" onclick="follow()">关注</a>
  <?php else:?>
  <a href="javascript:void 0;" id="cancelfollowBt" onclick="quite()" class="quit-tag">取消关注</a>
  <?php endif;?>
    <?php endif;?>
 </span>
        </div>
    </div>
    <div class="answers" id="answers">
        <div class="answers-do">
            <span class="answers-num gfl">
                <?php echo $this->info['answer_count']?>个答案
            </span>
        </div>
        <?php echo $this->myreply("ask#". $this->info['id']);?>
    </div>

        </div>
        
            <div class="side gspan-10 gprefix-1">
                <a href="<?php echo $this->url("index/add", "ask");?>" class="gbtn-primary" id="newPost">提问</a>
                <div class="side-title mt12">
                    <h2>热门问答</h2>
                </div>
                <div class="side-question-titles" id="recommendQuestion">
 <?php if($this->hot):?>   
 <?php foreach ($this->hot as $v):?>                
<p><a href="<?php echo $this->url("index/view/id/".$v['id']);?>" title="<?php echo $v['title'];?>" target="_blank"><?php echo $v['title'];?></a><?php echo $v['answer_count'];?>回答</p>
<?php endforeach;?>
<?php endif;?>
                </div>
                
            </div>
    </div>
  <script>
  var follow_url = "<?php echo $this->url("index/follow/id/".$this->id);?>";
  var cancelfollow_url = "<?php echo $this->url("index/cancelfollow/id/".$this->id);?>";
  var reply_support_url = "<?php echo $this->url("index/replygood");?>";
  var reply_aga_url = "<?php echo $this->url("index/replybad");?>";
	function follow(){
		ajax_get(follow_url, function(a){
			if(a.code != 200){
				falert(a.msg);
			}else{
				var str = "<a href=\"javascript:void 0;\" id=\"cancelfollowBt\" onclick=\"quite()\" class=\"quit-tag\">取消关注</a>";
				$("#followdiv").html(str);
				var num = parseInt($("#follownum").text());
				$("#follownum").html(num+1);
			}
		});
	}
	function quite(){
		fconfirm("确认要取消关注吗?",function(){
			ajax_get(cancelfollow_url, function(a){
				if(a.code != 200){
					falert(a.msg);
				}else{
					var str = "<a href=\"javascript:void 0;\" id=\"followBt\"  class=\"gbtn-primary\" onclick=\"follow()\">关注</a>";
					$("#followdiv").html(str);
					var num = parseInt($("#follownum").text());
					$("#follownum").html(num-1);
				}
			});
		});
	}	
	$(function(){
		$(".answer-digg-up").each(function(){
			$(this).click(function(){
				var id = $(this).attr("data-id");
				ajax_get(reply_support_url+"/id/"+id,function(a){
					if(a.code != 200){
						falert(a.msg);
					}else{
						var num = parseInt($("#supp_"+id).text());
						$("#supp_"+id).html(num+1);
					}
				});
			});
		});
		
		
		$(".answer-digg-dw").each(function(){
			$(this).click(function(){
				var id = $(this).attr("data-id");
				ajax_get(reply_aga_url+"/id/"+id,function(a){
					if(a.code != 200){
						falert(a.msg);
					}else{
						var num = parseInt($("#aga_"+id).text());
						$("#aga_"+id).html(num+1);
					}
				});
			});
		});
		
	});
  </script>