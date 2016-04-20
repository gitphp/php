<?php
/**
 * www.juulu.com.
 * User: 支付宝类。基于THinkPHP3.2.3版本
 * Date: 16-04-19 上午9:18
 */
namespace Org\Pay;
class Alipay{
    private $config = array();
    private $notify_url = '';
    private $return_url = '';
    private $dir        = '';
    private $host       = '';
    public function __construct(){
        $this->config = array(
            //合作身份者id，以2088开头的16位纯数字
            'partner'        => '',
            //安全检验码，以数字和字母组成的32位字符
            'key'           => '',
            //签名方式 不需修改
            'sign_type'     => strtoupper('MD5'),
            //字符编码格式 目前支持 gbk 或 utf-8
            'input_charset' => strtolower('utf-8'),
            //ca证书路径地址，用于curl中ssl校验
            //请保证cacert.pem文件在当前文件夹目录中
            'cacert'        => getcwd().'\\Core\\Library\\Org\\Pay\\Alipay\\cacert.pem',
            //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
            'transport'     => 'http'
        );
        $this->dir = dirname(__FILE__).'/Alipay/';
        $this->host = 'http://'.$_SERVER['HTTP_HOST'];
        $this->return_url = $this->host.U('Member/notify');    //跳转的URL地址
    }
    public function pay($data){
        //构造要请求的参数数组，无需改动
        require_once($this->dir.'alipay_submit.class.php');
        $parameter = array(
            "service"           => "create_direct_pay_by_user",
            "partner"           => trim($this->config['partner']),
            "payment_type"      => 1,//支付类型
            "notify_url"        => $this->notify_url, //服务器异步通知页面路径
            "return_url"        => $this->return_url,//页面跳转同步通知页面路径
            "seller_email"      => '',//卖家支付宝帐户,
            "seller_id"         => trim($this->config['partner']),
            "out_trade_no"      => $data['WIDout_trade_no'], //商户订单号
            "subject"           =>  $data['WIDsubject'],//订单名称
            "total_fee"         => $data['WIDtotal_fee'], //付款金额
            "body"              => $data['WIDbody'], //订单描述 
            "show_url"          => $this->host.$data['WIDshow_url'], //商品展示地址
            "anti_phishing_key" => '',//防钓鱼时间戳
            "exter_invoke_ip"   => get_client_ip(),//客户端的IP地址
            "_input_charset"    => trim(strtolower($this->config['input_charset']))
        );
        //建立请求
        $alipaySubmit = new  \Org\Pay\Alipay\AlipaySubmit($this->config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"post", "请稍候，正在跳转至付款页面");
        return $html_text;
    }
    public function Alipay_notify(){
        require_once($this->dir.'alipay_notify.class.php');
        //计算得出通知验证结果
        $alipayNotify = new \Org\Pay\Alipay\AlipayNotify($this->config);
        $verify_result = $alipayNotify->verifyNotify();
        if($verify_result) {//验证成功
            
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
 
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
 
            //交易状态
            $trade_status = $_POST['trade_status'];
 
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
 
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
 
            }
 
            echo "success";        //请不要修改或删除
 
            
 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "fail";
 
        }
    }
    public function Alipay_return(){
        require_once($this->dir.'alipay_notify.class.php');
        //计算得出通知验证结果
        $alipayNotify = new \Org\Pay\Alipay\AlipayNotify($this->config);
        $verify_result = $alipayNotify->verifyReturn();
        if($verify_result) {//验证成功
            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];
 
            //支付宝交易号
            $trade_no = $_GET['trade_no'];
 
            //交易状态
            $trade_status = $_GET['trade_status'];
            if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                return array(
                    'order_no' => $_GET['out_trade_no'],//订单号
                    'title'    => $_GET['subject'],//订单名称
                    'total_fee' => $_GET['total_fee'],//金额
                    'buyer'     => $_GET['buyer_email'],//买家email
                    'notify_time' => $_GET['notify_time'],//交易时间
                    'trade_no'    => $_GET['trade_no'] //淘宝交易号
                );
            }
            else {
                return false;
            }
        }
        else {
           return false;
    }
    }
}