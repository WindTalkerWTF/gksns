<?php
class My_Cache {
	
	/**
	 * 清空文件缓存
	 */
	static function clearFileCache(){
		$path = CACHE_DIR;
		if(!is_dir($path)) return true;
		My_Tool_File::deldir($path);
		return true;
	}
	
	/**
	 * 
	 * 得到缓存处理对象
	 */
	static function set($key, $result, $expire=3600){
		$config = getInit();
		$cacheHandle = $config['cache']['handle'];
		if($cacheHandle=='memcache'){
			$obj = My_Cache_Memcache::getInstance();
            $key = $config['appname']."_".$key;
			$obj->set($key, $result, 0, $expire);
		}else{
			$obj = My_Cache_File::getInstance();
            $key = $config['appname']."_".$key;
			$obj->set($key, $result, $expire);
		}
	}
	
	static function get($key){
		$config = getInit();
		$cacheHandle = $config['cache']['handle'];
		if($cacheHandle=='memcache'){
			$obj = My_Cache_Memcache::getInstance();
            $key = $config['appname']."_".$key;
			return $obj->get($key);
		}else{
			$obj = My_Cache_File::getInstance();
            $key = $config['appname']."_".$key;
			return $obj->get($key);
		}
	}
	
	static function delete($key){
				$config = getInit();
		$cacheHandle = $config['cache']['handle'];
		if($cacheHandle=='memcache'){
			$obj = My_Cache_Memcache::getInstance();
            $key = $config['appname']."_".$key;
			return $obj->delete($key);
		}else{
			$obj = My_Cache_File::getInstance();
            $key = $config['appname']."_".$key;
			return $obj->delete($key);
		}
	}
	
	static function deleteFileCacheList($path){
		if(!$path) return true;
		$cacheList = CACHE_DIR . "/cacheList.php";
		if(!is_file($cacheList)) return true;
		$arr = include $cacheList;
		if($path){
			foreach($path as $v){
				$k = array_search($v, $arr);
				unset($arr[$k]);
			}
		}
        if(!$arr){
			$cacheListStr = '<?php' . PHP_EOL . 'return array();'. PHP_EOL;
			file_put_contents($cacheList, $cacheListStr,LOCK_EX);
			return true;
		}
		$cacheListStr = '<?php' . PHP_EOL . 'return ' . var_export($arr, true) .";". PHP_EOL;
        file_put_contents($cacheList, $cacheListStr,LOCK_EX);
        return true;
	}
	
}