<?php
abstract class Home_Dao_Base extends My_Dao_Abstract{
	protected static $_dbConfigFileName = "db";
	protected  function getDbConfigFileName() {
		return self::$_dbConfigFileName;
	}
	
	function insert(array $data){
	    if(isset($data['content'])) $data['content'] = My_Tool::removeXss($data['content']);
	    if(isset($data['title'])) $data['title'] = My_Tool::removeXss($data['title']);
	    return parent::insert($data);
	}
	
	function update(array $data, $where = array()){
	    if(isset($data['content'])) $data['content'] = My_Tool::removeXss($data['content']);
	    if(isset($data['title'])) $data['title'] = My_Tool::removeXss($data['title']);
	    return parent::update($data,$where);
	}
	
}