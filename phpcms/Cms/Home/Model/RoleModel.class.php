<?php
namespace Home\Model;
use Think\Model;

// 角色模型
class RoleModel extends Model{
	protected $_validate=array(
		array('r_name','require','不为空'),
	);


	//插入后
	public function _after_insert($data,$options){
		// 完成中间表的入库操作
		$ids=I('post.auth_id');		//获取所有栏目ids
		$role_id=$data['r_id'];
		foreach ($ids as $val) {
			$data=array(
				'role_id'=>$role_id,
				'auth_id'=>$val,	
			);
			M('AuthRole')->add($data);
		}
	}
	// 前置删除
	public function _before_delete($data){
		//获取当前角色id
		$r_id=$data['where']['r_id'];
		// 判断当前角色是否有用户
		$res=M('UserRole')->where("role_id=$r_id")->select();
		if($res){
			$this->error='当前角色有用户，不能删除';
			return false;
		}
		return true;
	}
	// 后置删除
	public function _after_delete($data){
		$r_id=$data['r_id'];
		M('AuthRole')->where("role_id=$r_id")->delete();
	}
}