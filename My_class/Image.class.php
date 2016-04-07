<?php
//图片处理类getNewImgSize($file)------setImgLogo($file)
	class Image{
		//属性
		private $path;					//缩略图要保存的地址路径
		private $smallwidth;			//缩略图的宽
		private $smallheight;			//缩略图的高
		private $smallprefix;			//缩略图的前缀
		
		private $logo;					//logo图地址
		private $logoprefix;			//生成新图的前缀
		private $position;				//logo的位置信息，1,2,3,4,5上下中左右
		private $pct;					//透明度
		private $logopath;				//logo图保存路径
		
		public $errors;					//保存错误信息
		// 构造
		public function __construct(){
			// 读取配置文件夹的信息参数
			$this->path		  =$GLOBALS['config']['image']['path'];
			$this->smallwidth =$GLOBALS['config']['image']['smallwidth'];
			$this->smallheight=$GLOBALS['config']['image']['smallheight'];
			$this->smallprefix=$GLOBALS['config']['image']['smallprefix'];
			$this->logo		  =$GLOBALS['config']['image']['logo'];
			$this->logoprefix =$GLOBALS['config']['image']['logoprefix'];
			$this->position	  =$GLOBALS['config']['image']['position'];
			$this->pct		  =$GLOBALS['config']['image']['pct'];
			$this->logopath	  =$GLOBALS['config']['image']['logopath'];
		}
		/**
		 * 获取图片尺寸，信息，getimagesize(),pathinfo()
		*/
		private function getImgInfo($file){
			// 判断文件是否存在------一次性的
			if(!file_exists($file)){
				$this->errors='文件图片不存在';
				return false;
			}
			// 返回三位数组，嗯哼
			$imginfo['size']=getimagesize($file);
			$imginfo['path']=pathinfo($file);
			return $imginfo;
		}
		/**
		 * 获得imagecreatefromxxx函数名
		*/
		private function getFunction($imginfo){
			$fun=array(
				'gif'	 => 'gif',
				'jpg'	 => 'jpeg',
				'jpeg'	 => 'jpeg',
				'png'	 => 'png',
				'pjpeg'  => 'jpeg'
			);
			// 返回后缀名
			return $fun[$imginfo['path']['extension']];
		}
		/**
		 * 执行缩放图片(缩放成固定尺寸的图片)(等比例缩放的没做)-------------------------------------
		*/
		public function getNewImgSize($file){
			//判断路径------前面函数已经判断了
			$imginfo=$this->getImgInfo($file);			//图片所有尺寸，path信息
			$create=$this->getFunction($imginfo);		//后缀名  .gif
			$save='image' . $create;					//保存的函数名 imagegif()
			$create='imagecreatefrom' . $create;		//创建的函数名 imagecreatefromgif()
			//1,获得原图片资源
			$img=$create($file);
			//2,创建新的画布固定的尺寸
			$newimg=imagecreatetruecolor($this->smallwidth,$this->smallheight);
			//3,创建颜色
			$color=imagecolorallocate($newimg,255,255,255);			//白色
			imagefill($newimg,0,0,$color);							//填充白色画布
			//4,计算缩略图位置
			if(($this->smallwidth / $imginfo['size'][0]) < ($this->smallheight / $imginfo['size'][1])){
				$b=$this->smallwidth / $imginfo['size'][0];		//取小的比例尺
			}else{
				$b=$this->smallheight / $imginfo['size'][1];		//取小的比例尺
			}
			//5,计算等比例新图的尺寸
			$width =round($imginfo['size'][0] * $b);
			$height=round($imginfo['size'][1] * $b);
			
			//6,计算缩略图的开始位置的点坐标
			$begin=ceil(($this->smallwidth-$width) / 2);
			$end  =ceil(($this->smallheight-$height) / 2);
			//6,执行缩放imagecopyresampled(10个参数)
			if(imagecopyresampled($newimg,$img,$begin,$end,0,0,$width,$height,$imginfo['size'][0],$imginfo['size'][1])){
				//成功了返回图片名字
				$newname=$this->smallprefix . basename($file);
				$save($newimg,$this->path . $newname);
				return isset($newname) ? $newname : false;
			}else{
				$this->errors='采样失败';
				return false;
			}
		}
		/**
		 * 给图片加水印方法，水印有5个位置信息，左上，右上，中间，左下，右下----------------------
		 * $file
		 * $logo
		 * $position
		*/
		public function setImgLogo($file){
			//判断文件是否存在,上面已经判断了，不需要在判断了
			
			// 1,获得图片信息
			$imginfo =$this->getImgInfo($file);				//原图信息
			$logoinfo=$this->getImgInfo($this->logo);		//logo图信息
			// 2,判断位置
			switch($this->position){
				case 1:
					$startx=0;
					$starty=0;
					break;
				case 2:
					$startx=$imginfo['size'][0] - $logoinfo['size'][0];
					$starty=0;
					break;
				case 3:
					$startx=ceil(($imginfo['size'][0] - $logoinfo['size'][0]) / 2);
					$starty=ceil(($imginfo['size'][1] - $logoinfo['size'][1]) / 2);
					break;
				case 4:
					$startx=0;
					$starty=$imginfo['size'][1] - $logoinfo['size'][1];
					break;
				case 5:
					$startx=$imginfo['size'][0] - $logoinfo['size'][0];
					$starty=$imginfo['size'][1] - $logoinfo['size'][1];
					break;
			}
			// 3,判断函数类型
			$fun1=$this->getFunction($imginfo);
			$save='image' . $fun1;				//保存函数
			$fun1='imagecreatefrom' . $fun1;	//创建原图函数
			$fun2=$this->getFunction($logoinfo);//创建logo图函数
			$fun2='imagecreatefrom' . $fun2;
			// 4,创建原图和logo图的资源
			$img=$fun1($file);
			$logo=$fun1($this->logo);
			// 5,可以采样合并文件了，哈哈哈imagecopymerge(9大参数)
			if(imagecopymerge($img,$logo,$startx,$starty,0,0,$logoinfo['size'][0],$logoinfo['size'][1],$this->pct)){
				//成功，则拼接图片名字
				$newname=$this->logoprefix . basename($file);
				//保存图片到指定的位置
				$save($img,$this->logopath . $newname);
			}
			//销毁资源
			imagedestroy($img);
			imagedestroy($logo);
			//返回一个新图的名字
			return isset($newname) ? $newname : false;
		}
		//end---
	}