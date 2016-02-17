<?php
namespace Home\Controller;
use Think\Controller;
// 登陆控制器
class LoginController extends Controller{
	// 退出
	public function logout(){
		session(null);
		$this->success('退出成功',U('Login/login'));exit;
	}
	/**
	 * 登陆方法，验证数据
	 * return [type] [description]
	 */
	public function login(){
		if(IS_POST){
			$model = D('Admin');
			if($model->create()){
				// doubi($model);
				if($model->checkUser()){
					// 登陆成功
					$this->success('登陆成功',U('Index/index'));exit;
				}else{
					$this->success($model->getError(),'login/login');exit;
				}

			}else{
				// 表单验证失败的时候
				$this->success($model->getError(),'login/login');exit;
			}
		}else{
			// 没有表单提交的时候
			$this->display();
		}
		
	}

	// 验证码方法
	public function ccode(){
		$config =    array(    
			'fontSize'    =>    30,    // 验证码字体大小    
			'length'      =>    2,     // 验证码位数    
			'useNoise'    =>    false, // 关闭验证码杂点);
			'codeSet' 	  => 	'0123456789',
		);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
}