<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// 前台首页控制器
class Home extends Home_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('goods_model');
		$this->load->model('category_model');
	}
	//前台首页
	public function index(){
		// 导航无线分类
		$data['navs']=$this->category_model->getAllCats();
		$this->load->view('index.html',$data);
	}
}