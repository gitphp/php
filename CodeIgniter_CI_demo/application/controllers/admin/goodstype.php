<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goodstype extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('goodstype_model');
		$this->load->library('pagination');		//载入分页类

	}
	// 增加
	public function add(){
		if(isset($_POST['type_name'])){
			$this->form_validation->set_rules('type_name','类型名字','required');
			if($this->form_validation->run()==false){
				die('类型名字不可以为空');
			}
			//执行添加操作
			if($this->goodstype_model->add_type($_POST)){
				redirect('admin/goodstype/add');
			}else{
				redirect('admin/goodstype/add');
			}
		}else{
			$this->load->view('goods_type_add.html');
		}
		
	}
	// 显示
	public function show($offset=''){
		// 分页信息
		$config['base_url']=site_url('admin/goodstype/show');
		$config['total_rows']=$this->goodstype_model->count_type();	//总行数
		$config['per_page']=2;
		$config['uri_segment']=4;	//表示接受第四个参数为偏移量
		//当页数为-负数，或者超过最大页数的时候，没有判断啊？老师？
		$config['first_link']='首页';
		$config['last_link']='尾页';
		$config['prev_link']='上一页';
		$config['next_link']='下一页';
		// 初始化分页类
		$this->pagination->initialize($config);
		$data['pageinfo']=$this->pagination->create_links();
		$limit=$config['per_page'];

		$data['types']=$this->goodstype_model->get_types($limit,$offset);
		// doubi($data);exit;
		$this->load->view('goods_type_list.html',$data);
	}

	// 修改
	public function edit(){

		$this->load->view('goods_type_edit.html');
	}
	// 删除
	public function del($type_id){

		
	}


}