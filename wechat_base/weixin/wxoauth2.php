<?php
class wxoauth2 {
    public static function get_login_url($appid, $callbackurl, $scope='snsapi_base') {
        $appid = trim($appid);
        $_SESSION['wx_state'] = md5(microtime(true).'vsapp');
        $login_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($callbackurl).'&response_type=code&scope='.$scope.'&state='.$_SESSION['wx_state'].'#wechat_redirect';
        return $login_url;
    }
    public static function get_access_token($appid, $secret) {
    	$appid = trim($appid);
        $secret = trim($secret);
        if(isset($_REQUEST["code"]) && $_REQUEST["code"] && isset($_REQUEST['state']) && $_REQUEST['state'] && $_REQUEST['state'] == $_SESSION['wx_state']) {
            $_SESSION['wx_state'] = '';
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$_REQUEST["code"].'&grant_type=authorization_code';
            $_SESSION['wx_access_token'] = json_decode(file_get_contents($url), true);
            return $_SESSION['wx_access_token'];
        }
        
        $_SESSION['wx_state'] = '';
        return false;
    }
    public static function get_userinfo() {
        if(empty($_SESSION['wx_access_token']) || $_SESSION['wx_access_token']['scope'] != 'snsapi_userinfo') {
            return false;
        }
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$_SESSION['wx_access_token']['access_token'].'&openid='.$_SESSION['wx_access_token']['openid'].'&lang=zh_CN';
        $res = file_get_contents($url);
        return json_decode($res, true);
    }
}