<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//属性控制器
class Attribute extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('attribute_model');
		$this->load->model('goodstype_model');
		$this->load->library('pagination');		//载入分页类
	}


	public function show($offset=''){
		//分页信息
		$config['base_url']=site_url('admin/attribute/show');
		$config['total_rows']=$this->attribute_model->count_attr();	//总行数
		$config['per_page']=10;
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



		//取得所有商品类型展示
		$data['types']=$this->goodstype_model->getall_types();
		// 取出所有的属性列表
		$data['attrs']=$this->attribute_model->get_all_attr($limit,$offset);
		$this->load->view('attribute_list.html',$data);
	}

	public function add(){
		if(isset($_POST['a_name'])){
			// doubi($_POST);
			if($this->attribute_model->add_a($_POST)){
				redirect('admin/attribute/show');
			}else{
				redirect('admin/attribute/add');
			}
		}else{
			// 展示商品类型
			$data['types']=$this->goodstype_model->getall_types();
			// doubi($data);exit;
			$this->load->view('attribute_add.html',$data);
		}
		
	}

	public function edit(){

		$this->load->view('attribute_edit.html');
	}
	public function del($a_id){

		echo $a_id;
	}
}