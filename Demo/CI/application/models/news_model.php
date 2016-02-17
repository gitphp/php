<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model{
	const TBL='news';	//表名常量

	// 构造函数
	public function __construct(){
		parent::__construct();
		//引入类文件
		$this->load->database();
	} 

	// 定义添加news方法
	public function add_news($data){
		return $this->db->insert(self::TBL,$data);
	}

	//获取数据的方法
	public function getAll(){
		$query = $this->db->get(self::TBL);
		return $query->result_array();
	}
	//获取数据的方法
	public function list_news(){
		$query = $this->db->get(self::TBL);
		return $query->result_array();
	}
}