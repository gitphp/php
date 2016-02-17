<?php
// 微信自定义菜单文件（l联网访问）
//860eb808259daf6704620bf4c850259e
//{"access_token":"6ppqO-e7PD7Ppz0Q-xwRfHafqNahl8G2VxkqeTuFTIMNeJLGre8IT01-gilrr6USRYJPLxPRO-PxHR2UYKv6s4_G4ecL5gF7US5KBwU8BWU","expires_in":7200}
//初始化
$ch = curl_init();
//设置参数
$url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=6ppqO-e7PD7Ppz0Q-xwRfHafqNahl8G2VxkqeTuFTIMNeJLGre8IT01-gilrr6USRYJPLxPRO-PxHR2UYKv6s4_G4ecL5gF7US5KBwU8BWU';
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
//禁止腾讯服务器端校验SSL证书
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_POST,1);
$data = '{
     "button":[
      {
           "name":"最新资讯",
           "sub_button":[
           {
               "type":"click",
               "name":"最新动态",
               "key":"news"
            },
            {
               "type":"click",
               "name":"最新产品",
               "key":"goods"
            },
            {
               "type":"click",
               "name":"随机音乐",
               "key":"music"
            }]
       },
	  {
           "name":"实用查询",
           "sub_button":[
           {
               "type":"click",
               "name":"最新电影",
               "key":"movie"
            },
            {
               "type":"click",
               "name":"天气查询",
               "key":"weather"
            },
            {
               "type":"click",
               "name":"酒店查询",
               "key":"hotel"
            }]
       },
	  {
          "type":"view",
          "name":"公司主页",
          "url":"http://www.juulu.com/"
      }]
 }';
curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
//执行curl
$output = curl_exec($ch);
//判断执行是否成功
if($output === false){
    echo curl_error($ch);
}else{
    echo $output;
}
//关闭curl
curl_close($ch);
