<?php
My_Tool::importOpen("simple_html_dom.php");
class My_Tool_Pick{
	private $htmlObj = null;
	
   function __construct($html, $safeEncoding=1){
			$html = preg_replace('/<meta.*?charset=[\"|\']?(.*?)[\"|\']?[^>].*?>/i', '', $html);
 			if($safeEncoding) $html = My_Tool::safeEncoding($html);
 			$html = $this->closetags($html);
			try{
				$this->htmlObj = str_get_html($html);
			}catch (Exception $e){
				My_Tool::debug($e->getMessage());
			}
	}
	
	function getHtmlObj(){
		return $this->htmlObj;
	}
	
	function closetags($html) {
		// 不需要补全的标签
		$arr_single_tags = array('meta', 'img', 'br', 'link', 'area', "input");
		// 匹配开始标签
		preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
		$openedtags = $result[1];
		// 匹配关闭标签
		preg_match_all('#</([a-z]+)>#iU', $html, $result);
		$closedtags = $result[1];
		// 计算关闭开启标签数量，如果相同就返回html数据
		$len_opened = count($openedtags);
		if (count($closedtags) == $len_opened) {
		return $html;
		}
		// 把排序数组，将最后一个开启的标签放在最前面
		$openedtags = array_reverse($openedtags);
		// 遍历开启标签数组
		for ($i = 0; $i < $len_opened; $i++) {
		// 如果需要补全的标签
		if (!in_array($openedtags[$i], $arr_single_tags)) {
		// 如果这个标签不在关闭的标签中
		if (!in_array($openedtags[$i], $closedtags)) {
		// 直接补全闭合标签
		$html .= '</' . $openedtags[$i] . '>';
		} else {
		unset($closedtags[array_search($openedtags[$i], $closedtags)]);
		}
		}
		}
		return $html;
	}
	
	function parseValue($str, $getHtml=1, $num=null){
		$resultTmp = $this->htmlObj->find($str);
		if(!$resultTmp) return false;
		$result = array();
		foreach($resultTmp as $v){
			if(!$v) continue;
			if($getHtml == 1){
				$result[] = $v->innertext;
			}elseif($getHtml == 2){
				$result[] = $v->outertext;
			}elseif($getHtml == 3){
				$result[] = $v;
			}else{
				$result[] = $v->plaintext;
			}
		}
		if($num != null) $result = $result[$num];
		return $result;
	}
	
	function parseAttr($str, $attr){
		$resultTmp = $this->htmlObj->find($str);
		$result = array();
		foreach($resultTmp as $v){
			$result[] = $v->$attr;
		}
		return $result;
	}
	
	function clear(){
		$this->htmlObj->clear();
	}
	
	function __destruct(){
		$this->htmlObj->clear();
	}
	
	
}