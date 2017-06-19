<?php
class Admin_Service_App extends Home_Service_Base{
	function init(){
	}
	
	//导出sql
	function exportSql($appName, $appPath){
		$filePath = $appPath . "data/sql/install.sql";
		$unFilePath = $appPath . "data/sql/uninstall.sql";
		$dirPath = dirname($filePath);
		if(!is_dir($dirPath)) mkdir($dirPath, 0777, true);
		$myTables = $this->getTables($appName, $appPath);
		if(!$myTables){
			file_put_contents($filePath, "");
		}
		$sql = "";
		$unsql = "";
		foreach ($myTables as $v){
			$unsql .= "DROP TABLE " . $v.";\n";
			$createSqlTmp = Home::dao()->getCommon()->selectRow("SHOW CREATE TABLE " . $v);
			$createSql = $createSqlTmp['Create Table'];
			$createSql = str_ireplace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $createSql);
			$sql .= str_replace(array("\n","\t"), "" , $createSql) . ";\n";
			
			$info = Home::dao()->getCommon()->selectAll("SELECT * FROM ". $v);
			if($info){
				foreach($info as $iv){
					$fields = array_keys($iv);
					$values = My_Tool::escape(array_values($iv));
					$sql .= "INSERT INTO {$v}(`" . implode("`,`", $fields) . "`) VALUES ('" . implode("','", $values) . "');\n";
				}
			}
			
		}
		if($sql) file_put_contents($filePath, $sql);
		if($unsql) file_put_contents($unFilePath, $unsql);
	} 
	
	
	function getTables($appName, $appPath){
		$tables = Home::dao()->getCommon()->selectAll("SHOW TABLES");
		$myTables = array();
		if($tables){
			foreach ($tables as $v){
				$v = array_values($v);
				$arr = explode("_", $v[0]);
				if($arr[0] == $appName){
					$myTables[] = $v[0];
				}
			}
		}
		
		return $myTables;
	}
	
	#获取app当前模板
	function getAppCurentTpl($appName){
		$config = My::config()->getConfig("init",1,1,$appName);
		return $config['view']['tpl'];
	}
	
	#保存模板
	function saveTpl($appName,$tpl){
		$data['view.tpl'] = $tpl;
		return My::config()->save($data,"init",1,$appName);
	}
	
	#获取app所有模板
	function getAppTpls($appName){
		$tplPath = ROOT_DIR . DS . "apps" . DS . strtolower($appName) . DS . "views";
		$path = My_Tool_File::getDirNames($tplPath);
		return $path;
	}
	
}