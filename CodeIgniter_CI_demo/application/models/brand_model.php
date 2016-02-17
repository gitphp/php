<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// 后台品牌模型
class Brand_model extends CI_Model{
	const TB='brand';
	// 添加一个品牌信息
	public function add_brand($data){
		return $this->db->insert(self::TB,$data);
	}

	// 取数据
	public function get_brands(){
		$res=$this->db->get(self::TB);
		return $res->result_array();
	}

}