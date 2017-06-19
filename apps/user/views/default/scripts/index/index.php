<div class="grow gmt60 index-page">
        <?php echo $this->leftmenu($this->user['id']);?>
        <div class="main gprefix-1 gspan-25">
            
    <div class="info" id="info">
        <p class="info-intro">
        
        简介：<?php if(!$this->user['sign']):?>这家伙很懒，还没有写简介<?php else: ?><?php echo $this->user['sign'];?><?php endif;?>
        
        </p>
        
        <span class="info-location">
        
        </span>
        
    </div>
    <div class="gmt20 gclear">
        <div class="gbtitle">
            <h2>博客<a class="gbtitle-more" href="<?php echo $this->url("index/blog/id/".$this->user['id']);?>">[全部]</a></h2>
			<?php if($this->isMe): ?>
            <a href="<?php echo $this->url("index/add","site");?>" class="gbtn-primary">添加博客</a>
			<?php endif; ?>
        </div>
        <ul class="blog_list">
            <?php if($this->blog):?>
            <?php 
            	foreach ($this->blog as $v):
            ?>
            <li class="blog">
                <h3>
                    <a target="_blank" href="<?php echo $this->url("/index/view/id/".$v['id'],"site");?>"><?php echo $v['title'];?></a>
                </h3>
                <p class="blog-meta"><?php echo My_Tool::qtime($v['created_at'])?></p>
                <p><?php echo $v['descr'];?> <a target="_blank" href="<?php echo $this->url
				("/index/view/id/"
					.$v['id'],"site");?>">查看全文</a></p>
            </li>
            <?php 
            endforeach;
            ?>
           <?php endif;?>
        </ul>
    </div>
    
    <div class="gmt20 gclear">
        <div class="gbtitle">
            <h2>回答<a class="gbtitle-more" href="<?php echo $this->url("index/answer/id/".$this->user['id']);?>">[全部]</a></h2>
        </div>
        <ul class="answer_list">
      <?php 
      	if($this->answer):
      ?> 
      <?php 
      	foreach ($this->answer as $v):
      ?>
            <li class="answer gclear">
                <h3>
                    <a target="_blank" href="<?php echo $this->url("index/view/id/".$v['ref_id']."?#answer_".$v['id'], "ask");?>"><?php echo $v['arc']['title']; ?></a>
                </h3>
                <?php echo $v['content'];?>
                <p><span class="answer-num gfr"><?php echo $v['support_count'];?>人支持</span></p>
            </li>
     <?php endforeach;?>
     <?php endif;?>       
        </ul>
    </div>
    
    <div class="gmt20 gclear">
        <div class="gbtitle">
            <h2>动态<a class="gbtitle-more" href="<?php echo $this->url("index/feed/id/".$this->user['id']);?>">[全部]</a></h2>
        </div>
        <ul class="news_list">
            <?php if($this->feed):?>
            <?php foreach ($this->feed as $v):?>
            <li class="news">
            <dl>
                <dt class="news-main gellipsis"><span class="news-action"><?php echo $v['feed_type_name'];?></span>
                <?php if($v['url']):?>
                <a target="_blank" href="<?php echo $this->url($v['url'], $v['url_app']);?>"><?php echo $v['feed_title'];?></a>
                <?php else:?>
                "<?php echo $v['feed_title'];?>"
                <?php endif;?>
                </dt>
                <dd class="news-content">
                <p class="news-quote gellipsis"> 
                <?php echo stripslashes($v['feed_data']);?>
                </p>
                <p class="news-time">
                <?php echo My_Tool::qtime($v['created_at'])?>
                </p>
                </dd>
            </dl>
            </li>
           <?php endforeach;?>
           <?php endif;?>
        </ul>
    </div>
        </div>
    </div>