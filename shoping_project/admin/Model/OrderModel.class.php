<?php
/*
购物车需求：
1.	如果用户没有登录，购物车中的数据存在cookie
2.	如果用户登录了，就把购物车中的数据从COOKIE中移到数据库中
3.	用户下单之后，清空购物车中的数据
4.	购物车中商品：先判断如果用户没有登录从COOKIE中取数据，如果用户已经登录了从数据库中取

////////////////

取出购物车中商品的信息列表
程序流程：
1.	从购物车中取出商品的ID
2.	根据ID查询商品表取出：链接地址、商品名称
3.	从购物车中取出商品属性ID并转化成属性名称：属性值的字符串
4.	从商品图片表中取出第一张图片做为LOGO

*/
	//后台订单管理表
	class OrderModel extends Model{
		protected $table='order';
		//
		//取出订单信息
		public function getorder($user){
			//只取一条记录，最后的一条记录
			$sql="select * from {$this->getTableName()} where u_username='{$user}' order by o_hao desc";
			return $this->db_selectAll($sql);
			
		}
		
	}
	