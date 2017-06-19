<?php
class Site_Service_Common{
    const HOME_LIST_CACHE_KEY  = "HOME_LIST_CACHE_KEY1";
	function getAdmMenu(){
		$config = My_Config::getInstance()->getConfig("init", 1, 1, "site");
		return isset($config['adminUrl']) ? $config['adminUrl']:"";
	}
	
	function getViewTrees($pid=0, $divMark=""){
		$trees = Site::dao()->getTree()->gets(array("pid"=>$pid), "tree_sort asc");
//		print_r($trees);
		if($trees){
			foreach ($trees as $k=>$v){
				unset($trees[$k]);
				$trees[] = $v;
				$divMark="";
				$child = $this->getViewTrees($v['id'], $divMark);
				if($child){
					$divMark .="├┈┈";
					foreach($child as $c){
						$c['name'] = $divMark . $c['name'];
						$trees[] = $c;
					}
				}
			}
		}
		return $trees;
	}
	
	//获取栏目所有子栏目
	function getChildTree($id){
		$childs = array();
		$childs = Site::dao()->getTree()->gets(array("pid"=>$id), " tree_sort ASC");
		if($childs){
			foreach ($childs as $v){
				$arr = $this->getChildTree($v['id']);
				if($arr) $childs = array_merge_recursive($arr,$childs);
			}
		}
		return $childs;
	}
	
	//获取栏目所有子栏目id
	function getChildTreeIds($id){
		$arr = $this->getChildTree($id);
		$ids = array();
		if($arr){
			foreach ($arr as $v){
				$ids[] = $v['id'];
			}
		}
		return $ids;
	}
	
	//博客首页list
	function getHomeList(){
	     $trees = Site::dao()->getTree()->gets(array("pid"=>0),"tree_sort ASC");
	    if($trees){
	        foreach ($trees as $k=>$v){
	            $id = $v['id'];
	            $childs = $this->getChildTreeIds($id);
	            if($childs){
	                $childs[] = $id;
	            }else{
	                $childs = array($id);
	            }
	            $arcWhere['is_publish'] = 1;
	            $arcWhere['tree_id'] = array("in",$childs);
	            //获取图片文章
	            $arcWhere['position'] = array("like","%,2,%");
	            
	            $sql= "SELECT * ,if(face,1,0) as orderface FROM site_arc WHERE
	                   is_publish = 1 AND tree_id in (".implode(',', $childs).") AND 
	                   position like '%,2,%' ORDER BY orderface DESC ,created_at DESC
	                    ";
	            $picArc = Site::dao()->getArc()->selectRow($sql);
	            $picInfo = $picArc && $picArc['face'] ? $this->getArc($picArc['id']) : array();
	            $trees[$k]['picArc'] = $picInfo;
	            //获取其他文章
	            $otherWhere['tree_id'] = array("in",$childs);
	            $otherWhere['is_publish'] = 1;
	            $otherWhere['id'] = array("!=",$picArc['id']);
	            $otherList = Site::dao()->getArc()->gets($otherWhere,"created_at DESC",0,12);
	            $trees[$k]['otherList'] = $otherList;
	        }
	    }
	    return $trees;
	}
	
	
	#获取列表 
	function getList($where, $pageLimit=0, $pageSize=10, $orderBy=null,$getTotal=true){
		$obj = new Site_Dao_Arc();
		$list = $obj->gets($where, $orderBy, $pageLimit, $pageSize, "", $getTotal);
		if($getTotal) $count = $obj->getTotal();
		$ids = array();
		$uids = array();
		if($list){
			foreach ($list as $k=>$v){
				$ids[]  =$v['id'];
				$uids[] = $v['uid'];
			}
			
			$arcs = Home::dao()->getArc()->gets(array('arc_type'=>"site", "ref_id"=>array("in", $ids)));
			$users = User::dao()->getInfo()->gets(array("id"=>array("in", $uids)));
			if($arcs){
				foreach ($list as $lk=>$lv){
					foreach($arcs as $k=>$v){
						if($lv['id'] == $v['ref_id']){
							$list[$lk]['arc'] = $v;
						}
					}
					
					foreach ($users as $ku=>$vu){
						if($lv['uid'] == $vu['id']){
							$list[$lk]['user'] = $vu;
						}
					}
				}
			}
		}
		
		if($getTotal) return array($list, $count);
		return $list;
	}
	
	#获取文章 
	function getArc($id){
		$info = Site::dao()->getArc()->get(array("id"=>$id));
		if($info){
			$tree = $this->getTreeParent($info['tree_id']);
			
			$info['tree'] = $tree;
			
			$arc = Home::dao()->getArc()->get(array("arc_type"=>"site", "ref_id"=>$id));
			$info['arc'] = $arc;
			$user = User::service()->getCommon()->getUserInfo($info['uid']);
			$info['user'] = $user;
		}
		return $info;
	}
	
	#获取父栏目
	function getTreeParent($treeId){
		if(!$treeId) return false;
		$parent = array();
		$tree = Site::dao()->getTree()->get(array("id"=>$treeId));
		if($tree) $parent[] = $tree;
		if(!$tree || !$tree['pid']){
			return $parent;
		}else{
			$ptmp = $this->getTreeParent($tree['pid']);
			$parent = array_merge_recursive($ptmp, $parent);
		}
		return $parent;
	}
		
	#通过对比获取上下篇
	function getArcByCompare($id, $treeId, $compareTag){
		$where["id"] = array($compareTag, $id);
		$where['tree_id'] =$treeId;
		$where['is_publish'] =1;
		return Site::dao()->getArc()->get($where);
	}
	
	#通过对比获取上下篇
	function getArcsSameTree($id, $treeId){
		$where["id"] = array("<>", $id);
		$where['tree_id'] =$treeId;
		$where['is_publish'] =1;
		return Site::dao()->getArc()->gets($where,"",0,20);
	}
	
}