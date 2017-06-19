<?php
class User_Tool{	
	
	static function getFace($face='', $size='48'){
		return My_Tool::getFace($face, $size);
	}
	
	#获取@某人的会员id
	static function getAtUid($content){
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
				if($userInfo) $uids[] = $userInfo['id'];
			}
		}
		return $uids;
	}

}