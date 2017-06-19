<?php 
	echo $this->cplace("网站设置");
?>
<div class="tab-box">
	<ul id="nav_tabs">
		<li><a href="#nav1" >网站基本设置</a></li>
		<li><a href="#nav2" >会员金币获得配置</a></li>
		<li><a href="#nav3" >特定页面设置</a></li>
		<li><a href="#nav4" >SMTP邮件发送服务器设置</a></li>
		<li><a href="#nav5" >统计设置</a></li>
		<li><a href="#nav6" >联合登录设置</a></li>
        <li><a href="#nav7" >广告设置</a></li>
	</ul>
</div>
<form name="setting" method="post" action="<?php echo My_Tool::url("/sys/dosetting")?>" >
<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption><a href="javascript:;" id="nav1">网站基本设置</a></caption>
<tr>
	<th colspan="2" class="th1">网站名称:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.siteName"
       value="<?php echo isset($this->config["site.config.siteName"]) ? $this->config["site.config.siteName"] : "";?>" >
</td>
<td class="tablerow1 tips">请输入站点名称</td>
</tr>
<tr>
	<th colspan="2" class="th1">网站域名:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.domain" value="<?php echo isset($this->config["site.config.domain"]) ? $this->config["site.config.domain"] : "";?>" >
</td>
<td class="tablerow1 tips">例如:www.baidu.com,不带"http://"和最后面的"/"</td>
</tr>

<tr>
	<th colspan="2" class="th1">网站标题:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.seo.home.title" value="<?php echo isset($this->config["site.config.seo.home.title"]) ?$this->config["site.config.seo.home.title"]:"" ;?>" >
</td>
<td class="tablerow1 tips">首页显示标题</td>
</tr>


<tr>
	<th colspan="2" class="th1">网站关键字:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<textarea name="site.config.seo.home.keywords" ><?php echo isset($this->config["site.config.seo.home.keywords"]) ? $this->config["site.config.seo.home.keywords"]:'';?></textarea>
</td>
<td class="tablerow1 tips">首页显示关键字</td>
</tr>

<tr>
	<th colspan="2" class="th1">网站描述:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<textarea name="site.config.seo.home.descr" ><?php echo isset($this->config["site.config.seo.home.descr"]) ?$this->config["site.config.seo.home.descr"]:'' ;?></textarea>
</td>
<td class="tablerow1 tips">首页显示描叙</td>
</tr>

<tr>
	<th colspan="2" class="th1">达人头衔:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<textarea name="site.config.daren" ><?php
    echo isset($this->config["site.config.daren"]) ?$this->config["site.config.daren"]:"";?></textarea>
</td>
<td class="tablerow1 tips">多个以英文","隔开</td>
</tr>

<tr>
	<th colspan="2" class="th1">session保存方式:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
    <?php
        $sessionHandle = isset($this->config["session.handle"])?$this->config["session.handle"] :"";
    ?>
<select name="session.handle">
<option value="memcache" <?php echo $sessionHandle =='memcache' ? "selected" : "";?>>memcache</option>
<option value="db"  <?php echo $sessionHandle =='db' ? "selected" : "";?>>数据库</option>
</select>
</td>
<td class="tablerow1 tips"></td>
</tr>

<tr>
	<th colspan="2" class="th1">session,cookie域:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" value="<?php echo isset($this->config["session.domain"]) ? $this->config["session.domain"]:'';?>" name="session.domain" >
</td>
<td class="tablerow1 tips">请填写网站域名的顶级域名前面加".",如".baidu.com"或者不填</td>
</tr>


<tr>
    <th colspan="2" class="th1">你可能喜欢选择方式</th>
