<?php
//调用方法：getCaptcha() 无参数
//验证码复杂类2
	class Captcha{
		//$type验证码的类型 默认是0：纯数字，1=数字+小写字母，2=数字+大小写字母
		private $type;					//验证码类型
		private $num;					//默认4个字符
		private $width;					//默认1个字符的图片宽度
		private $height;				//图片高度
		private $pixels;				//验证码干扰点数量
		private $lines;					//验证码干扰线数量
		//private $code;				//验证码字符串
		//构造方法
		public function __construct($arr=array()){
			//初始化属性
			$this->type=isset($arr['type']) 	? $arr['type'] 	 : $GLOBALS['config']['captcha']['type'];
			$this->num=isset($arr['num']) 		? $arr['num'] 	 : $GLOBALS['config']['captcha']['num'];
			$this->width=isset($arr['width']) 	? $arr['width']  : $GLOBALS['config']['captcha']['width'];
			$this->height=isset($arr['height']) ? $arr['height'] : $GLOBALS['config']['captcha']['height'];
			$this->pixels=isset($arr['pixels']) ? $arr['pixels'] : $GLOBALS['config']['captcha']['pixels'];
			$this->lines=isset($arr['lines']) 	? $arr['lines']  : $GLOBALS['config']['captcha']['lines']; 
			/* $this->type=isset($arr['type']) 	? $arr['type'] 	 : 0;
			$this->num=isset($arr['num']) 		? $arr['num'] 	 : 4;
			$this->width=isset($arr['width']) 	? $arr['width']  : 20;
			$this->height=isset($arr['height']) ? $arr['height'] : 35;
			$this->pixels=isset($arr['pixels']) ? $arr['pixels'] : 199;
			$this->lines=isset($arr['lines']) 	? $arr['lines']  : 9; */
		}
		//私有获取字符串方法1
		/* public function getCode(){
			$str='0123456789qwertyuioplkjhgfdsazxcvbnmMNBVCXZASDFGHJKLPOIUYTREWQ';
			$arr=array(9,35,61);
			for($i=0;$i<$this->num;$i++){
				$this->code.=$str[rand(0,$arr[$this->type])];
			}
		} */
		
		/*
		 * 私有获取随机字符串方法----------
		 * @return string $code返回随机字符串 
		*/
		private function getCode(){
			$str=implode(array_merge(range(1,9),range('a','z'),range('A','Z')));
			$arr=array(9,35,61);
			$code='';
			for($i=0;$i<$this->num;$i++){
				$n=rand(0,$arr[$this->type]-1);
				$code.=$str[$n];
			}
			//加入验证码到session
			// session_start();
			$_SESSION['code']=$code;
			return $code;
		}
		/*
		 * 私有添加干扰点方法----------
		 * @param resource $img 资源画布
		*/
		private function addpixels($img){
			//颜色
			for($i=0;$i<$this->pixels;$i++){
				$pixel_color = imagecolorallocate($img,mt_rand(0,150),mt_rand(100,150),mt_rand(100,150));
				imagesetpixel($img,rand(0,$this->width*$this->num),rand(0,$this->height),$pixel_color);
			}
		}
		/*
		 * 私有添加干扰线方法----------
		 * @param resource $img 资源画布
		*/
		private function addlines($img){
			for($i=0;$i<$this->lines;$i++){
				$line_color = imagecolorallocate($img,mt_rand(30,150),mt_rand(77,150),mt_rand(0,150));
				imageline($img,rand(0,$this->width*$this->num),rand(0,$this->height),rand(0,$this->width*4),rand(0,$this->height),$line_color);
			}
		}
		/*
		 * 公有获取验证码图片的方法----------
		 * @直接输出一张图片
		*/
		public function getCaptcha(){
			//1,定义画布
			$im=imagecreatetruecolor($this->width*$this->num,$this->height);
			//2,背景色
			$bg=imagecolorallocate($im,rand(200,255),rand(200,255),rand(200,255));
			//3,填充背景颜色
			imagefill($im,0,0,$bg);
			$code=$this->getCode();			//调用获取字符串方法，接收返回值
			$this->addpixels($im);			//调用干扰点方法
			$this->addlines($im);			//调用干扰线方法
			//4,定义几个不同的字体颜色，保存到数组
			$fbg[]=imagecolorallocate($im,rand(0,100),rand(0,100),rand(0,100));
			$fbg[]=imagecolorallocate($im,rand(0,100),rand(0,100),rand(0,100));
			$fbg[]=imagecolorallocate($im,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
			$fbg[]=imagecolorallocate($im,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
			//5,for循环绘制验证码
			for($i=0;$i<$this->num;$i++){
				//这里还可以用另外一个函数imagestring,但是没下面这个函数强大---注意字体路径问题。。。
				imagettftext($im,18,rand(0,20),8+(18*$i),24,$fbg[rand(0,3)],"elephant.ttf",$code[$i]);
			}
			////head信息
			header("Content-Type:image/png");
			imagepng($im);
			imagedestroy($im);//销毁内存图片
		}
		/*
		 * 验证-验证码的方法----------
		 * @直接返回结果，布尔值boolen
		*/
		public static function checkCode($captcha){
			return $captcha==$_SESSION['code'];
			// if($_SESSION['code']!=$captcha)
		}
	}
//-------------test-------
// $c=new Captcha();
// $c->getCaptcha();