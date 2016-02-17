<?php
namespace Home\Controller;
use Think\Controller;
// 父类控制器
class BaseController extends Controller{
	public function _initialize(){
		//验证登陆权限问题，在构造函数里面会自动执行的方法
		$admin_id = $_SESSION['userid'];
		if(!$admin_id){
			$this->success('请先登陆',U('Login/login'));exit;
		}
		// 换一个验证权限的思路，要验证用户的操作权限和登陆权限2个，下面来验证操作权限
		// 根据管理员的id，取出用户在数据库的所有权限，然后和用户想操作的权限进行匹配，
		//如果是超级管理员员则不受限制
		if($admin_id==1){
			return true;
		}
		//首页模块不受限制
		if(CONTROLLER_NAME=='Index'){
			return true;
		}
		//ECHO CONTROLLER_NAME;//该常量返回的是控制器的名称
		//ECHO ACTION_NAME;//该常量返回的是方法的名称

		$str =CONTROLLER_NAME.'-'. ACTION_NAME;		//组织用户方问的模块和方法
// 		查询数据库，取出当前用户的所有权限
		$sql="select c.*,concat(c.p_cname,'-',c.p_aname) url from cms_user_role a,
				cms_auth_role b,cms_auth c where a.role_id=b.role_id and b.auth_id=c.p_id 
				and a.user_id=$admin_id having url='$str'";
// 		执行sql语句
		$res=M()->query($sql);
		//判断结果，返回真，则可以访问
		if(!$res){
			$this->error('你没有权限操作此模块');
		}else{
			return true;
		}
	}
}