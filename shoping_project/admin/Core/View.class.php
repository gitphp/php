<?php
if(!defined('ACCESS')){
	echo '非法入侵';
	exit;
}
//模板类
	class View{
		//属性
		private $path=VIEW_DIR;				//模板路径
		protected $data=array();				//保存要替换的数据
		private $left_de='{';				//左边界
		private $right_de='}';				//右边界
		//assign
		public function assign($name,$value){
			// name 替换哪里
			// value 替换成什么
			$this->data[$name]=$value;
			// echo '<pre>';
		}
		public function display($templates){
			//传入模板文件，获得文件内容
			// var_dump($this->data);
			$str=file_get_contents($this->path .'/'. $templates);
			// 遍历模板文件内容
			foreach($this->data as $key=>$value){
				// 替换模板标签
				$str=str_replace($this->left_de . $key . $this->right_de,$value,$str);
			}
			// 输出替换好的模板字符串
			echo $str;
		}
		//格式化字符串自定义方法  addslashes（防止注入攻击）
		
	}
