<?php
define("RUN_CLI", 1);
php_sapi_name() != 'cli' && exit('no access!');
require_once str_replace("shell", "", dirname(__FILE__)) . "/index.php";

/************以下是自定义区***************/

class creategroupface{

    static function todo(){
            //group
        $list = Group::dao()->getArc()->gets();
        if(!$list){
            echo "group-done\r\n";
        }else{
            foreach($list as $v){
                $id = $v['id'];
                $content = Home::dao()->getArc()->get(array("mark"=>"group#".$id));
                $hrefs = My_Tool::getImgPath($content['content']);
                $face = 0;
                if($hrefs) $face = $hrefs[0];
                Group::dao()->getArc()->update(array("face"=>$face),array("id"=>$id));
                echo $id."-done\r\n";
            }
            echo "group-done\r\n";
        }
    }

}
creategroupface::todo();