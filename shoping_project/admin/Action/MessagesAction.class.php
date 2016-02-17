<?php

//留言板控制器类
	class MessagesAction extends Action{
		public function show(){
			$m=new MessagesModel();
			$res=$m->getAll();
			// echo '显示留言板信息';
			// var_dump($res);exit;
			require_once(VIEW_DIR . 'guestbook.html');
		}
	}
