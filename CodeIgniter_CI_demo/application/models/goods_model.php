<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods_model extends CI_Model{
	const TB_G='goods';
	// 添加、
	public function add_goods($data){
		$res=$this->db->insert(self::TB_G,$data);
		// 成功返回id，否则返回假的
		return $res ? $this->db->insert_id():false;
	}
}