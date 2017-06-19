<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>网站后台管理</title>
<meta http-equiv="expires" content="0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<!--meta http-equiv="X-UA-Compatible" content="IE=8" /-->
<?php 
echo $this->loadscript("/asset/admin/style.css");
?>
<script>
var IE6 = navigator.userAgent.toLowerCase().indexOf("msie 6") > -1;
var IE7 = navigator.userAgent.toLowerCase().indexOf("msie 7") > -1;

function $(id) { return (typeof id == 'string' ? document.getElementById(id) : null);}

function $T(name) { return (typeof name == 'string' ? document.getElementsByTagName(name) : null);}

function showsubmenu(sid) {
	var whichEl = document.getElementById("submenu_" + sid);
	var menuTitle = document.getElementById("menutitle_" + sid);
	if (whichEl!=null) {
		if (whichEl.style.display == "none"){
			whichEl.style.display='';
			if (menuTitle!=null)
			menuTitle.className='menu_title';
		}else{
			whichEl.style.display='none';
			if (menuTitle!=null)
			menuTitle.className='menu_title2';
		}
	}
}

function toggleMenubar(n){
	var menutoggle = document.getElementById('menutoggle');
	var menubar = document.getElementById('admin_menubar');
	var contont = document.getElementById('admin_contont');
	if(n == 1){
		menubar.style.display = 'none';
		menutoggle.className = 'menutoggle-2';
		if (!IE6 && !IE7) contont.style.left = 5+'px';
	}else{
		menubar.style.display = '';
		menutoggle.className = 'menutoggle-1';
		if (!IE6 && !IE7) contont.style.left = 160+'px';
		
	}
}

function toggleMenuTabs(obj, id){
	var navtab = document.getElementById("tabs").getElementsByTagName("a");
	for(var i= 0,len = navtab.length;i<len;++i){
		if(navtab[i].clssName !==""){
			navtab[i].className = "";
		}
	}
	obj.className = "active";
	obj.blur();
	if(id == 'help' || id == 'logout' || id == 'home') return;
	var menubars = document.getElementById("admin_menubar").getElementsByTagName("dl");
	for(var i= 0,len = menubars.length;i<len;++i){
		menubars[i].style.display = 'none';
	}
	var menuid = document.getElementById("menu_" + id);
	if(menuid){
		menuid.style.display = '';
		var menus = menuid.getElementsByTagName("li");
		for(var i= 0,len = menus.length;i<len;++i){
			if(menus[i].clssName !== ""){
				menus[i].className = "";
			}
			if(i == 0){
				menus[0].className = "current";
			}
		}
	}
}

function showAllMenus(){
	var menubars = document.getElementById("admin_menubar").getElementsByTagName("dl");
	for(var i= 0,len = menubars.length;i<len;++i){
		menubars[i].style.display = '';
	}
}
var menuTimeout = null;
function previewMenu(id){
	if(id){
		if(id == 'help' || id == 'logout' || id == 'home') return;
		menuTimeout = setTimeout(function() {
			var menubars = document.getElementById("admin_menubar").getElementsByTagName("dl");
			for(var i= 0,len = menubars.length;i<len;++i){
				menubars[i].style.display = 'none';
			}
			var menuid = document.getElementById("menu_" + id);
			if(menuid){
				menuid.style.display = '';
			}
		},1000);
	}else{
		clearTimeout(menuTimeout);
	}
	
	
}

function admincpMenuScroll(op, e){
	var obj = document.getElementById('admin_menubar');
	var scrollh = document.body.offsetHeight - 110;
	if(op == 1) {
		obj.scrollTop = obj.scrollTop - scrollh;
	} else if(op == 2) {
		obj.scrollTop = obj.scrollTop + scrollh;
	} else if(op == 3) {
		if(!e) e = window.event;
		if(e.wheelDelta <= 0 || e.detail > 0) {
			obj.scrollTop = obj.scrollTop + 20;
		} else {
			obj.scrollTop = obj.scrollTop - 20;
		}
	}
}

function admincpMenus(obj){
	var menus = document.getElementById("admin_menubar").getElementsByTagName("li");
	for(var i= 0,len = menus.length;i<len;++i){
		if(menus[i].clssName !== ""){
			menus[i].className = "";
		}
	}
	obj.className = "current";
	obj.blur();
}

