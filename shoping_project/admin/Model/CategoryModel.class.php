<?php
//分类表的model类
	class CategoryModel extends Model{
		protected $table='category';
		//获取全部数据方法
		public function getAllCategory(){
			$sql="select * from {$this->getTableName()}";
			// echo $sql,'<br/>';
			$arr=$this->db_selectAll($sql);
			// var_dump($arr);exit;
			return $this->onList($arr);
		}
		//无线分类
		private function onList($arr,$pid=0,$lev=0){
			static $cats=array();
			//循环遍历
			foreach($arr as $k=>$v){
				if($v['c_parent_id']==$pid){
					$v['lev']=$lev;
					$cats[]=$v;
					//递归
					$this->onList($arr,$v['c_id'],$lev+1);
				}
			}
			return $cats;
		}
		//通过id获取一行数据的方法
		public function getById($id){
			$sql="select * from {$this->getTableName()} where c_id='{$id}' limit 1";
			return $this->db_selectOne($sql);
		}
		
		
		
		
	}