<?php

/**
 * 微信自定义菜单文件（联网访问）【服务号】
 * 账号：星雅假日信息科技
 * 55e736d4991d80b13e7cf71042ce39b7
 * 星雅假日投资发展公司公众号【服务号】
 * 账号：xytrip333@163.com
 * 密码：xytrip333
 * Addtime: 2016-04-18 17:05:21 
 *
 */

//初始化
$ch = curl_init();
//设置参数
$url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=VXtXN9cN5KbDlyCZ8Toe85vnz_-aeUiG9F2OicOwUxfWNB_nRnAyHrbvWUKVVXO1CLIP6s851yFYsictZnSBONFgedW4-MWTp4ghE1RLfiTpS6f_3Q_js4YRKfH29ytZKLOeCDANOR';
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
//禁止腾讯服务器端校验SSL证书
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_POST,1);


function curl_post($url, $data) {
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    //禁止腾讯服务器端校验SSL证书
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

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

}


$data = '{
     "button":[
      {
           "name":"线路推荐",
           "sub_button":[
           {
               "type":"view",
               "name":"曼芭·泰爱之旅",
               "url":"http://www.xingyatrip.com/wx/thailand/index.html"
            },
            {
               "type":"view",
               "name":"记忆中那抹普吉蓝",
               "url":"http://www.xingyatrip.com/wx/puket/index.html"
            },
            {
               "type":"view",
               "name":"韩国梦幻之旅",
               "url":"http://www.xingyatrip.com/wx/korea/index.html"
            },
            {
               "type":"view",
               "name":"百变巴厘阳光假期",
               "url":"http://www.xingyatrip.com/wx/bali/index.html"
            }]
      },
      {
          "type":"view",
          "name":"斯里兰卡",
          "url":"http://www.xingyatrip.com/sllk/wx.html"
      },
	    {
          "type":"click",
          "name":"电话咨询",
          "key":"kefu"
      }
	    ]
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

// oJLF9t2XTFcuNkHyMrAN1Rv1-VoE

// {"access_token":"VXtXN9cN5KbDlyCZ8Toe85vnz_-aeUiG9F2OicOwUxfWNB_nRnAyHrbvWUKVVXO1CLIP6s851yFYsictZnSBONFgedW4-MWTp4ghE1RLfiTpS6f_3Q_js4YRKfH29ytZKLOeCDANOR","expires_in":7200}
//https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx05399835f11281d7&secret=55e736d4991d80b13e7cf71042ce39b7











