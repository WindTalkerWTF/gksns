<?php
class Home_Exception extends My_Exception{
	public function __construct($msg = '', $code = 2012, Exception $previous = null){
		parent::__construct($msg, $code, $previous);
	}
}