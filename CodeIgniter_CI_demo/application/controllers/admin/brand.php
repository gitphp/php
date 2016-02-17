<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//后台品牌控制器
class Brand extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('brand_model');			//加载模型
		$this->load->library('form_validation');	//加载表单验证
		// $this->load->library('upload');			//加载图片上传类
	}

	// 增加
	public function add(){
		if(isset($_POST['b_name'])){
			// 表单验证
			$this->form_validation->set_rules('b_name','品牌名字','required');
			if($this->form_validation->run()==false){
				die('品牌名字不可以为空');
			}
			// 执行图片文件上传操作
			$config['upload_path']='./public/uploads/';
			$config['allowed_types']='gif|png|jpg|jpeg|pjpeg';
			$config['max_size']=3000;	//kb单位

			// 在这里加载了，就不需要在构造函数里面加载了
			$this->load->library('upload',$config);
			// 在构造函数里面加载的话，可以使用一个外部的配置文件upload.php
			if(! $this->upload->do_upload('b_logo')){
				die($this->upload->display_errors());
			}
			// 获取信息
			$info=$this->upload->data();
			$_POST['b_logo']=$info['file_name'];

			if($this->brand_model->add_brand($_POST)){
				//添加成功
				redirect('admin/brand/show');
			}else{
				redirect('admin/brand/add');
			}
		}else{
			// 显示add表单
			$this->load->view('brand_add.html');
		}
		
	}

	// 显示
	public function show(){
		$data['brands']=$this->brand_model->get_brands();
		// doubi($data);
		$this->load->view('brand_list.html',$data);
	}

	// 修改
	public function edit($b_id){

		$this->load->view('brand_edit.html');
	}

	// 删除
	public function del($b_id){

		
	}

}