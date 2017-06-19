<?php
class Home_Service_Common extends Home_Service_Base{

	#获取默认apps路径
	function getDefaultDirectory(){
		$defaultAppName = Zend_Controller_Front::getInstance()->getDefaultModule();
		return Zend_Controller_Front::getInstance()->getModuleDirectory($defaultAppName);
	}

	#获取网站名称
	function getSiteName(){
		$config = My_Config::getInstance()->getInit();
		return $config['appname'];
	}

	#检查验证码
	function checkCaptcha($captcha,$key=""){
		My_Tool::importOpen("php_verify/verify.php");
		$session = new My_Session_Namespace($key.YL_Security_Secoder::$seKey);
		$code = $session->code;
		if(strtolower($code) == strtolower($captcha)) return true;
		return false;
	}

	#获取app路径
	function getAppPath($appName=''){
		if($appName){
			$appName = strtolower($appName);
			return Zend_Controller_Front::getInstance()->getModuleDirectory($appName);
		}else{
			return Zend_Controller_Front::getInstance()->getModuleDirectory();
		}
	}

	#清空app文件
	function clearAppFile($appName){
		$appName = strtolower($appName);
		$path = APPLICATION_PATH . DS.$appName;
		My_Tool_File::deldir($path);
		$resPath = ROOT_DIR."/res/asset/" . $appName;
		My_Tool_File::deldir($resPath);
		$libPath = ROOT_LIB."/".ucfirst($appName);
		My_Tool_File::deldir($libPath);
		$configPath = ROOT_DIR."/configs/" . $appName;
		My_Tool_File::deldir($configPath);
		return true;
	}

	#卸载
	function uninstall($appName){
		if(!$appName) return false;
		set_time_limit(0);
 		$appPath = $this->getAppPath($appName);
		$sqlPath = $appPath."/data/sql/uninstall.sql";
		if(is_file($sqlPath)){
			My_Tool::importOpen("Install.class.php");
			$sqlArr = FInstall::mysql($sqlPath);
			if($sqlArr){
				foreach ($sqlArr as $sv){
					Home::dao()->getCommon()->exec($sv, array(), 0);
				}
			}
		}
		//删除文件
		$this->clearAppFile($appName);
		return true;
	}

	#安装
	function install($appName){
		if(!$appName) return false;
		set_time_limit(0);
 		$appPath = APPLICATION_PATH . DS. strtolower($appName);
		$sqlPath = $appPath."/data/sql/install.sql";
		if(is_file($sqlPath)){
		    $txt = file_get_contents($sqlPath);
		    if(!$txt) return true;
			My_Tool::importOpen("Install.class.php");
			$sqlArr = FInstall::mysql($sqlPath);
			if($sqlArr){
				foreach ($sqlArr as $sv){
					Home::dao()->get()->exec($sv, array(), 0);
				}
			}
 		}
		return true;
	}

	#上传图片
	function upImg($savePath,$isked=0){
	 	$upload = new My_Tool_Upload();
		//设置上传文件大小
		$upload->maxSize=1024*1024*1;//最大1M
		//设置上传文件类型
		$upload->allowExts  = explode(',','jpg,png,jpeg,bmp');
		//设置附件上传目录
		$upload->savePath = $savePath;
		if(!is_dir($upload->savePath)) mkdir($upload->savePath, 0777, true);
		$upload->saveRule = "uniqid";
		if(!$upload->upload())
		 {
			 $appName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
			 $isAdmin = $appName == 'admin' ? 1:0;
			 if($isAdmin){
				//捕获上传异常
                if($isked){
                    exit(json_encode(array('error' => 1, 'message' => '上传失败，只支持jpg,png,jpeg,bmp格式，不大于1M的图片，请重新上传!')));
                }else{
                    Admin_Tool::showMsg("上传失败，只支持jpg,png,jpeg,bmp格式，不大于1M的图片，请重新上传!");
                }

			 }else{
				 //捕获上传异常
                 if($isked){
                     exit(json_encode(array('error' => 1, 'message' => '上传失败，只支持jpg,png,jpeg,bmp格式，大小不大于1M的图片，请重新上传!')));
                 }else{
                     My_Tool::showMsg("上传失败，只支持jpg,png,jpeg,bmp格式，不大于1M的图片，请重新上传!");
                 }
			 }
		}
		else
		{
			//取得成功上传的文件信息
			$info = $upload->getUploadFileInfo();
			return $info;
	    }
	}

	#裁剪图片
	function cutImg($oldPath, $newPath, $sizes=array("160x160","48x48", "24x24","330x235")){
		foreach ($sizes as $v){
			list($w, $h) = explode('x', $v);
			My_Tool_Image::makethumb($oldPath, $newPath."_".$w."x".$w.".jpg",$w,$h);
		}
		$savepath = str_replace(ROOT_DIR, "", $newPath);
		$savepath = str_replace('\\', '/', $newPath);
		return $savepath;
	}

	//保存系统配置
	function saveSysData($key,$content){
		if(!$key) return My_Tool::errorReturn("系统配置参数为空!");
        $data=array($key=>$content);
        My::config()->save($data,"sysdata");
        return true;
	}

