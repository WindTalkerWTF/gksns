<?php
class Group_Service_Common{
	function getAdmMenu(){
		$config = My_Config::getInstance()->getConfig("init", 1, 1, "group");
		return isset($config['adminUrl']) ? $config['adminUrl']:"";
	}
	
	//获取群组分页信息
	function getPageGroups($where=array(), $orderBy="", $limit='',$pageSize=''){
		$obj = new Group_Dao_Info();
    	$list = $obj->gets($where, $orderBy ,$limit, $pageSize, "", true);
    	$totalNum =  $obj->getTotal();
    	if($list){
    		$user = User::service()->getCommon()->getLogined();
    		$uid = $user['id'];
    		foreach ($list as $k=>$v){
    			$members = Group::dao()->getUser()->get(array("uid"=>$uid,"group_id"=>$v['id']));
    			$list[$k]['hasJoin'] = $members ? 1 : 0;
    		}
    	}
    	return array($list, $totalNum);
	}
	
	//获取群组帖子
	function getGroupPosts($where=array(), $orderBy="", $limit='',$pageSize=''){
		$obj = new Group_Dao_Arc();
    	$list = $obj->gets($where, $orderBy ,$limit, $pageSize, "", true);
    	$totalNum =  $obj->getTotal();

		if($list){
			$uids = array();
			$groupIds = array();
    		foreach($list as $k=>$v){
    			$uids[] = $v['uid'];
    			$groupIds[] = $v['group_id'];
    		}
    		
    		$userInfos = User::dao()->getInfo()->gets(array("id"=>array("in",$uids)));
    		$groupInfos = Group::dao()->getInfo()->gets(array("id"=>array("in",$groupIds)));
    		
    		foreach ($list as $k=>$v){
	    		foreach ($userInfos as $ik=>$iv){
	    			if($v['uid'] == $iv['id']){
	    				$list[$k]['user'] = $iv;
	    			}
	    		}
	    		
    			foreach ($groupInfos as $gk=>$gv){
	    			if($v['group_id'] == $gv['id']){
	    				$list[$k]['group'] = $gv;
	    			}
	    		}
    		}
    		
    	}

    	return array($list, $totalNum);
	}
	
	#获取文章 
	function getArc($id){
		$info = Group::dao()->getArc()->get(array("id"=>$id,"is_publish"=>1));
		if($info){
			$arc = Home::dao()->getArc()->get(array("arc_type"=>"group", "ref_id"=>$id));
			$info['arc'] = $arc;
			$user = User::dao()->getInfo()->get(array("id"=>$info['uid']));
			$info['user'] = $user;
			$groupInfo = Group::dao()->getInfo()->get(array("id"=>$info['group_id']));
			$info['group'] = $groupInfo;
			
		}
		return $info;
	}
	
}