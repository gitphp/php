<?php
header('Content-type:text/html;charset=utf-8');

function doubi($msg){
    echo "<pre style='color:red;'>";
    var_dump($msg);
    echo "</pre>";
}


// phpcms 唯一项目入口文件
// define('APP_NAME','cms');
define('APP_PATH','./Cms/');

define('APP_DEBUG', true);

require_once './ThinkPHP/ThinkPHP.php';










