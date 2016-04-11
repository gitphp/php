<?php
class wxpay {
    
    //支付回调，AppSignature验证
    public static function appsignature_chk($paysignkey) {
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"])?$GLOBALS["HTTP_RAW_POST_DATA"]:'';
        $xmlobj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmlobj = (Array) $xmlobj;
        $post_arr = array();
        foreach($xmlobj as $k=>$v) {
            $post_arr[strtolower($k)] = $v;
        }
        $AppSignature = $post_arr['appsignature'];
        unset($post_arr['appsignature']);
        unset($post_arr['signmethod']);
        $post_arr['appkey'] = $paysignkey;
        ksort($post_arr);
        $query_arr = array();
        foreach($post_arr as $k=>$v) {
            $query_arr[] = $k.'='.$v;
        }
        $signature_str = implode('&', $query_arr);
        $signature_value = sha1($signature_str);
        if($signature_value != $AppSignature) {
            return false;
        }else {
            return $post_arr;
        }
    }
    
    //支付回调，sign验证
    public static function sign_chk($partnerkey) {
        if(!isset($_GET['sign'])) {
            return false;
        }
        $get_sign = $_GET['sign'];
        $get_arr = $_GET;
        unset($get_arr['sign']);
        ksort($get_arr);
        $query_arr = array();
        foreach($get_arr as $k=>$v) {
            $query_arr[] = $k.'='.$v;
        }
        $string1 = implode('&', $query_arr);
        $string1 .= '&key='.$partnerkey;
        $sign_value = strtoupper(md5($string1));
        $notifyargs = '&sign='.$sign_value;
        if($sign_value != $get_sign) {
            return false;
        }else {
            return $get_arr;
        }
    }
    
    //共享地址接口，生成package
    public static function create_addr_package($appid, $access_token) {
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $params = array(
        'appId'=>"$appid",
        'url'=>$url,
        'timeStamp'=>'"'.time().'"',
        'nonceStr'=>'"'.rand(100000,999999).'"',
        'accessToken'=>$access_token
        );
        ksort($params);
        $query_arr = array();
        foreach($params as $k=>$v) {
            $query_arr[] = strtolower($k).'='.$v;
        }
        $string1 = implode('&', $query_arr);
        $addrSign = sha1($string1);
        
        unset($params['accessToken'], $params['url']);
        $params['scope'] = 'jsapi_address';
        $params['signType'] = 'sha1';
        $params['addrSign'] = $addrSign;
        return json_encode($params);
    }
    
    //生成支付 package
    public static function create_biz_package($appid, $paysignkey, $partnerid, $partnerkey, $notify_url, $order_subject, $order_num, $order_amount) {
        include_once(k::$ROOT_PATH.'third_party/wxpay/WxPayHelper.php');
        $wxPayHelper = new WxPayHelper();
        $wxPayHelper->setParameter("bank_type", "WX");
        $wxPayHelper->setParameter("appid", $appid);
        $wxPayHelper->setParameter("paysignkey", $paysignkey);
        $wxPayHelper->setParameter("signtype", "sha1");
        $wxPayHelper->setParameter("body", $order_subject);
        $wxPayHelper->setParameter("partner", $partnerid);
        $wxPayHelper->setParameter("partnerkey", $partnerkey);
        $wxPayHelper->setParameter("out_trade_no", $order_num);
        $wxPayHelper->setParameter("total_fee", $order_amount*100);
        $wxPayHelper->setParameter("fee_type", "1");
        $wxPayHelper->setParameter("notify_url", $notify_url);
        $wxPayHelper->setParameter("spbill_create_ip", std::getonlineip());
        $wxPayHelper->setParameter("input_charset", "GBK");
        
        return $wxPayHelper->create_biz_package();
    }
}