<?php
//后台分类管理
	class CategoryAction extends Action{
		//显示分类
		public function show(){
			$cat=new CategoryModel();
			$cats=$cat->getAllCategory();
			// var_dump($cats);
			require_once(VIEW_DIR . 'productClass.html');
		}
		//修改
		public function update(){
			$id=$_GET['id'];
			$c=new CategoryModel();
			$cats=$c->getAllCategory();
			$cat=$c->getById($id);
			require_once(VIEW_DIR.'productClass-modify.html');
		}
		// 更新插入
		public function insert(){
			// echo '更新成功';exit;
			$this->success('index.php?m=category&a=show','更新成功了。',1);
		}
		public function add(){
			
			require_once(VIEW_DIR .'product-add.html');
		}
	}