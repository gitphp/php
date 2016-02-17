<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// 分类表模型
class Category_Model extends CI_MOdel{
	const TB='category';
	//-------------------------前台方法------------
	// 找到某个分类下面的子分类
	public function getChild($arr,$pid=0){
		$childs=array();
		foreach ($arr as $k => $v) {
			if($v['c_pid']==$pid){
				$childs[]=$v;
			}
		}
		return $childs;
	}
	// 组织三维分类数组
	public function sanwei($arr,$pid=0){
		$childs=$this->getChild($arr,$pid);
		// 再次遍历寻找子分类
		if(empty($childs)){
			return null;
		}
		//有东西就继续遍历
		foreach ($childs as $k => $val) {
			// 获取子分类数组保存起来
			$current_child=$this->sanwei($arr,$val['c_id']);
			if($current_child!=null){
				// 不为空的话，就作为childs数组的一个元素添加到数组末尾
				$childs[$k]['child']=$current_child;
			}
		}
		return $childs;
	}
	//获取分类好的三维数组
	public function getAllCats(){
		$res=$this->db->get(self::TB);
		$cats=$res->result_array();
		return $this->sanwei($cats,$pis=0);
	}
	//------------------------nav  end-------------------------







	//-------------------------后台方法------------
	// 获取所有分类
	public function getAll($pid=0){
		$query=$this->db->get(self::TB);
		$cats=$query->result_array();
		// 调用自己的方法，排序无线分类
		// var_dump($cats);
		return $this->tree($cats,$pid);
	}
	// 修改
	public function update_cat($data,$c_id){
		return $this->db->where('c_id',$c_id)->update(self::TB,$data);
	}
	//获取一行记录，用于修改
	public function getOne($c_id){
		// $condition['c_id']=$c_id;
		$res=$this->db->where('c_id',$c_id)->get(self::TB);
		// 返回一条数据
		
		return $res->row_array();//doubi($res->row_array());
	}
	// 删除一行记录
	public function delete_cat($c_id){
		return $this->db->where('c_id',$c_id)->delete(self::TB);
		// 这里应该判断一下结果然后在返回，收影像的行数
	}
	//添加一条分类记录
	public function insert_cat($data){
		return $this->db->insert(self::TB,$data);
	}

	
	// 无线分类方法
	private function tree($arr,$pid=0,$lev=0){
		static $tree=array();
		foreach ($arr as $key=>$val) {
			if($val['c_pid']==$pid){
				$val['lev']=$lev;
				$tree[]=$val;
				unset($arr[$key]);
				// 递归
				$this->tree($arr,$val['c_id'],$lev+1);
			}
		}
		// 返回排列好的数组
		return $tree;
	}
}