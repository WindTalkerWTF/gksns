<?php
/**
 *
 * @author kaihui_wang
 * @version 
 */
require_once 'Zend/View/Interface.php';
/**
 * Truncate helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class User_View_Helper_Leftmenu
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
    /**
     * 
     */
    public function leftmenu($id){
   	 	$isFollow = 0;
   	 	$userInfo = User::service()->getCommon()->getLogined();
		$me = isset($userInfo['id']) ? $userInfo['id']:0;
		if($id == $me){
			$this->view->isMe=1;
		}
		else{
			$this->view->isMe=0;
			#是否关注
			if($userInfo){
				$isFollow = User::dao()->getFollow()->get(array("uid"=>$me, "follow_uid"=>$id));
				$isFollow = $isFollow ? 1 : 0;
			}
		}
		$this->view->isFollow = $isFollow;
		$this->view->user = User::service()->getCommon()->getUserInfo($id);
		$this->view->follow = User::service()->getCommon()->getFollow(array("uid"=>$this->view->user['id']), 0, 7);
		$this->view->toFollow = User::service()->getCommon()->getToFollow(array("follow_uid"=>$this->view->user['id']), 0, 7);
		//print_r($this->view->toFollow);
		$this->view->uid = $id;
		return $this->view->render("/helper/leftmenu.php");
    }
    /**
     * Sets the view field 
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
