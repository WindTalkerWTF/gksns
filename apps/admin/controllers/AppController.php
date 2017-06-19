<?php

class Admin_AppController extends Admin_Controller_Action
{

    public function init()
    {
//    	$this->_helper->layout()->disableLayout();
//    	$this->_helper->viewRenderer->setNoRender();
    	//$this->_helper->cache(array("index"), array("sss"));
    }
     /********以下为自定义内容****************/
    
	function indexAction(){
		if(My_Tool::isPost()){
			$name = strtolower($this->p("name"));
			$aliname = strtolower($this->p("aliname"));
			$author = $this->p("author");
			
			$appNames = Admin::service()->getSys()->getAllAppNames();
			
			if(!$name || !$aliname || !$author){
			 	Admin_Tool::showAlert("所有输入框都必须填写!");
			 	$this->view->name = $name;
			 	$this->view->aliname = $aliname;
			 	$this->view->author = $author;
			}elseif(in_array($name, $appNames)){
				Admin_Tool::showAlert("英文名称已经存在!");
			 	$this->view->name = $name;
			 	$this->view->aliname = $aliname;
			 	$this->view->author = $author;
			}else{
				//开始复制模板
				$sourcePath = ROOT_DIR . "/data/tpl";
				$realPath = ROOT_DIR;
				$destinationPath = ROOT_DIR . "/data/cache/tpl";
				My_Tool::xCopy($sourcePath, $destinationPath);
				if(is_dir($destinationPath)){
					//批量文本替换
					My_Tool::batchReplace($destinationPath, "/@Tpl@/", ucfirst($aliname));
					My_Tool::batchReplace($destinationPath, "/@tpl@/", strtolower($aliname));
					//批量文件改名
					My_Tool::batchDirNameReplace($destinationPath, "/@Tpl@/", ucfirst($aliname));
					My_Tool::batchDirNameReplace($destinationPath, "/@tpl@/", strtolower($aliname));
					//创建静态样式文件
					mkdir(PUBLIC_DIR . "/res/asset/" . $aliname . "/images", 0777, true);
					mkdir(PUBLIC_DIR . "/res/asset/" . $aliname . "/js", 0777, true);
					//copy
					My_Tool::xCopy($destinationPath, $realPath);
					//修改info.ini;
					$iniStr = ";<?php /*\r\n[production]\r\napp.name= \"".$name."\";\r\napp.aliname= \"".$aliname."\";\r\napp.version=\"1.0\";\r\napp.author=\"".$author."\";\r\n;*/";
					$infoIniPath = ROOT_DIR ."/configs/".$aliname."/info.ini.php";
					file_put_contents($infoIniPath, $iniStr);
					//删除缓存
					My_Tool_File::deldir($destinationPath);
					//扫描app
					Admin::service()->getSys()->scannerAppInfo();
				}
				$this->showMsg("app创建成功!", $this->url("/app/index"));
			}
		}
	}
	
	#列表
	function listAction(){
		Admin::service()->getSys()->scannerAppInfo();
		//分页
		$page = (int) $this->getCookieParam("page");
    	$page = $page ? $page : 1;
    	$pageSize = 10;
    	
    	$limit = $pageSize * ($page-1);
		
    	$where = array();
    	
    	$this->view->list = Admin::service()->getSys()->getActionsInfo($where, "id DESC" ,$limit, $pageSize);
    	$this->view->totalNum =  Admin::dao()->getAppinfo()->getCount($where);
    	
    	$this->view->page = $page;
    	$this->view->pageSize = $pageSize;
	}
	
