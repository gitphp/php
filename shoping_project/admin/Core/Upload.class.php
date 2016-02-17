<?php
//文件上传类(单文件上传:$this->fileUpload($_FILES['type']));
	class Upload{
		//属性
		private $path;				//文件要保存的路径
		private $size;				//最大允许文件尺寸
		private $allow;				//文件的类型
		public $errors;
		
		//构造函数
		public function __construct(){
			$this->path=$GLOBALS['config']['file']['path'];
			$this->size=$GLOBALS['config']['file']['size'];
			$this->allow=$GLOBALS['config']['file']['allow'];
		}
		
		/**
		 * 随机获取文件名字的方法
		*/
		public function getName(){
			// $str='qwertyuioplkjhgfdsazxcvbnmASDFGHJKLMNBVCXZQWERTYUIOP';		//简便获取文字方法
			$str=implode('',array_merge(range('a','z'),range('A','Z')));
			$name=date('YmdHis');
			for($i=0;$i<6;$i++){
				$name.=$str[mt_rand(0,strlen($str)-1)];
			}
			return $name;
		}
		/**
		 * 文件上传函数
		*/
		public function fileUpload($file){
			// 判断是否是数组
			if(!(is_array($file) && count($file)==5)){
				$this->errors='参数不是一个数组';
				return false;
			}
			// 判断错误信息
			// 2,判断error信息
			switch($file['error']){
				case 1:
					$this->$errors='文件太大';
					return false;
				case 2:
					$this->$errors='浏览器不允许这么大的文件';
					return false;
				case 3:
					$this->$errors='没有文件上传';
					return false;
				case 4:
					$this->$errors='文件部分上传';
					return false;
				case 6:
				case 7:
					$this->$errors='服务器奔溃';
					return false;
			}
			// 3,文件大小判断
			if($file['size'] > $this->size){
				$this->errors='文件太大，不让传';
				return false;
			}
			// 4,判断文件类型
			if(!in_array($file['type'],$this->allow)){
				$this->errors='文件类型错，不让传';
				return false;
			}
			// 5,拼凑新名字
			$newname=$this->getName();
			$newname=$newname . strrchr($file['name'],'.');
			// 6,移动临时文件
			if(move_uploaded_file($file['tmp_name'],$this->path . $newname)){
				//成功，则返回
				return isset($newname) ? $newname : false;
			}else{
				$this->errors='文件上传失败';
				return false;
			}
		}
	}