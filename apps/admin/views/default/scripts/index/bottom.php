<!doctype html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php 
echo $this->loadscript("/admin/common.css");
?>
	</head>
	<body>
		<div id="bottom">
			<p class="fl lh24">Powered by 知乐网</p>
			<script type="text/javascript">
				var enabled = 0;
				var today = new Date();
				if(today.getDay()==0) day = " 星期日"
				if(today.getDay()==1) day = " 星期一"
				if(today.getDay()==2) day = " 星期二"
				if(today.getDay()==3) day = " 星期三"
				if(today.getDay()==4) day = " 星期四"
				if(today.getDay()==5) day = " 星期五"
				if(today.getDay()==6) day = " 星期六"
				document.fgColor = "000000";
				date = "<p class='fr lh24'>" + today.getFullYear() + "年" + (today.getMonth() + 1 ) + "月" + today.getDate() + "日" + day + "</p>";
				document.write(date);
			</script>
		</div>
<?php 
echo $this->loadscript("/js/jquery-1.7.2.min.js");
echo $this->loadscript("/js/jquery.cookie.js");
echo $this->loadscript("/admin/js/common.js");
?>
	</body>
</html>