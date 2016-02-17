<?php
//action,我就不验证了直接上代码了
	class CarAction extends Action{
		public function car(){
			//这里是添加商品到购物车
			$id=isset($_GET['id']) ? $_GET['id'] : '';
			//判断用户是否登陆,如果没有登陆就不可以添加购物车
			if(!isset($_SESSION['user'])){
				$this->failure('./admin/index.php','您还没有登陆！',1);
			}
			if($id){
				//存入id值到session里面
				// 判断是有这个商品已经存在，如果已经存在的话，数量就相加
				
				if(isset($_SESSION['product'][$id])){
					//假如商品已经存在的话,数量就++
					$_SESSION['product'][$id]['num']++;
				}else{
					// 定义一个数组保存一个商品的id和数量
					$_SESSION['product'][$id][$id]=$id;
					$_SESSION['product'][$id]['num']=1;
				}
				
			}
			//2,取出数据库数据，存入到购物车表里面
			$g=new GoodsModel();
			$goods=$g->getOne($id);	//取出一个商品信息
			// var_dump($goods);exit;
			$car=new CarModel();
			// var_dump($_SESSION['product']);exit;
			// 取出用户的用户名
			$admin=new AdminModel();
			$res=$admin->getusername($_SESSION['user']['u_id']);
			
			$total=$goods['g_price'] * $_SESSION['product'][$id]['num'];
			// echo $total;exit;//插入一个商品到购物车，需要5个参数？
			$car->addcar($id,$goods['g_name'],$goods['g_thumb'],$_SESSION['product'][$id]['num'],$goods['g_price'],$total,$res['u_username']);
			
			
			// 成功则跳转到提示页面
			$this->success('index.php?a=index&a=productlist','添加购物车成功',1);
		}
		
		// 查看购物车
		public function showcar(){
			//展示购物车里面的信息
			// 取出购物车表里面的数据，显示
			if(!isset($_SESSION['user'])){
				$this->failure('./admin/index.php','您还没有登陆！',1);
			}
			// var_dump($_SESSION['product']);
			// 根据用户名取购物车数据
			$car=new CarModel();
			$admin=new AdminModel();
			$res=$admin->getusername($_SESSION['user']['u_id']);		//取出用户名
			
			$shop=$car->getcarbyusername($res['u_username']);			//获得购物车所有信息
			// var_dump($shop);
			
			
			
			// 展示购物车信息
			
			
			require_once (VIEW_DIR.'shopping.html');
		}
		//删除购物车信息
		public function deletecar(){
			$id=isset($_GET['id']) ? $_GET['id'] : '';
			// 调用车类，删除
			$car=new CarModel();
			if($car->deletecarbyid($id)){
				//成功
				$this->success('index.php?m=car&a=showcar','删除商品成功',1);
			}else{
				//失败
				$this->failure('index.php?m=car&a=showcar','删除商品失败',2);
			}
			
			
		}
		
		
		
		
	}