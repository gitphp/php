<?php
if(!defined('ACCESS')){
	echo '非法';
	exit;
}
//前台注册模块
	class RegisterAction extends Action{
		//显示注册表单
		public function reg(){
			require_once(VIEW_DIR . 'register.html');
		}
		
		/**
		 * 验证码
		*/
		public function captcha(){
			$c=new Captcha();
			$c->getcaptcha();
		}
		/**
		 * check注册信息
		*/
		public function check(){
			//用户提交注册信息，接收用户数据
			$username=isset($_POST['userName']) 	? trim($_POST['userName']) 	: '' ;
			$password=isset($_POST['passWord']) 	? $_POST['passWord'] 		: '' ;
			$repass	 =isset($_POST['rePassWord']) 	? $_POST['rePassWord'] 		: '' ;
			$name	 =isset($_POST['name']) 		? trim($_POST['name']) 		: '' ;
			$phone	 =isset($_POST['phone']) 		? trim($_POST['phone']) 	: '' ;
			$email	 =isset($_POST['email']) 		? trim($_POST['email']) 	: '' ;
			$captcha =isset($_POST['veryCode']) 	? $_POST['veryCode'] 		: '' ;
			
			// 2,验证数据合法性
			if(empty($username) || empty($password) || empty($repass)){
				$this->failure('index.php?m=register&a=reg','注册信息不可以为空',1);
			} 
			if(empty($captcha)){
				$this->failure('index.php?m=register&a=reg','验证码为空',1);
			}
			if(!Captcha::checkCode($captcha)){
				$this->failure('index.php?m=register&a=reg','验证码错误',1);
			}
			if(empty($name) || empty($phone) || empty($email)){
				$this->failure('index.php?m=register&a=reg','表单不可以为空',1);
			}
			if($password !== $repass){
				$this->failure('index.php?m=register&a=reg','2次密码不一样',1);
			}
			// 3,验证电话为纯数字 is_numeric(函数)，是否为11位，邮箱格式(正则表达式)；
			$user=new AdminModel();
			 if($user->addUser($username,$password,$name,$phone,$email)){
				$this->success('admin/index.php','注册成功',1);
			}else{
				$this->failure('index.php?m=register&a=reg','注册失败',1);
			}
			
		}
		/**
		 * 退出系统，删除cookie和session
		*/
		public function logout(){
			// 消除cookie
			// var_dump($_COOKIE);exit;
			setcookie('u_id',$_SESSION['user']['u_id'],time()-100,'/');
			// 为了退出不让用户看购物车信息，所以把session里面的user给删除了
			$_SESSION['user']=null;
			// setcookie('u_id',$user['u_id'],time()+3600,'/');
			$this->success('index.php','退出成功',1);
		}
		
		
		
		
		
		
	}