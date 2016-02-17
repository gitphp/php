<?php
//新闻类
	class NewsModel extends Model{
		protected $table='news';
		public function getAllNews(){
			$sql="select n_title from {$this->getTableName()} limit 7";
			return $this->db_selectAll($sql);
		}
	}