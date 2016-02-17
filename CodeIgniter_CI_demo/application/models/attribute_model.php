<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//商品属性模型
class attribute_model extends CI_Model{
	const TB_A='attribute';

	public function add_a($data){
		return $this->db->insert(self::TB_A,$data);
	}

	// 取出所有
	public function get_all_attr($limit,$offset){
		$res=$this->db->limit($limit,$offset)->get(self::TB_A);
		return $res->result_array();
	}

	#获取指定类型id下面所有的属性
	public function get_attrs($type_id){
		$condition['a_type_id'] = $type_id;
		$query = $this->db->where($condition)->get(self::TB_A);
		return $query->result_array();
	}

	public function count_attr(){
		return $this->db->count_all(self::TB_A);
	}
}