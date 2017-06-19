<div class="grow search-page">
            <div class="main gspan-21 gsuffix-1">
                
                <ul class="items">
                  <?php if($this->list):?>
                  <?php foreach($this->list as $v):?>
                  <?php $body=$v['body'];?>
                  
                  <?php if($v['type']=='user'):?>
                    <li class="items-guy">
                        <a><img src="<?php echo My_Tool::getFace($body['face']?$body['face']:$body['id'], 48);?>" alt="" width="48" height="48" /></a>
                        <div>
                            <a target="_blank" href="<?php echo $this->url("index/index/id/".$body['id'],"user");?>">
                            <?php echo $body['nickname'];?>
                            </a>
                            <span><?php echo $body['to_follow_count'];?>人关注</span>
                            <p>
                            <?php echo $body['sign'];?>
                            </p>
                        </div>
                    </li>
                    <?php endif;?>
                    
                    <?php if($v['type']=='group_arc'):?>
                    <li class="items-post">
                        <h2><span>[&nbsp;帖子&nbsp;]&nbsp;</span>
       <a target="_blank" href="<?php echo $this->url("index/view/id/".$body['id'],"group");?>"><?php echo $body['title']?></a></h2>
                        <p><?php echo My_Tool::htmlCut(strip_tags($body['content']), 100)?></p>
                        <p>来自：<a target="_blank" href="<?php echo $this->url("index/g/id/".$body['group_id'],"group")?>"><?php echo $body['name']?></a>&nbsp;小组&nbsp;&nbsp;<?php echo My_Tool::qtime($body['created_at'])?></p>
                    </li>
                    <?php endif;?>
                    
                  <?php if($v['type']=='ask_arc'):?>
<li class="items-post">
<h2><span>[&nbsp;问题&nbsp;]&nbsp;</span><a target="_blank" href="<?php echo $this->url("index/view/id/".$body['id'],"ask");?>"><?php echo $body['title']?></a></h2>
<p></p>
<p>
标签:<?php 
                    $tagArr = explode(',', trim($body['tag_name_path'],','));
                    if(isset($tagArr[0])):
                    ?>
                    <span class="tag"><a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[0],"ask");?>"><?php echo $tagArr[0];?></a></span>
                    <?php endif;?>
                    <?php 
                    if(isset($tagArr[1])):
                    ?>
                    <span class="split">|</span>
                    
                    <span class="tag"><a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[1],"ask");?>"><?php echo $tagArr[1];?></a></span>
                    
                    <?php endif;?>
                     <?php 
                    if(isset($tagArr[2])):
                    ?>
                    <span class="split">|</span>
                    <span class="tag"><a target="_blank" href="<?php echo $this->url("tag/view/t/".$tagArr[2],"ask");?>"><?php echo $tagArr[2];?></a></span>
                    <?php endif;?>
&nbsp;&nbsp;&nbsp;<?php echo My_Tool::qtime($body['created_at'])?></p>
</li>
				<?php endif;?>
				
				<?php if($v['type']=='site_arc'):?>
 				<li class="items-post">
                        <h2><span>[&nbsp;文章&nbsp;]&nbsp;</span><a target="_blank" href="<?php echo $this->url("index/view/id/".$body['id'],"site");?>">
                        	<?php echo $body['title']?> </a></h2>
                        <p><?php echo $body['descr'];?></p>
                        <p>来自：<a target="_blank" href="<?php echo $this->url("index/index/id/".$body['tree_id'],"site");?>"><?php echo $body['name']?></a>
                        &nbsp;博客&nbsp;&nbsp;<?php echo My_Tool::qtime($body['created_at'])?></p>
                    </li>
				<?php endif;?>
				
				<?php if($v['type']=='group_info'):?>
				<li class="items-guy">
                        <a  target="_blank" href="<?php echo $this->url("index/g/id/".$body['id'],"group");?>"><img src="<?php echo My_Tool::getFace($body['face']?$body['face']:$body['id'], 48);?>" alt="" width="48" height="48" /></a>
                        <div>
                            <a target="_blank" href="<?php echo $this->url("index/g/id/".$body['id'],"group");?>">
                            <?php echo $body['name'];?>
                            </a>
                            <span><?php echo $body['user_number'];?>人加入</span>
                            <p>
                            <?php echo $body['descr'];?>
                            </p>
                        </div>
                   </li>
				<?php endif?>
				
				<?php if($v['type']=='ask_tag'):?>
				<li class="items-guy">
                        <a  target="_blank" href="<?php echo $this->url("tag/view/t/".$body['name'],"ask");?>"><img src="<?php echo My_Tool::getFace($body['name'], 48);?>" alt="" width="48" height="48" /></a>
                        <div>
                            <a target="_blank" href="<?php echo $this->url("tag/view/t/".$body['name'],"ask");?>">
                            <?php echo $body['name_view'];?>
                            </a>
                            <span><?php echo $body['follow_count'];?>人关注</span>
                            <p>
                            <?php echo $body['descr'];?>
                            </p>
                        </div>
                   </li>
				<?php endif?>
				
                    <?php endforeach;?>
                  <?php endif;?>
                </ul>
	<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 	

            </div>
            <div class="side gspan-10">
                <a target="_blank" class="side-link" href="<?php echo $this->url("tag/index", "ask");?>">找标签？去标签广场&nbsp;&gt;</a>
                <a target="_blank" class="side-link" href="<?php echo $this->url("index/index", "group");?>">找小组？去小组广场&nbsp;&gt;</a>
            </div>
        </div>