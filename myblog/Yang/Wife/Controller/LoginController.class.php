<?php
namespace Wife\Controller;
use Think\Controller;
/*
 * 后台用户登陆控制器
*/
class LoginController extends Controller{
	/**
	 * 显示登陆表单
	 */
	public function index(){
		$this->display();
	}
	
	/**
	 * 获取验证码
	 */
	public function verify(){
		$Verify = new \Think\Verify();
		$Verify->fontSize = 60;
		$Verify->length   = 3;
		$Verify->useNoise = false;
		$Verify->codeSet = '0123456789'; 
		$Verify->entry();
	}
	
	/**
	 * 验证登录
	 */
	public function check(){
		// 检测验证码
		$verify = new \Think\Verify();    
		$code=I('post.varify');
		if (!$verify->check($code)){
			$this->success('验证码输入错误');exit;
			return;
		}	
		// 验证用户名和密码
		$dao=new \Model\UserModel();
		$username = I('post.username');
		$password = md5(I('post.password'));
		$rs = $dao->where('username="'.$username.'" and password="'.$password.'"')->find();	
		if (!$rs){
			$this->error('用户名或密码错误,请重新登陆');
			return;
		}else{
			// 把用户的信息存入session里面
			session('user',$rs);
			session('userid',$rs['id']);
			// 更改用户最后登陆时间
			$dao->where('id='.$rs['id'])->setField('login_time',time());
			$this->redirect('Index/index');	
		}			
		
	}
	
	/**
	 * 退出登录
	 */
	public function outlogin(){
		session(null);
		$this->redirect('Login/index');
	}	
}// end