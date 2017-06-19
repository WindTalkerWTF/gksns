<div class="grow gmt60 gpack settings-profile-page">
<?php echo $this->leftsettingmenu();?>
 <div class="main gspan-24 gprefix-1">
                <div class="gbtitle">
                    <h2>邮箱认证</h2>
                </div>
                <div class="gbind gprefix-2 gmt20">

                      <?php  if($this->user['email_validate']): ?>
                          <p>
                                邮箱已认证
                            </p>
                      <?php else: ?>
                          <p>
                          邮箱未认证
                            </p>
                          <p>
                        <a href="<?php echo $this->url("setting/doresendemail","user"); ?>" class="gbtn-ext">重新发送认证邮件</a>
                        </p>
                      <?php endif;?>


                </div>
</div>
</div>