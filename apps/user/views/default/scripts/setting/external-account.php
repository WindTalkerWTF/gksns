<div class="grow gmt60 gpack settings-profile-page">
<?php echo $this->leftsettingmenu();?>
 <div class="main gspan-24 gprefix-1">
                <div class="gbtitle">
                    <h2>绑定帐号</h2>
                </div>
                <div class="gbind gprefix-2 gmt20">
                    
                    
                    <!-- 
                    <p>
                        <span class="gicon-sina">新浪微博帐号</span>
                        <span class="gbind-line"></span>
                        
                        <span class="gicon-binded">已绑定</span>
                        <a href="/weibo/unbind/?csrf_token=20130421205927%23%23f467698fa11b9812c29968d57abe4220f722b2a5&amp;success=https%3A%2F%2Faccount.guokr.com%2Fsettings%2Fexternal_account%2F" class="gicon-unbind">解除绑定</a>
                        
                    </p>
                     -->
                    
                    
                    <p>
                        <span class="gicon-qq">QQ帐号</span>
                        <span class="gbind-line"></span>
                        <?php if($this->qqbind):?>
                        <a href="<?php echo $this->url("qqlogin/unbind","user");?>" class="gicon-bind">取消绑定</a>
                        <?php else:?>
                        <a href="<?php echo $this->url("qqlogin/bind","user");?>" class="gicon-bind">绑定帐号</a>
                        <?php endif;?>
                    </p>
                    
                    
                    <!-- 
                    <p>
                        <span class="gicon-rr">人人帐号</span>
                        <span class="gbind-line"></span>
                        
                        <a href="/renren/sign_in/?success=https%3A%2F%2Faccount.guokr.com%2Fsettings%2Fexternal_account%2F" class="gicon-bind">绑定帐号</a>
                        
                    </p>
                     -->
                </div>
</div>
</div>