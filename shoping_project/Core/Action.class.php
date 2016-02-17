<?php
if(!defined('ACCESS')){
	echo '非法入侵';
	exit;
}
//前台---控制器基类
	class Action{
		// 属性view,用于保存试图类View的一个对象
		public $view;
		/**
		 * 构造，获得view类的对象，并保存到view属性里面
		*/
		public function __construct(){
			$this->view=new View();
		}
		/**
		 * 跳转方法，引入跳转中间模板页面，定义url，time，msg等
		*/
		protected function success($url,$msg,$t=2){
			//成功跳转到模板文件，记得修改模板文件的参数
			require_once VIEW_DIR . 'success.html';exit;
		}
		protected function failure($url,$msg,$t=2){
			//失败跳转到模板文件，记得修改模板文件的参数
			require_once VIEW_DIR . ('failure.html');exit;
		}
	}
