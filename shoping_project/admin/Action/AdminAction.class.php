<?php
//后台管理员控制器
	class AdminAction extends Action{
		//显示用户信息
		public function user(){
			//获取数据库数据内容-----分页显示
			$admin=new AdminModel();
			//实例化分页类
			$p=new Page();
			// 取出数据库总行数
			$counts=$admin->getCounts();
			$page=isset($_GET['page']) ? $_GET['page'] : 1;
			$str=$p->getPage('index.php?m=admin&a=user',$counts,$page,$GLOBALS['config']['pagelistsize']);
			
			//取出所有数据，传入limit 2个参数
			$offset=($page-1) * $GLOBALS['config']['pagelistsize'];
			$users=$admin->getAllUser($offset,$GLOBALS['config']['pagelistsize']);
			
			// var_dump($GLOBALS['config']['pagelistsize']);
			// var_dump($users);
			//显示模板
			// $this->view->assign('name',$_SESSION['user']['u_name']);
			// $this->view->assign('time',date('Y-m-d H:i:s',$_SESSION['user']['u_logintime']));
			// $this->view->display('user.html');
			require_once(VIEW_DIR . '/user.html');
		}
		/**
		 * 更新用户信息
		*/
		public function update(){
			$id=isset($_GET['id']) ? $_GET['id'] : '';
			//获取数据显示
			$admin=new AdminModel();
			$user=$admin->getUserById($id);
			// var_dump($user);
			//显示模板
			// $this->view->display('user-modify.html');
			require_once(VIEW_DIR . 'user-modify.html');
		}
		/**
		 * 获取数据，插入一行数据
		*/
		public function insert(){
			//获取数据,不想用isset判断了
			$u_id				=$_POST['u_id'];
			$data['u_username'] =trim($_POST['userName']);
			$data['u_name']		=trim($_POST['name']);
			$data['u_sex']		=trim($_POST['sex']);
			$data['u_phone']	=trim($_POST['mobile']);
			$data['u_addr']		=trim($_POST['address']);
			//判断数据合法性
			if(empty($data['u_username']) || empty($data['u_name'])){
				$this->failure('index.php?m=admin&a=update','信息不可以为空',2);
			}
			if(empty($data['u_phone']) || empty($data['u_addr'])){
				$this->failure('index.php?m=admin&a=update','电话地址不为空',2);
			}
			if(!is_numeric($data['u_phone'])){
				$this->failure('index.php?m=admin&a=update','电话必须是数字11位',2);
			}
			//执行头像上传
			$up=new Upload();
			if($picname=$up->fileUpload($_FILES['pic'])){
				//成功，则继续缩略
				$img=new Image();
				$smallpic=$img->getNewImgSize(PUBLIC_DIR . 'uploads/imgs/'.$picname);
				// $a=PUBLIC_DIR . 'uploads/'.$picname;// var_dump($smallpic);--成功
				$data['u_portrait']='uploads/thumbs/' . $smallpic;
				// var_dump($data);
			}//else这里不管，写入系统日志
			// 5，执行update方法，修改数据
			$admin=new AdminModel();
			if($admin->updateById($u_id,$data)){
				//修改成功
				$this->success('index.php?m=admin&a=user','修改成功',1);
			}
			
			
		}
		/**
		 * 增加
		*/
		public function add(){
			
			require_once(VIEW_DIR . 'user-add.html');
		}
		
		
		
	}