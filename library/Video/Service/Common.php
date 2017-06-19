<?php
class Video_Service_Common  extends My_Service{
	function getAdmMenu(){
		$config = My_Config::getInstance()->getConfig("init", 1, 1, "video");
		return isset($config['adminUrl']) ? $config['adminUrl']:"";
	}
	
	function getViewTrees($pid=0, $divMark=""){
		$trees = Video::dao()->getTree()->gets(array("pid"=>$pid), "tree_sort asc");
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
	
	//获取栏目所有子栏目
	function getChildTree($id){
		$childs = array();
		$childs = Video::dao()->getTree()->gets(array("pid"=>$id), " tree_sort ASC");
		if($childs){
			foreach ($childs as $v){
				$arr = $this->getChildTree($v['id']);
				if($arr) $childs = array_merge_recursive($arr,$childs);
			}
		}
		return $childs;
	}
	
	public function gets($where = array(), $orderBy = "", $limit = "", $offset = "", $groupBy = "", $returnCount=false){
		$obj = Video::dao()->getList();
		$list = $obj->gets($where, $orderBy, $limit,$offset,$groupBy,$returnCount);
		
		if($returnCount){
			$total = $obj->getTotal();
			$data["total"] = $total;
		}
		
		if($list){
			foreach ($list as $k=>$v){
				$tree = Video::dao()->getTree()->get(array("id"=>$v['tree_id']));
				$list[$k]['tree'] = $tree;
			}
		}
		if(!$returnCount) return $list;
		$data["list"] = $list;
		return $data;
	}
	
	#通过对比获取上下篇
	function getArcByCompare($id, $treeId, $compareTag){
		$where["id"] = array($compareTag, $id);
		$where['tree_id'] =$treeId;
		$where['is_publish'] =1;
		return Video::dao()->getList()->get($where);
	}
	
	#通过对比获取上下篇
	function getArcsSameTree($id, $treeId){
		$where["id"] = array("<>", $id);
		$where['tree_id'] =$treeId;
		$where['is_publish'] =1;
		return Video::dao()->getList()->gets($where,"",0,20);
	}
	
	
}