<?php
class My_Tool{
    #调试
    public static function debug($str){
        $logs[] = $str;
        $path = ROOT_DIR  . "/data/logs/".date('Y-m-d')."/debug-log.txt.php";
        Home_Tool_Log::save($logs, $path);
        return true;
    }

    #输出调试信息
    static function dump($value){
        echo "<pre>";
        print_r($value);
    }

    #输出执行
    static function trace($isShow=1){
        $trace = debug_backtrace();
        $output = "";
        $trace = array_reverse($trace);
        $len = count($trace)-1;
        $output .= "\n";
        foreach ($trace as $k=>$bt) {
            if($k == $len ) continue;
            $args = '';
            if(isset($bt['args'])){
                foreach ($bt['args'] as $a) {
                    if ($args) {
                        $args .= ', ';
                    }
                    switch (gettype($a)) {
                        case 'integer':
                        case 'double':
                            $args .= $a;
                            break;
                        case 'string':
                            $a = htmlspecialchars(substr($a, 0, 64)).((strlen($a) > 64) ? '...' : '');
                            $args .= "\"$a\"";
                            break;
                        case 'array':
                            $args .= 'Array('.count($a).')';
                            break;
                        case 'object':
                            $args .= 'Object('.get_class($a).')';
                            break;
                        case 'resource':
                            $args .= 'Resource('.strstr($a, '#').')';
                            break;
                        case 'boolean':
                            $args .= $a ? 'True' : 'False';
                            break;
                        case 'NULL':
                            $args .= 'Null';
                            break;
                        default:
                            $args .= 'Unknown';
                    }
                }
            }
            $output .= "\n";
            @$output .= "file: {$bt['line']} - {$bt['file']}\n";
            @$output .= "call: {$bt['class']}{$bt['type']}{$bt['function']}($args)\n";
        }
        if($isShow){
            echo "<pre>";
            echo $output;
        }else{
            return $output;
        }
    }

    #显示消息
    public static function showMsg($msg='', $href='',$isJs=0, $goUrl="/index/msg",$appName="home"){
        $msg = self::safeEncoding($msg);
        $data = array($msg, $href,$isJs);

        My_Tool_FlashMessage::set("showMsg", $data);

        $goUrl = My_Tool::url($goUrl, $appName);
        self::redirect($goUrl);
        exit;
    }

    /**
     *
     * 网址跳转
     * @param string $url
     */
    public static function redirect($url){
        if(stristr($url,"http")){
            $action = new Zend_Controller_Action_Helper_Redirector();
            $action->gotoUrl($url);
            exit;
        }elseif(stristr($url,"index.php")){
            header("LOCATION:".$url);
        }else{
            $action = new Zend_Controller_Action_Helper_Redirector();
            $action->gotoUrl($url);
            exit;
        }
    }

    /**
     *
     * 文档截取
     * @param string $string
     * @param int $length
     * @param string $etc
     * @param string $break_words
     * @param int $middle
     */
    public static function substrtxt($string, $length = 80, $etc = ''){
        $str = mb_substr($string, 0, $length, "UTF-8");
        return $etc ? $str . $etc : $str;
    }


    /**
     *
     * 显示json
     * @param int $code
     * @param string $msg
     */
    public static function showJson($code, $msg=""){
        header("content-type:text/javascript");
        echo self::jsonencode(array("code"=>$code, "msg"=>$msg));
        exit;
    }

    static function showError($msg){
        header("content-type:text/html; charset=utf-8");
        exit($msg);
    }

    /**
     *
     * 显示jsonp
     * @param int $code
     * @param string $msg
     * @param string $jsonp
     */
    public static function showJsonp($code, $msg="", $jsonp="jsonpcallback"){
        $jsonpStr = isset($_REQUEST[$jsonp]) ? $_REQUEST[$jsonp]:time();
        echo $jsonpStr . "(" . self::jsonencode(array("code"=>$code, "msg"=>$msg)) . ")";
        exit;
    }


    /**
     *
     * 显示json
     * @param int $code
     * @param string $msg
     */
    public static function viewJson($code, $msg){
        echo self::jsonencode(array("code"=>$code, "msg"=>$msg));
        exit;
    }

    /**
     *
     * 获取提交
     */
    static function request($param, $default=""){
        if(!$param) return false;
        $font = Zend_Controller_Front::getInstance();
        $appName = $font->getRequest()->getModuleName();
        $controllerName = $font->getRequest()->getControllerName();
        $actionName = $font->getRequest()->getActionName();

        $pre = $appName."_".$controllerName . "_". $actionName;
        $result = My_Tool_Cookie::get($pre . $param);
        $resultTmp = $font->getRequest()->getParam($param);
        if($resultTmp && $resultTmp>0){
            My_Tool_Cookie::set($pre . $param, $resultTmp, 60*30);//保存半小时
            return ($resultTmp != "") ? $resultTmp:$default;
        }elseif($resultTmp === 0||$resultTmp === '0'){
            My_Tool_Cookie::set($pre . $param, 0, 60*30);//保存半小时
            return 0;
        }elseif($resultTmp<0){
            My_Tool_Cookie::set($pre . $param, $resultTmp, 60*30);//保存半小时
            return $resultTmp;
        }else{
            return $result;
        }
    }


    /**
     *
     * 加密解密
     * @param string $string
     * @param string $operation
     * @param string $key
     * @param string $expiry
     */
    static function authcode($string,  $key = '', $operation = 'DECODE', $expiry = 0) {
        $ckey_length = 4;
        if($key == "") return false;
        $key = md5($key ? $key : "ad^%FFGFFFF");
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }

