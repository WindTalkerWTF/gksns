<?php
/**
 * 分页
 * @author kaihui_wang
 *
 */
class Home_Tool_Paginator{
	public static $pageSize = 20;
	public static $page = 1;
	public static $totalNum = 0;
	
	public static $previous = "";
	public static $next = "";
	public static $current = "";
	public static $pageCount = "";
	public static $totalData = "";
	
	public static function init($pageSize, $page, $totalNum){
		self::$page = (int) $page;
		self::$pageSize = (int) $pageSize;
		self::$totalNum = (int) $totalNum;
		self::$page = self::$page < 0 ? 1 : self::$page;
		self::$pageCount = (self::$totalNum % self::$pageSize) == 0 ?  (self::$totalNum / self::$pageSize) : ceil(self::$totalNum / self::$pageSize);
		self::$previous = self::$page-1 < 0 ? 0 : self::$page-1;
		self::$next = self::$page+1 < self::$pageCount ? self::$page+1 : self::$pageCount;
		self::$current = self::$page;
		self::$totalData = self::$totalNum;
	}
	
	/**
	 * 基本处理
	 * @param int $pageSize
	 * @param int $page
	 * @param int $totalNum
	 * @param string $app
	 */
	public static function base($pageSize, $page, $totalNum, $app = "admin"){
		self::init($pageSize, $page, $totalNum);
		ob_start(); 
		$options = My_Config::getInstance()->getOptions();
		
		$appName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
		
		$BasePath = $options['resources']['view']['params'][$appName]['basePath'];
		
		include $BasePath . DS . "scripts" . DS . $app . "_pagination.html";
		
		$content = ob_get_contents();
		ob_end_clean(); 
		return $content;
	}
	
	/**
	 * 
	 * 获取当前网址
	 * @param int $page
	 */
	public static function url($page){
		$page = intval($page);
		$page = $page > self::$pageCount ? self::$pageCount : $page;
		$page = $page < 1 ? 1 :  $page;
		$url = isset($_SERVER["REQUEST_URI"])? $_SERVER["REQUEST_URI"] : "";
		if(!stristr($url, "page")){
			$url = stristr($url, "?") ? $url . "&page=" . $page : $url . "?page=" . $page;
			return $url;
		}
		$url = preg_replace("/page\\=([^&]+)/i","page={$page}" , $url);

		return $url;
	}
	
	/**
	 * 
	 * 后台分页
	 * @param array $results
	 * @param int $pageSize
	 * @param int $page
	 */
	public static function forAdmin($pageSize, $page, $totalNum){
		return self::base($pageSize, $page, $totalNum, "admin");
	}
}
