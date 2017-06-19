<?php 
                    list($msg, $href,$isJs) = My_Tool_FlashMessage::get("showMsg");
                    if(!$isJs){
	                    if(!stristr($href, "ref=") && $this->ref && stristr($href, "/user/login")){
	                        $href = stristr($href, '?') ? $href . "&ref=". $this->ref : $href . "?ref=". $this->ref;
	                    }
                    }
?>
            <?php if($href):?>
            <script type="text/javascript">
            function redirect(){
                <?php if($isJs):?>
                <?php echo $href;?>
                <?php else:?>
				location.href= '<?php echo $href;?>';
				<?php endif;?>
             }
            setTimeout('redirect()', 2000);
            </script>
            <?php endif;?>
<div class="wrap grow gmt60 gpack">
        <div class="gspan-25 gprefix-2 main">
            <div class="msg-box">
                <p><?php echo $msg; ?></p>
                <?php if($href):?>
                <?php if(!$isJs):?>
<p>系统将在<span style="color: blue; font-weight: bold">3</span>秒后自动跳转，如果不想等待，直接点击<a style="color:red; display:inline;" href="<?php echo $href;?>"> 这里 </a></p>
				<?php else:?>
<p>系统将在<span style="color: blue; font-weight: bold">3</span>秒后自动跳转，如果不想等待，直接点击<a style="color:red; display:inline;" href="javascript:<?php echo $href;?>"> 这里 </a></p>
				<?php endif;?>
                <?php else: ?>
                <p>返回到<a style="color:red; display:inline;" href="/"> 首页 </a></p>
                <?php endif;?>
            </div>
        </div>
</div>