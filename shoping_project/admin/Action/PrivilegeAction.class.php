<?php
if(!defined('ACCESS')){
	echo '非法请求';
	exit;
}
//权限控制器--继承基类
	class PrivilegeAction extends Action{
		public function login(){
			//登陆方法		// echo '访问方法：http://yi.cc/admin/?m=product&a=add';
			//判断是否有cookie，有的话就直接跳到首页，不需要登录
			// var_dump($_COOKIE);
			if(isset($_COOKIE['u_id'])){
				// $this->success('index.php?m=index&a=index', '登陆成功',1);
				header("location:index.php?m=index&a=index");
			}else{
				include_once VIEW_DIR.'login.html';
			}
			// 显示login模板
			// $this->view->display('login.html');
			
		}
		/**
		* 获得验证码方法
		*/
		public function captcha(){
			$c=new Captcha();
			$c->getCaptcha();
		}
		/**
		* 后台登陆验证
		*/
		public function sigin() {
			//接收系统传递过来的参数
			$username = isset($_POST['userName'])?trim($_POST['userName']):'';
			$password = isset($_POST['passWord'])?trim($_POST['passWord']):'';
			$captcha = isset($_POST['veryCode'])?trim($_POST['veryCode']):'';
			
			//判断验证码是否为空
			if($captcha=='') {
				$this->failure('index.php?m=privilege&a=login', '验证码不能为空',1);exit;
			}
			
			//判断验证码合法性
			/* if(!Captcha::checkCode($captcha)) {
				$this->failure('index.php?m=privilege&a=login', '验证码错误',1);exit;
			} */
			
			//用户名与密码的判断
			if(empty($username) || empty($password)) {
				$this->failure('index.php?m=privilege&a=login', '用户名或密码不能为空',1);exit;
			}else{
				//操作模型
				$admin = new AdminModel();
				if($user = $admin->checkUser($username,$password)) {
					$_SESSION['user'] = $user;
					//更新数据、添加cookied
					setcookie('u_id',$user['u_id'],time()+3600,"/");
					// var_dump($_COOKIE);exit;
					$admin->updateUser($user['u_id']);
					//跳转首页
					$this->success('index.php?m=index&a=index', '登陆成功',1);
				} else {
					$this->success('index.php?m=privilege&a=login', '登陆失败',1);exit;
				}
			}
			
			
		}
		
		
		
		
		
		
	}