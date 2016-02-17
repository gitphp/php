<?php
//购物车
	class CarModel extends Model{
		//购物车类
		protected $table='car';
		
		//插入一个商品到购物车
		public function addcar($id,$name,$t,$num,$price,$total,$username){
			$sql="replace into {$this->getTableName()} values(null,{$id},'{$name}','{$t}',{$num},{$price},{$total},'{$username}')";
			return $this->db_insert($sql);
		}
		
		//通过用户取出所有该用户的购物车信息
		public function getcarbyusername($user){
			//
			$sql="select * from {$this->getTableName()} where u_username='{$user}'";
			return $this->db_selectAll($sql);
		}
		//凭借id删除个购物车商品
		public function deletecarbyid($id){
			$sql="delete from {$this->getTableName()} where c_id={$id}";
			return $this->db_delete($sql);
		}
		//下单成功之后，通过用户账号名字，删除购物车
		public function clearcar($user){
			$sql="delete from {$this->getTableName()} where u_username='{$user}'";
			return $this->db_delete($sql);
		}
	}