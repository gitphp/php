<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends Admin_Controller{
	// 构造方法
	public function __construct(){
		parent::__construct();
		$this->load->model('category_model');
		$this->load->library('form_validation');
		//开启调试
		$this->output->enable_profiler(TRUE);
	}
	// 查
	public function show(){
		$data['cats']=$this->category_model->getAll();
		// var_dump($data['cats']);exit;
		$this->load->view('cat_list.html',$data);
	}
	// 改
	public function edit($c_id){
		if(isset($_POST['c_name'])){
			// 处理修改分类信息，判断不可以把当前分类添加到其子分类下面
			$c_id=$this->input->post('c_id');
			// 获取当前分类的所有子分类信息、
			$data=$this->category_model->getAll($c_id);
			$ids=array();
			// 收集所有的子分类的id值
			foreach ($data as $key => $val) {
				$ids[]=$val['c_id'];
			}
			$c_pid=$this->input->post('c_pid');
			// 假如当前分类父id=自己的id或者是：父id在子分类id里面就错误
			if($c_pid==$c_id || in_array($c_pid,$ids)){
				echo 'error, you cannot add it on this child or self';
				exit;
			}
			// doubi($_POST);
			if($this->category_model->update_cat($_POST,$c_id)){
				redirect('admin/category/show');
			}else{
				echo 'error,you can return youself';
			}



		}else{
			// 取出当前这行数据显示，和所有的分类信息展示
			$data['cats']=$this->category_model->getAll();
			$data['cat']=$this->category_model->getOne($c_id);
			// 把所有的信息都分类到数组里面
			$this->load->view('cat_edit.html',$data);
		}
		
	}
	// 删
	public function del($c_id){
		// 判断逻辑，如果当前分类有子分类就不可以删除
		$data=$this->category_model->getAll($c_id);
		if(empty($data)){
			// 假如没有子分类的话就直接删除
			$res=$this->category_model->delete_cat($c_id);
			if($res){
				redirect('admin/category/show');
			}else{
				redirect('admin/category/show');
			}
				
		}else{
			// 有子分类，不可以删除的
			echo 'error,this category has child,can not delete';
		}

	}
	// 增
	public function add(){
		// 判断逻辑
		if(isset($_POST['c_name'])){
			// doubi($_POST);insert_cat
			// 设置表单验证规则
			$this->form_validation->set_rules('c_name','分类名称','required');
			// 判断验证结果
			if($this->form_validation->run()==false){
				// 验证失败
				$data['message']=validation_errors();
				$data['wait']=2;
				$data['url']=site_url('admin/category/add');
				$this->load->view('message.html',$data);
			}else{
				// 验证成功
				$res=$this->category_model->insert_cat($_POST);
				if($res){
					redirect('admin/category/show');
				}else{
					redirect('admin/category/add');
				}
			}

		}else{
			$data['cats']=$this->category_model->getAll();
			$this->load->view('cat_add.html',$data);
		}
		
	}
}