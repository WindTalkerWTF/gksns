<?php
/**
 *
 * @author kaihui_wang
 * @version 
 */
require_once 'Zend/View/Interface.php';
/**
 * Truncate helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Home_View_Helper_Setseo
{
    /**
     * 
     */
    public function setseo($data,$field){
    	$tmp = array("title","keywords","descr");
    	if(!in_array($field,$tmp)) return "";
		
    	if($field == 'title'){
    		return isset($data[$field])?$data[$field]."|" .getSysData('site.config.seo.home.title'):getSysData('site.config.seo.home.title');
    	}
    	
    	if($field == 'descr'){
    		return isset($data[$field])?$data[$field]:"";
    	}
    	return isset($data[$field])?$data[$field]:getSysData('site.config.seo.'.$field.'');
    }
}
