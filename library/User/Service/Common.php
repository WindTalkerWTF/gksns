<?php
class User_Service_Common extends Home_Service_Base{
	//site
	const FEED_TYPE_SITE_ADD = "SITE_ADD";
	const FEED_TYPE_NAME_SITE_ADD = "添加文章";
	const FEED_TYPE_SITE_EDIT = "SITE_EDIT";
	const FEED_TYPE_NAME_SITE_EDIT = "编辑文章";
	const FEED_TYPE_SITE_DELETE = "SITE_DELETE";
	const FEED_TYPE_NAME_SITE_DELETE = "删除文章";
	const FEED_TYPE_SITE_REPLY_ADD = "SITE_REPLY_ADD";
	const FEED_TYPE_NAME_SITE_REPLY_ADD = "评论文章";
	const FEED_TYPE_SITE_REPLY_DELETE = "SITE_REPLY_DELETE";
	const FEED_TYPE_NAME_SITE_REPLY_DELETE = "删除文章评论";
	const FEED_TYPE_SITE_RECOMEND = "SITE_RECOMEND";
	const FEED_TYPE_NAME_SITE_RECOMEND = "推荐文章";
	//video
	const FEED_TYPE_VIDEO_REPLY_ADD = "VIDEO_REPLY_ADD";
	const FEED_TYPE_NAME_VIDEO_REPLY_ADD = "评论视频";
	const FEED_TYPE_VIDEO_REPLY_DELETE = "VIDEO_REPLY_DELETE";
	const FEED_TYPE_NAME_VIDEO_REPLY_DELETE = "删除视频评论";
	const FEED_TYPE_VIDEO_RECOMEND = "VIDEO_RECOMEND";
	const FEED_TYPE_NAME_VIDEO_RECOMEND = "推荐视频";
	//group
	const FEED_TYPE_GROUP_POST_DELETE = "GROUP_POST_DELETE";
	const FEED_TYPE_NAME_GROUP_POST_DELETE = "删除小组帖子";
	const FEED_TYPE_GROUP_POST_EDIT = "GROUP_POST_EDIT";
	const FEED_TYPE_NAME_GROUP_POST_EDIT = "编辑小组帖子";
	const FEED_TYPE_GROUP_POST_ADD = "GROUP_POST_ADD";
	const FEED_TYPE_NAME_GROUP_POST_ADD = "添加小组帖子";
	const FEED_TYPE_GROUP_REPLY_ADD = "GROUP_REPLY_ADD";
	const FEED_TYPE_NAME_GROUP_REPLY_ADD = "评论小组帖子";
	const FEED_TYPE_GROUP_REPLY_DELETE = "GROUP_REPLY_DELETE";
	const FEED_TYPE_NAME_GROUP_REPLY_DELETE = "删除小组帖子评论";
	const FEED_TYPE_GROUP_APPLY= "GROUP_APPLY";
	const FEED_TYPE_NAME_GROUP_APPLY = "申请小组";
	const FEED_TYPE_GROUP_JOIN= "GROUP_JOIN";
	const FEED_TYPE_NAME_GROUP_JOIN = "加入小组";
	const FEED_TYPE_GROUP_QUITE= "GROUP_QUITE";
	const FEED_TYPE_NAME_GROUP_QUITE = "退出小组";
	const FEED_TYPE_GROUP_POST_RECOMMENG= "GROUP_POST_RECOMMENG";
	const FEED_TYPE_NAME_GROUP_POST_RECOMMENG = "推荐帖子";
	//ask
	const FEED_TYPE_ASK_QUESTION_ADD= "ASK_QUESTION_ADD";
	const FEED_TYPE_NAME_ASK_QUESTION_ADD = "添加问题";
	const FEED_TYPE_ASK_QUESTION_EDIT= "ASK_QUESTION_EDIT";
	const FEED_TYPE_NAME_ASK_QUESTION_EDIT = "编辑提问";
	const FEED_TYPE_ASK_QUESTION_DELETE= "ASK_QUESTION_DELETE";
	const FEED_TYPE_NAME_ASK_QUESTION_DELETE = "删除提问";
	const FEED_TYPE_ASK_QUESTION_FOLLOW= "ASK_QUESTION_FOLLOW";
	const FEED_TYPE_NAME_ASK_QUESTION_FOLLOW = "关注问题";
	const FEED_TYPE_ASK_QUESTION_CANCELFOLLOW= "ASK_QUESTION_CANCELFOLLOW";
	const FEED_TYPE_NAME_ASK_QUESTION_CANCELFOLLOW = "取消关注问题";
	const FEED_TYPE_ASK_REPLY_ADD= "ASK_REPLY_ADD";
	const FEED_TYPE_NAME_ASK_REPLY_ADD = "回答问题";
	const FEED_TYPE_ASK_REPLY_DELETE= "ASK_REPLY_DELETE";
	const FEED_TYPE_NAME_ASK_REPLY_DELETE = "删除回答";
	const FEED_TYPE_ASK_TAG_FOLLOW= "ASK_TAG_FOLLOW";
	const FEED_TYPE_NAME_ASK_TAG_FOLLOW = "关注标签";
	const FEED_TYPE_ASK_TAG_CANCELFOLLOW= "ASK_TAG_CANCELFOLLOW";
	const FEED_TYPE_NAME_ASK_TAG_CANCELFOLLOW = "取消关注标签";
	const FEED_TYPE_ASK_REPLY_GOOD= "ASK_REPLY_GOOD";
	const FEED_TYPE_NAME_ASK_REPLY_GOOD = "支持答案";
	
	
	#登录成功处理
	function setLogin($userInfo, $rememberMe=0,$isUid=0){
        if($isUid){
            $uid = $userInfo;
        }else{
            $uid = $userInfo['id'];
        }

        $userInfo = User::dao()->getInfo()->get(array("id"=>$uid));
        $user = $userInfo;
        unset($userInfo['pwd']);
		$session = new My_Session_Namespace("login");
		$session->user = $userInfo;
		if($rememberMe){
			$autoLoginData['uid'] = $user['id'];
			$autoLoginData['pwd'] = $user['pwd'];
			$autoLoginData = serialize($autoLoginData);
			 $config= My::config()->getInit('site.salt.key');
			 $key = $config['site']['salt']['key'];
			$autoLoginData = My_Tool::authcode($autoLoginData,$key, "ENCODE");
			$sessionDomain = getInit('session.domain');
			My_Tool_Cookie::set("autologin", $autoLoginData, 60*60*24*365, "/", $sessionDomain);
		}
		
		return true;
	}
	
