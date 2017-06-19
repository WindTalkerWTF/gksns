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
class Home_View_Helper_Cplace
{
    /**
     * @var Zend_View_Interface 
     */
    public $view;
   
    /**
     * 当前页面位置
     * @param string $name
     * @param array $params array(),返回链接
     * @return string
     */
    public function cplace($name, $params=""){
    	$other = "<span class=\"separator\"> &raquo; </span>";
    	if($params){
    		foreach($params as $k=>$v){
    			$other .="<span><a href=\"".$v."\">".$k."</span><span class=\"separator\"> &raquo; </span>";
    		}
    	}
		$str = "<table id=\"crumbnav\" class=\"table1\" cellspacing=\"1\" cellpadding=\"3\" align=\"center\" border=\"0\">
				<tr>
					<td class=\"tableline linetitle\" width=\"*\" align=\"left\"><span
						class=\"nav-home\">当前位置</span>{$other}{$name}
					</td>
					<td class=\"tableline\" width=\"320\" align=\"right\" id=\"showadmininfo\"><div>
							<a class=\"admin-back\" title=\"后退\" href=\"javascript:history.go(-1)\"
								hidefocus=\"true\"><em>后退</em></a> <a class=\"admin-refresh\"
								onclick=\"toRefresh()\" title=\"刷新\" href=\"javascript:void(0)\"
								hidefocus=\"true\"><em>刷新</em></a> <a class=\"admin-home\" title=\"首页\"
								href=\"".My_Tool::url("index/index","home")."\" target=\"_blank\" hidefocus=\"true\"><em>首页</em></a> <a
								class=\"admin-logout\" title=\"退出\" href=\"".My_Tool::url("/index/logout","admin")."\"
								hidefocus=\"true\"><em>退出</em></a>
						</div></td>
				</tr>
			</table>
	<script>
		function toRefresh(){
    		location.assign(location.href);
    	}
	</script>	
		";
		$msg = My_Tool_FlashMessage::get("showAlert", 1);
		if($msg){
			$str .= "<div style=\"height:25px;line-height:25px;background:#FFE7BA;color:#FF0000;padding-left:10px;\">{$msg}</div>";
		}
		return $str;
		
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
