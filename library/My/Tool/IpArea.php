<?php
/**
 * 
 * 获取ip省市县
 *
 */
class My_Tool_IpArea{
	
	private static $specialProvince = array("内蒙古", "黑龙江", "广西", 
											"西藏", "宁夏", "新疆", 
											"香港", "澳门");
	
	/**
	 * 
	 * 通过ip获取地址
	 */
	private static function getAreaByIp($ipStr){
		if(!$ipStr) return false;
		require_once ROOT_LIB . '/Open/IpArea.class.php';
		$dataPath = 'ipdata/qqwry.dat';
		$ip= new IpArea($dataPath);         
		return $ip->get($ipStr, true);
	}
	
	/**
	 * 
	 * 通过ip获取最小地址
	 * @param string $ipStr
	 */
	static function getSmallArea($ipStr){
		$info = self::getAreaByIp($ipStr);
		$a= self::getAreaType1($info);
//		print_r($ipStr."sss");
		if(!$a['county'] && !$a['city']){
			$a = self::getAreaType2($info);
		}
		
		if(!$a['county'] && !$a['province'] && !$a['city']){
			$a = self::getAreaType3($info);
		}
		return $a;
	}
	
	/**
	 * 
	 * example  香港
	 * @param string $ipStr
	 */
	private static function getAreaType3(array $info){
		if(!$info) throw new Exception("数据为空", -401);
		
		$province = "";
		$city = "";
		$county = "";
		
		if($info['country']){
			$word= "";
			#取前2字
			foreach(self::$specialProvince as $k=>$v){
				if(mb_strstr($info['country'], $v)){
					$word = $v;
					break;
				}
			}
			$tmp = explode($word, $info['country']);
			if(isset($tmp[0])) $province = $word;
			if(isset($tmp[1])) $city = $tmp[1];
		}
		return array("province"=>$province, "city"=>$city, "county"=>$county);
	}
	
	
	/**
	 * 
	 * example 上海市闸北区
	 * @param array $info
	 * @throws Exception
	 */
	private static function getAreaType2(array $info){
		if(!$info) throw new Exception("数据为空", -401);
		$province = "";
		$city = "";
		$county = "";
		
		if($info['country']){
			$tmp = explode("市", $info['country']);
			if(isset($tmp[1])){ 
				$province = $tmp[0];
				$city = $province;
			}
			if(isset($tmp[1])) $county = $tmp[1];
		}
		
		$county = str_replace("区", "", $county);
		
		return array("province"=>$province, "city"=>$city, "county"=>$county);
	}
	
	
	
	/**
	 * 
	 * xx省xx市xx县(市/区)
	 * @param array $info
	 * @throws Exception
	 */
	private static function getAreaType1(array $info){
		if(!$info) throw new Exception("数据为空", -401);
		$province = "";
		$city = "";
		$county = "";
//		print_r($info);
		if($info['country']){
			//xx省xx市xx县
			$tmp = explode('省', $info['country']);
			if(isset($tmp[1])) $province = $tmp[0];
			if(isset($tmp[1])){
				$cityTmp = explode('市', $tmp[1]);
				
				if(isset($cityTmp[1])) $city = $cityTmp[0];
				if(isset($cityTmp[1])){
					#县
					$countyTmp = explode("县", $cityTmp[1]);
					if(isset($countyTmp[1])) $county = $countyTmp[0];
//					print_r($cityTmp[1]);
					#区
					if(!$county) {
						$countyTmp = explode("区", $cityTmp[1]);
						if(isset($countyTmp[1])) $county = $countyTmp[0];
					}
				 }
				
				if(!$city){
					$cityTmp = explode('州', $tmp[1]);
					if(isset($cityTmp[1])) $city = $cityTmp[0];
					if(isset($cityTmp[1])){
						#县
						$countyTmp = explode("县", $cityTmp[1]);
						if(isset($countyTmp[1])) $county = $countyTmp[0];
	//					print_r($cityTmp[1]);
						#区
						if(!$county) {
							$countyTmp = explode("区", $cityTmp[1]);
							if(isset($countyTmp[1])) $county = $countyTmp[0];
						}
					 }
				}
				
				if(!$county) $county = (isset($cityTmp[1]) && $cityTmp[1]) ? $cityTmp[1] : "";
				
			}
		}
		return array("province"=>$province, "city"=>$city, "county"=>$county);
	}
	
}