<?php
/*替换为你自己的数据库名*/
$dbname = 'voyzpJYEAtPTPEBPIUmX';
/*填入数据库连接信息*/
$host = 'sqld.duapp.com';
$port = 4050;
$user = 'Nb2OnGASUOglDOe3qMwHq0ls';//用户名(api key)
$pwd = 'rQ3L6LvR9TjSp9roIwzNZIdykj57aXLY';//密码(secret key)
 /*以上信息都可以在数据库详情页查找到*/
 
/*接着调用mysql_connect()连接服务器*/
$link = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
if(!$link) {
    die("Connect Server Failed: " . mysql_error());
}
/*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
if(!mysql_select_db($dbname,$link)) {
    die("Select Database Failed: " . mysql_error($link));
}