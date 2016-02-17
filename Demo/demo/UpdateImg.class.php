<?php
 /**
  * 封装类，处理图片
  *
 */
	class UpdateImg{
		public $imgpath;						//原图片路径
		public $newimg_w;						//新图的宽度
		public $newimg_h;						//新图的高度
		public $newimg_pre;						//新图的前缀名
		public $logoimgpath;					//logo原图
		public $newlogoimg_pre;					//新图+logo的前缀
		
		//构造
		public function __construct($imgpath='',$logoimgpath='',$newimg_w=100,$newimg_h=100,$newimg_pre='s_',$newlogoimg_pre='logo_'){
			$this->imgpath=$imgpath;
			$this->logoimgpath=$logoimgpath;
			$this->newimg_w=$newimg_w;
			$this->newimg_h=$newimg_h;
			$this->newimg_pre=$newimg_pre;
			$this->newlogoimg_pre=$newlogoimg_pre;
		}
		//缩放方法
		public function newImgSize(){
			//1,获取img信息
			$imginfo=getimagesize($this->imgpath);
			//获得img的with和height
			$width=$imginfo[0];
			$height=$imginfo[1];
			//匹配img格式
			switch($imginfo[2]){
				case 1:
					$i=imagecreatefromgif($this->imgpath);
					break;
				case 2:
					$i=imagecreatefromjpeg($this->imgpath);
					break;
				case 3:
					$i=imagecreatefrompng($this->imgpath);
					break;
				default :
					die('图片格式不正确，请重新选择图片格式');
			}
			//计算等比例
			if($width / $this->newimg_w > $height / $this->newimg_h){
				$x = $this->newimg_w / $width;
			}else{
				$x = $this->newimg_h / $height;
			}
			//计算新图的width和height,向下取整
			$nwidth  = floor($x * $width);
			$nheight = floor($x * $height);
			//创建新图资源
			$nimg = imagecreatetruecolor($nwidth,$nheight);
			//获得img的pathinfo
			$img_info = pathinfo($this->imgpath);
			//获得新img的路径
			$newimgpath=$img_info['dirname'].'/'.$this->newimg_pre.$img_info['basename'];
			//创建缩放后的图片原
			$newimg=imagecopyresampled($nimg,$i,0,0,0,0,$nwidth,$nheight,$width,$height);
			//匹配图片格式，输出
			switch($imginfo[2]){
				case 1:
					imagegif($nimg,$newimgpath);
					break;
				case 2:
					imagejpeg($nimg,$newimgpath);
					break;
				case 3:
					imagepng($nimg,$newimgpath);
					break;
			}
			//释放
			imagedestroy($i);
			imagedestroy($nimg);
			//返回新路径
			return $newimgpath;
			
		}
		//public函数加logo-----------------------------------------------------
		public function addImgLogo(){
			//.......
		}
		
	}
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 