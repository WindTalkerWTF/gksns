<?php
class My_Exception extends Zend_Exception{
	public function __construct($msg = '', $code = 2012, Exception $previous = null){
		parent::__construct($msg, $code, $previous);
	}
}