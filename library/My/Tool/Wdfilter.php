<?php
My_Tool::importOpen("orea/filter.class.php");
class My_Tool_Wdfilter{
	
	static function filter($str){
		if(!$str) return false;
		$str = mb_convert_encoding($str, "gbk", "utf-8");
		$wordsObj = new Censor($str);
		return $wordsObj->content;
	}
	
}