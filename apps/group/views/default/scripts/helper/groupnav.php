<div class="sub-nav">
        <div class="sub-nav-wrap gclear">
            <ul class="sub-nav-link gfl">
<?php if($this->user):?>      
<li <?php if($this->actionName == 'my') echo 'class="current"'; ?>>
    <a href="<?php echo $this->url("/index/my","group");?>">我的小组</a>
</li>
<?php endif;?>
<li <?php if($this->actionName == 'all-view') echo 'class="current"'; ?>>
    <a href="<?php echo $this->url("/index/all-view","group");?>">小组首页</a>
</li>
<li  <?php if($this->actionName == 'index') echo 'class="current"'; ?>>
    <a href="<?php echo $this->url("/index/index","group");?>">全部小组</a>
</li>
<li  <?php if($this->actionName == 'apply') echo 'class="current"'; ?>>
    <a href="<?php echo $this->url("index/apply");?>">申请创建小组</a>
</li>
            </ul>
        </div>
    </div>