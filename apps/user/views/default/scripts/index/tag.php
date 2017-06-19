<div class="grow tag-page">
<?php echo $this->leftmenu($this->user['id']);?>
<div class="main gprefix-1 gspan-25">
            
    <div class="gbtitle">
        <h2><a class="gbtitle-link" href="<?php echo $this->url("index/index/id/".$this->id,"user")?>">个人主页</a>
        <span class="entities">&gt;</span>标签<span class="gbtitle-more">（全部<?php echo $this->user['tag_count'];?>个）</span></h2>
    </div>
    <ul class="tag-list gpack gclear">
        <?php if($this->list):?>
        <?php foreach ($this->list as $v):?>
        <li>
            <div class="tag-list-options">
                <a target="_blank" href="<?php echo $this->url("/tag/view/t/".$v['name'], "ask");?>">
                <img src="<?php echo Ask_Tool::getFace($v['name'], 48);?>" width="48" height="48"></a>
   <?php if(!$this->me):?>
   <?php 
    	if(!$v['hasFollow']):
    ?>
    <a class="gbtn-join-gray followBt" data-id="<?php echo $v['id']?>" data-operation="follow" href="javascript: void 0;">关注</a>
    <?php 
    	else:
    ?>
    <a class="quit-tag followBt" data-id="<?php echo $v['id']?>" data-operation="follow" href="javascript: void 0;">取消关注</a>
    <?php 
    	endif;
    ?> 
    <?php 
    	endif;
    ?>
            </div>
            <div class="tag-list-desc">
                <p>
                    <a target="_blank" href="<?php echo $this->url("tag/view/t/".$v['name'],'ask');?>"><?php echo $v['name']?></a><span><?php echo $v['ask_count']?>个问题</span>
                </p>
                <p><?php echo $v['descr']?></p>
            </div>
        </li>
        <?php endforeach;?>
        <?php endif;?>
    </ul>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?>
        </div>
</div>