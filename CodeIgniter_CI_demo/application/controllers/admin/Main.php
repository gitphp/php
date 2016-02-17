<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 后台首页控制器
 */
class Main extends Admin_Controller{
	/**
	 * 后台首页框架显示
	 * return [type] [description]
	 */
	public function index(){
		$this->load->view('index.html');
	}

	public function top(){
		$this->load->view('top.html');
	}

	public function menu(){
		$this->load->view('menu.html');
	}

	public function drag(){
		$this->load->view('drag.html');
	}

	public function right(){
		$this->load->view('right.html');
	}
}