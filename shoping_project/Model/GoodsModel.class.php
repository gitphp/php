<?php

//产品类
	class GoodsModel extends Model{
		//
		protected $table='goods';
		/**
		 * 获取goods的8条数据
		*/
		public function getGoods8(){
			$sql="select * from {$this->getTableName()} limit 0,8";
			return $this->db_selectAll($sql);
		}
		/**
		 * 获取后面的12行数据
		*/
		public function getGoods12(){
			$sql="select * from {$this->getTableName()} limit 8,12";
			return $this->db_selectAll($sql);
		}
		/**
		 * 取出一行数据显示
		*/
		public function getOne($id){
			$sql="select * from {$this->getTableName()} where g_id={$id} limit 1";
			return $this->db_selectOne($sql);
		}
		
		
		
		
	}