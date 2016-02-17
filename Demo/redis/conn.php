<?php
// 实例化对象
$r=new Redis();
// 链接redis数据库
$r->connect('192.168.114.237');

// 输入密码
// $r->auth('');
// $r->set('b','bbbb');


if($r->set('b','bbbb')){
	echo 'ok';
}else{
	echo 'error';
} 
