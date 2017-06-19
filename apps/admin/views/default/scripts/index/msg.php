<?php 
                    list($msg, $href) = My_Tool_FlashMessage::get("showMsg");
                    if(!stristr($href, "ref=") && $this->ref && stristr($href, "/user/login")){
                        $href = stristr($href, '?') ? $href . "&ref=". $this->ref : $href . "?ref=". $this->ref;
                    }
?>
            <?php if($href):?>
<script type="text/javascript">
            function redirect(){
				location.href= '<?php echo $href;?>';
             }
            setTimeout('redirect()', 2000);
            </script>
<?php endif;?>
<table class="message-table" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td class="message-wrap">
				<div class="message-main">
					<dl>
						<dd>
							<h3><?php echo $msg; ?></h3>
						</dd>
					</dl>
					<div class="message-button">
					<?php if($href):?>
系统将在<span style="color: blue; font-weight: bold">2</span>秒后自动跳转，如果不想等待，直接点击<a style="color: red; display: inline;" href="<?php echo $href;?>"> 这里 </a>	
					<?php else:?>
						<a href="javascript:history.back();">返回</a>
					<?php endif;?>
					</div>
				</div>
			</td>
		</tr>
	</tbody>
</table>

