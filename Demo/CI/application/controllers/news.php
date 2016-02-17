<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Home_Controller{
	//构造函数
	public function __construct(){
		// 自动载入model类
		parent::__construct();
		$this->load->model('news_model');
	}
	public function add(){
		// var_dump($this->db);exit;
		if(isset($_POST['title'])){
			// 调用模型方法，添加数据
			$_POST['add_time']=time();
			if($this->news_model->add_news($_POST)){
				echo 'success';
			}else{
				echo 'error';
			}
		}else{
			$this->load->view('news_add.html');
		}
	}

	//显示新闻列表
	public function show(){
		$data['news']=$this->news_model->getAll();
		
		$this->load->view('news_show.html',$data);
	}

	//显示新闻列表
	public function index(){
		#调用list_news方法得到数据
		$data['news'] = $this->news_model->list_news();
		#分配到视图
		$this->load->view('news_show.html',$data);
	}
}