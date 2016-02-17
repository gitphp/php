<?php

	//订单控制
	class OrderAction extends Action{
		//接收购物车信息，生成订单
		public function order(){
			// var_dump($_POST);exit;
			// 接收用户提交的购物车信息
			$g_name	 =isset($_POST['g_name']) 	? $_POST['g_name']  	: ''; 
			$price	 =isset($_POST['price']) 	? $_POST['price'] 		: ''; 
			$num	 =isset($_POST['num']) 		? $_POST['num'] 		: ''; 
			$total	 =isset($_POST['total']) 	? $_POST['total'] 		: '';
			$username=isset($_POST['username']) ? $_POST['username'] 	: '';
			
			$name	=isset($_POST['name']) 	? $_POST['name'] 	: ''; 
			$addr	=isset($_POST['addr']) 	? $_POST['addr'] 	: ''; 
			$phone	=isset($_POST['phone']) ? $_POST['phone'] 	: ''; 
			//验证用户信息合法性
			if(empty($name) || empty($addr) || empty($phone)){
				//不可以为空
				$this->failure('index.php?m=car&a=showcar','个人信息为空，哈哈哈哈！',1);
			}
			//2, 验证用户的手机是否是数字，11位
			if(!is_numeric($phone) || (mb_strlen($phone,'UTF-8')!=11)){
				//
				$this->failure('index.php?m=car&a=showcar','手机号码不对，哈哈哈！',1);
			}
			//(二),插入订单信息到数据库
			
			// 随机生成订单号ss001
			$hao='ss';
			// 取出数据库已有的最大订单号
			$o=new OrderModel();
			$res=$o->getmaxhao();						//ss003
			$o_hao=substr($res['o_hao'],-3);			//003
			// echo $o_hao;
			$o_hao++;			//2   ->0002
			// echo $o_hao;exit;
			$o_hao=str_pad($o_hao,4,0,STR_PAD_LEFT);   //0002
			$o_hao='ss'.$o_hao;
			// echo $o_hao;
			// exit;
			// 组织语句，插入数据库的订单表，和用户的信息表
			$userinfo=new UserinfoModel();
			$userinfo->addinfo($_SESSION['user']['u_username'],$name,$addr,$phone);
			
			//生成订单
			/* var_dump($g_name);
			var_dump($price);
			var_dump($num);
			var_dump($total); */
			
			// 讲数组砸成字符串，然后插入数据库
			$g_name	=implode('@@',$g_name);
			$price	=implode('@@',$price);
			$num	=implode('@@',$num);
			$total	=implode('@@',$total);
			// 遍历总价格
			/* $sum=0;
			foreach($total as $v){
				$sum+= $v;
			} */
			// $username=$res['u_username'];
			// var_dump($res);
			// var_dump($_SESSION['user']['u_username']); 
			if($o->addorder($o_hao,$g_name,$price,$num,$total,$_SESSION['user']['u_username'])){
				//成功
				//订单完成之后要删除购物车的内容
				$cat=new CarModel();
				$cat->clearcar($_SESSION['user']['u_username']);
				$this->success('index.php?m=order&a=show','下订单完成',1);
			}else{
				//失败
				echo'失败了';
				
			}
			
			
			
			
			
			
			
			
		}
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
			
			
			require_once (VIEW_DIR.'orderlist.html');
		}
		
		/**
		 * 终于有人付款了，啊哈哈哈哈
		*/
		public function money(){
			//付款成功
			$money=isset($_GET['money']) ? $_GET['money'] : '';
			if($money){
				//成功
				$this->success('index.php','购买商品成功',3);
			}
			else{
				//失败
				$this->failure('index.php?m=order&a=show','购买商品失败',3);

			}
		}
	}