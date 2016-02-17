<?php
header("content-type:text/html;charset=utf-8");
include("img_function.php");


// 调用等比例缩放函数
echo newImgSize('lenovo.jpg').'<hr/>';

//调用图片水印函数  3个参数-------添加logo函数--------
echo imageLogo('lenovo.jpg','cxy.gif');


