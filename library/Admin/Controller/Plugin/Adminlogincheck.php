<?php
class Admin_Controller_Plugin_Adminlogincheck extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
       		Admin::service()->getCommon()->checkAdminLogin();
    }

}