	//获取系统配置
	function getSysData($key){
		if(!$key) return My_Tool::errorReturn("系统配置参数为空!");
        $sysDefault = My::config()->getSysdata();
        $config = array();
        My_Tool::changeArray2One($sysDefault,$config);
        return $config[$key];
	}


	//内容是否需要审核
	function contentNeedCheck(){
		$key = "site.config.content.is.check";
		$info = Home::dao()->getSysdata()->get(array("sys_key"=>$key));
		if(!$info) return 1;//默认需要审核
		return unserialize($info['sys_content'])?0:1;
	}
	
	function clearAllCache(){
		Admin::service()->getSys()->clearCache();
		Admin::service()->getSys()->scannerActions();
	}

    //是否需要验证码检测
    function needCheckCode(){
        $user = User::service()->getCommon()->getLogined();
        $user = User::dao()->getInfo()->get(array("id"=>$user['id']));
        return $user['coin'] < getSysData("site.coin.needyanzheng");
    }

    function checkCode(){
        if(Home::service()->getCommon()->needCheckCode()){
            $captcha = $_REQUEST['captcha'];
            if(!$this->checkCaptcha($captcha)){
                My_Tool::showMsg("验证码不匹配!","history.back()",1);
            }
        }
        return true;
    }

    /**
     * @param $title
     * @param $content
     * @param int $type 1-博客，2-帖子，3-视频
     */
    function addTags($title,$content,$objId,$type=1){

        $imghref = My_Tool::getImgPath($content);
        $hasImg = $imghref && $imghref[0] ?1:0;

        $tags = My_Tool::getTags($title,$content,10);

        if($tags){
            foreach($tags as $v){
                if(!$v) continue;
                $v = strtoupper($v);
                $check=Home::dao()->getTag()->get(array("name"=>$v));
                $tagCountName=$this->getTagCountName($type);
                if($check){
                   Home::dao()->getTag()->inCrease($tagCountName,array("id"=>$check['id']));
                    $id = $check['id'];
                }else{
                    $idata=array();
                    $idata['name'] =$v;
                    $idata[$tagCountName] =1;
                    $idata['created_at'] =date('Y-m-d H:i:s');

                    $id = Home::dao()->getTag()->insert($idata);
                }
                if(!$id) continue;
                $idata=array();
                $idata['tag_id'] =$id;
                $idata['obj_id'] =$objId;
                $idata['obj_type'] =$type;
                $idata['tag_name'] =$v;
                $idata['has_pic'] =$hasImg;
                $idata['created_at'] =date('Y-m-d H:i:s');
                $idata['updated_at'] =date('Y-m-d H:i:s');
                Home::dao()->getTagext()->insert($idata);
            }
        }
        return true;
    }

    function getTagCountName($type){
        $name="";
        switch($type){
            case 1: $name='site_count';break;
            case 2: $name='group_count';break;
            case 3: $name='video_count';break;
        }
        return $name;
    }

    function deleteTags($title,$content,$objId,$type=1){
        $tags = My_Tool::getTags($title,$content);
        if($tags){
            foreach($tags as $v){
                if(!$v) continue;
                $v = strtoupper($v);
                $tagCountName=$this->getTagCountName($type);
                Home::dao()->getTag()->deCrement($tagCountName,array("name"=>$v));
            }
        }
        $idata = array();
        $idata['obj_id'] =$objId;
        $idata['obj_type'] =$type;
        Home::dao()->getTagext()->delete($idata);
    }

    //编辑标签
    function editTags($otitle,$ocontent,$title,$content,$objId,$type=1){
        $this->deleteTags($otitle,$ocontent,$objId,$type);
        $this->addTags($title,$content,$objId,$type);
    }


    function getRecommend($id,$type=1){
          $tags = Home::dao()->getTagext()->getField("tag_id",array("obj_id"=>$id,"obj_type"=>$type),true);
         if(!$tags) return array();
          $list = Home::dao()->getTagext()->gets(array("tag_id"=>array("IN",$tags),"has_pic"=>1,"is_public"=>1,"obj_id"=>array("!=",$id)),"rand()",0,6,"obj_id");
          if(!$list) return array();
          $rs = array();
          foreach($list as $k=>$v){
                 $type = $v['obj_type'];
                 $objArr = $this->getTypeObj($type);
                 if(!$objArr) continue;
                 $obj = $objArr[0];
                 $tmp = $obj->get(array("id"=>$v['obj_id']));
                 $tmp['urltype'] = $objArr[1];
                 $rs[] =$tmp;
          }
          return $rs;
    }

    function getTypeObj($type){
         switch($type){
             case 1:return array(new Site_Dao_Arc(),"site");
             case 2:return array(new Group_Dao_Arc(),"group");
             case 3:return array(new Video_Dao_List(),"video");
         }
        return false;
    }

    function getUrlType($type){
        switch($type){
            case 1:return "site";
            case 2:return "group";
            case 3:return "video";
        }
        return false;
    }

    function dealVoteScore($id){
        $reply = Home::dao()->getReply()->get(array("id"=>$id));
        if(!$reply) return true;
        $score = My_Tool::getVoteScore($reply['support_count'],$reply['against_count']);
        Home::dao()->getReply()->update(array("reply_score"=>$score*100),array('id'=>$id));
        return true;
    }

}