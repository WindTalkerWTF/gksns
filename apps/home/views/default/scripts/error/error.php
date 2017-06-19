<?php 
if(isDebug()):
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>错误提示</title>
<link rel="shortcut icon" href="/res/favicon.ico" />
</head>
<body>
	<h2>
		<?php echo $this->message ?>
	</h2>

	<?php if (isset($this->exception)): ?>

	<h3>Exception information:</h3>
	<p>
		<b>Message:</b>
		<?php echo $this->exception->getMessage() ?>
	</p>

	<h3>Stack trace:</h3>
	<pre>
		<?php echo $this->exception->getTraceAsString() ?>
  </pre>

	<h3>Request Parameters:</h3>
	<pre>
		<?php echo var_export($this->request->getParams(), true) ?>
  </pre>
	<?php endif ?>

</body>
</html>
<?php else:?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>404错误页面</title>
        <style type="text/css">
            body {margin:0;padding:0;font-size:14px;line-height:1.231;color:#555;text-align:center;font-family:"微软雅黑", "黑体";}
            a {color:#999;text-decoration:none;}
            a:hover {color:#2E7BB8;}
            #container {width:684px;height:315px;margin:100px auto; border:#666 dotted 1px;}
            #container #title {overflow:hidden; padding-top:30px;}
            #container #title h1 {font-size:36px;text-align:center;color:#555;}
            #content p{ font-size:18px;}
            #footer {width:100%;padding:20px 0px;font-size:14px;color:#555;text-align:center;}
        </style>
    </head>

    <body>
    <div id="container">
        <div id="title"><h1>法海不懂爱~页面不出来!</h1></div>
        <div id="content">
            <p><a href="<?php echo $this->url("index/index","home"); ?>" style="color:#F00">返回网站首页</a></p>
            <br />
        </div>
    </div>
    </body>
    </html>

<?php endif;?>
