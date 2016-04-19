<?php
/**
 * 微信自定义菜单文件（联网访问）【服务号】
 * 账号：星雅假日信息科技
 * 星雅假日常用微信公众号【订阅号】
 * 微信：
 * 密码：
 * Addtime: 2016-04-18 17:05:21 
 *
 */

//初始化
$ch = curl_init();
//设置参数
$url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=rmFjAJV5B2l-OVp0Sz0IuuqSZ6vM8x6Qz2DiPhIFQGiZuBBmKvgxoGIFLRAvS8PIcRSvsu9vaP6UZrwRAGb97Oi3hoEpnDKdGBm_FcGP44XtySxHFtavZObk7mNLS9O6VEBjCIAFOL';

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
          "type":"view",
          "name":"轻商城",
          "url":"https://wap.koudaitong.com/v2/feature/jmvfextq"
      },
      {
           "name":"有料",
           "sub_button":[
           {
               "type":"click",
               "name":"活动精选",
               "key":"huodong"
            }
            ]
      },
	    {
           "name":"我们是",
           "sub_button":[
           {
               "type":"view",
               "name":"品牌故事",
               "url":"http://mp.weixin.qq.com/mp/homepage?__biz=MjM5MzIxNjI2NQ==&hid=1&sn=af1a03a3557525dce86e0b0f82b370ef#wechat_redirect"
            },
            {
               "type":"view",
               "name":"官方微博",
               "url":"http://weibo.com/u/3171383882?is_hot=1"
            },
            {
               "type":"click",
               "name":"联系客服",
               "key":"kefu"
            },
            {
               "type":"click",
               "name":"星雅团队",
               "key":"tuandui"
            }]
      }
	    ]
 }';

curl_post($url, $data);

// oJLF9t2XTFcuNkHyMrAN1Rv1-VoE
// {"access_token":"rmFjAJV5B2l-OVp0Sz0IuuqSZ6vM8x6Qz2DiPhIFQGiZuBBmKvgxoGIFLRAvS8PIcRSvsu9vaP6UZrwRAGb97Oi3hoEpnDKdGBm_FcGP44XtySxHFtavZObk7mNLS9O6VEBjCIAFOL","expires_in":7200}
// {"access_token":"d50r63U_AW-Hw89GUpKDGuzExDr6fwzfUD9S6MMhT7Q5_XbvetBMjLDLJk_TGaC_v67GIyDiFhmDLnoCnTGhmJmqJMugoiZV_dD2h7mWDJlXCgzBcGiIm89Ueoa0urtyMYXiCHASED","expires_in":7200}
//https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx05399835f11281d7&secret=55e736d4991d80b13e7cf71042ce39b7











