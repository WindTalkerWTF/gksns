            <div class="side gspan-6">
                <h1>设置</h1>
                <ul>
                    
                    <li class="gactived"><span class="gicon-profile"></span>
                    <?php if($this->actionName == "index"):?>
                    <span>个人资料</span>
                    <?php else:?>
                    <a href="<?php echo $this->url("setting/index", "user");?>">个人资料</a>
                    <?php endif;?>
                    </li>
                    <li><span class="gicon-avatar"></span>
                     <?php if($this->actionName == "mface"):?>
                    <span>设置头像</span>
                    <?php else:?>
                    <a href="<?php echo $this->url("setting/mface", "user");?>">设置头像</a>
                    <?php endif;?>
                    </li>
                    <li><span class="gicon-security"></span>
                     <?php if($this->actionName == "mpwd"):?>
                    <span>修改密码</span>
                    <?php else:?>
                    <a href="<?php echo $this->url("setting/mpwd", "user");?>">安全</a>
                    <?php endif;?>
                    </li>
                     
                    <li><span class="gicon-external_account"></span>
                     <?php if($this->actionName == "external-account"):?>
                    <span>绑定帐号</span>
                    <?php else:?>
                    <a href="<?php echo $this->url("setting/external-account", "user");?>">绑定帐号</a>
                    <?php endif;?>
                    </li>
                    <li><span class="gicon-security"></span>
                        <?php if($this->actionName == "resendemail"):?>
                            <span>邮箱认证</span>
                        <?php else:?>
                            <a href="<?php echo $this->url("setting/resendemail", "user");?>">邮箱认证</a>
                        <?php endif;?>
                    </li>
                     
                </ul>
            </div>