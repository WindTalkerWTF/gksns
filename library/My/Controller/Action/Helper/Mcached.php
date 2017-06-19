<?php
/**
 * 
 * memcache 缓存
 * @author kaihui_wang
 *
 */
class My_Controller_Action_Helper_Mcached extends Zend_Controller_Action_Helper_Abstract {
	  
	private $time = 0;
	private $actionName = null;
	private $isTodo = 0;
	private $actions = null;
	private $key = "";
	
	function direct($actions){
		$this->actions = $actions;
	}
	
	function preDispatch(){
		$this->key = md5($_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"]);
		if(!isDebug()){
			$html = "";
			$html = My_Cache::get($this->key);
	//		My_Cache::delete($this->key);
			
			if($html && is_string($html)){
				echo $html;
				exit;
			}
		}
		$this->actionName = $this->getRequest()->getActionName();
        
		foreach($this->actions as $v){
			if($v[0] == $this->actionName){
// 				ob_start();
				ob_start(array($this, '_flush'));
				$this->isTodo = 1;
				$this->time = $v[1];
				break;
			}
		}
	}
	
	function postDispatch(){
		if($this->isTodo){
	   		ob_start(array($this, '_flush'));
	        ob_implicit_flush(false);
		}
	}
	
	function _tmp($data){
		
	}
	
	
	function _flush($data){
	    My_Cache::set($this->key, $data, $this->time);
		return $data;
	}
	
}