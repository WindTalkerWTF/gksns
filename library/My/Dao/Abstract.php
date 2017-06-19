<?php
/**
 * 
 * 处理dao连接，读写分离等
 * @author kaihui_wang
 *
 */
abstract class My_Dao_Abstract{
  static $hasTran = 0;//是否有事务
	private $_adapter = null;
	private $_total=0;
	
	abstract protected  function getDbConfigFileName();
	abstract protected  function getTableName();
	abstract protected  function getPK();
	protected $_sql = "";
	/**
	 * 
	 * 设置配置器
	 * @param string $dbConfigFileName
	 * @param string $adapterType
	 */
	protected function getAdapter($adapterType='master'){
		
		$dbConfigFileName = $this->getDbConfigFileName();

		if(!$dbConfigFileName) return false;
		My_Connection_Pdo::getInstance()->setConfig($dbConfigFileName);
		
		switch ($adapterType){
			case "master" : $this->_adapter = My_Connection_Pdo::getInstance()->getMasterConnection();
			default : $this->_adapter = My_Connection_Pdo::getInstance()->getSlaveConnection();
		}
		$this->_adapter->setFetchMode(Zend_Db::FETCH_ASSOC);
		return $this->_adapter;
	}
	
	/*
	 * 更新专用
	 */
	public function getMasterDb(){
		return $this->getAdapter("master");
	}
	
	/**
	 * 查询专用
	 */
	public function getDb(){
		return $this->getAdapter("slave");
	}
	
	/**
	 * 启动事务
	 * @access public
	 * @return void
	 */
	public function startTrans() {
	    if(!self::$hasTran){
	        $this->exec("BEGIN",null,0);
	    }
	    self::$hasTran++;
	    return true;
	}
	
	/**
	 * 提交事务
	 * @access public
	 * @return boolean
	 */
	public function commit() {
	    if(self::$hasTran) self::$hasTran--;
	    if(!self::$hasTran){
	        return $this->exec("COMMIT",null,0);
	    }
	}
	
	/**
	 * 事务回滚
	 * @access public
	 * @return boolean
	 */
	public function rollback() {
	    self::$hasTran = 0;
	    return  $this->exec("ROLLBACK",null,0);
	}
	
	/**
     * invokes the read/write connection
     */
    public function insert(array $data)
    {
        $tableName = $this->getTableName();
        $return = $this->getMasterDb()->insert($tableName, $data);
        $lastInsertId = $this->getMasterDb()->lastInsertId();
        return $lastInsertId;
    }
    
    /**
     * 根据条件，有则更新，无则插入
     */
    public function insertIf(array $data, array $where){
    	if(!$data || !$where) return false;
    	$tableName = $this->getTableName();
    	$whereSql = $this->parseWhere($where);
    	
    	$keys = array_keys($data);
    	$sql = "INSERT INTO ".$tableName."(".implode(',', $keys).")
                VALUES(:".implode(', :', $keys).")
                ON DUPLICATE KEY UPDATE " . $whereSql;
    	
    	foreach ($data as $k=>$v){
    		$v = $this->getMasterDb()->quote($v);
    		$sql = str_replace(":" . $k, $v, $sql);
    	}
	
    	$this->getMasterDb()->query($sql);
    	$this->_sql = $sql;
    	return true;
    }
    
	/**
     * invokes the read/write connection
     */
    public function delete($where = array())
    {
        $tableName = $this->getTableName();
        
     	$whereStr = $this->parseWhere($where);
        $return = $this->getMasterDb()->delete($tableName, $whereStr);
        return $return;
    }
    
    
 	/**
     * Invokes the read/write connection
     */
    public function update(array $data, $where = array())
    {
        $tableName = $this->getTableName();
        
	      $whereStr = $this->parseWhere($where);
	    
        $this->getMasterDb()->update($tableName, $data, $whereStr);
        return true;
    }
    
