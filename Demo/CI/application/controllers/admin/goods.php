<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods extends CI_Controller {
	public function index(){
		// echo 'Today I study CI';
		$data['title']='今天我学习ci';
		$data['content']='今天你学thinkphp了么？';
		$this->load->view('goods_show.html',$data);
	}
}
