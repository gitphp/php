<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// 自定义扩展控制器类
class Home_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->themes_on();
	}
}

// 后台控制器
class Admin_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->themes_off();

		//后台权限验证方法
		if(! $this->session->userdata('admin')){
			redirect('admin/manage/login');
		}
	}
}
