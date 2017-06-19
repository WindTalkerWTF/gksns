<?php 
	echo My_Tool_Form::start("config", My_Tool::url("index/config"));
?>
<h1>捷库sns安装配置</h1>
  <div class="content">
    <div class="list">
      <div class="name">数据库地址：</div>
      <div class="value"><input type="text" class="input" name="DB_HOST" id="DB_HOST" value="<?php echo $this->dbHost?$this->dbHost:"localhost";?>"  /></div>
    </div>
    <div class="list">
      <div class="name">数据库端口：</div>
      <div class="value"><input type="text" class="input" name="DB_PORT" id="DB_PORT" value="<?php echo $this->dbPort?$this->dbPort:"3306";?>" /></div>
    </div>
    <div class="list">
      <div class="name">数据库名称：</div>
      <div class="value"><input type="text" class="input" name="DB_NAME" id="DB_NAME" value="<?php echo $this->dbName?$this->dbName:"yusns";?>"  /> </div>
    </div>
    <div class="list">
      <div class="name">数据库用户名：</div>
      <div class="value"><input type="text" class="input" name="DB_USER" id="DB_USER" value="<?php echo $this->dbUser?$this->dbUser:"root";?>"  /></div>
    </div>
    <div class="list">
      <div class="name">数据库密码：</div>
      <div class="value"><input type="text" class="input" name="DB_PWD" id="DB_PWD" value="<?php echo $this->dbPwd?$this->dbPwd:"";?>" /></div>
    </div>
    <div class="list">
      <div class="name">管理员账户：</div>
      <div class="value"><input type="text" class="input" name="admin" value="<?php echo $this->admin?$this->admin:"admin@admin.com";?>" />&nbsp;&nbsp;&nbsp;&nbsp;必须为邮箱地址</div>
    </div>
    <div class="list">
      <div class="name">管理员密码：</div>
      <div class="value"><input name="adminPwd"  class="input"  type="text" value="<?php echo $this->adminPwd?$this->adminPwd:"111111";?>" /></div>
    </div>
    
  </div>
  <div class="menu">
  <?php 
  $msg = My_Tool_FlashMessage::get("mycmf_install",1);
  if($msg):?>
  	<div style="color:red" id="error"><?php echo $msg?></div>
  <?php endif;?>
    <button type="submit" class="submit" id="submit">准备完毕进入安装</button>
  </div>
<?php echo My_Tool_Form::end();?>
<script>
  $(function(){
	 		$("#submit").click(function(){
				$(this).html("正在安装中，请耐心等待");
			});
  })
</script>