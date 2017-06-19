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
class Group_View_Helper_Paginator
{
	public  $pageSize = 20;
	public  $page = 1;
	public  $totalNum = 0;
	
	public  $previous = "";
	public  $next = "";
	public  $current = "";
	public  $pageCount = "";
	public  $totalData = "";
	public  $scriptPath = "";
	
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    
    public function paginator($pageSize, $page, $totalNum, $tpl = "group",$urlExt=""){   	
    	$this->page = (int) $page;
		$this->pageSize = (int) $pageSize;
		$this->totalNum = (int) $totalNum;
		$this->page = $this->page < 0 ? 1 : $this->page;
		$this->pageCount = ($this->totalNum % $this->pageSize) == 0 ?  ($this->totalNum / $this->pageSize) : ceil($this->totalNum / $this->pageSize);
		$this->previous = $this->page-1 < 0 ? 0 : $this->page-1;
		$this->next = $this->page+1 < $this->pageCount ? $this->page+1 : $this->pageCount;
		$this->current = $this->page;
		$this->totalData = $this->totalNum;
		
		$this->view->page = $this->page;
		$this->view->pageSize = $this->pageSize;
		$this->view->totalNum = $this->totalNum;
		$this->view->pageCount = $this->pageCount;
		$this->view->previous = $this->previous;
		$this->view->next = $this->next;
		$this->view->current = $this->current;
		$this->view->totalData = $this->totalData;
		$this->view->urlExt = $urlExt;
		
		return $this->view->render("/helper/{$tpl}_pagi.php");
    } 
    
    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
