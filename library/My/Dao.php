<?php
/**
 * 
 * dao 主类
 * @author kaihui_wang
 *
 */
abstract class My_Dao{
	/**
	 *
	 * @return Home_Dao_Common
	 */
	function get(){
	    return new Home_Dao_Common();
	}
	
}