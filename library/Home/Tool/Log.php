<?php
/**
 * 日志记录
 * @author wangkaihui
 */
class Home_Tool_Log{
	
	/**
	 * 保存到数据库
	 * @param array $logs
	 * @param string $path
	 * @return boolean
	 */
	static function save($logs, $path=""){
		
		if(!$path) $path = ROOT_DIR  . "/data/logs/".date('Y-m-d')."/log.txt.php";
    	
    	$dir = dirname($path);
    	if(!is_dir($dir)){
    		My_Tool_File::createfolder($dir);
    	}
    	
    	if($logs){
    		if(is_array($logs)){
    			foreach($logs as $k=>$v){
                  if(is_string($v)){ 
					  $logs[$k] = $v;
				  }elseif(is_array($v)){
						$logs[$k] = var_export($v,true);
				  }else{
					unset($logs[$k]);
				  } 
    			}
    		}
    	}

    	$tmp[] = My_Tool::getOlineIp();
    	$tmp[] = date("Y-m-d H:i:s");
    	$logstr = '/*';
    	$logstr .= implode("      ", $tmp). "\n";
    	if(isset($logs) && is_array($logs)) $logstr .= implode("      \n", $logs). "\n";
    	$logstr .= "---------------------------------------------------\n";
    	$logstr .= "*/\r\n";
    	
        if(!is_file($path)){
            $tmp="<?php\r\n".$logstr;
        }else{
            $tmp = $logstr;
        }
    	file_put_contents($path, $tmp, FILE_APPEND);
    	return true;
	}
	
	/**
	 * 保存到数据库
	 * @param array $logs
	 */
	static function saveDb($logs, $uid=0){
		$logstr = print_r($logs, true);
		
		$data["ip"] = My_Tool::getOlineIp();
		$data["created_at"] = date("Y-m-d H:i:s");
		$data["content"] = $logstr;
		$data["uid"] = $uid;
		Home::dao()->getLogs()->insert($data);
		return true;
	}

}