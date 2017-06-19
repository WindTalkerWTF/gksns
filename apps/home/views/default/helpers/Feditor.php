<?php
/**
 *
 * @author kaihui_wang
 * @version 
 */
require_once 'Zend/View/Interface.php';
require_once ROOT_DIR . '/res/js/ckeditor/ckeditor.php';
require_once ROOT_DIR . '/res/js/ckfinder/ckfinder.php';
/**
 * Truncate helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Home_View_Helper_Feditor
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function feditor ($str='', $name="content", $width="100%", $height="300")
    {
        $baseUrl = $this->getBaseUrl();
        $baseUrl = $baseUrl."/res/";
    	echo "<script type='text/javascript' src='".$baseUrl."js/ckfinder/ckfinder.js'></script>";
    	
		$sBasePath = "".$baseUrl."js/ckeditor/" ;
		
		$CKEditor = new CKEditor();

		$CKEditor->returnOutput = true;
		
		$CKEditor->basePath = $sBasePath;
		
		$CKEditor->config['width'] = $width;
		$CKEditor->config['height'] = $height;
		
		CKFinder::SetupCKEditor($CKEditor, "".$baseUrl."js/ckfinder/");
		
		$code = $CKEditor->editor($name, $str);
		echo $code;
    }
    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    function getBaseUrl(){
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        $baseUrl = str_replace("/index.php", "", $baseUrl);
        return $baseUrl;
    }
}
