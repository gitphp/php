<?php
return array(
	//'配置项'=>'配置值'
    'DEFAULT_CHARSET'       =>  'utf-8', // 默认输出编码
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '120.25.122.113', // 服务器地址
    'DB_NAME'               =>  'yang_blog',    // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'w9b7yaso1ei',      // 密码
    'DB_PORT'               =>  '3306',      // 端口
    'DB_PREFIX'             =>  'bk_',          // 数据库表前缀
    
    //设置模块访问列表，后台wife
    'MODULE_ALLOW_LIST'    => array('Home','Wife'),
    'DEFAULT_MODULE'       => 'Home',
    
    
    // 显示页面Trace信息
    'SHOW_PAGE_TRACE' =>true, 
    //URL伪静态
	// 'URL_HTML_SUFFIX'=>'html',
	'URL_HTML_SUFFIX'=>'shtml',
    
    //'ACTION_SUFFIX'         =>  'Action', // 操作方法后缀
    
    'URL_CASE_INSENSITIVE' =>false, //URL地址区分大小写
    
    //'ACTION_BIND_CLASS' =>true,
);