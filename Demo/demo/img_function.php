<?php
	//================================================================
	/*图片等比例缩放函数
	 *@param picname文件名
	 *@param minx缩放后图片的宽度
	 *@param miny缩放后图片的高度
	 *@param pre新图片的前缀名
	 */
	function newImgSize($picname,$minx=100,$miny=100,$pre='s_'){
		//1.取得图片信息getimagesize函数,判断三种图片格式：1 = GIF，2 = JPG，3 = PNG
		$info=getimagesize($picname);
		//var_dump($info);
		$w=$info[0];//获得图片的宽度
		$h=$info[1];//获得图片的高度
		
		switch($info[2]){
			case 1://gif格式图片
				$im=imagecreatefromgif($picname);
				break;
			case 2://jpg格式图片
				$im=imagecreatefromjpeg($picname);
				break;
			case 3://png格式图片
				$im=imagecreatefrompng($picname);
				break;
			default://其它类型->
				die("图片格式不对");
		
		}
		//2.计算缩放后的图面和原图的宽,高比例，判断比例尺，这里取小的比例的那个作为标准缩放比例
		if(($minx/$w)>($miny/$h)){//取最小的缩放比例.
			$b=$miny/$h;//比例=新图的高 / 原图的高
		}else{
			$b=$minx/$w;//否则就取 = 新图的宽 / 原图的宽
		}
		//3.计算新图片的尺寸，向下取整( = 比例 * 原图的宽,高)
		$nw=floor($b*$w);
		$nh=floor($b*$h);
		//4.创建新图 图像源
		$nim=imagecreatetruecolor($nw,$nh);
		//5.执行等比例缩放
		imagecopyresampled($nim,$im,0,0,0,0,$nw,$nh,$w,$h);
		//6.获得图片的pathinfo信息
		$picinfo=pathinfo($picname);
		//var_dump($picinfo);
		$newpicname=$picinfo['dirname'].'/'.$pre.$picinfo['basename'];
		//echo $newpicname;
		//7.输出图像,也要判断图片的格式switch
		switch($info[2]){
			case 1:
				imagegif($nim,$newpicname);
				break;
			case 2:
				imagejpeg($nim,$newpicname);
				break;
			case 3:
				imagepng($nim,$newpicname);
				break;
		}
		//8.释放图片资源
		imagedestroy($im);
		imagedestroy($nim);
		//9.返回结果
		return $newpicname;
	}
//==================================test======================================
//echo newImgSize('img/gui.jpg',11,11,'ss_').'<br/>';//调用的时候，记得传入三个参数
//============================================================================

	/**
	 * GD图像函数处理库
	 * 图片添加logo函数
	 * @param string $picname 被处理图片源
	 * @param string $logo 水印图片
	 * @param string $pre 处理后图片的前缀名
	 * @return string 返回后的图片名字（带路径） 如：a.jpg -> s_a.jpg
	*/
	function imageLogo($picname,$logo,$pre="logo_"){
		$picnameinfo = getimageSize($picname);	//获取图片源的基本信息
		$logoinfo 	 = getimageSize($logo);		//获取logo图片信息(长，宽，后缀名，路径)
		//var_dump($logoinfo);
		//1.根据原图类型创建对应的图片源
		switch($picnameinfo[2]){
			case 1://gif格式图片
				$im = imagecreatefromgif($picname);
				break;
			case 2://jpg格式图片
				$im = imagecreatefromjpeg($picname);
				break;
			case 3://png格式图片
				$im = imagecreatefrompng($picname);
				break;
			default://其它类型图片
				die("原图类型不对");
		}
		//2.根据logo图片类型创建出对应的图片源
		switch($logoinfo[2]){
			case 1://gif
				$logoim = imagecreatefromgif($logo);
				break;
			case 2://jpg
				$logoim = imagecreatefromjpeg($logo);
				break;
			case 3://png
				$logoim = imagecreatefrompng($logo);
				break;
			default:
				die("logo图片类型不对");
		}
		//3.执行图片加水印处理8个参数(原图,logo图,,,,,,)
		imagecopyresampled($im,$logoim,$picnameinfo[0]-$logoinfo[0],$picnameinfo[1]-$logoinfo[1],0,0,$logoinfo[0],$logoinfo[1],$logoinfo[0],$logoinfo[1]);
		//4.输出图像（根据图像类型，输出对应的类型）
		$arr = pathinfo($picname);   //解析图片path信息
		//var_dump($arr);
		$newpicname = $arr['dirname']."/".$pre.$arr['basename'];
		switch($picnameinfo[2]){
		  case 1:
			imagegif($im,$newpicname);
			break;
		  case 2:
			imagejpeg($im,$newpicname);
			break;
		  case 3:
			imagepng($im,$newpicname);
			break;
		}
	  //6.释放图像画布资源
	  imagedestroy($im);
	  imagedestroy($logoim);
	  //7.返回新图的路径
	  return $newpicname;
	  //$str="<img src='{$newpicname}'/>";//也可以返回一个图像输出到浏览器
	}
//=============================test===========================================
 //echo imageUpdateLogo("img/qiu.jpg","img/gui.jpg");
//============================================================================