    /**
     *
     * 模拟file_get_contents
     * @param string $durl
     * @param int $timeOut
     * @param array $proxyArr array("127.0.0.1:8080", "user:pwd")
     */
    static function fileGetContents($durl, $timeOut = 0, $proxyArr=array()){
        if(!$durl) return false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $durl);
        if($timeOut){
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
        }
        curl_setopt($ch, CURLOPT_HEADER, 0);
        if($proxyArr){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            curl_setopt($ch, CURLOPT_PROXY, $proxyArr[0]);
            if(isset($proxyArr[1])){
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyArr[1]);
            }
        }
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        $r = curl_exec($ch);
        if(!$r) return false;
        return $r;
    }

    /**
     * 异步请求url
     * @param string $url
     * @return boolean
     */
    static public function asyncCurl($url, $cookie=array(), $post=array(), $timeout=1)
    {
        self::importOpen("asynHandle.class.php");
        $obj    = new asynHandle();
        $obj->Request($url, $cookie, $post, $timeout);
    }

    #多线程抓取
    static function curlHttp($array, $timeout){
        $res = array ();
        $mh = curl_multi_init (); //创建多个curl语柄
        //var_dump($mh);exit;
        $startime = self::getmicrotime ();
        //echo $startime;exit;
        foreach ( $array as $k => $url ) {
            $conn [$k] = curl_init ( $url ); //创建一个curl 会话
            //curl_setopt 设置一个cURL传输
            curl_setopt ( $conn [$k], CURLOPT_TIMEOUT, $timeout ); //设置超时时间
            curl_setopt ( $conn [$k], CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)' ); //在HTTP请求中包含一个"User-Agent: "头的字符串
            curl_setopt ( $conn [$k], CURLOPT_MAXREDIRS, 7 ); //HTTp定向级别
            curl_setopt ( $conn [$k], CURLOPT_HEADER, 0 ); //这里不要header，加块效率
            // curl_setopt($conn[$k], CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
            curl_setopt ( $conn [$k], CURLOPT_RETURNTRANSFER, 1 );
            curl_multi_add_handle ( $mh, $conn [$k] ); //向curl批处理会话中添加单独的curl句柄
        }
        // 防止死循环耗死cpu 这段是根据网上的写法
        do {
            $mrc = curl_multi_exec ( $mh, $active ); //当无数据，active=true
        } while ( $mrc == CURLM_CALL_MULTI_PERFORM ); //当正在接受数据时
        while ( $active and $mrc == CURLM_OK ) // 当无数据时或请求暂停时，active=true
        {
            if (curl_multi_select ( $mh ) != - 1) {
                do {
                    $mrc = curl_multi_exec ( $mh, $active );
                } while ( $mrc == CURLM_CALL_MULTI_PERFORM );
            }
        }

        foreach ( $array as $k => $url ) {
            curl_error ( $conn [$k] );
            $res [$k] = curl_multi_getcontent ( $conn [$k] ); //获得返回信息

            $header [$k] = curl_getinfo ( $conn [$k] ); //返回头信息

            curl_close ( $conn [$k] ); //关闭语柄
            curl_multi_remove_handle ( $mh, $conn [$k] ); //释放资源
        }

        curl_multi_close ( $mh ); //关闭一组cURL句柄
        $endtime = self::getmicrotime ();
        $diff_time = $endtime - $startime;

        return $res;
    }

    #计算当前时间
    static function getmicrotime(){
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * 获取客户端IP地址
     *
     * @return unknown
     */
    static function getOlineIp() {
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown'))
        {
            $onlineip = getenv('HTTP_CLIENT_IP');
        }
        elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
        {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown'))
        {
            $onlineip = getenv('REMOTE_ADDR');
        }
        elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
        {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        preg_match("/[\d\.]{7,15}/", $onlineip, $ipmatches);
        $onlineip = $ipmatches[0] ? $ipmatches[0] : 'unknown';
        return $onlineip;
    }

    #是否是ajax请求，jquery有效
    static function isAjax(){
        $tag = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : "";
        return $tag == 'xmlhttprequest' ? true : false;
    }
    /**
     *
     * 是否提交
     */
    static function isPost(){
        return strtolower($_SERVER['REQUEST_METHOD']) == "post" ? true :false;
    }


    #检查email
    static function checkEmail($email){
        return  My_Tool_Check::email($email);
    }

    #检查手机号码
    static function checkMobile($mobilephone){
        //手机号码的正则验证
        return My_Tool_Check::mobile($mobilephone);
    }

    #是否是序列化数据
    static function isSerialized( $data ) {
        if(!is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        if (!preg_match('/^([adObis]):/', $data, $badions))
            return false;
        switch ($badions[1]) {
            case 'a' :
            case 'O' :
            case 's' :
                if (preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ))
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ))
                    return true;
                break;
        }
        return false;
    }

    #自动转码
    static function safeEncoding($string,$outEncoding = 'UTF-8'){
        $encoding = "UTF-8";
        for($i=0;$i<strlen($string);$i++)
        {
            if(ord($string{$i})<128)
                continue;

            if((ord($string{$i})&224)==224)
            {
                //第一个字节判断通过
                $char = $string{++$i};
                if((ord($char)&128)==128)
                {
                    //第二个字节判断通过
                    $char = $string{++$i};
                    if((ord($char)&128)==128)
                    {
                        $encoding = "UTF-8";
                        break;
                    }
                }
            }
            if((ord($string{$i})&192)==192)
            {
                //第一个字节判断通过
                $char = $string{++$i};
                if((ord($char)&128)==128)
                {
                    //第二个字节判断通过
                    $encoding = "GBK";
                    break;
                }
            }
        }
        if(strtoupper($encoding) == strtoupper($outEncoding))
            return $string;
        else
            return iconv($encoding,$outEncoding."//ignore",$string);
    }


    /**
     *
     * 获取当前网址
     */
    static function getCurrentUrl(){
        $url='http://';
        if(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']=='on'){
            $url='https://';
        }
        if($_SERVER['SERVER_PORT']!='80'){
            $url.=$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        }else{
            $url.=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        }
        return $url;
    }



    /**
     * php 切割html字符串 自动配完整标签
     *
     * @param $s 字符串
     * @param $zi 长度
     * @param $ne 没有结束符的html标签
     */
    static function htmlCut($s,$zi,$ne=',br,hr,input,img,'){
        $s = stripslashes($s);
        $s=preg_replace('/\s{2,}/',' ',$s);
        $os=preg_split('/<[\S\s]+?>/',$s);
        preg_match_all('/<[\S\s]+?>/',$s,$or);
        if(!$or[0]) return mb_substr($s, 0, $zi, "UTF-8");
        $s='';
        $tag=array();
        $n=0;
        $m = count($or[0])-1;
        foreach($os as $k => $v){
            $n = $k>$m ? $m :$k;
            if($v!='' && $v!=' '){
                $l=strlen($v);
                for($i=0;$i<$l;$i++){
                    if(ord($v[$i]) > 127){
                        $s.=$v[$i].$v[++$i].$v[++$i];
                    }else{
                        $s.=$v[$i];
                    }
                    $zi--;
                    if($zi < 1){
                        break 2;
                    }
                }
            }

            preg_match('/<\/?([^\s>]+)[\s>]{1}/',$or[0][$n],$t);
            $s.=$or[0][$n];
            if(strpos($ne,','.strtolower($t[1]).',')===false && $t[1]!='' && $t[1]!=' '){
                $n=array_search('</'.$t[1].'>',$tag);
                if($n!==false){
                    unset($tag[$n]);
                }else{
                    array_unshift($tag,'</'.$t[1].'>');
                }
            }
        }
        return $s.implode('',$tag);
    }


    /**
     * #导入外部类
     *
     * @param $path example : Check.class.php
     */
    static function importOpen($path){
        if($path){
            $path = ltrim($path, DS);
            require_once ROOT_LIB . DS . "Open" . DS . $path;
        }
    }

    /**
     *
     * memcached 处理
     * @param string $key
     * @param string $expire
     * @param mixed $dataCome
     * @param array $params
     * @return mixed
     */
    static function mcached($key,$dataCome, $params=array(),$expire=0){
        if(!$key) return false;
        if(!isDebug()){
            $appName = Home_Service::getInstance()->getCommon()->getSiteName();
            $key = $appName ."_".md5($key);

            $result = My_Cache::get($key);
            if($result) return $result;
        }
        $result = call_user_func_array($dataCome, $params);
        if(!isDebug()){
            My_Cache::set($key, $result, $expire);
        }
        return $result;
    }

    /**
     *
     * 分页获取当前网址
     * @param int $page
     */
    static function pagiUrl($page, $pageCount){
        $page = intval($page);
        $page = $page > $pageCount ? $pageCount : $page;
        $page = $page < 1 ? 1 :  $page;
        $url = isset($_SERVER["REQUEST_URI"])? $_SERVER["REQUEST_URI"] : "";

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $router = Zend_Controller_Front::getInstance()->getRouter()->getCurrentRoute();
        $isMatch= $router->getMatchedPath();

        if($isMatch){
            $param = $request->getParams();

            $controller = $param['controller'];
            $action = $param['action'];
            $module = $param['module'];
            unset($param['controller'],$param['action'], $param['module'],$param['page']);
            if($param){
                $paramStr = str_replace('&', '/', http_build_query($param));

                $paramStr = "/".str_replace('=', '/', $paramStr);
            }else{
                $paramStr = "";
            }

            $paramStr .="/page/".$page;

            $urlTmp = $controller."/".$action.$paramStr;

            $url = self::url($urlTmp,$module);
            if(stristr($url,"index.php")){
                return $url;
            }


            if(getInit('site.config.isrewrite')) return $url;
        }

        $appName = $request->getModuleName();

        $defaultModule = Zend_Controller_Front::getInstance()->getDefaultModule();
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();

        $url = str_replace($baseUrl,"",$url);
        if($appName != $defaultModule){
            $url = substr(trim($url, "/"), strlen($appName));
        }
        
        if(!trim($url,"/")) $url = "/index/index";

        if(!stristr($url, "page")){
            $url = trim($url, "/"). "/page/" . $page;
            $url = self::url($url);
            return $url;
        }

        $url = str_replace("?", "/", $url);
        $url = str_replace("=", "/", $url);
        $url = str_replace("&", "/", $url);
        $url = preg_replace("/page\\/([^&]+)/i","page/{$page}" , $url);

        $url = self::url($url);

        return $url;
    }

    /**
     *
     * 网址处理
     * @param string $str example "/user/add"
     * @param string $appName
     */
    static function urlparse($str, $appName=0){
// 		echo $str."||||||||||";
        $helper = new Zend_View_Helper_Url();
        $last = substr($str,strlen($str)-1,strlen($str)+1);
        $request = Zend_Controller_Front::getInstance()->getRequest();
        if(!$appName){
            $appName = $request->getModuleName();
        }
        $urlArr = explode("/", trim($str, '/'));

        $controller = "index";
        $action = "index";
        $params = array();
        if($urlArr){
            if($urlArr){ $controller = $urlArr[0]; array_shift($urlArr);}
            if($urlArr){ $action = $urlArr[0]; array_shift($urlArr);}
            if($urlArr){
                $len = count($urlArr);
                for($i=0; $i<$len;$i++){
                    $params[$urlArr[$i]] = isset($urlArr[$i+1]) ? $urlArr[$i+1] : "";
                    $i++;
                }
            }
        }
        $params['module'] = $appName;
        $params['controller'] = $controller;
        $params['action'] = $action;


        $rewriteName = $appName."-".$controller."-".$action;

        $router = Zend_Controller_Front::getInstance()->getRouter();
        $hasRoute = $router->hasRoute($rewriteName);
        if($hasRoute){
            $name = $rewriteName;
        }else{
            $name = 'default';
        }

        $url = $helper->url($params,$name,true);
//	    $url= $router->assemble($params, $name, true, true);
        $url = self::urlUnescape($url);

        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        if(getInit('site.config.isrewrite')) return $url;

        $url = str_replace($baseUrl,"",$url);
        if(!stristr($baseUrl,"index.php")){
            $url = trim($url,"/");
            $url = "/index.php/".$url;
        }
        $url = $baseUrl.$url;
        return $url;

    }

    //网址处理
    static function url($str,$appName=0){
        if(!$str) return "/";
        $request = Zend_Controller_Front::getInstance()->getRequest();
        if(!$appName){
            $appName = $request->getModuleName();
        }
        $key = md5($appName."/".$str);

        if(isDebug()) return self::urlparse($str,$appName);
//		$cache = My_Cache::get($key);
//        if($cache) return $cache;
        $rs = self::urlparse($str,$appName);
        My_Cache::set($key,$rs);
        return $rs;
    }

    //url转码
    static function urlEscape($str) {
        preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/",$str,$r);
        $ar = $r[0];
        foreach($ar as $k=>$v) {
            if(ord($v[0]) < 128)
                $ar[$k] = rawurlencode($v);
            else
                $ar[$k] = "%u".bin2hex(iconv("GB2312","UCS-2",$v));
        }
        return join("",$ar);
    }
    //url反转
    static function urlUnescape($str)
    {
        $ret = '';
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++){
            if ($str[$i] == '%' && $str[$i+1] == 'u'){
                $val = hexdec(substr($str, $i+2, 4));
                if ($val < 0x7f) $ret .= chr($val);
                else if($val < 0x800) $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f));
                else $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f));
                $i += 5;
            }else if ($str[$i] == '%'){
                $ret .= urldecode(substr($str, $i, 3));
                $i += 2;
            }else $ret .= $str[$i];
        }
        return $ret;
    }

    /**
     *
     * 几小时前
     * @param int $time
     * @return string
     */
    static function qtime($time){
        if(is_string($time)) $time = strtotime($time);
        $limit = time() - $time;

        if($limit<60)
            $time="{$limit}秒前";
        if($limit>=60 && $limit<3600){
            $i = floor($limit/60);
            $_i = $limit%60;
            $s = $_i;
            $time="{$i}分{$s}秒前";
        }
        if($limit>=3600 && $limit<3600*24){
            $h = floor($limit/3600);
            $_h = $limit%3600;
            $i = ceil($_h/60);
            $time="{$h}小时{$i}分前";
        }
        if($limit>=(3600*24) && $limit<(3600*24*30)){
            $d = floor($limit/(3600*24));
            $time= "{$d}天前";
        }
        if($limit>=(3600*24*30)){
            $time=gmdate('m-d H:i', $time);
        }
        return $time;
    }

    /**
     *
     * 来源页
     * @param string $default
     */
    static function getRef($default=""){
        return isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : $default;
    }

    /**
     *
     * 生成php文件
     * @param string $code 代码
     * @param string $path  路径
     */
    static function createPHP($code, $path){
        $str = '<?php' . PHP_EOL . $code. PHP_EOL;
        file_put_contents($path, $str);
        return true;
    }


    /**
     * 获取随机字符串
     * @static
     * @param int $len 随机字符串长度
     * @param bool $bNumber 是否包括数字，默认 true
     * @param bool $bLower  是否包括小写字母，默认 false
     * @param bool $bUpper  是否包括大写字母，默认 false
     * @return string 返回随机字符串
     */
    static function getRandomString($len=6, $bNumber=true, $bLower=false, $bUpper=false){
        $tmp = '';

        if($bNumber)
            $tmp .= '0123456789';
        if($bLower)
            $tmp .= 'abcdefghijklmnopqrstuvwxyz';
        if($bUpper)
            $tmp .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $str = '';
        $min = 0;
        $max = strlen($tmp) - 1;
        for($i=0; $i<$len; $i++)
        {
            $str .= substr($tmp, rand($min, $max), 1);
        }

        return $str;
    }


    /**
     * 文件大小 字符串
     * @static
     * @param $size
     * @return string
     */
    static function getFileSizeText($size)
    {
        if($size < 0x400) // Bytes - 1024
            return $size.' Bytes';
        else if($size < 0x100000) // KB - 1024
            return (round($size/0x400*100)/100).'KB';
        else if($size < 0x40000000) // MB - 1024 * 1024
            return (round($size/0x100000*100)/100).' MB';
        else // GB - 1024 * 1024 * 1024
            return (round($size/0x40000000*100)/100).' GB';
    }

    /**
     * 取出html图片地址
     * @param string $content
     */
    static function getImgPath($content){
        //取出图片路径
        $content = str_replace("alt=\"\"","",$content);
        $content = str_replace("alt=\'\'","",$content);
        $content = str_replace("alt=","",$content);
        $content = str_replace("alt","",$content);
        preg_match_all("/<img.*?src\s*=\s*.*?([^\"'>]+\.(gif|jpg|jpeg|bmp|png))/i",$content,$match);
        $result= isset($match[1]) ? $match[1] : array();
        if($result) return $result;
        preg_match_all("/<img.*?src=[\"|\'|\s]?(.*?)[\"|\'|\s]/i",$content,$match1);
        return isset($match1[1]) ? $match1[1]:array();
    }

    /**
     * 获取mysql join数据
     * @param array $selectData
     * @param string $method
     * @param obj $obj
     * @param string $field
     * @return boolean|mixed
     */
    static function getJoin($selectData, $obj, $method, $field="id"){
        if(!$selectData) return false;
        $ids = array();
        foreach($selectData as $v){
            $ids[]= $v[$field];
        }
        return call_user_func_array(array($obj, $method), array($ids));
    }

    /**
     * json 格式解析
     * @param array $arr
     */
    static function jsonencode($arr){
        $na = array();
        if($arr){
            if(is_array($arr)){
                foreach ($arr as $k => $value) {
                    $na[self::urlencode($k)] = self::urlencode($value);
                }
            }else{
                $na = urlencode($arr);
            }
        }
        return addcslashes(urldecode(json_encode($na)),"\r\n");
    }

    /**
     * urlencode解析
     * @param array $elem
     * @return mixed
     */
    static function urlencode($elem){
        if(!$elem) return $elem;
        if(is_array($elem)){
            foreach($elem as $k=>$v){
                $na[self::urlencode($k)] = self::urlencode($v);
            }
            return $na;
        }
        return urlencode($elem);
    }



    /**
     * xml转数组
     * @param unknown_type $contents
     * @param unknown_type $get_attributes
     * @param unknown_type $priority
     * @return void|multitype:
     */
    static function xml2array($contents, $get_attributes=1, $priority = 'tag') {
        if(!$contents) return array();

        if(!function_exists('xml_parser_create')) {
            //print "'xml_parser_create()' function not found!";
            return array();
        }

        //Get the XML parser of PHP - PHP must have this module for the parser to work
        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $xml_values);
        xml_parser_free($parser);

        if(!$xml_values) return;//Hmm...

        //Initializations
        $xml_array = array();
        $parents = array();
        $opened_tags = array();
        $arr = array();

        $current = &$xml_array; //Refference

        //Go through the tags.
        $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
        foreach($xml_values as $data) {
            unset($attributes,$value);//Remove existing values, or there will be trouble

            //This command will extract these variables into the foreach scope
            // tag(string), type(string), level(int), attributes(array).
            extract($data);//We could use the array by itself, but this cooler.

            $result = array();
            $attributes_data = array();

            if(isset($value)) {
                if($priority == 'tag') $result = $value;
                else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
            }

            //Set the attributes too.
            if(isset($attributes) and $get_attributes) {
                foreach($attributes as $attr => $val) {
                    if($priority == 'tag') $attributes_data[$attr] = $val;
                    else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                }
            }

            //See tag status and do the needed.
            if($type == "open") {//The starting of the tag '<tag>'
                $parent[$level-1] = &$current;
                if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                    $current[$tag] = $result;
                    if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                    $repeated_tag_index[$tag.'_'.$level] = 1;

                    $current = &$current[$tag];

                } else { //There was another element with the same tag name

                    if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                        $repeated_tag_index[$tag.'_'.$level]++;
                    } else {//This section will make the value an array if multiple tags with the same name appear together
                        $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                        $repeated_tag_index[$tag.'_'.$level] = 2;

                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }

                    }
                    $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                    $current = &$current[$tag][$last_item_index];
                }

            } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
                //See if the key is already taken.
                if(!isset($current[$tag])) { //New Key
                    $current[$tag] = $result;
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

                } else { //If taken, put all things inside a list(array)
                    if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                        // ...push the new element into that array.
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;

                        if($priority == 'tag' and $get_attributes and $attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                        $repeated_tag_index[$tag.'_'.$level]++;

                    } else { //If it is not an array...
                        $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                        $repeated_tag_index[$tag.'_'.$level] = 1;
                        if($priority == 'tag' and $get_attributes) {
                            if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well

                                $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                                unset($current[$tag.'_attr']);
                            }

                            if($attributes_data) {
                                $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                            }
                        }
                        $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                    }
                }

            } elseif($type == 'close') { //End of tag '</tag>'
                $current = &$parent[$level-1];
            }
        }

        return($xml_array);
    }

    /**
     *
     * 格式化网址为本地网址
     * @param unknown_type $srcurl
     * @param unknown_type $baseurl
     */
    static function formatUrl($srcurl, $baseurl) {
        if(!$srcurl) return false;
        $srcurl = is_array($srcurl) ? $srcurl[0] : $srcurl;
        $srcinfo = parse_url($srcurl);
        if(isset($srcinfo['scheme'])) {
            return $srcurl;
        }
        $baseinfo = parse_url($baseurl);
        $url = $baseinfo['scheme'].'://'.$baseinfo['host'];
        $url = isset($baseinfo['port']) ? $url.":".$baseinfo['port']:$url;
        if(substr($srcinfo['path'], 0, 1) == '/') {
            $path = $srcinfo['path'];
        }else{
            $pathInfo = pathinfo($baseinfo['path']);
            $path = isset($pathInfo['extension']) ? dirname($baseinfo['path']).'/'.$srcinfo['path']: $baseinfo['path'].'/'.$srcinfo['path'];
        }
        $path = str_replace('\\', '/', $path);
        $path = str_replace('//', '/', $path);

        $rst = array();
        $pathArray = explode('/', $path);
        if(!$pathArray[0]) {
            $rst[] = '';
        }
        foreach ($pathArray as $key => $dir) {
            if ($dir == '..') {
                if (end($rst) == '..') {
                    $rst[] = '..';
                }elseif(!array_pop($rst)) {
                    $rst[] = '..';
                }
            }elseif($dir && $dir != '.') {
                $rst[] = $dir;
            }
        }
        if(!end($pathArray)) {
            $rst[] = '';
        }

        $pathTmp = implode('/', $rst);
        $pathTmp = str_replace('\\', '/', $pathTmp);
        $pathTmp = str_replace('//', '/', $pathTmp);
        $url .= $pathTmp;
        return $url;
    }

    /**
     *
     * 显示memcache所有key.value
     * @param string $host
     * @param string $port
     */
    static function showAllData($host, $port){
        $memcache_obj = new Memcache();
        $memcache_obj->addServer($host, $port, true);
        $result = $memcache_obj->getExtendedStats('items');

        $items=$result["$host:$port"]['items'];
        if(!$items) return false;
        $arr_slabid = array_keys($items);
        foreach($arr_slabid as $id)
        {
            $id=intval($id);
            $str=$memcache_obj->getExtendedStats("cachedump",$id,0);
            $line=$str["$host:$port"];
            if(!empty($line))
            {
                $keys = array_keys($line);
                foreach($keys as $key)
                {
                    $data[$key] = $memcache_obj->get($key);
                }
            }
        }
        $memcache_obj->close();
        return $data;
    }

    #获取ping code
    static function getPingCode($url="http://www.baidu.com/", $proxyArr=array()){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        if($proxyArr){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
            curl_setopt($ch, CURLOPT_PROXY, $proxyArr[0]);
            if(isset($proxyArr[1])){
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyArr[1]);
            }
        }
        curl_exec($ch);
        return curl_getinfo($ch, CURLINFO_HTTP_CODE);
    }

    #检查代理是否有用
    static function checkProxyIp($ip){
        $url = "http://www.baidu.com/";
        $code = self::getPingCode($url, array($ip));
        return $code == 200 ? true:false;
    }

    #复制目录
    static function xCopy($source, $destination, $child = 1){
        if (!is_dir($source)) {
            return false;
        }
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true );
        }

        $handle = dir ($source);
        while ( $entry = $handle->read() ) {
            if (($entry != ".") && ($entry != "..")) {
                if (is_dir ( $source . "/" . $entry )) {
                    if ($child)
                        self::xCopy( $source . "/" . $entry, $destination . "/" . $entry, $child);
                } else {
                    copy($source . "/" . $entry, $destination . "/" . $entry );
                }
            }
        }
        return true;
    }


    #目录下文件正则批量替换
    static function batchReplace($sourcePath, $reg, $replaceTo, $ext="php,ini,phtml") {
        if (!is_dir($sourcePath)) {
            return false;
        }

        $handle = dir ($sourcePath);
        while ( $entry = $handle->read() ) {
            if (($entry != ".") && ($entry != "..")) {
                $tmpPath = $sourcePath . "/" . $entry;
                if (is_dir ($tmpPath)) {
                    self::batchReplace($tmpPath, $reg, $replaceTo, $ext);
                } else {
                    //开始替换
                    $pathinfo = pathinfo($tmpPath);
                    $extArr = explode(",", $ext);
                    if(isset($pathinfo['extension']) && in_array($pathinfo['extension'], $extArr)){
                        $tmpData = file_get_contents($tmpPath);
                        $tmpData = preg_replace($reg, $replaceTo, $tmpData);
                        file_put_contents($tmpPath, $tmpData);
                    }
                }
            }
        }
        return true;
    }

    #目录下文件夹，文件名正则批量替换
    static function batchDirNameReplace($sourcePath, $reg, $replaceTo) {
        if (!is_dir($sourcePath)) {
            return false;
        }
        $handle = dir ($sourcePath);
        while ( $entry = $handle->read() ) {
            if (($entry != ".") && ($entry != "..")) {
                $tmpPath = $sourcePath . "/" . $entry;
                $newEntry = preg_replace($reg, $replaceTo, $entry);
                $newPath = $sourcePath . "/" . $newEntry;
                if($newPath != $tmpPath) rename($tmpPath, $newPath);
                if (is_dir ($newPath)) {
                    self::batchDirNameReplace($newPath, $reg, $replaceTo);
                }
            }
        }
        return true;
    }

    //变量处理
    static function escape($value){
        if( is_array($value) ) {
            return array_map('My_Tool::escape', $value);
        } else {
            if(is_null($value)) return 'null';
            if(is_bool($value)) return $value ? 1 : 0;
            if(is_int($value)) return (int) $value;
            if( get_magic_quotes_gpc() ) {
                $value = stripslashes($value);
            }
            return	$value;
        }
    }

    #获取内容中的图片
    static function getContentImg($content, $isReplace=false){
        if(!$content) return false;
        set_time_limit(0);
        $content = str_replace('alt=""',"",$content);
        $content = str_replace("alt=''","",$content);
        $content = str_replace("alt=","",$content);
        $content = str_replace("alt","",$content);
        $hrefs = self::getImgPath($content);
        $hrefs = is_array($hrefs) ? $hrefs : array($hrefs);
        if($hrefs){

            foreach($hrefs as $v){
                $domian = getSysData('site.config.domain');
                $urlInfo = parse_url($v);
                if(stristr($urlInfo['host'], $domian)) continue;
                $pathinfo = pathinfo($v);

                if(!$pathinfo) return false;
                $path = "/res/upload/app/arc/".substr(md5($v),0,2)."/".substr(md5($v),2,2)."/".substr(md5($v),4,2)."/";
                $fullPath = PUBLIC_DIR . $path;
                if(!is_dir($fullPath)){
                    mkdir($fullPath, 0777, true);
                }

                $imgFullPath = isset($pathinfo['extension']) ? $fullPath.md5($v).".".$pathinfo['extension']:$fullPath.md5($v);
                $imgPath = isset($pathinfo['extension']) ? $path.md5($v).".".$pathinfo['extension']:$path.md5($v);

                if(stristr($v, "http")){
                    $imgCode = self::fileGetContents($v,120);
                    if($imgCode) {
                        file_put_contents($imgFullPath, $imgCode);
                        Home::service()->getCommon()->cutImg($imgFullPath,$imgFullPath);
                        if($isReplace && $imgPath) $content = str_replace($v, $imgPath, $content);
                    }
                }else{
                    Home::service()->getCommon()->cutImg($imgFullPath,$imgFullPath);
                }
            }
        }
        return $content;
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    static function getGravatar($email, $s = 48, $d = 'identicon', $r = 'g', $img = false, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    /**
     * 显示图片
     * Enter description here ...
     * @param unknown_type $face
     * @param unknown_type $size
     */
    static function getFace($face='', $size='48'){
        if(!$face){
            $email = rand(100, 99999)."@126.com";
            return My_Tool::getGravatar($email,$size);
        }elseif(!self::isPath($face)){
            $email = md5($face)."@126.com";
            return My_Tool::getGravatar($email,$size);
        }
        else{
            return self::showImg($face."_".$size."x".$size.".jpg");
        }
    }

    /**
     * 是否是路径
     */
    static function isPath($str){
        if(stristr($str,'/')) return true;
        if(stristr($str,'\\')) return true;
        return false;
    }


    static function isImg($imgUrl){
        return preg_match("/(\.jpg)|(\.png)|(\.gif)|(\.jpeg)$/i", $imgUrl);
    }

    //给用户名替换链接
    static function addUserLink($content){
            if(!$content) return array();
        preg_match_all("/@(.*?)&nbsp;/", $content, $matches);
        $names= isset($matches[1]) ?$matches[1]:array();
        if(!$names){
            preg_match_all("/@(.*?)\s/", $content, $matches);
            $names= isset($matches[1]) ?$matches[1]:array();
        }
        $uids = array();
        if($names){
            foreach ($names as $v){
                $userInfo = User::dao()->getInfo()->get(array("nickname"=>$v));
                if($userInfo) {
                    $url = self::url("index/index/id/".$v,"user");
                      $str = "<a href=\"".$url."\" target=\"_blank\">@".$v."&nbsp;</a>";
                      // $content = str_replace("@".$v."&nbsp;", $str, $content);
                      $content = preg_replace("/@".$v."&nbsp;/", $str, $content);
                      $content = preg_replace("/@".$v."\s/", $str, $content);
                }
            }
        }
        return $content;

    }

    //过滤xss
    static function removeXss($val) {
        $val = stripslashes($val);
        $result = self::dealWithXss($val);
        return $result;
    }

    /**
     * 处理xss
     * @param unknown $html
     * @param unknown $allow_tag
     * @param unknown $allow_tag_attr
     * @return unknown
     */
    static function dealWithXss($html,$allow_tag=array(),$allow_tag_attr=array()){
        if(!$allow_tag){
            $allowStr = "p,strong,a,em,table,td,tr,h1,h2,h3,h4,h5,hr,br,u,ul,ol,li,center,code,div,font,blockquote,small,caption,img,span,strike,sup,sub,b,dl,dt,dd,embed,object,param,pre,tbody";
            $allow_tag = explode(',',$allowStr);
        }
        if(!$allow_tag_attr){
            $allow_tag_attr = array(
                '*' => array (
                    'style'=>'/.*/i',
                    'alt'=>'/.*/i',
                    'width'=>'/^[\w_-]+$/i',
                    'height'=>'/^[\w_-]+$/i',
                    'class'=>'/.*/i',
                    'name'=>'/^.*$/i',
                    'value'=>'/.*/i',
                ),
                "object"=>array("data"=>'/.*/i',
                ),
                "embed"=>array(
                    "type"=>'/.*/i',
                    'src'=>'/.*/i',
                ),
                "font"=>array(
                    "color"=>'/^[\w_-]+$/i',
                    "size"=>'/^[\w_-]+$/i',
                ),
                'a'=>array(
                    'href'=>'/.*/i',
                    'title'=>'/.*/i',
                    'target'=>'/^[\w_-]+$/i',
                ),
                'img' => array (
                    'src'=>'/.*/i',
                ),
            );
        }
        //匹配出所有尖括号包含的字符串
        preg_match_all('/<[^>]*>/s',$html,$matches);

        if($matches[0]){
            $tags = $matches[0];

            foreach($tags as $tag_k=>$tag){

                //匹配出标签名 比如 a, br, html, li, script
                preg_match_all('/^<\s{0,}\/{0,}\s{0,}([\w]+)/i',$tag,$tag_name);
                $tags[$tag_k] = array('name'=>$tag_name[1][0],'html'=>$tag);
                if($tag_name && in_array($tags[$tag_k]['name'],$allow_tag)){

                    //匹配出含等于号的属性，注，当前版本不支持readonly等无等于号的属性
                    preg_match_all('/\s{0,}([a-z]+)\s{0,}=\s{0,}["\']{0,}([^\'"]+)["\']{0,}[^>]/i',$tag,$tag_matches);
                    if($tag_matches[0]){
                        $tags[$tag_k]['attr'] = $tag_matches;
                        foreach($tags[$tag_k]['attr'][1] as $k => $v){
                            $attr = $tags[$tag_k]['attr'][1][$k];
                            $value = $tags[$tag_k]['attr'][2][$k];
                            $preg_attr_all = isset($allow_tag_attr['*'][$attr]) ? $allow_tag_attr['*'][$attr] : "";
                            $preg_attr = isset($allow_tag_attr[$tags[$tag_k]['name']][$attr]) ? $allow_tag_attr[$tags[$tag_k]['name']][$attr]:"";

                            //判断该属性是否允许，如不允许，则unset。
                            if(($preg_attr && preg_match($preg_attr,$value)) || ($preg_attr_all && preg_match($preg_attr_all,$value))){
                                $tags[$tag_k]['attr'][0][$k] = "{$attr}='{$value}'";
                            }else{
                                unset($tags[$tag_k]['attr'][0][$k]);
                            }
                        }
                        $tags[$tag_k]['replace'] = '<'.$tags[$tag_k]['name'];
                        if(is_array($tags[$tag_k]['attr'][0])) $tags[$tag_k]['replace'] .= ' '.implode(' ',$tags[$tag_k]['attr'][0]);
                        $tags[$tag_k]['replace'] .= '>';
                    }else{
                        $tags[$tag_k]['replace'] = $tags[$tag_k]['html'];
                    }
                }else{
                    $tags[$tag_k]['replace'] = htmlentities($tags[$tag_k]['html']);
                }
                $search[$tag_k] = $tags[$tag_k]['html'];
                $replace[$tag_k] = $tags[$tag_k]['replace'];
            }
            $html = str_replace($search,$replace,$html);
        }
        return $html;
    }


    /**
     *
     * 读取文件
     * @param string $file  文件路径
     */
    static function readFile($file){
        $fp = fopen($file , 'r');
        if(flock($fp , LOCK_SH | LOCK_NB)){
            return  fread($fp , filesize($file));
            flock($fp , LOCK_UN);
        }
        return false;
    }

    /**
     *
     * 是否可以管理操作
     */
    static function canAdmin($dtstr){
        if(is_string($dtstr)){
            $dtstr = strtotime($dtstr);
        }

        $treedayTime = strtotime("-7 days");
        return $treedayTime > $dtstr ?false:true;
    }

    //获取请求类型
    static function getRequestType(){
        $accept = $_SERVER['HTTP_ACCEPT'];
        $types = explode(',', $accept);
        if(in_array("text/html", $types)){
            return "html";
        }elseif(in_array("application/json", $types)){
            return "json";
        }elseif(in_array("application/xml", $types)){
            return "xml";
        }else{
            return "unknow";
        }
    }

    //获取数组中相关key的值
    static function array_format($arr,$fields){
        if(!$arr || !$fields) return array();
        $fieldsTmp = array_flip($fields);
        $arrTmp = array_intersect_key($arr,$fieldsTmp);
        return $arrTmp;
    }

    #错误返回
    static function errorReturn($info){
        My_Tool_Error::add($info);
        return false;
    }

    //显示图片
    static function showImg($imgPath){
        $imgPath = ltrim($imgPath,"/");
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $baseUrl = $request->getBaseUrl();
        $baseUrl = str_replace("/index.php", "", $baseUrl);
        if(stristr($imgPath,'http')){
            return $imgPath;
        }
        return $baseUrl."/".$imgPath;
    }

    static function md5($str,$salt=""){
        if(getInit('site.pwd.join.salt')){
            if(!$salt){
                $salt = My::config()->getInit();
                $salt = $salt['site']['salt']['key'];
            }
            $pwd = md5($salt.$str);
        }else{
            $pwd =  md5($str);
        }

        return $pwd;
    }

    //多维数组转成一维数组
    static function changeArray2One($arr,&$getKeyResult,$tag='.',$keyStr=""){
        $keyTmp = $keyStr;
        if(is_array($arr)){
            foreach($arr as $k=>$v){
                $keyStr .=$tag.$k;
                if(is_array($v)){
                    self::changeArray2One($v,$getKeyResult,$tag,$keyStr);
                    $keyStr =$keyTmp;
                }else{
                    $keyStr = trim($keyStr,$tag);
                    $getKeyResult[$keyStr] = $v;
                    $keyArr = explode($tag,$keyStr);
                    array_pop($keyArr);
                    $keyStr = implode($tag,$keyArr);
                }
            }
        }else{
            $getKeyResult= $arr;
        }
        return $getKeyResult;
    }


    /**
     * 字符串中间打星号
     *
     * @param $str
     * @param int $left_length  左边保留长度
     * @param int $right_length 右边保留长度
     * @return string
     */
    static function marskName($str,$left_length=1,$right_length=1){
        $s = mb_strlen($str,'utf-8');
        if($s< $left_length + $right_length) {
            return $str;
        }
        $left = mb_substr($str, 0, $left_length, 'utf-8');
        if($s == $left_length + $right_length) {
            return $left.str_repeat('*', $right_length);
        }
        $right = mb_substr($str, $s - $right_length, $right_length, 'utf-8');
        return $left.str_repeat('*', $s - $left_length - $right_length).$right;
    }


    static function getTags($subject,$message,$num=3){
        $subjectenc = strip_tags($subject);
        $messageenc = strip_tags(preg_replace("/[\s]{2,}/", '', $message));
        $parsestr = $subjectenc.$messageenc;
        $parsestr = preg_replace("/&.*?;/i",'',$parsestr);
//        echo $parsestr;
        self::importOpen("fenci/pscws4.class.php");
        $pathRoot = ROOT_LIB."/Open/fenci";
        $pscws = new PSCWS4();
        $pscws->set_dict($pathRoot.'/scws/dict.utf8.xdb');
        $pscws->set_rule($pathRoot.'/scws/rules.utf8.ini');
        $pscws->set_ignore(true);
        $pscws->send_text($parsestr);
        $words = $pscws->get_tops($num);
        $tags = array();
        foreach ($words as $val) {
            $tags[] = $val['word'];
        }
        $pscws->close();
        return $tags;
    }

    //投票算法分数
    static function getVoteScore($vote,$devote){
        $voteDiff = $vote - $devote;
        if($voteDiff > 0) {
            $pos = 1;
        } elseif($voteDiff < 0) {
            $pos = -1;
        } else {
            $pos = 0;
        }
        $voteDispute = $voteDiff != 0 ? abs($voteDiff) : 1;
        $fund = strtotime('2012-12-12');
        $created = strtotime('-3 days');
        $time = $created - $fund;
        $socre = log10($voteDispute) + $pos * $time / 45000;
        return $socre;
    }

    static function my_substr($str, $start, $len)
    {
        $tmpstr = "";
        $strlen = $start + $len;
        for($i = 0; $i < $strlen; $i++)
        {
            if( ord( substr($str, $i, 1) ) > 0xa0 )
            {
                $tmpstr .= substr($str, $i, 3);
                $i += 2;
            } else
                $tmpstr .= substr($str, $i, 1);
        }
        return $tmpstr;
    }

   static function parseHost($httpurl){
        $host = strtolower ($httpurl);
        if (strpos ( $host, '/' ) !== false) {
            $parse = @parse_url ( $host );
            $host = $parse ['host'];
        }
        $topleveldomaindb = array ('com', 'edu', 'gov', 'int', 'mil', 'net', 'org', 'biz', 'info', 'pro', 'name', 'museum', 'coop', 'aero', 'xxx', 'idv', 'mobi', 'cc', 'me' );
        $str = '';
        foreach ( $topleveldomaindb as $v ) {
            $str .= ($str ? '|' : '') . $v;
        }

        $matchstr = "[^\.]+\.(?:(" . $str . ")|\w{2}|((" . $str . ")\.\w{2}))$";
        if (preg_match ( "/" . $matchstr . "/ies", $host, $matchs )) {
            $domain = ".".$matchs ['0'];
        } else {
            $domain = $host;
        }
        return $domain;
  }

}
