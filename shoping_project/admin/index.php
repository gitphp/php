<?php
// 网站单一入口index.php
// 访问index.php页面，带参数m=module模块，a=action动作
define('ACCESS','shoping');			//定义常量判断用户是否非法访问
// 引入核心初始化文件
require_once ("./Core/Application.class.php");

Application::run();
// echo 'index.php';