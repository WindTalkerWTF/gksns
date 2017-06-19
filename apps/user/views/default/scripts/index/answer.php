<div class="grow  gmt60  answer-page">
<?php echo $this->leftmenu($this->id);?>
<div class="main gprefix-1 gspan-25">
            
    <div class="gbtitle">
        <h2><a class="gbtitle-link" href="<?php echo $this->url("index/index/id/".$this->id,"user")?>">个人主页</a>
        <span class="entities">&gt;</span>回答<span class="gbtitle-more">（全部<?php echo $this->user['answer_count'];?>个）</span></h2>
    </div>
    <ul class="answer_list">
        <?php if($this->list):?>
        <?php foreach ($this->list as $v):?>
        <li class="answer gclear">
            <h2><a target="_blank" href="<?php echo $this->url("index/view/id/".$v['ref_id'], "ask");?>"><?php echo $v['arc']['title']; ?></a></h2>
            <p>
            <?php echo $v['content'];?>
            <a target="_blank" href="<?php echo $this->url("index/view/id/".$v['ref_id'], "ask");?>">查看全文</a></p>
            <span class="answer_list-num"><?php echo $v['support_count'];?>人支持</span>
        </li>
        <?php endforeach;?>
        <?php endif;?>
    </ul>
<?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "user");?>
        </div>
</div>