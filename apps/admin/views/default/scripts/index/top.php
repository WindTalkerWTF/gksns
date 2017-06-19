<!doctype html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php 
echo $this->loadscript("/admin/common.css");
?>
	</head>
	<body id="top_page">
		<div id="top">
			<div class="logo fl"><h1>捷库sns系统</h1></div>
			<div class="nav">
				<div class="top_menu">
					<p class="fl lh32">您好，<span class="red fwb"><?php echo $this->user['nickname']?></span> 
					[ <a href="<?php echo $this->url("/index/logout"); ?>">退出</a> ]
					[ <a href="javascript:parent.frameRight.window.location.reload()">刷新当前页</a> ]
					</p>
					<p class="fr lh32"><a href="<?php echo $this->url("index/index","home"); ?>">网站首页</a> </p>
				</div>
			</div>
		</div>
<?php 
echo $this->loadscript("/js/jquery-1.7.2.min.js");
echo $this->loadscript("/js/jquery.cookie.js");
echo $this->loadscript("/admin/js/common.js");
?>
	</body>
</html>