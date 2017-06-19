<div class="mainWrap1">
   <h4 class="heading">消息查看</h4>
   <div class="tabcon">
  		<div style="border-bottom:1px #ddd solid;padding-left:10px;">
  		   <?php 
  		   	if($this->t != 3):
  		   ?>
  			<?php if($this->info['uid'] ==0)
  			{
  				echo "系统";
  			}else{
  				echo  $this->user['nickname'] ;
  			}
  			?> &nbsp;&nbsp;说：
  		 <?php 
  		 	else:
  		 	echo "你对" . $this->user['nickname'];
  		 ?>	
  			&nbsp;&nbsp;说：
  		 <?php endif;?>
  		</div>
  		<div>
  			<?php echo $this->info['content'];?>
  		</div>
  		<div  style="color:#999;">
   			<?php echo  My_Tool::qtime($this->info['created_time'])?>
   		</div>
   </div>
   <?php 
   	if($this->info['uid'] != 0):
   ?>
   <div>
   <?php 
   		echo My_Tool_Form::start("addreply", $this->url('index/reply',"msg"));
   ?>
   	<h3><b>回复Ta:</b></h3>
   	<p>
   	<textarea name="reply" style="width:400px;height:100px;font-size:12px;"></textarea>
   	</p>
   	<p style="margin-top:10px;">
   	<input type="hidden" name="id" value="<?php echo $this->id; ?>" >
   	<input type="hidden" name="t" value="<?php echo $this->t; ?>" >
   	<input type="submit" name="sub" value="提交" class="pn"> 
   	</p>
   	<?php 
   		echo My_Tool_Form::end();
   	?>
   </div>
   <?php 
   	endif;
   ?>
</div>