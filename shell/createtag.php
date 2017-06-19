<?php
define("RUN_CLI", 1);
php_sapi_name() != 'cli' && exit('no access!');
require_once str_replace("shell", "", dirname(__FILE__)) . "/index.php";

/************以下是自定义区***************/

class createtag{

    static function todo(){
            //group
        $list = Group::dao()->getArc()->gets();
        if(!$list){
            echo "group-done\r\n";
        }else{
            foreach($list as $v){
                $id = $v['id'];
                $arc = Home::dao()->getArc()->get(array("mark"=>"group#".$id));
                Home::service()->getCommon()->addTags($v['title'],$arc['content'],$id,2);
            }
            echo "group-done\r\n";
        }
        //site
        $list = Site::dao()->getArc()->gets();
        if(!$list){
            echo "site-done\r\n";
        }else{
            foreach($list as $v){
                $id = $v['id'];
                $arc = Home::dao()->getArc()->get(array("mark"=>"site#".$id));
                Home::service()->getCommon()->addTags($v['title'],$arc['content'],$id,1);
            }
            echo "site-done\r\n";
        }
        //video
        $list = Video::dao()->getList()->gets();
        if(!$list){
            echo "video-done\r\n";
        }else{
            foreach($list as $v){
                $id = $v['id'];
                Home::service()->getCommon()->addTags($v['title'],$v['content'],$id,3);
            }
            echo "video-done\r\n";
        }
    }

}
createtag::todo();