<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Home_Controller{

	public function show(){
		// 默认是php的模板，是可以不写后缀名字的
		$this->load->view('news_show.html');
	}
}