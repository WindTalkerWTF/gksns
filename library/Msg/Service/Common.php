<?php
class Msg_Service_Common extends Home_Service_Base{
	
	function init(){
	}
	
	#发送消息
	function sendMsg($sendUid, $receiveUid , $content, $rootId=0, $isSys=0){
		$sendUid = intval($sendUid);
		$receiveUid = intval($receiveUid);
		$insertId = 0;
		if($content){
			if($rootId) $data['root_id'] = 	$rootId;
			$data['uid'] = 	$sendUid;
			$data['receive_uid'] = 	$receiveUid;
			$data['content'] = 	$content;
			$data['msg_type'] = $isSys;
			$insertId = Msg::dao()->getData()->insert($data);
			if(!$rootId){
				Msg::dao()->getData()->update(array("root_id"=>$insertId), array("id"=>$insertId));
			}
			#更新统计
			$rootId = $rootId ? $rootId : $insertId;
			Msg::dao()->getData()->inCrease("sub_count", array("id"=>$rootId));
		}
		return $insertId;
	}
	
	#发送通知
	function sendNotice($feedTitle,$url,$urlApp,$uids){
		if(!$feedTitle) return false;
		$data['feed_title'] = $feedTitle;
		$data['url'] = $url;
		$data['url_app'] = $urlApp;
		$id = Msg::dao()->getNotice()->insert($data);
		$uids = array_unique($uids);
		if($uids){
			foreach($uids as $uid){
				My_Tool_Queue::getInstance("msg_notice_".$uid)->set($id);
			}
		}
		
		return true;
	}
	
	#处理会员通知队列
	function dealNoticeQueue($uid){
		if(!$uid) return false;
		$arr = My_Tool_Queue::getInstance("msg_notice_".$uid)->get(5);
		if($arr){
			foreach ($arr as $v){
				if(!$v) continue;
				$result = Msg::dao()->getNoticereadlog()->get(array("notice_id"=>$v,"uid"=>$uid));
				if(!$result){
    				$data['notice_id'] = $v;
    				$data['uid'] = $uid;
    				Msg::dao()->getNoticereadlog()->insert($data);
				}
			}
		}
	}
	
}