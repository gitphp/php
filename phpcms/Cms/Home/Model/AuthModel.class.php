<?php
namespace Home\Model;
use Think\Model;

class AuthModel extends Model{
	// 定义验证规则
	protected $_validate=array(
		array('p_name','require','栏目名字不可以为空'),
		array('p_pid','require','请选择父级栏目'),
		array('p_cname','require','控制器不可以为空'),
		array('p_aname','require','方法不可以为空'),
	);

	//取出所有分类+无限分类
	public function getAuth(){
		$arr=$this->select();
		return $this->getTree($arr);
	}
	//无限分类辅助方法
	private function getTree($arr,$pid=0,$lev=0){
		static $auths=array();
		foreach ($arr as $key => $val) {
			if($val['p_pid']==$pid){
				$val['lev']=$lev;
				$auths[]=$val;
				unset($arr[$key]);
				$this->getTree($arr,$val['p_id'],$lev+1);
			}
			
		}
		return $auths;
	}
	//-----------取出所有子栏目的ids--------------
	public function getIds($pid){
		$arr=$this->select();
		return $this->getTreeId($arr,$pid);
	}
	//收集所有子栏目的ids的值
	protected function getTreeId($arr,$p_pid){
		static $auths=array();
		foreach ($arr as $key => $val) {
			if($val['p_pid']==$p_pid){
				$auths[]=$val['p_id'];
				unset($arr[$key]);
				$this->getTreeId($arr,$val['p_id']);
			}
		}
		return $auths;
	}
	// 前置更新
	public function _before_update($data,$options){
		//获取ids
		$ids=$this->getIds($data['p_id']);
		$ids[]=$data['p_id']; //把自己添加进去
		if(in_array($data['p_pid'],$ids)){
			$this->error='不可以添加到子栏目下面';
			return false;
		}
		return true;
	}
	//前置删除
	public function _before_delete($data){
		$p_id=$data['where']['p_id'];
		$ids=$this->getIds($p_id);
		if($ids){
			$this->error='请先删除子分类，谢谢！';
			return false;
		}
		return true;
	}
	
}