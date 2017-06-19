<?php echo $this->groupnav();?>
<div class="grow group-hot-page">
        <div class="main gspan-21 gsuffix-1">
            <ul class="titles">
            <?php if($this->list):?>
            <?php foreach ($this->list as $v):?>
                <li>
				<div>
                <h3 class="titles-txt"><a href="<?php echo $this->url("/index/view/id/". $v['id'], "group");?>" target="_blank"><?php echo $v['title'];?></a></h3>
                <div class="titles-r-grey"><?php echo $v['reply_count'];?><span class="titles-comment-icon"></span></div>
				</div>
				<div class="gclear"></div>
                <p class="titles-b">
                    <span class="titles-b-l">来自：<a href="<?php echo $this->url("/index/g/id/".$v['group']['id']);?>" target="_blank"><?php echo $v['group']['name'];?></a> 小组</span>
                    <span class="titles-b-c">|</span>
                    <span class="titles-b-l">发表：<a href="<?php echo $this->url("/index/index/id/". @$v['user']['id'], "user");?>" target="_blank"><?php echo @$v['user']['nickname']; ?></a></span>
                
                    <span class="titles-b-r">最后回应：&nbsp;&nbsp;<?php echo My_Tool::qtime($v['last_action_at'])?></span>
                </p>
                </li>
            <?php endforeach;?>
            <?php endif;?>
       
            </ul>
	<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum);?> 	
        </div>
        <div class="side gspan-10">
            <form id="groupSearch" action="/group/search/" class="gsearch" method="get">
                <p>
                <input id="word" type="text" class="gsearch-txt" name="q" maxlength="10" placeholder="搜索小组" value=""/>
                <input type="submit" value="搜索" class="gsearch-bt gicon-search" />
                </p>
            </form>
            <div class="side-title">
                <h2>最近热帖</h2>
            </div>
            <ul class="side-hotest">
                <?php if($this->hot):?>
                <?php foreach ($this->hot as $v):?>
                <li>
                    <a href="<?php echo $this->url("/index/view/id/".$v['id']);?>">
                   <?php echo $v['title'];?>
                    </a>
                    <p class="side-hotest-l">来自：<a href="<?php echo $this->url("/index/g/id/".$v['group']['id']);?>" target="_blank"><?php echo $v['group']['name'];?></a></p>
                </li>
                <?php endforeach;?>
                <?php endif;?>
            </ul>
            <div class="side-title">
                
                <h2>近期热门小组</h2>
            </div>
            <div id="groups">
                
                <ul class="side-groups ">
                <?php 
                	if($this->hotg):
                ?>
                <?php 
                	foreach ($this->hotg as $v):
                ?>
                    <li>
                        <a class="pt-pic" href="<?php echo $this->url("/index/g/id/".$v['id']);?>" title="<?php echo $v['name'];?>" target="_blank">
                            <img width="48" height="48" src="<?php echo My_Tool::getFace($v['face'],48);?>" alt="<?php echo $v['name'];?>" hoverboxadded="true">
                        </a>
                        <div class="pt-txt">
                            <h3><a href="<?php echo $this->url("/index/g/id/".$v['id']);?>" target="_blank"><?php echo $v['name'];?></a></h3>
                            <span><?php echo $v['user_number'];?>人加入</span>
                            <div class="pt-txt-d"><p class="gellipsis">
                                    <?php echo $v['descr'];?>
                            </p></div>
                        </div>
                    </li>
                <?php 
                	endforeach;
                ?>
                <?php 
                	endif;
                ?>
                </ul>
            </div>
        </div>
    </div>