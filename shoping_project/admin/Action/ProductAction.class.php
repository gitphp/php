<?php
//产品控制器
	class ProductAction extends Action{
		
		public function show(){
			//取出数据
			$p=new ProductModel();
			// $goods=$p->getAllGoods();
			// var_dump($goods);
			/****分页******/
			$page=isset($_GET['page']) ? $_GET['page'] : 1;
			$pa=new Page();
			$o=($page-1) * $GLOBALS['config']['pagelistsize'];	//起始下标
			$counts=$p->getCount();
			//获得分页字符串
			$str=$pa->getPage('index.php?m=product&a=show',$counts,$page,$GLOBALS['config']['pagelistsize']);
			$goods=$p->getAllGoods($o,5);		//分页参数
			
			
			
			//--------------------------------
			require_once(VIEW_DIR . 'product.html');
		}
		/**
		 * update
		*/
		public function update(){
			//展示数据
			$id=$_GET['id'];
			$p=new ProductModel();
			$good=$p->getOneGoods($id);
			// var_dump($good);
			$cat=new CategoryModel();
			$cats=$cat->getAllCategory();	//所有分类信息
			
			require_once(VIEW_DIR . 'product-modify.html');
		}
		/**
		 * 更新验证商品的数据
		*/
		public function modify(){
			//接收数据
			$g_id = isset($_POST['g_id'])   ? trim($_POST['g_id']) : '';
			$data['g_name'] 	= isset($_POST['g_name'])   	? trim($_POST['g_name']) : '';
			$data['c_id']   	= isset($_POST['c_id']) 		? trim($_POST['c_id']) 	 : '';
			$data['g_price']	= isset($_POST['g_price']) 		? trim($_POST['g_price']) 	 : '';
			$data['g_brand']	= isset($_POST['g_brand']) 		? trim($_POST['g_brand']) 	 : '';
			$data['g_barcode']	= isset($_POST['g_barcode']) 	? trim($_POST['g_barcode'])  : '';
			$data['g_inv']   	= isset($_POST['g_inv']) 		? trim($_POST['g_inv']) 	 : '';
			$data['g_desc']   	= isset($_POST['g_desc']) 		? trim($_POST['g_desc']) 	 : '';
			// 在线编辑器生成的代码，要用addslashes函数转义一下的
			// 然后从数据库取出来的数据也要用函数stripclashes反转义一下的
			// var_dump($data);
			//合法性
			if (empty($data['g_name'])) {
            $this->failure("index.php?m=product&a=update&id=" . $g_id, "商品名字不能为空!",1);
			}
			//商品分类
			if ($data['c_id'] == '') {
				$this->failure("index.php?m=product&a=update&id=" . $g_id, '商品分类必须选择!',1);
			}
			//商品价格
			if (!is_numeric($data['g_price']) || $data['g_price'] < 0) {
				$this->failure("index.php?m=product&a=update&id=" . $g_id,'商品价格必须是大于等于0的数值!',1);
			}
			//商品库存
			if (!is_numeric($data['g_inv']) || $data['g_inv'] < 0) {
				$this->failure("index.php?m=product&a=update&id=" . $g_id,'商品库存必须是大于等于0的数值!',1);
			}
			
			/****有效性*********/
			// 处理图片上传，，保存在uploads/imgs下面，，缩略图保存在uploads/thumbs
			if($_FILES['g_image']['name']){
				//执行上传
				$up=new Upload();
				$imgname=$up->fileUpload($_FILES['g_image']);
				//保存图片路径
				$data['g_image']='imgs/'.$imgname;
				// var_dump($data); 
				//执行缩放图片处理
				$i=new Image();
				$thumbname=$i->getNewImgSize(PUBLIC_DIR . 'uploads/imgs/'.$imgname);
				if($thumbname){
					$data['g_thumb']='thumbs/'.$thumbname;
				}
			}
			// echo $data['g_thumb'];exit;
			//执行修改数据库
			$p=new ProductModel();
			if($p->modify($g_id,$data)){
				//成功
				// echo "ddd";
				$this->success("index.php?m=product&a=show",'修改商品信息成功',1);
			}else{
				//失败
				$this->failure("index.php?m=product&a=update&id=" . $g_id, '更新商品失败!',2);
			}
			
			
			
			
			
			
		}
		
		
		
		
		
		
		
		/**
		 * 增加
		*/
		public function add(){
			
			require_once(VIEW_DIR . 'productClass-add.html');
		}
		
		
		
		
	}