<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//前台控制器类
class Home_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		#开启皮肤功能
		$this->load->switch_themes_on();
	}
}


//后台控制器
class Admin_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->switch_themes_off();
	}
	
}

//---------------

