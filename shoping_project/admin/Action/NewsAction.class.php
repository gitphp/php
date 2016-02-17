<?php

//控制器类
	class NewsAction extends Action{
		//显示数据，并分页
		public function show(){
			$page=isset($_GET['page']) ? $_GET['page'] : 1;
			$n=new NewsModel();
			$p=new Page();
			$o=($page-1) * $GLOBALS['config']['pagelistsize'];	//起始下标
			$counts=$n->getCount();
			//获得分页字符串
			$str=$p->getPage('index.php?m=news&a=show',$counts,$page,$GLOBALS['config']['pagelistsize']);
			$news=$n->getAll($o,$GLOBALS['config']['pagelistsize']);		//分页参数
			
			
			
			require_once(VIEW_DIR . 'news.html');
		}
		/**
		 * 增加
		*/
		public function add(){
			
			require_once(VIEW_DIR . 'news-add.html');
		}
		
		/**
		 * modify,修改新闻信息展示表单
		*/
		public function modify(){
			// 展示信息
			$id=isset($_GET['id']) ? $_GET['id'] : '';
			$n=new NewsModel();
			$news=$n->getnewsbyid($id);
			require_once(VIEW_DIR . 'news-modify.html');
		}
		/**
		 * doupdate 执行更新
		*/
		public function doupdate(){
			//
			
			$content=isset($_POST['content']) ? $_POST['content'] : '';
			$id=isset($_POST['id']) ? $_POST['id'] : '';
			$n=new NewsModel();
			if($n->modifycontent($id,$content)){
				echo "更新成功了，<a href='index.php?m=news&a=show'>返回查看信息</a>";
			}
			
			
		}
		
		
	}
	
	
	