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
class Home_View_Helper_Keditor
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function keditor ($name="content", $isFull=0)
    {
        $baseUrl = $this->getBaseUrl();
        $baseUrl = $baseUrl."/res/";
    	$str = "<script type='text/javascript' src='".$baseUrl."js/kindeditor/kindeditor-min.js'></script>";
    	$str .=  "<link rel=\"stylesheet\" href=\"".$baseUrl."js/kindeditor/themes/default/default.css\" />";
    	
		$str .=  "<script>\n";
		$str .=  "var editor;\n";
		$str .=  "var csspath=new Array('".$baseUrl."js/kindeditor/themes/default/default.css','".$baseUrl."js/kindeditor/plugins/code/prettify.css');\n";
		$str .=  "KindEditor.ready(function(K) {\n";
		$str .=  "editor = K.create('textarea[name=\"".$name."\"]', {\n";
		$str .=  "id:'".$name."',\n";
		$str .=  "resizeMode : 1,\n";
		$str .=  "afterBlur:function(){this.sync();},\n";
		$str .=  "allowPreviewEmoticons : false,\n";
		$str .=  "uploadJson  : '".My_Tool::url('index/upimg','home')."',\n";
		$str .=  "dir:'image',\n";
		$str .=  "allowImageUpload : true,\n";
		$str .=  "cssPath :csspath,\n";
		$str .=  "shadowMode : false,\n";
		$str .=  "allowPreviewEmoticons : false,\n";
		$str .=  "allowFlashUpload : false,\n";	
		if(!$isFull){
			$str .=  "items : ['fullscreen','bold', 'italic', 'strikethrough', 'removeformat','|','insertunorderedlist','justifyleft', 'justifycenter', 'justifyright',
					 'forecolor', 'hilitecolor', 'fontname', 'fontsize',  '|', 'link', 'unlink', 'emoticons', 'media',
					 'image','|', 'source','code','bockquote','about'],\n";
		}else{
			$str .= "items : [
							'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
							'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
							'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
							'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
							'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
							'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
							'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
							'anchor', 'link', 'unlink','bockquote', '|', 'about'],\n";
		}
		$str .=  "filterMode :true,\n";
		$str .= "htmlTags:
		{
			script : ['src'],
            font : ['color', 'size', 'face', '.background-color'],
            span : [
                    '.color', '.background-color', '.font-size', '.font-family', '.background',
                    '.font-weight', '.font-style', '.text-decoration', '.vertical-align', '.line-height'
            ],
            div : [
                    'class', 'align', '.border', '.margin', '.padding', '.text-align', '.color',
                    '.background-color', '.font-size', '.font-family', '.font-weight', '.background',
                    '.font-style', '.text-decoration', '.vertical-align', '.margin-left'
            ],
            table: [
                    'border', 'cellspacing', 'cellpadding', 'width', 'height', 'align', 'bordercolor',
                    '.padding', '.margin', '.border', 'bgcolor', '.text-align', '.color', '.background-color',
                    '.font-size', '.font-family', '.font-weight', '.font-style', '.text-decoration', '.background',
                    '.width', '.height', '.border-collapse'
            ],
            'td,th': [
                    'align', 'valign', 'width', 'height', 'colspan', 'rowspan', 'bgcolor',
                    '.text-align', '.color', '.background-color', '.font-size', '.font-family', '.font-weight',
                    '.font-style', '.text-decoration', '.vertical-align', '.background', '.border'
            ],
            a : ['href', 'target', 'name'],
            embed : ['src', 'width', 'height', 'type', 'loop', 'autostart', 'quality', '.width', '.height', 'align', 'allowscriptaccess'],
            img : ['src', 'width', 'height', 'border', 'alt', 'title', 'align', '.width', '.height', '.border'],
            'p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6' : [
                    'align', '.text-align', '.color', '.background-color', '.font-size', '.font-family', '.background',
                    '.font-weight', '.font-style', '.text-decoration', '.vertical-align', '.text-indent', '.margin-left'
            ],
            pre : ['class'],
            hr : ['class', '.page-break-after'],
            'br,tbody,tr,strong,b,sub,sup,em,i,u,strike,s,del' : []
		}\n
		";
		$str .=  "});\n";
		$str .=  "});\n";
		$str .=  "</script>\n";
		return $str;
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
