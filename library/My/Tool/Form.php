<?php
class My_Tool_Form{
	
	/**
	 * form 添加 防止csrf
	 * @param string $name
	 * @param string $url
	 * @param array $params
	 * @throws My_Exception
	 */
	static function start($name, $url, $method="post", $params=array()){
		if(empty($name)|| empty($url)) throw new My_Exception("参数为空!", -201);
	    $str = "<form  name = \"{$name}\" action=\"{$url}\" method=\"$method\" ";
	    if($params){
	    	foreach($params as $k=>$v){
	    		$str .= $k . " = \"{$v}\" ";
	    	}
	    }
	    $str .= ">";
	     
	    $csrf = md5(uniqid("form_").time());
	    $session = My_Tool_Session::getAdapter("form_".$name);
	    $session->csrf = $csrf;
	    
	    $str .= "
	    \n<input type=\"hidden\" name=\"csrf\" id=\"csrf\" value=\"{$csrf}\" >\n
	    ";
	    
	    return $str;
	}
	   
	
	#结束
	static function end(){
		return "</form>
		";
	}
	
	/**
	 * 
	 * 验证csrf
	 * @param string $formName
	 * @param string $csrf
	 * @throws My_Exception
	 */
	static function validate($formName, $csrf=""){
		if(empty($formName)) My_Tool::showMsg("参数为空!", -201);
		 $session = My_Tool_Session::getAdapter("form_".$formName);
		 $csrf = $csrf ? $csrf : $_REQUEST['csrf'];
		 $csrfTmp = $session->csrf;
		 if($csrfTmp == $csrf){
		 	$session->csrf = "";//清除csrf
		 	return true;
		 }
		  My_Tool::showMsg("你提交太快了,请返回后重试!","history.back()",1);
	}
	
}