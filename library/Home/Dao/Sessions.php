<?php
class Home_Dao_Sessions extends Home_Dao_Base{
	private static $_tableName = "home_sessions";
	private static $_PK = "id";
	
	protected   function getTableName(){
		return self::$_tableName;
	}
	
	protected   function getPK(){
		return self::$_PK;
	}

	/*************以下是自定义区***************/
}