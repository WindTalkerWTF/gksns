<div class="sub-nav">
        <div class="sub-nav-wrap gclear">
            <ul class="sub-nav-link gfl">
<li <?php if($this->id == 0) echo 'class="current"'; ?>>
    <a href="<?php echo $this->url("/index/index","site");?>">最新</a>
</li>
<?php if($this->tree):?>
<?php foreach ($this->tree as $v):?>      
<li <?php if($this->id == $v['id']) echo 'class="current"'; ?>>
    <a href="<?php echo $this->url("/index/index/id/".$v['id']."","site");?>"><?php echo $v['name'];?></a>
</li>
<?php endforeach;?>
<?php endif;?>
            </ul>
        </div>
    </div>