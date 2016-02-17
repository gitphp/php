<?php
//商品表的类
	class ProductModel extends Model{
		protected $table='goods';
		//取出所有数据
		public function getAllGoods($a,$b){
			$sql="select * from {$this->getTableName()} limit {$a},{$b}";
			return $this->db_selectAll($sql);
		}
		//取出一行数据
		public function getOneGoods($id){
			$sql="select * from {$this->getTableName()} where g_id=$id limit 1";
			return $this->db_selectOne($sql);
		}
		/**
		 * 更新
		*/
		public function modify($id,$data){
			//拼接
			$sql="update {$this->getTableName()} set ";
			foreach($data as $k=>$v){
				$sql.=$k."='".$v."',";
			}
			$sql=rtrim($sql,',');
			$sql.=" where g_id={$id}";
			// echo $sql;
			return $this->db_update($sql);
		}
		public function getCount(){
			$sql="select count(*) as c from {$this->getTableName()}";
			$res=$this->db_selectOne($sql);
			if($res){
				return $res['c'];
			}
		}
		
		
		
		
		
	}