<?php
class Admin_Service_Sys extends Home_Service_Base{
	
	function scannerActions(){
		#扫描app
		$appActions = $this->_scannerApp();
		$paths = array();
		if($appActions){
			foreach ($appActions as $v){
				$appName = $v['app'];
				$controllerName = $v['controller'];
				$actionName = $v['action'];
				$name = $appName."#".$controllerName."#".$actionName;
				$data['action'] = $actionName;
				$data['controller'] = $controllerName;
				$data['app'] = $appName;
				$data['path'] = $name;
				$data['name'] = $name;
				if(!Admin::dao()->getActions()->get(array("path"=>$name))){
					Admin::dao()->getActions()->insert($data);
				}
				$paths[] = $name;
			}
			//删除多余的
			$cActions = Admin::dao()->getActions()->gets();
			if($cActions){
				foreach ($cActions as $v){
					if(!in_array($v['path'], $paths)){
						Admin::dao()->getActions()->delete(array("id"=>$v['id']));
					}
				}
			}
		}
		
		$this->scannerAppInfo();
		
		return true;
	}
	
	/**
	 * 
	 * 应用名称
	 */
	public function getMoreAppNames(){
		$this->clearAppCache();
		//app library
		$appNames = fileCached("data/apps.php", array("My_Tool_File", "getDirNames"), array(ROOT_DIR . '/apps'));
		
		$rs = array();
		if($appNames){
			foreach($appNames as $v){
				//剔除不需要的app
				if(preg_match("/^@.*?@$/", $v)) continue;
				
				$rs[] = $v;
			}
		}
		return $rs;
	}
	
	public function getAllAppNames(){
		$appNames = $this->getAppNames();
		return $appNames;
	}
	
	#清空缓存
	function clearCache(){
		My_Cache::clearFileCache();
	}
	
	#清空缓存
	function clearAppCache(){
	    $data = array(CACHE_DIR . "/data/_apps_/appinfo.php",CACHE_DIR . "/data/_apps_/apps.php");
	    My_Cache::deleteFileCacheList($data);
	}
	/**
	 * 
	 * 应用信息
	 */
	public function getAppInfo(){
		$appNames = $this->getMoreAppNames();
		$configResult = array();
		if($appNames){
			foreach($appNames as $v){
				$path= ROOT_DIR .DS."configs".DS.$v.DS."info.ini.php";
				$tmpPath = DS . "apps".DS.$v.DS;
                
				$configPath = CACHE_DIR . "/ini" . DS . "_appinfo_".DS.md5($path).".php";
				$configInfo = My_Config::getInstance()->getSimpleConfig($path, $configPath);
				if($configInfo){
					$configInfo['app']['path'] = $tmpPath;
					$configInfo['app']['state'] = 1;
					$configResult[$v] = $configInfo['app'];
				}
			}
		}
		return $configResult;
	}
	
	public function scannerAppInfo(){
		$appInfo = $this->getAppInfo();
		
		if($appInfo){
			$appNames = array();
			foreach ($appInfo as $k=>$v){
					$appNames[] = $k;
					$appInfoTmp = Admin::dao()->getAppinfo()->get(array("name"=>$k));
					$data['name'] = $k;
					$data['version'] = $v['version'];
					$data['author'] = $v['author'];
					$data['view_name'] = $v['name'];
					$data['path'] = $v['path'];
				if($appInfoTmp){
					Admin::dao()->getAppinfo()->update($data,array("name"=>$k));
				}
				else{
					Admin::dao()->getAppinfo()->insert($data);
				}
			}
			//删除没有的apps
			$allAppNames = $this->getAppNames();
			$diff = array_diff($allAppNames, $appNames);
			if($diff){
				foreach($diff as $v){
				//删除action等
				$roleactionSql = "DELETE a FROM admin_roleaction a INNER JOIN admin_actions b ON a.action_id = b.id AND b.app='".$v."' ";
				Home::dao()->get()->exec($roleactionSql);
				Admin::dao()->getActions()->delete(array("app"=>$v));
				//删除appinfo
				Admin::dao()->getAppinfo()->delete(array("name"=>$v));
			}
		  }
		}
		return true;
	}
	
	function getAppNames(){
		if(!My_Init::$isInstall) return array("install");
		$allAppNames = array();
		$allApps = Admin::dao()->getAppinfo()->gets();
		if($allApps){
			foreach($allApps as $v){
				$allAppNames[] = $v['name'];
			}
		}
		return $allAppNames;
	}
	
	#扫描后台
	private function _scannerAdmin(){
		return $this->_getActions("admin");
	}

	#扫描app
	private function _scannerApp(){
		$appNames = $this->getMoreAppNames();
		
		$result=array();
		if($appNames){
			foreach($appNames as $v){
				$actions = $this->_getActions($v);
				if($actions) $result = array_merge_recursive($actions, $result);
			}
		}
		return $result;
	}
	
	private function _getActions($appName){
		if(!$appName) throw new Admin_Exception("app 名称为空!");
		$isAdmin = strtolower($appName) == "admin" ? true:false;
		$actions = array();
	    $path = APPLICATION_PATH . DS. $appName . DS . "controllers";
		$methods = array();
		$file = My_Tool_File::listFiles($path);
		$defaultModuleName = Zend_Controller_Front::getInstance()->getDefaultModule();
		if($file){
			foreach($file as $fv){
				$controllernameArr = preg_split("/(?=[A-Z])/", str_replace("Controller.php", "", $fv));
				$controllername = implode('-', $controllernameArr);
				$controllername = ltrim($controllername, '-');
				$controllername = strtolower($controllername);
				if(!Admin::service()->getCommon()->isAdminController($appName, $controllername)) continue;
				if($appName != $defaultModuleName){
				    $fileName = ucfirst($appName). "_" . str_replace(".php", "", $fv);
				}else{
				    $fileName = str_replace(".php", "", $fv);
				}
				if(!is_file($path . DS . $fv)) continue;
				include_once $path . DS . $fv;
				$methods = get_class_methods($fileName);
				if($methods){
					foreach ($methods as $v){
						if(substr($v, -6, 6)=="Action"){
							$actionsTmp['app'] =  $appName;
							$actionsTmp['controller'] =  $controllername;
							$actionsTmp['action'] =  substr($v, 0, strlen($v)-6);
							$actions[] = $actionsTmp;
						}
					}
				}
				
			}
		}
		return $actions;
	}
	
	#获取节点信息
	function getActionsInfo($where, $orderBy ,$limit, $pageSize){
		$list = Admin::dao()->getAppinfo()->gets($where, "id DESC" ,$limit, $pageSize);
		$result = array();
		if($list){
		    $adminCommonService = new Admin_Service_Common();
			foreach($list as $k=>$v){
			    $name = $v['name'];
			    if($adminCommonService->isCoreApp($name)) continue;
				$actions = Admin::dao()->getActions()->gets(array("app"=>$name));
				$result[$k]=$v;
				$result[$k]['actions'] = $actions;
				$result[$k]['tpl'] = Admin::service()->getApp()->getAppCurentTpl($name);
				$result[$k]['all_tpl'] = Admin::service()->getApp()->getAppTpls($name);
			}
		}
		
		return $result;
	}
	
	
}