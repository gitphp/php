<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 后台登陆权限验证控制器,
 * 此控制器不需要验证，直接继承基类控制器即可
 */
class Manage extends CI_Controller{
	public function __construct(){
		parent::__construct();
		//加载验证码类
		$this->load->helper('captcha');
		//加载验证表单类
		$this->load->library('form_validation');
	}
	/**
	 * 登陆表单
	 * return [type] [description]
	 */
	public function login(){
		//判断逻辑
		if(isset($_POST['a_username'])){
			$code=strtolower($this->session->userdata('code'));
			$captcha=strtolower($this->input->post('captcha'));
			if($code != $captcha){
				// 验证码错误
				redirect('admin/manage/login');exit;
			}
			// 用系统类接收表单的值post是个方法
			$user=$this->input->post('a_username');
			$pass=$this->input->post('a_password');
			echo $user,$pass;
			if($user=='admin' && $pass=='admin'){
				//登陆成功,设置session的值
				$this->session->set_userdata('admin',$user);
				redirect('admin/main/index');

			}else{
				redirect('admin/manage/login');
			}
		}else{
			$this->load->view('login.html');
		}
		
	}
	// 显示验证码方法
	public function captcha(){
		$vals=array(
			'word_length'=>4,
		);

		$code=create_captcha($vals);
		// 保存验证码到session
		$this->session->set_userdata('code',$code);
	}
	//logout
	public function logout(){
		$this->session->unset_userdata('admin');
		redirect('admin/manage/login');
	}
}