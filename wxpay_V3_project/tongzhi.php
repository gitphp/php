<?php
 //方倍工作室

include_once("WxPayPubHelper/WxPayPubHelper.php");

 //1. 获取access token
 $appid = "wx05399835f11281d7";
 $appsecret = "55e736d4991d80b13e7cf71042ce39b7";
 $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
 $result = https_request($url);
 $jsoninfo = json_decode($result, true);
 $access_token = $jsoninfo["access_token"];



 //2.准备参数
 $deliver_timestamp = time();
 //2.1构造最麻烦的app_signature
 $obj['appid']               = $appid;
 $obj['appkey']              = "7Xkakynopxcplr7Av1AdR6PQBYlDtulMES5s96JBiuP1KsJd1kXeSyojMCDU1KFikaxYCkMgHlcRYe8fDWYJGJLT1o1430WhfgBMCZmkUzaLVEemkwG7K0xQSZd48Pq3";
 $obj['openid']              = "oOFlPtyYEO9hF_DSEUrHlpPDbIzw";
 $obj['transid']             = "1220729301201409293192194354";
 $obj['out_trade_no']        = "4113809675977447400";
 $obj['deliver_timestamp']   = $deliver_timestamp;
 $obj['deliver_status']      = "1";
 $obj['deliver_msg']         = "ok";


//sign:8764951AA15B4ED17E809A4B2A132256
$WxPayHelper = new Common_util_pub();
$app_signature = $WxPayHelper->getSign($obj);
echo $app_signature."<br>";

$jsonmenu = '{
	 
     "appid" : "'.$obj['appid'].'",
	 "openid" : "'.$obj['openid'].'",
     "transid" : "'.$obj['transid'].'",
     "out_trade_no" : "'.$obj['out_trade_no'].'",
     "deliver_timestamp" : "'.$deliver_timestamp.'",
     "deliver_status" : "'.$obj['deliver_status'].'",
     "deliver_msg" : "'.$obj['deliver_msg'].'",
     "app_signature" : "'.$app_signature.'", 
     "sign_method" : "sha1"
 }';


 $url = "https://api.weixin.qq.com/pay/delivernotify?access_token=".$access_token;

 $result = https_request($url, $jsonmenu);
 echo "<pre>";
 var_dump($jsonmenu);
 var_dump($result);exit;

 function https_request($url, $data = null){
     $curl = curl_init();
     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
     if (!empty($data)){
         curl_setopt($curl, CURLOPT_POST, 1);
         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
     }
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     $output = curl_exec($curl);
     curl_close($curl);
     return $output;
 }

