<?php 
include_once("WxPayHelper.php");

//$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
//$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);


$appid = "wx05399835f11281d7";
 $appsecret = "55e736d4991d80b13e7cf71042ce39b7";
 $openid = 'oOFlPtyYEO9hF_DSEUrHlpPDbIzw';
$transid =  '1220729301201409293192194354';
$out_trade_no = '4113809675977447400';



 $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
 $result = https_request($url);
 $jsoninfo = json_decode($result, true);
 
 $access_token = $jsoninfo["access_token"];



//* 向用户推送发货信息 *
$d['deliver_timestamp'] = time();
$d['appid']          = $appid;
$d['appkey']         = $appkey;
$d['openid']         = $openid;
$d['transid']        = $transid;
$d['out_trade_no']   = $out_trade_no;
$d['deliver_status'] = "1";
$d['deliver_msg']    = "OK";

	$obj = $b;
//向购买支付成功的用户发送 发货信息
function send_fahuo($obj){
	
	$WxPayHelper = new WxPayHelper();
	//$sign = $WxPayHelper->get_sign($obj);
	
	$txt = '{
		"appid" : "'.$obj['appid'].'", 
		"openid" : "'.$obj['openid'].'", 
		"transid" : "'.$obj['transid'].'", 
		"out_trade_no" : "'.$obj['out_trade_no'].'", 
		"deliver_timestamp" : "'.$obj['deliver_timestamp'].'", 
		"deliver_status" : "'.$obj['deliver_status'].'", 
		"deliver_msg" : "'.$obj['deliver_msg'].'", 
		"app_signature" : "'.$sign.'", 
		"sign_method" : "sha1"
	}';		
	


	 $url = "https://api.weixin.qq.com/pay/delivernotify?access_token=".$access_token;
 $result = https_request($url, $txt);
 var_dump($result);

/*
	$wx = new weixinbase();
	$access_token = $wx->get_access_token();
	$url = "https://api.weixin.qq.com/pay/delivernotify?access_token=".$access_token;
	$status = $wx->https_post($url,$txt);
	$status = json_decode($status);
	if($status->errmsg=="ok"){
		//如果发货成功，则向客服发送微信文本信息
		$msgcontent = "尊敬的用户，我们已经收到订单号：".$obj['out_trade_no']." 支付成功订单，请耐心等待客服发货哦！ ";
		$wx->kefu_response($obj['openid'],$msgcontent);
	}
	return $status->errmsg;

	*/
}

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

//生成后台通知 	
$s_status = send_fahuo($d);	
echo "suceess";
?>