function initAdmincpMenus(){
	var menus = $('admin_menubar').getElementsByTagName('li');
	for (var i = 0, len = menus.length; i<len; ++i) {
		menus[i].onmouseover = function(e){
			if(this.className == ''){
				this.className = 'active';
			}
			if(this.getElementsByTagName('span')[0])
				this.getElementsByTagName('span')[0].className = 'y';
		};
		menus[i].onmouseout = function(){
			if(this.className == 'active'){
				this.className = '';
			}else{
				this.className = this.className.replace(/active /, '');
			}
			if(this.getElementsByTagName('span')[0])
				this.getElementsByTagName('span')[0].className = 'x';
		};
		menus[i].onclick = function(){
			admincpMenus(this);
		}
		if(i == 0){
			menus[0].className = "current";
		}
	}
}

</script>
<link rel="shortcut icon" href="/res/favicon.ico" />
</head>
<body>
	<div id="admin_header">
		<div id="admin_logo">
			<img src="<?php echo $this->img("/res/asset/admin/images/admin-logo.png"); ?>" height="50" width="155">
		</div>
		<div id="admin_topmenu">
			<div id=""></div>
			<div id="navbox">
				<div id="tabs">
					<ul id="topmenu">
						<li class="first"><a target="mainFrame"
							href="<?php echo $this->url("/sys/setting"); ?>"
							id="tabs_index" onclick="toggleMenuTabs(this, 'index')"
							hidefocus="true" class="active">系统管理</a></li>
					   <?php if($this->appinfo):?>
					   <?php 
					   		$count=count($this->appinfo);
					   		$pnum = $count%3 == 0 ?  $count/3 : ceil($count/3);
					   		for($i=1; $i<=$pnum;$i++):
					   ?>
					   <li><a class="" target="mainFrame"
							href="javascript:void(0);" id="tabs_app"
							onclick="toggleMenuTabs(this, 'app<?php echo $i;?>')"
							hidefocus="true">app管理</a></li>
							<?php endfor;?>
					   <?php endif;?>
					   <?php if($this->pmenu):?>
					   <?php foreach($this->pmenu as $v):?>
					   		<li><a class="" target="mainFrame"
							href="javascript:void(0);" id="tabs_<?php echo md5($v['name']);?>"
							onclick="toggleMenuTabs(this, '<?php echo md5($v['name']);?>')"
							hidefocus="true"><?php echo $v['name'];?></a></li>
					   <?php endforeach;?>
					   <?php endif;?>
					</ul>
				</div>
			</div>
			<div id="admin_info">
				您好，<strong style="color: #ff8800"><?php echo $this->user['nickname'];?>
				</strong> <a href="<?php echo $this->url("/index/logout"); ?>">退出</a>
			</div>
			<div style="clear: both"></div>
		</div>
	</div>
	<div id="admin_menubar">
		<dl id="menu_index" style="display:">
			<dt class="menu_title" id="menutitle_index"
				onclick="showsubmenu('index')">管理首页</dt>
			<dd id="submenu_index">
				<ul>
				    <li><a style="display: block" target="mainFrame"
						href="<?php echo $this->url("/sys/setting"); ?>" hidefocus="true">网站设置</a>
					</li>
					<li><a style="display: block" target="mainFrame"
						href="<?php echo $this->url("/sys/actions"); ?>" hidefocus="true">节点管理</a>
					</li>
					<li><a style="display: block" target="mainFrame"
						href="<?php echo $this->url("/sys/roles"); ?>" hidefocus="true">角色管理</a>
					</li>
					<li><a style="display: block" target="mainFrame"
						href="<?php echo $this->url("/sys/masters"); ?>" hidefocus="true">管理员管理</a>
					</li>
					<li><a style="display: block" target="mainFrame"
						href="<?php echo $this->url("/menu/index"); ?>" hidefocus="true">自定义菜单</a>
					</li>
					<li><a style="display: block" target="mainFrame"
						href="<?php echo $this->url("/app/list"); ?>" hidefocus="true">App管理</a>
					</li>
                    <li><a style="display: block" target="mainFrame"
                           href="<?php echo $this->url("/user/index"); ?>" hidefocus="true">用户管理</a>
                    </li>
					<li><a style="display: block" target="mainFrame"
						href="<?php echo $this->url("/reply/reply-list"); ?>" hidefocus="true">评论管理</a>
					</li>
                    <li><a style="display: block" target="mainFrame"
                           href="<?php echo $this->url("/linked/index"); ?>" hidefocus="true">友情链接管理</a>
                    </li>
                    <li><a style="display: block" target="mainFrame"
                           href="<?php echo $this->url("/sys/cache"); ?>" hidefocus="true">缓存管理</a>
                    </li>
                    <li><a style="display: block" target="mainFrame"
                           href="<?php echo $this->url("sys/tree-list"); ?>" hidefocus="true">栏目管理</a>
                    </li>
                    <li><a style="display: block" target="mainFrame"
                           href="<?php echo $this->url("sys/tag-list"); ?>" hidefocus="true">tag管理</a>
                    </li>
				</ul>
			</dd>
		</dl>
		<?php if($this->appinfo):?>
		<?php for($i=1;$i<=$pnum;$i++):
			  $start = ($i-1)*3;
			  $start = $start <0 ? 0:$start;
			  $appMenu = array_slice($this->appinfo, $start, 3);
		?>
		<dl id="menu_app<?php echo $i;?>" style="display: none">
			<?php foreach($appMenu as $k=>$v):?>
