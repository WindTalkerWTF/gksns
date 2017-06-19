<?php
class My_Tool_Xpath{
	private $links=array();
    private $pre;
    private $html;
    private $result;
    private $baseUrl;
    function getLink(){
        $links = $this->links?array_unique($this->links):array();
        return $links;
    }

    function getHtml(){
        return $this->html;
    }

    function getParseResult(){
        return $this->result;
    }

    function setLinkRule($pre){
        $this->pre = $pre;
        return $this;
    }

    function setBaseUrl($url){
        $this->baseUrl = $url;
        return $this;
    }

    function linkFrom2($start,$end,$setp=1,$tag='*'){
        if(!$this->pre) return $this;
        $i = $start;
        while($i<=$end){
            $str = str_replace($tag,$i,$this->pre);
            $i+=$setp;
            array_push($this->links,$str);
        }
        return $this;
    }

    function addLinks($links){
        if(is_array($links)){
            if($this->links){
                $this->links = array_merge($this->links,$links);
            }else{
                $this->links = $links;
            }
        }else{
            array_push($this->links,$links);
        }
        return $this;
    }

    function autoParseLink($xpath,$isRegx=0){
            $rs = $this->parse($xpath,$isRegx)->getParseResult();
            if(!$rs) return $this;
            if(!$this->baseUrl) return $this;
            foreach($rs as $v){
                $tmp = My_Tool::formatUrl($v,$this->baseUrl);
                if(!in_array($tmp,$this->links)){
                    $this->addLinks($tmp);
                }
            }
            return $this;
    }

    function parse($xpath,$isregx=0){
        if(!$this->html) return $this;
        $xml = $this->getXpathObj($this->html);
        $result = array();
        if(!$isregx){
            $rs = $xml->query($xpath);
            $length = $rs->length;
            for($i=0;$i<$length;$i++){
                $v = $rs->item($i);
                $tmp = htmlspecialchars($v->nodeValue);
                $tmp = preg_replace('/\s/', ' ', $tmp);
                if(!empty($tmp)) $result[] = $tmp;
            }
        }else{
            preg_match_all($xpath,$this->html,$matches);
            $result = $matches[1];
        }
        $this->result = $result;
        return $this;
    }

    function dealHtml($url){
        $html = My_Tool::fileGetContents($url,30);
        $this->html = $html;
        return $this;
    }

    function getXpathObj($content){
        libxml_use_internal_errors(true);
        mb_detect_order("UTF-8,GBK");
        if (!empty($content)) {
            if (empty($encod))
                $encod  = mb_detect_encoding($content);
            $headpos        = mb_strpos($content,'<head>');
            if (FALSE=== $headpos)
                $headpos= mb_strpos($content,'<HEAD>');
            if (FALSE!== $headpos) {
                $headpos+=6;
                $content = mb_substr($content,0,$headpos) . '<meta http-equiv="Content-Type" content="text/html; charset='.$encod.'">' .mb_substr($content,$headpos);
            }
            $content=mb_convert_encoding($content, 'HTML-ENTITIES', $encod);
        }
        $dom = new DomDocument;
        $res = @$dom->loadHTML($content);
        if (!$res) return FALSE;
        $xpath = new DomXPath($dom);
        return $xpath;
    }



}