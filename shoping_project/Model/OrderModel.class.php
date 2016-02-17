<?php

//订单
	class OrderModel extends Model{
		//
		protected $table='order';
		//接收购物车信息
		public function addorder($hao,$name,$price,$num,$total,$user){
			$sql="insert into {$this->getTableName()} values (null,'{$hao}','{$name}','{$price}','{$num}','{$total}','{$user}')";
			return $this->db_insert($sql);
		}
		
		//取出订单信息
		public function getorder($user){
			//只取一条记录，最后的一条记录
			$sql="select * from {$this->getTableName()} where u_username='{$user}' order by o_hao desc limit 1";
			return $this->db_selectAll($sql);
			
		}
		// 获得最大订单号吗
		public function getmaxhao(){
			$sql="select o_hao,u_username from {$this->getTableName()} order by o_hao desc limit 1";
			return $this->db_selectOne($sql);
		}
	}