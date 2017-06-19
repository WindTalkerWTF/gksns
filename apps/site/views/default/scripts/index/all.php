<div class="grow gmt60 gclear all-blogs-page">
    <div class="side gspan-10">
        <div class="side-title">
            <h2>近期活跃达人<a href="<?php echo $this->url("index/daren","user");?>" class="side-title-txt">（全部）</a></h2>
        </div>
        <ul class="side-nuts">
          <?php if($this->daren):?>
          <?php foreach ($this->daren as $v):?>
            <li>
            <a href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>" 
            title="<?php echo $v['nickname']?>" target="_blank" class="pt-pic">
            <img width="48" height="48" src="<?php echo My_Tool::getFace($v['face']?$v['face']:$v['id']);?>" alt="<?php echo $v['nickname']?>" />
            </a>
                <div class="pt-txt">
                    <h3><a target="_blank" href="<?php echo $this->url("index/index/id/".$v['id'],"user");?>"><?php echo $v['nickname']?></a></h3>
                    <span><?php echo $v['to_follow_count']?>人关注</span>
                </div>
            </li>
         <?php endforeach;?>
		<?php endif;?>
        </ul>
    </div>
    <div class="main gspan-21">
        <div class="gbtitle"><h1>全部博客</h1></div>

        <ul class="article_list">
             <?php if($this->list):?>
             <?php foreach ($this->list as $v):?>
            <li class="article">
            <h2><a target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'],"site");?>"><?php echo $v['title'];?></a></h2>
            <p class="article-meta"><a href="<?php echo $this->url("index/index/id/".$v['user']['id'],"user");?>"><?php echo $v['user']['nickname'];?></a>发表于<span><?php echo My_Tool::qtime($v['created_at'])?></span></p>
            <p class="article-num">评论&nbsp;<?php echo $v['reply_count'];?><span class="article-num-sp">|</span>推荐&nbsp;<?php echo $v['recommend_count'];?></p>
            <p><?php echo strip_tags($v['descr']);?><a target="_blank" href="<?php echo $this->url("index/view/id/".$v['id'],"site");?>">查看全文</a></p>
            </li>
            <?php endforeach;?>
   			<?php endif;?>
        </ul>
     <?php echo $this->paginator($this->pageSize, $this->page, $this->totalNum, "site");?>
    </div>
</div>