<?php
abstract class Admin_Controller_Action extends My_Controller_Action
{
    function showMsg($msg='', $href='',$isJs=0, $goUrl="/index/msg",$appName="admin"){
        parent::showMsg($msg, $href, $isJs, $goUrl,$appName);
    }
}