	#获取登录
	function getLogined(){
		$session = new My_Session_Namespace("login");
		return $session->user;
	}
	
	#注册处理
	function setReg($email){
		//写入token
		$idata['email'] = $email;
		$idata['token'] = My_Tool::md5("reg".uniqid().time());
		$idata['created_time'] = time();
		User::dao()->getEmailvalidate()->insert($idata);
		//发送验证邮件
		User::service()->getMail()->sendRegMail($email, $idata['token']);
		return true;
	}
	
	#增减coin
	function addCoin($uid, $number=1, $log=""){
		$number = intval($number);
		$uid = intval($uid);
		#积分增加
		User::dao()->getInfo()->inCrease("coin", array("id"=>$uid), $number);
		#增加记录
		$data['uid'] = $uid;
		$data['number'] = $number;
		if($log) $data['logs'] = $log;
		User::dao()->getCoinlogs()->insert($data);
		$this->updateUserSession($uid);
		return true;
	}
	
	#减少coin
	function delCoin($uid, $number=1, $log=""){
		$number = intval($number);
		$uid = intval($uid);
		#积分增加
		User::dao()->getInfo()->deCrement("coin", array("id"=>$uid), $number);
		#增加记录
		$data['uid'] = $uid;
		$data['number'] = "-".$number;
		if($log) $data['logs'] = $log;
		User::dao()->getCoinlogs()->insert($data);
		$this->updateUserSession($uid);
		return true;
	}
	
	#更新session
	function updateUserSession($uid){
		#更新session
		$userinfo = User::dao()->getInfo()->get(array("id"=>$uid));
		unset($userinfo['pwd']);
		$session = new My_Session_Namespace("login");
		$session->user = $userinfo;
		return true;
	}
	
	#判断是否是管理员
	function isAdmin($uid){
		if(!$uid) return false;
		$userinfo = User::dao()->getInfo()->get(array("id"=>$uid));
		if(!$userinfo) return false;
		if($userinfo['role'] == 9) return true;
		return false;
	}
	
	//添加动态
	function addFeed($uid, $feedType, $feedTypeName, $feed_title, $feed_data,$url="", $url_app="",$ref_id=0){
//		if(!$uid || !$feedType || !$feedTypeName || !$feed_title ) return false;
		$data["uid"] = $uid;
		$data["feed_type"] = $feedType;
		$data["feed_type_name"] = $feedTypeName;
		$data["feed_title"] = $feed_title;
		$data["feed_data"] = $feed_data;
		$data["ref_id"] = $ref_id;
		$data["is_public"] = Home::service()->getCommon()->contentNeedCheck();
		if($url) $data["url"] = $url;
		if($url_app) $data["url_app"] = $url_app;
	    User::dao()->getFeed()->insert($data);
	    #增减统计数目
	    $this->inCrField("feed_count", $uid);
	}
	
