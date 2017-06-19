<?php
class Ask_Service_Common{
	function getAdmMenu(){
		$config = My_Config::getInstance()->getConfig("init", 1, 1, "ask");
		return isset($config['adminUrl']) ? $config['adminUrl']:"";
	}
	
	function getTagIdByTagName($tagName,$uid=0){
		$info = Home::dao()->getTag()->get(array("name"=>$tagName));
		if($info){
			Home::dao()->getTag()->inCrease("ask_count",array("id"=>$info['id']));
			return $info['id'];
		}else{
			if(!$uid){
				$user = User::service()->getCommon()->getLogined();
				$uid = $user['id'];
			}
			$data['name'] = $tagName;
			$data['ask_count'] = 1;
			$data['uid'] = $uid;
			$insertId = Home::dao()->getTag()->insert($data);
			//添加即关注
			if($insertId){
				$idata['uid'] = $uid;
				$idata['tag'] = $tagName;
				$idata['tag_id'] = $insertId;
				Ask::dao()->getTagfollow()->insert($idata);
				#标签自增
				User::dao()->getStat()->inCrease("tag_count",array("uid"=>$uid));
			}
			return $insertId;
		}
	}
}