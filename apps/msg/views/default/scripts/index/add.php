<div class="grow message-new-page">
<?php echo $this->leftmenu();?>
        
<div class="gspan-24 gprefix-1">
    <div class="gbtitle">
        <h2><a href="<?php echo $this->url("index/index", "msg");?>">站内信</a><span class="gbtitle-point-to">&gt;</span>写站内信</h2>
    </div>
    <form class="gprefix-3 gsuffix-5 gform" method="POST" action="<?php echo $this->url("index/add"); ?>" id="newMessage">
    <label for="addressee">发给</label>
    
<div class="gform-box">
<input class="gstxt" id="receiver" name="receiver" type="text" value="<?php echo $this->uinfo ? $this->uinfo['nickname']:"";?>">
</div>
<div class="gform-box" style="padding-top:10px;font-size:10px;">(输入用户名发送,多个以","(英文逗号隔开)</div>
    <label for="msg"></label>
<div class="gform-box" style="padding-right:10px">
<?php echo $this->keditor("content");?>
<textarea class="" id="content" name="content" style="width:99%"></textarea>
 <br />
    <span class="tip"></span>
        </div>
        <p class="main-form-submit">
            <input type="submit" class="gbtn-primary gform-submit" value="发送" />
        </p>
    </form>
</div>

    </div>