	//获取动态
	function getFeed($where, $orderBy="", $limit=0,$pageSize=0){
		$obj = new User_Dao_Feed();
    	$info = $obj->gets($where, $orderBy, $limit, $pageSize,"",true);
    	if($info){
    		$uids = array();
    		foreach($info as $v){
    			$uids[] = $v['uid'];
    		}
    		$uobj = new User_Dao_Info();
    		$uinfo = $uobj->gets(array("id"=>array("in", $uids)));
    		if($uinfo){
	    		foreach($info as $k=>$v){
	    			foreach ($uinfo as $uv){
	    				if($v['uid'] == $uv['id']){
	    					$info[$k]['user'] = $uv;
	    				}else{
	    					$info[$k]['user'] = "";
	    				}
	    			}
	    		}
    		}
    	}
    	return array($info, $obj->getTotal());
	}
	
	#统计自增
	function inCrField($field, $uid, $num=1){
		if(!$field || !$uid) return false;
		User::dao()->getStat()->inCrease($field, array("uid"=>$uid), $num);
		return true;
	}
	
	#统计自减
	function deCrField($field, $uid, $num=1){
		if(!$field || !$uid) return false;
		User::dao()->getStat()->deCrement($field, array("uid"=>$uid, $field=>array(">", 0)), $num);
		return true;
	}
	
	#获取关注
	function getFollow($where, $limit=0, $pageSize=0, $getTotal=0){
		$orderBy = " created_at DESC ";
		$uids = array();
		$obj = new User_Dao_Follow();
		if($getTotal){
			$uidinfos = $obj->gets($where, $orderBy, $limit, $pageSize, "", true);
		}else{
			$uidinfos = $obj->gets($where, $orderBy, $limit, $pageSize);
		}
		if(!$uidinfos) return false;
		
		foreach($uidinfos as $v){
			$uids[] = $v['follow_uid'];
		}
		
		if(!$uids) return false;
		$whereInfo['id'] = array("in", $uids);
		$tmp = User::dao()->getInfo()->gets($whereInfo);
		$stat = User::dao()->getStat()->gets(array("uid"=>array("in", $uids)));
		
		if($tmp){
			foreach($tmp as $k=>$v){
				foreach($stat as $sv){
					if($v['id']==$sv['uid']){
						$tmp[$k]['stat'] =$sv; 
					}
				}
			}
		}
		
		if($getTotal){
			return array($tmp, $obj->getTotal());
		}else{
			return $tmp;
		}
	}
	
	#获取被关注
	function getToFollow($where, $limit=0, $pageSize=0, $getTotal=0){
		$orderBy = " created_at DESC ";
		$uids = array();
		$obj = new User_Dao_Follow();
		if($getTotal){
			$uidinfos = $obj->gets($where, $orderBy, $limit, $pageSize, "", true);
		}else{
			$uidinfos = $obj->gets($where, $orderBy, $limit, $pageSize);
		}
		if(!$uidinfos) return false;
		
		foreach($uidinfos as $v){
			$uids[] = $v['uid'];
		}
		
		if(!$uids) return false;
		$whereInfo['id'] = array("in", $uids);
		$tmp = User::dao()->getInfo()->gets($whereInfo);
		$stat = User::dao()->getStat()->gets(array("uid"=>array("in", $uids)));
		
		if($tmp){
			foreach($tmp as $k=>$v){
				foreach($stat as $sv){
					if($v['id']==$sv['uid']){
						$tmp[$k]['stat'] =$sv; 
					}
				}
			}
		}
		
		if($getTotal){
			return array($tmp, $obj->getTotal());
		}else{
			return $tmp;
		}
		
	}
	
	//获取用户信息
	function getUserInfo($uid){
		if(!$uid) return false;
		$info = User::dao()->getInfo()->get(array("id"=>$uid));
		if(!$info) return false;
		$ustat = User::dao()->getStat()->get(array("uid"=>$uid));
		if(!$ustat) return $info;
		return array_merge($info, $ustat);
	}
	
	
	function logout(){
		$session = new My_Session_Namespace("login");
		$user = User::service()->getCommon()->getLogined();
		User::dao()->getInfo()->update(array("uc_synlogout"=>0),array("id"=>$user['id']));
		User::dao()->getInfo()->update(array("uc_synlogin"=>1),array("id"=>$user['id']));
		unset($session->user);
	
		$sessionDomain = getInit('session.domain');
		My_Tool_Cookie::set("autologin", "", -10000, "/", $sessionDomain);
	}
	
}