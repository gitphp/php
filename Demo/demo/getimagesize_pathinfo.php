<?php
echo '<pre>';
$a=getimagesize("../img/qin.gif");
var_dump($a);
//-----------------------------------------------
echo '<hr/>';
$b=pathinfo("../img/qin.gif");
var_dump($b);