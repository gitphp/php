<?php
namespace Home\Controller;
use Think\Controller;

// 权限控制器
class RoleController extends BaseController{
	// 角色列表
	public function lst(){
		// 链3个表,查出当前角色的所有权限(,)号隔开
// select a.*,b.*,c.*,group_concat(c.p_name) from cms_role a 
// left join cms_auth_role b on a.r_id=b.role_id 
// left join cms_auth c on b.auth_id=c.p_id group by a.r_id;
		$this->roles=D('Role')->field('a.*,group_concat(c.p_name) auth')->join("a left join cms_auth_role b on a.r_id=b.role_id left join cms_auth c on b.auth_id=c.p_id group by a.r_id")->select();
		// doubi($this->roles);
		$this->display();
	}
	// 添加角色
	public function add(){
		if(IS_POST){
			$model=D('Role');
			if($model->create()){
				if($model->add()){
					$this->success('添加成功',U('Role/lst'));exit;
				}
			}
			$this->error('添加失败');
		}
		// 取出权限列表
		$auth_model=D('Auth');
		$this->auths=$auth_model->getAuth();
		$this->display();
	}
	// 删除角色
	public function del($id){
		//删除角色之前，先判断当前角色是否有用户
		//删除之后，要清除cms_auth_role里面的角色信息
		if(D('Role')->delete($id)){
			echo 'ok';
			// $this->success('删除成功',U('Role/lst'));exit;
		}else{
			// $this->error('删除失败');
			echo 'no';
		}
	}
	// 编辑角色、
	public function edit(){
		// 取出当前角色的信息
		$r_id=I('get.id');
		$this->role=D('Role')->find($r_id);
		// 取出所有权限
		$this->auths=D('Auth')->getAuth();
		$this->display();
	}
}