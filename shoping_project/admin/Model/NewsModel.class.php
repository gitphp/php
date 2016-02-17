<?php
	//news类
	class NewsModel extends Model{
		protected $table='news';
		//取出行数
		public function getCount(){
			$sql="select count(*) as c from {$this->getTableName()}";
			$res=$this->db_selectOne($sql);
			if($res){
				return $res['c'];
			}
		}
		//取出总数
		public function getAll($o,$n){
			$sql="select * from {$this->getTableName()} limit {$o},{$n}";
			return $this->db_selectAll($sql);
		}
		//通过id取一行数据
		public function getnewsbyid($id){
			$sql="select * from {$this->getTableName()} where n_id={$id}";
			return $this->db_selectOne($sql);
		}
		//更新新闻内容的方法，其他数据我不管
		public function modifycontent($id,$c){
			$sql="update {$this->getTableName()} set n_content='{$c}' where n_id={$id}";
			return $this->db_update($sql);
		}
	}