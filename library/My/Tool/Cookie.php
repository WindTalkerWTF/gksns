<?php
class My_Tool_Cookie{
	
	static function get($param){
//		$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "";
//		$param = $param;
		return isset($_COOKIE[$param]) ? $_COOKIE[$param] : "";
	}
	
	static function set($param, $value, $expire=0, $path="/", $domain=""){
		if(!$param) return false;
		$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "";
		$domain = $domain ? $domain : $host;
//		$param = $param;
		return setcookie($param, $value, $expire+time(), $path, $domain, 0);
	}
	
	static function clear($param){
		if(!$param) return false;
		return self::set($param, "");
	}
	
}