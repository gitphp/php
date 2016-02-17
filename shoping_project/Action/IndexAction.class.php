<?php
if(!defined('ACCESS')){
	echo '非法入侵';
	exit;
}
//前台index控制器
	class IndexAction extends Action{
		/**
		 * Index方法
		*/
		public function Index(){
			// echo '恭喜您成功请求前台首页！！！';
			//1，获取新闻数据并显示
			$new=new NewsModel();
			$news=$new->getAllNews();
			//2，获取留言数据并显示
			$m=new MessagesModel();
			$msg=$m->getAllMsg();
			//3，获取产品信息并显示
			$g=new GoodsModel();
			$goods=$g->getGoods8();//-------前面8条数据，显示在主页今日特价里面
			// 4.在取出后面的12条数据，显示在主页下面的热卖推荐
			$goods12=$g->getGoods12();
			// echo count($goods12);
			// 5,获取分类信息展示。
			$c=new CategoryModel();
			$cats=$c->getCats();
			// var_dump($cats);
			// $this->view->display('index.html');
			// 判断用户是否登陆，没有登陆的话，就显示登陆提示，登陆了的话就显示登陆名字
			// echo '<pre>';
			// var_dump($_COOKIE);//-------这里的cookie只有用户的id信息，和sessionid2个值
			// var_dump($_SESSION);---------这里的session只有验证码和用户信息
			if(isset($_SESSION['user'])){
				// 有登陆
				if(isset($_COOKIE['u_id'])){
					
					$name='欢迎您:'.$_SESSION['user']['u_name'];
					$url="admin/index.php?m=admin&a=user";
					// 如果用户已经登录了的话，就取cookie里面的产品信息展示
					if(isset($_COOKIE['goods'])){
						foreach($_COOKIE['goods'] as $id){
						// echo $id,'<hr/>';
						// 通过id取出商品信息，保存在一个二维数组里面，我要取出最后4个元素，不能用foreach呀
						$newgoods[]=$g->getOne($id);
						// echo $id,'<hr/>';
						}
					}else{
						//
						$newgoods[]=$g->getOne(mt_rand(1,18));
						$newgoods[]=$g->getOne(mt_rand(1,18));
					}
					require_once(VIEW_DIR . 'index.html');
				}else{
					// 没有登陆
					$newgoods[]=$g->getOne(mt_rand(1,18));
					$newgoods[]=$g->getOne(mt_rand(1,18));
					$name='登陆';
					$url="admin/index.php";
					require_once(VIEW_DIR . 'index.html');
				}																
			}else{
				// 没有登陆
				// $newgoods[]=$g->getOne(mt_rand(1,18));
				// $newgoods[]=$g->getOne(mt_rand(1,18));
				$name='登陆';
				$url="admin/index.php";
//---------------我想在实现一下，主页的用户最近浏览商品的信息------------------
				// 这个应该在没有登陆的情况下展示吧，所以应该写在else里面
				// 当用户点击一个商品的时候，就把这个商品的信息放入cookie里面
				// 循环遍历cookie里面的goods下标的元素，取出前面4个产品的id，用于显示在首页侧边栏
						
				// var_dump($newgoods);
				/* for($i=0,$i<=count($_COOKIE['goods'])-1;$i++){
					// 当i是数组最后4个元素的时候，就保存产品信息
					if($i==(count($_COOKIE['goods'])-1)){
						//这方法不行，放弃执行，，继续用foreach循环，不排序了
					}					
				} */
				
				//没有cookie，随便取6个产品展示
					$newgoods[]=$g->getOne(mt_rand(1,18));
					$newgoods[]=$g->getOne(mt_rand(1,18));
					$newgoods[]=$g->getOne(mt_rand(1,18));
					$newgoods[]=$g->getOne(mt_rand(1,18));
					$newgoods[]=$g->getOne(mt_rand(1,18));
					$newgoods[]=$g->getOne(mt_rand(1,18));
				
				//---------------------------------
				require_once(VIEW_DIR . 'index.html');
			}
					
		}
		
		//
		public function productlist(){
			//
			$g=new GoodsModel();
			// 4.在取出后面的12条数据，显示在主页下面的热卖推荐
			$goods12=$g->getGoods12();
			include VIEW_DIR . 'product-list.html';
		}
		//显示商品详情
		public function goodsview(){
			$id=isset($_GET['id']) ? $_GET['id'] : 1;
			//把商品的id存入cookie里面,用擦边球方法，保存产品id的数组
			// $g_id[]=$id;
			// 把产品的id编号成数组的形式保存的cookie里面，啊哈哈哈哈
			setcookie("goods[$id]",$id,0,'/');  
			//取出数据库数据
			$g=new GoodsModel();
			$goods=$g->getOne($id);
			// var_dump($goods); ----success
			// Notice: Uninitialized string offset: 2 in D:\s\shoping\Action\IndexAction.class.php on line 68
			// 擦，数字不可以为数组的下标
			//
			include VIEW_DIR.'product-view.html';
		}
		//显示新闻详情
		public function newsview(){
			
			include VIEW_DIR . 'news-view.html';
		}
		//显示留言信息详情
		public function messagesview(){
			
			include VIEW_DIR .'messages-view.html';
		}
	}