<?php
//后台Index控制器
//判断是否为非法请求
if(!defined('ACCESS')) {
	echo '非法请求';
	exit;
}
	class IndexAction extends Action{
		//显示后台主页方法
		public function index(){
			//成功，显示主页模板,保存信息到模板标签里面
			$this->view->assign('name',$_SESSION['user']['u_name']);
			$this->view->assign('time',date('Y-m-d H:i:s',$_SESSION['user']['u_logintime']));
			$this->view->display('index.html');
		}
	}