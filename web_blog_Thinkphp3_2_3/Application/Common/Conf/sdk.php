<?php
/**
* 等三方登陆插件配置
* @date: 2015年10月17日
* @author: Administrator
* @return:
*/
$SITE_URL = "http://loveteemo.com/";
define('URL_CALLBACK', "" . $SITE_URL . "Home/Common/callback?type=");
return array(    
    #腾讯QQ登录配置
    'THINK_SDK_QQ' => array(
        'APP_KEY' => '101232670', # APP ID
        'APP_SECRET' => '47d496c5cab11fad38b140e19084977f', # KEY
        'CALLBACK' => URL_CALLBACK . 'qq',
    ),
    
);