</tr>
<tr>
    <td class="tablerow1 formrow">
        <?php
        $choose = isset($this->config["site.my.recommend"]) ? $this->config["site.my.recommend"]:'';
        ?>
        <select name="site.my.recommend">
            <option value="0" <?php echo !$choose ? "selected" : "";?>>无觅插件</option>
            <option value="1"  <?php echo $choose ==1 ? "selected" : "";?>>本地方式</option>
        </select>
    </td>
    <td class="tablerow1 tips">无觅推荐详见(http://www.wumii.com/)</td>
</tr>

<tr>
	<th colspan="2" class="th1">缓存保存方式</th>
</tr>
<tr>
<td class="tablerow1 formrow">
 <?php
    $cacheHandle = isset($this->config["cache.handle"]) ? $this->config["cache.handle"]:'';
 ?>
<select name="cache.handle">
<option value="memcache" <?php echo $cacheHandle =='memcache' ? "selected" : "";?>>memcache</option>
<option value="file"  <?php echo $cacheHandle =='file' ? "selected" : "";?>>文件</option>
</select>
</td>
<td class="tablerow1 tips"></td>
</tr>

<tr>
	<th colspan="2" class="th1">memcache过期时间，单位为秒</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" value="<?php echo isset($this->config["cache.memcache.lifetime"]) ? $this->config["cache.memcache.lifetime"]:"";?>" name="cache.memcache.lifetime" >
</td>
<td class="tablerow1 tips">缓存保存方式为"memcache"时必填</td>
</tr>


<tr>
	<th colspan="2" class="th1">memcache服务器IP</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" value="<?php echo isset($this->config["cache.memcache.server.ip"]) ?$this->config["cache.memcache.server.ip"]:'' ;?>" name="cache.memcache.server.ip" >
</td>
<td class="tablerow1 tips">缓存保存方式为"memcache"时必填,memcache装在本机时，填127.0.0.1</td>
</tr>


<tr>
	<th colspan="2" class="th1">memcache服务器端口</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" value="<?php echo isset($this->config["cache.memcache.server.port"]) ? $this->config["cache.memcache.server.port"]:'';?>" name="cache.memcache.server.port" >
</td>
<td class="tablerow1 tips">缓存保存方式为"memcache"时必填,默认11211</td>
</tr>

<tr>
	<th colspan="2" class="th1">js,css静态文件版本号</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" value="<?php echo isset($this->config["static_version"]) ? $this->config["static_version"]:'';?>" name="static_version" >
</td>
<td class="tablerow1 tips">建议以时间作为标记如:201301023</td>
</tr>

<tr>
	<th colspan="2" class="th1">是否rewrite</th>
</tr>
<tr>
<td class="tablerow1 formrow">
 <?php
 $siteConfigRewrite = isset($this->config["site.config.isrewrite"]) ? $this->config["site.config.isrewrite"]:0;
 ?>
<select name="site.config.isrewrite">
<option value="1" <?php echo $siteConfigRewrite ==1 ? "selected" : "";?>>是</option>
<option value="0"  <?php echo $siteConfigRewrite ==0 ? "selected" : "";?>>否</option>
</select>
</td>
<td class="tablerow1 tips">开启前，请确认是否做了rewrite相关配置，否则网站将不能访问</td>
</tr>


    <tr>
        <th colspan="2" class="th1">注册是否需要发邮件验证</th>
    </tr>
    <tr>
        <td class="tablerow1 formrow">
            <?php
            $siteconfig = isset($this->config["site.reg.sedemail"]) ? $this->config["site.reg.sedemail"]:0;
            ?>
            <select name="site.reg.sedemail">
                <option value="1" <?php echo $siteconfig ==1 ? "selected" : "";?>>是</option>
                <option value="0"  <?php echo $siteconfig ==0 ? "selected" : "";?>>否</option>
            </select>
        </td>
        <td class="tablerow1 tips">开启前，请确认是否设置smtp服务器地址，否则注册功能将不能走完</td>
    </tr>

<tr>
	<th colspan="2" class="th1">评论是否需要审核</th>
</tr>
<tr>
<td class="tablerow1 formrow">
    <?php
    $siteConfigContentIsCheck = isset($this->config["site.config.content.is.check"]) ? $this->config["site.config.content.is.check"]:0;
    ?>
<select name="site.config.content.is.check">
<option value="1" <?php echo $siteConfigContentIsCheck ==1 ? "selected" : "";?>>是</option>
<option value="0"  <?php echo $siteConfigContentIsCheck == 0 ? "selected" : "";?>>否</option>
</select>
</td>
<td class="tablerow1 tips">开启后所有评论需要审核才能显示</td>
</tr>

</table>

<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption><a href="javascript:;" id="nav2">金币获得配置</a></caption>

    <tr>
        <th colspan="2" class="th1">金币名称</th>
    </tr>
    <tr>
        <td class="tablerow1 formrow">
            <input type="text" name="site.coin.name" value="<?php echo isset($this->config["site.coin.name"])?$this->config["site.coin.name"]:"" ;?>" >
        </td>
        <td class="tablerow1 tips">网站金币的名称</td>
    </tr>

    <tr>
        <th colspan="2" class="th1">拥有多少金币发帖不用显示验证码</th>
    </tr>
    <tr>
        <td class="tablerow1 formrow">
            <input type="text" name="site.coin.needyanzheng" value="<?php echo isset($this->config["site.coin.needyanzheng"])?$this->config["site.coin.needyanzheng"]:"" ;?>" >
        </td>
        <td class="tablerow1 tips">会员发布内容拥有金币超过这个数量将不用输入验证码</td>
    </tr>

<tr>
	<th colspan="2" class="th1">用户注册</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.user.reg" value="<?php echo isset($this->config["site.config.coin.user.reg"])?$this->config["site.config.coin.user.reg"]:"" ;?>" >
</td>
<td class="tablerow1 tips">注册成功送的金币个数</td>
</tr>

<tr>
	<th colspan="2" class="th1">发布新博客:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.site.arc.add" value="<?php echo isset($this->config["site.config.coin.site.arc.add"])?$this->config["site.config.coin.site.arc.add"]:'';?>" >
</td>
<td class="tablerow1 tips">发布新博客送的金币个数</td>
</tr>

<tr>
	<th colspan="2" class="th1">删除博客:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.site.arc.delete" value="<?php echo isset($this->config["site.config.coin.site.arc.delete"]) ? $this->config["site.config.coin.site.arc.delete"]:'';?>" >
</td>
<td class="tablerow1 tips">删除博客减少的金币个数</td>
</tr>
<tr>
	<th colspan="2" class="th1">添加小组文章:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.group.arc.add" value="<?php echo isset($this->config["site.config.coin.group.arc.add"])?$this->config["site.config.coin.group.arc.add"]:'';?>" >
</td>
<td class="tablerow1 tips">添加小组文章增加的金币个数</td>
</tr>

<tr>
	<th colspan="2" class="th1">删除小组文章:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.group.arc.delete" value="<?php echo isset($this->config["site.config.coin.group.arc.delete"])?$this->config["site.config.coin.group.arc.delete"]:'';?>" >
</td>
<td class="tablerow1 tips">删除小组文章减少的金币个数</td>
</tr>

<tr>
	<th colspan="2" class="th1">添加问题:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.ask.arc.add" value="<?php echo isset($this->config["site.config.coin.ask.arc.add"]) ? $this->config["site.config.coin.ask.arc.add"]:'';?>" >
</td>
<td class="tablerow1 tips">添加问题增加的金币个数</td>
</tr>

<tr>
	<th colspan="2" class="th1">删除问题:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.ask.arc.delete" value="<?php echo isset($this->config["site.config.coin.ask.arc.delete"])?$this->config["site.config.coin.ask.arc.delete"]:'';?>" >
</td>
<td class="tablerow1 tips">删除问题减少的金币个数</td>
</tr>

<tr>
	<th colspan="2" class="th1">回答问题:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.ask.reply.add" value="<?php echo isset($this->config["site.config.coin.ask.reply.add"])?$this->config["site.config.coin.ask.reply.add"]:'';?>" >
</td>
<td class="tablerow1 tips">回答问题增加的金币个数</td>
</tr>


<tr>
	<th colspan="2" class="th1">删除回答:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.ask.reply.delete" value="<?php echo isset($this->config["site.config.coin.ask.reply.delete"]) ?$this->config["site.config.coin.ask.reply.delete"]:'';?>" >
</td>
<td class="tablerow1 tips">删除回答减少的金币个数</td>
</tr>

<tr>
	<th colspan="2" class="th1">添加评论:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.reply.add" value="<?php echo isset($this->config["site.config.coin.reply.add"])?$this->config["site.config.coin.reply.add"]:'';?>" >
</td>
<td class="tablerow1 tips">评论增加的金币个数</td>
</tr>

<tr>
	<th colspan="2" class="th1">删除评论:</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.coin.reply.delete" value="<?php echo isset($this->config["site.config.coin.reply.delete"])?$this->config["site.config.coin.reply.delete"]:'';?>" >
</td>
<td class="tablerow1 tips">删除评论减少的金币个数</td>
</tr>

</table>

<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption><a href="javascript:;" id="nav3">特定页面设置</a></caption>

<tr>
	<th colspan="2" class="th1">帮助中心</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.ask.helptag.id" value="<?php echo isset($this->config["site.config.ask.helptag.id"])?$this->config["site.config.ask.helptag.id"]:'';?>" >
</td>
<td class="tablerow1 tips">"帮助中心"是问答模块的一个标签，请填写中文标签名称,新建该标签可以去后台问答模块添加，将用于网站回答一些网友的提问或说明等</td>
</tr>

<tr>
	<th colspan="2" class="th1">官方小组id</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.group.my.id" value="<?php echo isset($this->config["site.config.group.my.id"])?$this->config["site.config.group.my.id"]:'';?>" >
</td>
<td class="tablerow1 tips">官方小组的小组id</td>
</tr>

<tr>
	<th colspan="2" class="th1">社区指导原则id</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.guidelines.id" value="<?php echo isset($this->config["site.config.guidelines.id"])?$this->config["site.config.guidelines.id"]:'';?>" >
</td>
<td class="tablerow1 tips">"社区指导原则"是创建小组时，必须遵循的原则，需要在官方小组添加这篇文章</td>
</tr>


<tr>
	<th colspan="2" class="th1">隐私声明id</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.secret.id" value="<?php echo isset($this->config["site.config.secret.id"])?$this->config["site.config.secret.id"]:'';?>" >
</td>
<td class="tablerow1 tips">"隐私声明",需要在官方小组添加这篇文章</td>
</tr>

<tr>
	<th colspan="2" class="th1">注册条款id</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.reg.id" value="<?php echo isset($this->config["site.config.reg.id"])?$this->config["site.config.reg.id"]:'';?>" >
</td>
<td class="tablerow1 tips">"注册条款",需要在官方小组添加这篇文章</td>
</tr>

<tr>
	<th colspan="2" class="th1">免责声明id</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.relief.id" value="<?php echo isset($this->config["site.config.relief.id"])?$this->config["site.config.relief.id"]:'';?>" >
</td>
<td class="tablerow1 tips">"免责声明",需要在官方小组添加这篇文章</td>
</tr>

<tr>
	<th colspan="2" class="th1">联系我们id</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.linkman.id" value="<?php echo isset($this->config["site.config.linkman.id"])?$this->config["site.config.linkman.id"]:'';?>" >
</td>
<td class="tablerow1 tips">"联系我们",需要在官方小组添加这篇文章</td>
</tr>

<tr>
	<th colspan="2" class="th1">关于我们id</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.config.aboutme.id" value="<?php echo isset($this->config["site.config.aboutme.id"])?$this->config["site.config.aboutme.id"]:'';?>" >
</td>
<td class="tablerow1 tips">"关于我们",需要在官方小组添加这篇文章</td>
</tr>
</table>

<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption><a href="javascript:;" id="nav4"> SMTP邮件发送服务器设置</a></caption>
<tr>
	<th colspan="2" class="th1">smtp服务器IP</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.smtp.SMTP.HOST" value="<?php echo isset($this->config["site.smtp.SMTP.HOST"]) ?$this->config["site.smtp.SMTP.HOST"]:'' ;?>" >
</td>
<td class="tablerow1 tips">如:smtp.exmail.qq.com</td>
</tr>

<tr>
	<th colspan="2" class="th1">smtp服务器端口</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.smtp.SMTP.PORT" value="<?php echo isset($this->config["site.smtp.SMTP.PORT"]) ? $this->config["site.smtp.SMTP.PORT"]:'';?>" >
</td>
<td class="tablerow1 tips">一般是25</td>
</tr>

<tr>
	<th colspan="2" class="th1">是否开启SSL验证</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.smtp.SMTP.SSL" value="<?php echo isset($this->config["site.smtp.SMTP.SSL"])?$this->config["site.smtp.SMTP.SSL"]:'';?>" >
</td>
<td class="tablerow1 tips">是则填“1”,否则"0"</td>
</tr>

<tr>
	<th colspan="2" class="th1">账户</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.smtp.SMTP.USERNAME" value="<?php echo isset($this->config["site.smtp.SMTP.USERNAME"])?$this->config["site.smtp.SMTP.USERNAME"]:'';?>" >
</td>
<td class="tablerow1 tips"></td>
</tr>


<tr>
	<th colspan="2" class="th1">密码</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="password" name="site.smtp.SMTP.PASSWORD" value="<?php echo isset($this->config["site.smtp.SMTP.PASSWORD"])?$this->config["site.smtp.SMTP.PASSWORD"]:'';?>" >
</td>
<td class="tablerow1 tips"></td>
</tr>

<tr>
	<th colspan="2" class="th1">是否需要验证</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.smtp.SMTP.AUTH" value="<?php echo isset($this->config["site.smtp.SMTP.AUTH"])?$this->config["site.smtp.SMTP.AUTH"]:'';?>" >
</td>
<td class="tablerow1 tips">是则填“1”,否则"0"</td>
</tr>

<tr>
	<th colspan="2" class="th1">编码</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.smtp.SMTP.CHARSET" value="<?php echo isset($this->config["site.smtp.SMTP.CHARSET"])?$this->config["site.smtp.SMTP.CHARSET"]:'';?>" >
</td>
<td class="tablerow1 tips">默认填"utf.8"</td>
</tr>

<tr>
	<th colspan="2" class="th1">发送人</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.smtp.SMTP.FROMTO" value="<?php echo isset($this->config["site.smtp.SMTP.FROMTO"])?$this->config["site.smtp.SMTP.FROMTO"]:'';?>" >
</td>
<td class="tablerow1 tips"></td>
</tr>

<tr>
	<th colspan="2" class="th1">发送人名称</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<input type="text" name="site.smtp.SMTP.FROMNAME" value="<?php echo isset($this->config["site.smtp.SMTP.FROMNAME"])?$this->config["site.smtp.SMTP.FROMNAME"]:'';?>" >
</td>
<td class="tablerow1 tips"></td>
</tr>

</table>

<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption><a href="javascript:;" id="nav5"> 统计设置</a></caption>
<tr>
	<th colspan="2" class="th1">cnzz统计代码</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<textarea name="site.stat_code.cnzz"><?php echo isset($this->config["site.stat_code.cnzz"])?stripslashes($this->config["site.stat_code.cnzz"]):'';?></textarea>
</td>
<td class="tablerow1 tips">输入cnzz统计代码,需要加上&lt;script&gt;&lt;/script&gt;</td>
</tr>

<tr>
	<th colspan="2" class="th1">百度统计代码</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<textarea name="site.stat_code.baidu"><?php echo isset($this->config["site.stat_code.baidu"])?stripslashes($this->config["site.stat_code.baidu"]):'';?></textarea>
</td>
<td class="tablerow1 tips">输入百度统计代码,需要加上&lt;script&gt;&lt;/script&gt;</td>
</tr>

</table>


<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<caption><a href="javascript:;" id="nav6"> 联合登录设置</a></caption>
<tr>
	<th colspan="2" class="th1">QQ互联.APP ID</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<textarea name="app.user.openlogin.qq.appkey"><?php echo isset($this->config["app.user.openlogin.qq.appkey"])?$this->config["app.user.openlogin.qq.appkey"]:'';?></textarea>
</td>
<td class="tablerow1 tips">输入QQ互联.APP ID</td>
</tr>

<tr>
	<th colspan="2" class="th1">QQ互联.APP KEY</th>
</tr>
<tr>
<td class="tablerow1 formrow">
<textarea name="app.user.openlogin.qq.appsecret"><?php echo isset($this->config["app.user.openlogin.qq.appsecret"])?$this->config["app.user.openlogin.qq.appsecret"]:'';?></textarea>
</td>
<td class="tablerow1 tips">输入QQ互联.APP KEY</td>
</tr>

</table>

<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
    <caption><a href="javascript:;" id="nav7"> 广告设置</a></caption>
    <tr>
        <th colspan="2" class="th1">全局广告</th>
    </tr>
    <tr>
        <td class="tablerow1 formrow">
            <textarea name="site.ads.golbal"><?php echo isset($this->config["site.ads.golbal"])?stripslashes($this->config["site.ads.golbal"]):'';?></textarea>
        </td>
        <td class="tablerow1 tips">输入广告代码,需要加上&lt;script&gt;&lt;/script&gt;</td>
    </tr>
</table>

<table cellspacing="0" cellpadding="3" align="center" border="0"  class="tableborder">
<tr>
	<td colspan="2" class="tablerow1">
	<button class="btnsubmit" type="submit" name="btnsubmit" value="yes">保存</button>
	</td>
</tr>
</table>
</form>