    /**
     * 
     * 自增
     * @param string $field
     * @param array $where
     */
    public function inCrease($field, $where = array(), $number=1)
    {
        $tableName = $this->getTableName();
        
       	$whereSql = $this->parseWhere($where);
    	$whereSql = $whereSql ? " WHERE " . $whereSql  : "";
        
        $sql = "UPDATE `{$tableName}` SET {$field} = {$field} +{$number} " . $whereSql;
//        My_Tool::debug($sql);
        $this->getMasterDb()->query($sql);
    	$this->_sql = $sql;
        return true;
    }
    
    
    /**
     * 
     * 自减
     * @param string $field
     * @param array $where
     */
    public function deCrement($field, $where = array(), $number=1)
    {
        $tableName = $this->getTableName();
        
       	$whereSql = $this->parseWhere($where);
    	$whereSql = $whereSql ? " WHERE " . $whereSql : "";
        
        $sql = "UPDATE `{$tableName}` SET {$field} = {$field} - {$number} " . $whereSql;
        $this->getMasterDb()->query($sql);
    	$this->_sql = $sql;
    	
        return true;
    }
    /**
     * 
     * 更新，插入，删除sql执行,只返回受影响的行数
     * @param unknown_type $sql
     * @param unknown_type $data
     */
    function exec($sql, $data=array(), $check=1){
    	if(empty($sql)) return false;
    	if($check){
    		if(!(stristr($sql, "insert") || stristr($sql, "update") || stristr($sql, "delete") || stristr($sql, "drop"))) throw new My_Exception("此函数只能用于添加，更新，删除数据库操作");
    	}
    	if($data){
    		foreach ($data as $k=>$v){
    			$v = $this->getMasterDb()->quote($v);
    			$sql = str_replace(":" . $k, $v, $sql);
    		}
    	}
    	$this->_sql = $sql;
//    	echo $sql;exit;
    	$result = $this->getMasterDb()->exec($sql);
    	return $result;
    }
    
    /**
     * sql语句获取数据库数据
     * @param string $sql
     * @param array $data
     */
    function selectRow($sql, $data = array()){
    	if(empty($sql)) return false;
    	if(stristr($sql, "insert") || stristr($sql, "update") || stristr($sql, "delete")) throw new My_Exception("此函数不能用于添加，更新，删除数据库操作");
    	if($data){
    		foreach ($data as $k=>$v){
    			$v = $this->getDb()->quote($v);
    			$sql = str_replace(":" . $k, $v, $sql);
    		}
    	}
    	$this->_sql = $sql;
    	return $this->getDb()->fetchRow($sql);
    }
    
    /**
     * 
     * 用sql语句获取所有
     * @param string $sql
     * @param array $data
     * @param $returnCount //SQL_CALC_FOUND_ROWS
     */
    function selectAll($sql, $data =array(), $returnCount=false){
    	if(empty($sql)) return false;
    	if(stristr($sql, "insert") || stristr($sql, "update") || stristr($sql, "delete")) throw new My_Exception("此函数不能用于添加，更新，删除数据库操作");
    	if($data){
    		foreach ($data as $k=>$v){
    			$v = $this->getDb()->quote($v);
    			$sql = str_replace(":" . $k, $v, $sql);
    		}
    	}
//    	My_Tool::debug($sql);
    	$this->_sql = $sql;
    	$rs = $this->getDb()->fetchAll($sql);
    	if($returnCount){
    		$sqlCount = 'SELECT FOUND_ROWS() as cnt';
    		$rsCount = $this->getDb()->fetchRow($sqlCount);
    		$this->_total = $rsCount['cnt'];
    	}
    	return $rs;
    }
    
    function getTotal(){
    	return $this->_total;
    }
    
	//获取单个字段的数据
    function selectAllByField($sql,$field = "id",$data=array(), $returnCount=false){
    	$list = $this->selectAll($sql,$data,$returnCount);
    	$rs = array();
    	if($list){
    		foreach($list as $v){
    			$rs[] = $v[$field];
    		}
    	}
    	return $rs;
    }
    

    
    /**
     * 
     * 通过pk获取一行数据
     * @param string $pk
     */
    public function getByPK($pk){
    	if(!$pk) return false;
    	
    	$tableName = $this->getTableName();
    	$pkKey = $this->getPK();
    	$pk = $this->getDb()->quote($pk);
    	$sql = "SELECT * FROM `{$tableName}` WHERE `{$pkKey}` = {$pk}" ;
    	$this->_sql = $sql;
    	return $this->getDb()->fetchRow($sql);
    }
    
  /**
   * 
   * 解析where数据
   * @param array $where
   */
   protected function parseWhere($where = array()){
   		if(count($where) < 1) return "";
    	$whereSql = "";
    	foreach($where as $k=>$v){
    		$param = $k . " = ? ";
    		if(is_array($v)){
    			list($sign, $vl) = $v;
    			$param = $k ." ". $sign . " ? ";
    			$sign = strtolower($sign);
    			if($sign == 'in'){
    				$param = $k ." ". $sign . " (?) ";
    			}
    			$v=$vl;
    		}
    		
    		$whereSql .= " AND " . $this->getDb()->quoteInto($param, $v);
    	}
    	return preg_replace("/^AND/i",'', trim($whereSql));
   }
   
