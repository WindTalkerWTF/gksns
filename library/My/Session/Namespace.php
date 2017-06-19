<?php
class My_Session_Namespace extends Zend_Session_Namespace{
	public function __construct($key){
        if(!isDebug()) sessionIsset();
		$appName = Home::service()->getCommon()->getSiteName();
		$key .= "_" . $appName;
        $rs = parent::__construct($key);
		return $rs;
	}
}
