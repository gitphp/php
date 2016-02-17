<?php
if(file_exists('a.html') && filemtime('a.html')+20>time()){
	include './a.html';exit;
}
ob_start();
header('content-type:text/html;charset=utf-8');
mysql_connect('localhost','root','root');
mysql_query('set names utf8');
mysql_query('use shopping');
$sql="select * from es_messages limit 5";
$data=array();
$res=mysql_query($sql);
while($row=mysql_fetch_assoc($res)){
	$data[]=$row;
	echo $row['m_title'];
}

// var_dump($data);
$str=ob_get_contents();
// echo '111';
// var_dump($str);
file_put_contents('./a.html',$str);