    /**
     * 根据条件获取多个
     * @param array $where
     */
    public function gets($where = array(), $orderBy = "", $limit = "", $offset = "", $groupBy = "", $returnCount=false){
    	$whereSql = $this->parseWhere($where);
    	$whereSql = $whereSql ? " WHERE " . $whereSql : "";
    	$tableName = $this->getTableName();
    	$orderBySql = "";
    	$groupBySql = "";
    	$limitSql = "";
    	if($groupBy) $groupBySql = " GROUP BY " . $groupBy;
    	if($orderBy) $orderBySql = " ORDER BY " . $orderBy;

		if($offset){
    		$limit = intval($limit);
    		$offset = intval($offset);
    		$limitSql = " LIMIT {$limit} , {$offset} ";
		}
		
		
    	$sql = "SELECT *  FROM `{$tableName}` " . $whereSql . $groupBySql . $orderBySql . $limitSql;
// 		My_Tool::debug($sql);
   		$this->_sql = $sql;
    	$rs = $this->getDb()->fetchAll($sql);
    	
    	if($returnCount){
    		$sqlCount = "SELECT count(*) as cnt FROM  `{$tableName}` " . $whereSql;
    		$rsCount = $this->getDb()->fetchRow($sqlCount);
    		$this->_total = $rsCount['cnt'];
    	}
    	
    	return $rs;
    }

    /**
     * 得到单个字段
     * @param  [type]  $field   [description]
     * @param  [type]  $where   [description]
     * @param  boolean $isMore  [description]
     * @param  string  $orderBy [description]
     * @param  string  $limit   [description]
     * @param  string  $offset  [description]
     * @param  string  $groupBy [description]
     * @return [type]           [description]
     */
    function getField($field,$where,$isMore=false,$orderBy = "", $limit = "", $offset = "", $groupBy = ""){
        $whereSql = $this->parseWhere($where);
        $whereSql = $whereSql ? " WHERE " . $whereSql : "";
        $tableName = $this->getTableName();
        $orderBySql = "";
        $groupBySql = "";
        $limitSql = "";
        if($groupBy) $groupBySql = " GROUP BY " . $groupBy;
        if($orderBy) $orderBySql = " ORDER BY " . $orderBy;

        if($offset){
            $limit = intval($limit);
            $offset = intval($offset);
            $limitSql = " LIMIT {$limit} , {$offset} ";
        }
        
        
        $sql = "SELECT ".$field."  FROM `{$tableName}` " . $whereSql . $groupBySql . $orderBySql . $limitSql;
//      My_Tool::debug($sql);
//      $this->_sql = $sql;
        if($isMore){
            $rs = $this->getDb()->fetchAll($sql);
            if(!$rs) return array();
            $result = array();
            foreach ($rs as $key => $value) {
                $result[] = $value[$field];
            }
            return $result;
        }else{
            $rs = $this->getDb()->fetchRow($sql);
            return $rs ? $rs[$field] : "";
        }

    }
    
    

    /**
     * 根据条件获取一行
     * @param array $where
     */
    public function get($where, $orderBy=""){
    	$whereSql = $this->parseWhere($where);
    	$whereSql = $whereSql ? " WHERE " . $whereSql : "";
    	
    	$tableName = $this->getTableName();
    	$sql = "SELECT * FROM `{$tableName}` " . $whereSql;
    	if($orderBy) $sql .=" ORDER BY " . $orderBy;
//    	    My_Tool::debug($sql);
    	$this->_sql = $sql;
    	return $this->getDb()->fetchRow($sql);
    }
    

    /**
     * 
     * 获取数据行数
     * @param array $where
     */
    public function getCount($where = array(),$orderBy=""){
    	$whereSql = $this->parseWhere($where);
    	$whereSql = $whereSql ? " WHERE " . $whereSql : "";
    	$tableName = $this->getTableName();
    	$orderBySql = "";
    	if($orderBy) $orderBySql = " ORDER BY ". $orderBy;
    	$sql = "SELECT count(*) FROM `{$tableName}` " . $whereSql . $orderBySql;
    	$this->_sql = $sql;
    	return $this->getDb()->fetchOne($sql);
    }
    
    /**
     * 
     * 获取sql
     */
    public function getSql(){
    	return $this->_sql;
    }
    
}
