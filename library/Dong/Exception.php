<?php
class Dong_Exception extends My_Exception{
	public function __construct($msg = '', $code = 0, Exception $previous = null){
		parent::__construct($msg, $code, $previous);
	}
}