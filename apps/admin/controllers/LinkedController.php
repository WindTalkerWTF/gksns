<?php
/**
 * 友情链接管理
 */
class Admin_LinkedController extends Admin_Controller_Action{

    public function init()
    {
//    	$this->_helper->layout()->disableLayout();
//    	$this->_helper->viewRenderer->setNoRender();
        //$this->_helper->cache(array("index"), array("sss"));
    }

    /********以下为自定义内容****************/

    function indexAction(){
        //分页
        $page = (int) $this->getCookieParam("page");
        $page = $page ? $page : 1;
        $pageSize = 10;

        $limit = $pageSize * ($page-1);

        $where = array();

        $obj = Home::Dao()->getLinks();
        $this->view->list =$obj->gets($where, "fsort ASC" ,$limit, $pageSize,"",true);
        $this->view->totalNum =  $obj->getTotal();

        $this->view->page = $page;
        $this->view->pageSize = $pageSize;
    }

    function addAction(){
        if(My_Tool::isPost()){
            $title = $this->getRequest()->getParam("title");
            $url = $this->getRequest()->getParam("url");
            $fsort = (int) $this->getRequest()->getParam("fsort");

            $this->title = $title;
            $this->url = $url;
            $this->fsort = $fsort;

            $data = array();
            $data['title'] = $title;
            $data['url'] = $url;
            $data['fsort'] = $fsort;
            Home::dao()->getLinks()->insert($data);
            Admin_Tool::showAlert("添加成功");
        }
    }

    function editAction(){
            $id = (int) $this->getRequest()->getParam("id");
            $info = Home::Dao()->getLinks()->get(array("id"=>$id));
            if(!$info) $this->showMsg("参数错误",My_Tool::url("linked/index"));
            $this->view->id = $id;
            $this->view->info = $info;
            if(My_Tool::isPost()){
                $title = $this->getRequest()->getParam("title");
                $url = $this->getRequest()->getParam("url");
                $fsort = (int) $this->getRequest()->getParam("fsort");

                $this->title = $title;
                $this->url = $url;
                $this->fsort = $fsort;

                $data = array();
                $data['title'] = $title;
                $data['url'] = $url;
                $data['fsort'] = $fsort;
                Home::dao()->getLinks()->update($data,array("id"=>$id));
                Admin_Tool::showAlert("编辑成功");
            }
    }

    function deleteAction(){
        $this->_helper->viewRenderer->setNoRender();
        $id = (int) $this->getRequest()->getParam("id");
        $info = Home::Dao()->getLinks()->get(array("id"=>$id));
        if(!$info) $this->showMsg("参数错误",My_Tool::url("linked/index"));
        Home::dao()->getLinks()->delete(array("id"=>$id));
    }
}