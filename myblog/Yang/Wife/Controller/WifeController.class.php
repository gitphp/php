<?php
namespace Wife\Controller;
use Think\Controller;
// 父类控制器
class WifeController extends Controller{
	public function _initialize(){
		//验证登陆权限问题，在构造函数里面会自动执行的方法
		$admin_id = $_SESSION['userid'];
		if(!$admin_id){
			$this->success('请先登陆',U('Login/index'));exit;
		}
	}
}