<dt class="menu_title" id="menutitle_<?php echo md5($v['name']);?>" onclick="showsubmenu('<?php echo md5($v['name']);?>')"><?php echo $v['view_name'];?>管理</dt>
					<dd id="submenu_<?php echo md5($v['name']);?>">
						<ul>
						<?php foreach ($v['menulist'] as $mk=>$mv):?>
							<li><a style="display: block" target="mainFrame"
								href="<?php echo $this->url($mv, $v['name']); ?>" hidefocus="true"><?php echo $mk;?></a>
							</li>
						<?php endforeach;?>
						</ul>
					</dd>
			<?php endforeach;?>
		</dl>
		<?php endfor;?>
		<?php endif;?>
		 <?php if($this->pmenu):?>
					   <?php foreach($this->pmenu as $v):?>
					   <dl id="menu_<?php echo md5($v['name'])?>" style="display: none">
			<dt class="menu_title" id="menutitle_<?php echo md5($v['name'])?>"
				onclick="showsubmenu('<?php echo md5($v['name'])?>')"><?php echo $v['name']?></dt>
						<dd id="submenu_<?php echo md5($v['name'])?>">
						<?php if($v['cmenu']):?>
							<ul>
						<?php foreach($v['cmenu'] as $cv):?>	
								<li><a style="display: block" target="mainFrame"
									href="<?php echo $this->url($cv['url']); ?>" hidefocus="true"><?php echo $cv['name'];?></a>
								</li>
						<?php endforeach;?>
							</ul>
						<?php endif;?>
						</dd>
			</dl>
		<?php endforeach;?>
		 <?php endif;?>
		<script type="text/JavaScript">initAdmincpMenus();</script>
	</div>
	<div id="admin_switchbar"></div>
	<div id="admin_contont">
		<div id="x-content" style="height: 100%; width: 100%;">
			<div id="mainContainer"
				style="height: 100%; float: left; width: 100%;">
				<iframe src="<?php echo $this->url("/sys/setting"); ?>" id="mainFrame" name="mainFrame"
					style="height: 100%; visibility: inherit; width: 100%; z-index: 1; overflow: visible;"
					frameborder="no" scrolling="yes"> </iframe>
			</div>
		</div>
	</div>
	<div id="admin_bottom">
		<div id="menu-switch">
			<div class="menutoggle-1" id="menutoggle">
				<a class="mt1" href="javascript:void(0)" onclick="toggleMenubar(1)"
					title="隐藏左边栏"></a><a class="ms1" href="javascript:void(0)"
					onclick="admincpMenuScroll(1)"></a> <a class="sam"
					href="javascript:void(0)" onclick="showAllMenus()" title="显示所有菜单"></a>
				<a class="mt2" href="javascript:void(0)" onclick="toggleMenubar(2)"
					title="显示左边栏"></a><a class="ms2" href="javascript:void(0)"
					onclick="admincpMenuScroll(2)"></a>
			</div>
		</div>
		<div id="taskbar"></div>
		<div style="clear: both"></div>
	</div>
	<div style="clear: both"></div>

</body>
</html>
