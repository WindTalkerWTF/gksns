<?php
class Admin_UserController extends Admin_Controller_Action{
    public function init()
    {
//    	$this->_helper->layout()->disableLayout();
//    	$this->_helper->viewRenderer->setNoRender();
        //$this->_helper->cache(array("index"), array("sss"));
    }
    /********以下为自定义内容****************/

    function indexAction(){
        $nickname = $this->getParam("nickname");
        $this->view->nickname = $nickname;
        //分页
        $page = (int) $this->getCookieParam("page");
        $page = $page ? $page : 1;
        $pageSize = 10;

        $limit = $pageSize * ($page-1);

        $where = array();
        if($nickname) $where['nickname'] = array("like","%".$nickname."%");
        $obj = User::dao()->getInfo();
        $this->view->list = $obj->gets($where, "id DESC" ,$limit, $pageSize,"",true);
        $this->view->totalNum =  $obj->getTotal();

        $this->view->page = $page;
        $this->view->pageSize = $pageSize;

    }

    function deleteAction(){
        $this->_helper->viewRenderer->setNoRender();
        $id = (int) $this->getParam("id");
        if(!$id) $this->showMsg("参数错误",$this->url("user/index"));
        $udata = array();
        $udata['is_del'] = 1;
        User::dao()->getInfo()->update($udata,array("id"=>$id));
        $this->showMsg("操作成功!",$this->url("user/index"));
    }


    function openAction(){
        $this->_helper->viewRenderer->setNoRender();
        $id = (int) $this->getParam("id");
        if(!$id) $this->showMsg("参数错误",$this->url("user/index"));
        $udata = array();
        $udata['is_del'] = 0;
        User::dao()->getInfo()->update($udata,array("id"=>$id));
        $this->showMsg("操作成功!",$this->url("user/index"));
    }
}
