<?php
class Install_Service_Common{
	function getAdmMenu(){
		$config = My_Config::getInstance()->getConfig("init", 1, 1, "install");
		return isset($config['adminUrl']) ? $config['adminUrl']:"";
	}
	
	function checkDbConn($host,$port,$user,$pwd,$dbName){
		try{
			$link= mysql_connect($host.':'.$port,$user,$pwd);
			if(!$link){
				echo "<pre>";
				var_dump(mysql_error());
				throw new Exception('数据库连接失败，请检查连接信息是否正确！');
			}
			$status= mysql_select_db($dbName,$link);
			if(!$status){
				throw new Exception('数据库连接成功，请先建立数据库！');
			}
		}catch (Exception $e){
			return My_Tool::errorReturn($e->getMessage());
		}
		return true;
	}
	
	function install($host,$port,$user,$pwd,$dbName){
		$data['master.host'] = $host;
		$data['master.port'] = $port;
		$data['master.dbname'] = $dbName;
		$data['master.username'] = $user;
		$data['master.password'] = $pwd;
		$data['master.charset'] = 'utf8';
		
		$data['slave.host'] = $host;
		$data['slave.port'] = $port;
		$data['slave.dbname'] = $dbName;
		$data['slave.username'] = $user;
		$data['slave.password'] = $pwd;
		$data['slave.charset'] = 'utf8';
		echo "<pre>";
		print_r($data);
		My_Config::getInstance()->save($data,"db");
		$obj = new Home_Service_Common();
		$obj->install("install");
        return true;
	}
	
}