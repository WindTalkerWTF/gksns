<div class="form-wp  gmt30 ">
            <form id="search" class="grow"   method="get" action="">
<input id="searchTxt" class="search-text gspan-18" type="text" value="<?php echo $this->wd?>" 
placeholder="寻找你喜欢的内容或人" maxlength="30" name="wd" />
<input class="search-submit" value="搜索" type="submit" />
            </form>
        </div>
        <?php 
        	$actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        ?>
       <div class="tabs-wp">
            <ul class="grow">
                <li <?php echo $actionName == "index"? " class='current' ":" ";?>>
                    <a href="<?php echo $this->url("index/index"."/wd/".$this->wd, "search");?>">全站</a>
                    <b class="garrow_up arrow1"></b>
                    <b class="garrow_up arrow2"></b>
                </li>
                <li  <?php echo $actionName == "site"? " class='current' ":" ";?>>
                    <a href="<?php echo $this->url("index/site"."/wd/".$this->wd, "search");?>">文章</a>
                    <b class="garrow_up arrow1"></b>
                    <b class="garrow_up arrow2"></b>
                </li>
                <li  <?php echo $actionName == "ask"? " class='current' ":" ";?>>
                    <a href="<?php echo $this->url("index/ask"."/wd/".$this->wd, "search");?>">问答</a>
                    <b class="garrow_up arrow1"></b>
                    <b class="garrow_up arrow2"></b>
                </li>
                <li  <?php echo $actionName == "post"? " class='current' ":" ";?>>
                    <a href="<?php echo $this->url("index/post"."/wd/".$this->wd, "search");?>">帖子</a>
                    <b class="garrow_up arrow1"></b>
                    <b class="garrow_up arrow2"></b>
                </li>
                <li  <?php echo $actionName == "tag"? " class='current' ":" ";?>>
                    <a href="<?php echo $this->url("index/tag"."/wd/".$this->wd, "search");?>">标签</a>
                    <b class="garrow_up arrow1"></b>
                    <b class="garrow_up arrow2"></b>
                </li>
                <li  <?php echo $actionName == "user"? " class='current' ":" ";?>>
                    <a href="<?php echo $this->url("index/user"."/wd/".$this->wd, "search");?>">用户</a>
                    <b class="garrow_up arrow1"></b>
                    <b class="garrow_up arrow2"></b>
                </li>
                <li  <?php echo $actionName == "group"? " class='current' ":" ";?>>
                    <a href="<?php echo $this->url("index/group"."/wd/".$this->wd, "search");?>">小组</a>
                    <b class="garrow_up arrow1"></b>
                    <b class="garrow_up arrow2"></b>
                </li>
            </ul>
        </div>