<?php
include_once("WxPayHelper.php");


$commonUtil = new CommonUtil();
$wxPayHelper = new WxPayHelper();

/////////////////////
if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) 
{ 
$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]; 
} 
elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]) 
{ 
$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"]; 
}
elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]) 
{ 
$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"]; 
} 
elseif (getenv("HTTP_X_FORWARDED_FOR")) 
{ 
$ip = getenv("HTTP_X_FORWARDED_FOR"); 
} 
elseif (getenv("HTTP_CLIENT_IP")) 
{ 
$ip = getenv("HTTP_CLIENT_IP"); 
} 
elseif (getenv("REMOTE_ADDR"))
{ 
$ip = getenv("REMOTE_ADDR"); 
} 
else 
{ 
$ip = "Unknown"; 
} 
/////////////////////
$wxPayHelper->setParameter("bank_type", "WX");
$wxPayHelper->setParameter("body", "wsd");
$wxPayHelper->setParameter("partner", "1220729301");
$wxPayHelper->setParameter("out_trade_no", $commonUtil->create_noncestr());
$wxPayHelper->setParameter("total_fee", "1");
$wxPayHelper->setParameter("fee_type", "1");
$wxPayHelper->setParameter("notify_url", "http://www.xingyatrip.com/dwxpay/fahuo.php");
$wxPayHelper->setParameter("spbill_create_ip", $ip);
$wxPayHelper->setParameter("input_charset", "utf-8");



/*
$packageVar =  $wxPayHelper->create_biz_package();
echo  $packageVar;*/

?>
<html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<script language="javascript">
function callpay()
{   
	WeixinJSBridge.invoke('getBrandWCPayRequest',<?php echo  $wxPayHelper->create_biz_package() ?>,function(res){
	WeixinJSBridge.log(res.err_msg);
	//alert(res.err_code+res.err_desc+res.err_msg);
	});
}
</script>
<body>
<button type="button" onClick="callpay()">wx wsd pay test</button>
</body>
</html>
