<?php
namespace Wife\Controller;
use Think\Controller;

class UserController extends WifeController{
	/**
	 * 显示所有的前后台用户
	 * return [type] [description]
	 */
	public function index(){
		$user=new \Model\UserModel();
		$p=$_GET['p']?$_GET['p']:1;
		$list = $user->page($p.',10')->select();
		$this->assign('data',$list);
		$count      = $user->count();
		$Page       = new \Think\Page($count,10);
		$show       = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出	
		$this->display();
	}
	
	//添加数据
	public function adduser(){
		$dao=new \Model\UserModel();
		//判断
		if(IS_POST){
			if($dao->create()){
				$dao->password=md5($dao->password);
				if($dao->add()){
					$this->success('添加数据成功');exit;
				}
			}
			$this->error('添加失败了');
		}
		$this->display();
	}
	
	//删除记录(包含图片)
	public function del(){
		$this->success('用户是不可以删除滴！~删除失败');exit;
	}
	
}