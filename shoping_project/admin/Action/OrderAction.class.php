<?php
	//后台订单控制器
	class OrderAction extends Action{
		//
		// 展示订单信息
		public function show(){
			//取出订单信息
			$o=new OrderModel();
			$orders=$o->getorder($_SESSION['user']['u_username']);
			// 分割orders信息,砸成4个数组，保存所有的产品信息
			foreach($orders as $v){
				// var_dump($v);
				$names=explode('@@',$v['o_name']);
				$prices=explode('@@',$v['o_price']);
				$nums=explode('@@',$v['o_num']);
				$totals=explode('@@',$v['o_totle']);
			}
			//在订单页面显示订单信息
			// var_dump($nums);exit;
			// var_dump($orders);exit;
			// 计算总金额
			$money=0;
			for($i=0;$i<=count($totals)-1;$i++){
				$money+=$totals[$i];
			}
			//取出用户的地址
			$user=new UserinfoModel();
			//获得用户的地址，姓名，电话
			$res=$user->getaddr($_SESSION['user']['u_username']);
			// echo $_SESSION['user']['u_username'];
			// var_dump($res);exit;
			
			include_once(VIEW_DIR . 'order.html');
		}
		
		
		
		
		
		
	}