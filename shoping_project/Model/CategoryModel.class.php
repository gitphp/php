<?php

//cat类
	class CategoryModel extends Model{
		//取出数据
		    //属性
		protected $table = 'category';

		/*
		 *功能:获取所有商品分类
		 *@return mixed array or false
		 */
		public function getCats() {
			$sql = "select * from {$this->getTableName()}";
			if ($cats = $this->db_selectAll($sql)) {
				return $this->classfyCats($cats);
			} else {
				return false;
			}
		}

		/*
		 *功能:无限极分类
		 *@param1 array $arr
		 *@param2 int $parent
		 *@param3 int $level
		 *@return
		 */
		private function classfyCats($arr, $parent = 0, $level = 0) {
			static $list = array();//静态变量接收数组
			foreach ($arr as $value) {
				if($value['c_parent_id'] == $parent) {
					$value['level'] = $level;
					$list[] = $value;
					$this->classfyCats($arr, $value['c_id'], $level + 1);
				}
			}
			return $list;
		}

	}