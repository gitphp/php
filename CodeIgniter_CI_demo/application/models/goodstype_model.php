<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goodstype_model extends CI_Model{
	const TB='goods_type';
	//取出所有数据
	public function getall_types(){
		$res=$this->db->get(self::TB);
		return $res->result_array();
	}
	// 总行数
	public function count_type(){
		return $this->db->count_all(self::TB);
	}
	// 增加
	public function add_type($data){
		return $this->db->insert(self::TB,$data);
	}

	// 取数据,并分页显示,2个参数是相反的，和默认情况下
	public function get_types($limit,$offset){
		$res=$this->db->limit($limit,$offset)->get(self::TB);
		return $res->result_array();
	}


}