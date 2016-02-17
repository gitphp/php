<?php
namespace Home\Model;
use Think\Model;
class AdminModel extends Model{
	//------------------menu获取------------------------------------
	Public function getMenu(){
		//取出管理员id
		$adminid=session('userid');
		// 根据管理员id取出权限列表
		if($adminid==1){
			// 超级管理员
			$menus=D('Auth')->select();
			return $this->sanwei($menus,$pid=0);
		}else{
			//其他管理员，取出权限列表，链表查询
		//select c.* from cms_user_role a,cms_auth_role b, cms_auth c 
		//where a.role_id=b.role_id and b.auth_id=c.p_id and c.p_pid=0;
		
		//select c.* from cms_user_role a,cms_auth_role b, cms_auth c 
		//where a.role_id=b.role_id and b.auth_id=c.p_id and a.user_id=3 and c.p_pid=0;

			$menus=D('Auth')->select();//所有记录
			$sql="select c.* from cms_user_role a,cms_auth_role b, cms_auth c 
			where a.role_id=b.role_id and b.auth_id=c.p_id 
			and a.user_id=$adminid and c.p_pid=0";
			$arr=$this->query($sql);//找出顶级分类，返回二维数组
			//循环找出二维数组的子分类
			foreach ($arr as $k=>$v){
				$res=$this->sanwei($menus,$pid=$v['p_id']);
				if(empty($res)){
					return null;
				}
				// 如果不为空的话，就添加到顶级分类下面
				$arr[$k]['child']=$res;
			}
			return $arr;	
		}
	}
	// 组织三维分类数组
	public function sanwei($arr,$pid=0){
		$childs=$this->getChild($arr,$pid);
		// 再次遍历寻找子分类
		if(empty($childs)){
			return null;
		}
		//有东西就继续遍历
		foreach ($childs as $k => $val) {
			// 获取子分类数组保存起来
			$current_child=$this->sanwei($arr,$val['p_id']);
			if($current_child!=null){
				// 不为空的话，就作为childs数组的一个元素添加到数组末尾
				$childs[$k]['child']=$current_child;
			}
		}
		return $childs;
	}
	// 找到某个分类下面的子分类
	public function getChild($arr,$pid=0){
		$childs=array();
		foreach ($arr as $k => $v) {
			if($v['p_pid']==$pid){
				$childs[]=$v;
			}
		}
		return $childs;
	}

	//-------------------------------------------------------------------
	// 自定义一个添加用户的验证规则
	protected $_yanzheng=array(
		array('a_username','require','用户名不能为空'),
		array('a_password','require','密码不能为空',2),
		array('a_password','6-16','密码长度不符',1,'length',1),
		array('a_rpassword','a_password','密码一致',0,'confirm',1),
		array('role_id','require','角色为空'),
	);
	//定义验证规则
	protected $_validate=array(
		array('a_username','require','用户名不能为空'),
		array('a_password','require','密码不能为空'),
		array('captcha','require','验证码不能为空'),
	);

	// 创建用户名和密码验证的方法
	public function checkUser(){
		$user=I('post.a_username');
		$pass=I('post.a_password');
		$code=I('post.captcha');
		// 验证码验证
		$verify = new \Think\Verify();    
		if(!$verify->check($code)){
			$this->error='验证码错误';
			return false;
		}

		$userinfo=$this->where("a_username='$user'")->find();
		// doubi($userinfo);
		if($userinfo){
			//用户名正确
			if($userinfo['a_password']==md5(md5($pass).$userinfo['a_salt'])){
				// 保存用户信息到session
				session('admin',$user);
				session('userid',$userinfo['a_id']);
				return ture;
			}else{
				$this->error='密码错误';
				return false;
			}
		}else{
			$this->error='用户名不存在';
			return false;
		}
	}
	// 前置插入
	public function _after_insert($data,$options){
		//完成中间表的插入操作
		$admin_id=$data['a_id'];//获取用户id
		$role_id=I('post.role_id');//获取角色id
		$arr=array(
			'user_id'=>$admin_id,
			'role_id' =>$role_id,
		);
		// 这里不用循环，需求是一个用户，只有一个角色
		M('UserRole')->add($arr);
	}
}