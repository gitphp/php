<?php
$act=isset($_GET['act'])?$_GET['act']:'';
$conn = mysql_connect("localhost",'root','root');
mysql_query("use bbs");
mysql_query("set names utf8");

if($act=='add'){
	//
	$title=$_POST['title'];
	$content=$_POST['content'];
	$sql="insert into news (title,content) values('{$title}','{$content}')";
	mysql_query($sql);
	$id=mysql_insert_id();
	
	if(!$id){
		//失败，生成静态页面
		die();
	}
	//编址文件名字
	$dir=date('Ym/d');
	$path='../a/'.$dir;
	if(!is_dir($path)){
		mkdir($path,0777,true);
	}
	$filepath=$path.'/news_id_'.$id.'.html';
	$datapath='./a/'.$dir.'/news_id_'.$id.'.html';
	$sql="update news set filename='{$datapath}' where id='{$id}'";
	mysql_query($sql);
	// echo $filepath;exit;
	//打开模板文件
	$temp=fopen('tpl.html','r');
	$html=fopen($filepath,'w');
	// 循环替换模板
	while(!feof($temp)){
		$row=fgets($temp);
		$row=str_replace('%title%',$title,$row);
		$row=str_replace('%content%',$content,$row);
		fwrite($html,$row);
	}
	
	fclose($temp);
	fclose($html);
	echo 'ok';
	
	
}elseif($act=='del'){
	
	//
} 