<?php 
echo $this->cplace("管理员管理");
?>
<form method="post" name="frm" action="<?php echo $this->url("sys/masters");?>">
	<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
		<tr class="tr-3">
			<td class="tablerow2"><b>搜索账户:</b> 
			账户 <input class="input" size="45" name="user" type="text" value="<?php echo $this->user;?>"/>
			<button class="button" type="submit" name="btnsubmit" value="yes">搜索</button>
			</td>
		</tr>
	</table>
</form>
<table cellspacing="0" cellpadding="3" align="center" border="0" class="tableborder">
<tr>
	<th width="30%" class="left" noWrap="noWrap">账户</th>
	<th width="20%" class="left" noWrap="noWrap">昵称</th>
	<th width="20%" class="left" noWrap="noWrap">会员类型</th>
	<th>操作</th>
</tr>
		<?php if($this->info):?>
		<tr class="tr-1">
			<td class="tablerow1" noWrap="noWrap"><?php echo $this->info['username'];?></td>
			<td class="tablerow1" noWrap="noWrap"><?php echo $this->info['nickname'];?></td>
			<td class="tablerow1">
			<?php 
			if($this->info['role']==9){
				echo "管理员";
			}elseif($this->info['role']==10){
				echo "超级管理员";
			}else{
				echo "普通会员";
			}
			?>
			</td>
			<td class="tablerow1" align="center" noWrap="noWrap">
			<?php if($this->info['role'] ==9):?>
           <a href="<?php echo $this->url("sys/master-role/id/" . $this->info['id']);?>"><strong>角色设定</strong></a>
           |
           <?php endif;?>
           <a href="<?php echo $this->url("sys/master-set/id/" . $this->info['id']);?>">
           <strong> <?php if($this->info['role'] ==9):?>取消管理员身份<?php elseif($this->info['role'] != 10):?>设定为管理员身份<?php endif;?></strong>
           </a>
			</td>
		</tr>
		<?php endif;?>
</table>