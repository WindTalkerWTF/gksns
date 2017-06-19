<?php
class Admin_Dao_Roleaction extends Home_Dao_Base{
	function getTableName(){
		return "admin_roleaction";
	}
	
	function getPK(){
		return "id";
	}

////////////////////////////////////////////////////////////
	
	function getsRoleActions(){
		$sql = "SELECT a.*, b.* From admin_roleaction a LEFT JOIN admin_actions b ON
				a.action_id = b.id  ORDER BY b.id DESC ";
		return $this->getDb()->fetchAll($sql);
	}
	
	
}