	function savetplAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->viewRenderer->setNoRender();
		$appName = $this->getParam("name");
		$tpl = $this->getParam("tpl");
		if(!$appName || !$tpl) My_Tool::showJsonp(500,"参数为空!");
		Admin::service()->getApp()->saveTpl($appName, $tpl);
		My_Tool::showJsonp(200);
	}
	
	//关闭或开启
	function openerAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->p("id");
		if(!$id) $this->showMsg("数据不存在!", $this->url("/app/list"));
		$info = Admin::dao()->getAppinfo()->get(array("id"=>$id));
		if(!$info) $this->showMsg("数据不存在!", $this->url("/app/list"));
		$state = $info['state'] ? 0 : 1;
		Admin::dao()->getAppinfo()->update(array("state"=>$state), array("id"=>$id));
		My_Cache::clearFileCache();
		$this->showMsg("操作成功!", $this->url("/app/list"));
	}
	//卸载
	function deleteAction(){
		$this->_helper->viewRenderer->setNoRender();
		$id = (int) $this->p("id");
		if(!$id) $this->showMsg("数据不存在!", $this->url("/app/list"));
		$info = Admin::dao()->getAppinfo()->get(array("id"=>$id));
		if(!$info) $this->showMsg("数据不存在!", $this->url("/app/list"));
		Home::service()->getCommon()->uninstall($info['name']);
		Admin::dao()->getAppinfo()->delete(array("id"=>$id));
		My_Cache::clearFileCache();
		$this->showMsg("操作成功!", $this->url("/app/list"));
	}
	
	//导出
	function exportAction(){
		Admin::service()->getSys()->scannerAppInfo();
		$this->view->app = Admin::dao()->getAppinfo()->gets();
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$app = (int) $this->p("app");
			$info = Admin::dao()->getAppinfo()->get(array("id"=>$app));
			$path = ROOT_DIR . $info['path'];
			$resPath = ROOT_DIR. "/res/asset/" . $info['name'];
			$libPath = ROOT_LIB. "/" . ucfirst($info['name']);
			$configPath = ROOT_DIR. "/configs/" . $info['name'];
			My_Tool::importOpen("pclzip.lib.php");
			
			//保存sql
			Admin::service()->getApp()->exportSql($info['name'],$path);
			
			$savePath = $path;
			
			if(is_dir($resPath)){
				$savePath .= ",".$resPath;
			}
			
			if(is_dir($libPath)){
				$savePath .= ",".$libPath;
			}
			
			if(is_dir($configPath)){
			    $savePath .= ",".$configPath;
			}
			
			$saveFile =  ROOT_DIR . "/data/cache/tmp/zipTmp/";
			if(!is_dir($saveFile)) mkdir($saveFile, 0777, true);
			$saveFile = $saveFile.time()."zipTmp.zip";
			$archive = new PclZip($saveFile);
			
        	$list= $archive->create($savePath,PCLZIP_OPT_REMOVE_PATH, ROOT_DIR, PCLZIP_OPT_ADD_TEMP_FILE_ON);
        	if(!$list){
        		Admin_Tool::showAlert("Error : ".$archive->errorInfo(true));
        	}else{
        		ob_end_clean();
        		header("Content-Type: application/force-download");
				header("Content-Transfer-Encoding: binary");
				header('Content-Type: application/zip');
	        	header("Content-Disposition: attachment; filename=".$info['name'].".zip");
	        	header('Content-Length: '.filesize($saveFile));
	        	error_reporting(0);
	        	readfile($saveFile);
	        	flush();
				ob_flush();
        	}
		}
	}
	
	//导入
	function importAction(){
		if(My_Tool::isPost()){
			$this->_helper->viewRenderer->setNoRender();
			$saveFileRoot =  ROOT_DIR . "/data/cache/tmp";
			
			$up = new My_Tool_Upload();
			$up->allowTypes = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed','application/octet-stream');
			
			$up->savePath =$saveFileRoot."/zip_upfile/";
			$up->uploadReplace = true;
			
			if(!is_dir($up->savePath)) mkdir($up->savePath, 0777, true);
			
			if(!$up->upload())
			 {
				//捕获上传异常
				Admin_Tool::showAlert($up->getErrorMsg());
			}
			else 
			{
				$info =  $up->getUploadFileInfo();
				$tmpPath = $info[0]['savepath'].$info[0]['savename'];
			    $extrPath = $saveFileRoot."/zip_extr/";
			    
			    if(!is_dir($extrPath)) mkdir($extrPath, 0777, true);
			    
				My_Tool::importOpen("pclzip.lib.php");
				$archive = new PclZip($tmpPath);
				$list = $archive->extract(PCLZIP_OPT_PATH, $extrPath);  
				
				if ($list == 0) {    
    				Admin_Tool::showAlert("Error : ".$archive->errorInfo(true));
				}else{
					$infoPath="";
					foreach($list as $v){
						$baseName = basename($v['filename']);
						if($baseName == "info.ini.php"){
							$infoPath = $v['filename'];
							break;
						}
					}
					if(!$infoPath){
						Admin_Tool::showAlert("应用别名为空!");
					}else{
						$config = My_Config::getInstance()->getSimpleConfig($infoPath);
						$aliName = isset($config['app']['aliname']) ? $config['app']['aliname']:"";
						if(!$aliName){
							Admin_Tool::showAlert("应用别名设置有误!");
						}else{
							$appNames = Admin::service()->getSys()->getAllAppNames();
							if(in_array($aliName, $appNames)){
								Admin_Tool::showAlert("应用已经存在");
							}else{
								$archive->extract(PCLZIP_OPT_PATH, ROOT_DIR);
								if(is_file($saveFileRoot))  My_Tool_File::deldir($saveFileRoot);
								Home::service()->getCommon()->install($aliName);
								Admin_Tool::showAlert("导入成功!");
							}
						}
					}
				}
				
			}
			
		}
	}
	
}

