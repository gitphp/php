<?php 	
        session_start();
        require "../asp/tj/core/data/common2.inc.php";
		require "../asp/commom.func.php";

        $conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	    mysql_select_db($cfg_dbname);
	    mysql_query("set names 'UTF8'");

        //如果是已经生成了订单的，根据订单号获取订单信息
		if(isset($_GET['order_no'])){
            $tradeno = $_GET['order_no'];
            $sql = "select * from order1 where tradeno='$tradeno'";
	        $order = mysql_fetch_assoc(mysql_query($sql));
		    if(!$order){
                exit('对不起，您的订单有误！请重新下单!');
		    }

            extract($order);
        }
		//未生成订单的，先生成订单
		else if(isset($_POST['sf'])){
            //post拦截规则
	        $postfilter = "<.*=(&#\\d+?;?)+?>|<.*data=data:text\\/html.*>|\\b(alert\\(|confirm\\(|expression\\(|prompt\\(|benchmark\s*?\(.*\)|sleep\s*?\(.*\)|load_file\s*?\\()|<[^>]*?\\b(onerror|onmousemove|onload|onclick|onmouseover)\\b|\\b(and|or)\\b\\s*?([\\(\\)'\"\\d]+?=[\\(\\)'\"\\d]+?|[\\(\\)'\"a-zA-Z]+?=[\\(\\)'\"a-zA-Z]+?|>|<|\s+?[\\w]+?\\s+?\\bin\\b\\s*?\(|\\blike\\b\\s+?[\"'])|\\/\\*.*\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)|UPDATE\s*(\(.+\)\s*|@{1,2}.+?\s*|\s+?.+?|(`|'|\").*?(`|'|\")\s*)SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE)(\\(.+\\)|\\s+?.+?\\s+?|(`|'|\").*?(`|'|\"))FROM(\\(.+\\)|\\s+?.+?|(`|'|\").*?(`|'|\"))|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

	        foreach($_POST as $k=>$w)
	        {
		        $_POST[$k] = repHtml($w);		//过滤html标签特殊符号
		        webscan_StopAttack($k, $_POST[$k],$postfilter,"POST");	//过滤sql注入
	        }

	        $item  = $_POST['WIDsubject'];//商品名称
	        // $tradeno = $_POST['WIDout_trade_no'];//交易号
	        $tradeno = 'LY' . date('YmdHis') . mt_rand(10000, 99999);	
	        $price = $_POST['num1'];//单价
	 
	        $num = $_POST['num'];//数量
	        $amount = $_POST['WIDtotal_fee'];//总价格
	        $user = $_POST['user'];//姓名
	        $tel = $_POST['tel'];//电话
	        $sf = $_POST['sf'];//身份证后6位
	        $paytype ='微信';//支付渠道
	

	        $status = '未支付';//订单状态
	        $ordertime = time();//下单时间
	
	
	        //入库
            /*$sql = "select num from order1 where sf='$sf' AND status='已付款'";
	        $oNum = mysql_fetch_row(mysql_query($sql));
	        $numLimit = 9999;
	        $numTem = 0;
	        if($oNum){
                foreach($oNum as $k=>$v){
                    $numTem += $v['num'];
		        }
	        }

            $allowNum = $numLimit - $numTem;
	        $allowNum < 0 && $alllowNum = 0;
	        if($num > $allowNum){
                echo '<form action="buy1.asp" method="post" id="fm1"><input type="hidden" name="n" value="'.$item.'"><input type="hidden" name="p" value="'.$price.'"><input type="hidden" name="name" value="'.$user.'"><input type="hidden" name="sf" value="'.$sf.'"></from><script type="text/javascript">alert("对不起，您最多还能购买的数量是'.$allowNum.'份。谢谢您的支持。");document.getElementById("fm1").submit();</script>';
		        exit;
	        }
			*/

	        $sql  = "insert into order1(item,tradeno,price,num,amount,user,tel,sf,paytype,status,ordertime,ip) values('$item','$tradeno','$price','$num','$amount','$user','$tel','$sf','$paytype','$status','$ordertime','');";
	
	        //exit($sql);
            if(!mysql_query($sql)){
                echo '<script type="text/javascript">alert("对不起，服务器繁忙，请稍后再试！");window.location="http://www.xingyatrip.com/asp/buywx.php?n="'.$item.'&p='.$price.';</script>';
		        exit;
			}
		}

		if(!$tradeno){
            exit('对不起，您的订单有误！请重新下单!');
		}

		//微信支付 start
		require 'WxPayPubHelper.php'; //引入支付类库文件
		require 'WxPay.config.php';   //引入微信接口配置

		//支付配置数据准备
		$payinfo['appid'] = APPID;
		$payinfo['appsecret'] = APPSERCERT;
		$payinfo['mchid'] = MCHID;
		$payinfo['key'] = PAYKEY;
		//使用jsapi接口
		$jsApi = new JsApi_pub($payinfo);
		//=========步骤1：网页授权获取用户openid============
		//通过code获得openid
		if (!isset($_GET['code'])) {
			//触发微信返回code码
			$url = $jsApi->createOauthUrlForCode(urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'?order_no='.$tradeno));
			Header("Location: $url");
		} else {
			//获取code码，以获取openid
			$code = $_GET['code'];
			$jsApi->setCode($code);
			$openid = $jsApi->getOpenId();
			if($openid || !isset($_SESSION['openid'])){
                $_SESSION['openid'] = $openid;
			}
		}
		//$openid = 'oz7OPt9FIf5EpEHTKb3opDBKo5_c'; //餐饮的号
		//$openid = 'oOFlPt2UAjH7d41tKlAm3yB-eV4A';  //中兴的号
		if (empty($openid)) {
			if(isset($_SESSION['openid'])){
				//兼容订单完成后iphone按返回键提示获取openid超时问题，权宜之计
                $openid = $_SESSION['openid'];
			}
			else{
			    exit('获取openid超时,请稍候再试');
			}
		}

		$order_info = $res['data'];
		$goods_info = $res['data'];
		//=========步骤2：使用统一支付接口，获取prepay_id============
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub($payinfo);

		//设置统一支付接口参数
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//spbill_create_ip已填,商户无需重复填写
		//sign已填,商户无需重复填写
		$unifiedOrder->setParameter("openid", "$openid"); //商品描述
		$unifiedOrder->setParameter("body", "$item"); //商品描述
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		$out_trade_no = $tradeno;
		$unifiedOrder->setParameter("out_trade_no", "$out_trade_no"); //商户订单号
		$unifiedOrder->setParameter("total_fee", $amount * 100); //总金额
		$unifiedOrder->setParameter("notify_url", "http://xypay.xingyatrip.com/dwxpay/huid/huidiao.php"); //通知地址
		$unifiedOrder->setParameter("trade_type", "JSAPI"); //交易类型
		//非必填参数，商户可根据实际情况选填
		//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
		//$unifiedOrder->setParameter("device_info","XXXX");//设备号
		//$unifiedOrder->setParameter("attach","XXXX");//附加数据
		//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
		//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
		//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
		//$unifiedOrder->setParameter("openid","XXXX");//用户标识
		//$unifiedOrder->setParameter("product_id","XXXX");//商品ID

		$prepay_data = $unifiedOrder->getPrepayId();
		if ($prepay_data['ret'] == 0) {
			$prepay_id = $prepay_data['data'];
		} else {
			exit($prepay_data['data']);
		}
		//=========步骤3：使用jsapi调起支付============
		$jsApi->setPrepayId($prepay_id);

		$jsApiParameters = $jsApi->getParameters();

		$data['jsApiParameters'] = $jsApiParameters;

		//微信支付 end
		//$data['order_info'] = $order_info;
		//$data['goods_info'] = $goods_info;
		 //echo $jsApiParameters;exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=640, user-scalable=no">
<title>确认订单</title>
<style>
* {margin:0; padding:0;}
html, body {width:100%; height:100%;}
body {margin:0 auto; width:640px; background-color:#fafafa; font-family:"微软雅黑";}
input {-webkit-appearance:none; -webkit-tap-highlight-color:rgba(0,0,0,0); border:0 none; font:36px/1 sans-serif;}

.quan{
	width:640px;
	margin:0px;
	background-color:#FFF;
	font-family:"微软雅黑";}
.box{
	width:500px;
	padding-top:50px;
	margin:0px auto;
	}
.box_4{
	text-align:left;
	font-size:36px;
	color:#545454;}
.box_4_1{
	margin-top:20px;
	color:#545454;
	float:left;
	height:50px;
	font-size:36px;}
.xx{
	width:100%;
	padding-top:30px;
	font-size:36px;
	float:left;
	text-align:left;
	color:#545454;}
.box_xx_1{
	width:100%;
	float:left;
	font-size:24px;
	text-align:center;
	background-color:#ebebeb;
	padding-top:10px;
	padding-bottom:10px;
	color:#545454;
	border-top:1px solid #666666;
	border-left:1px solid #666666;
	border-right:1px solid #666666;}	
.box_xx_2{
	width:100%;
	float:left;
	font-size:24px;
	text-align:center;
	padding-top:14px;
	padding-bottom:14px;
	color:#ee0000;
	font-weight:bold;
	border-top:1px solid #666666;
	border-left:1px solid #666666;
	border-right:1px solid #666666;}
.box_xx_3{
	width:100%;
	height:50px;
	padding-top:3px;
	float:left;
	color:#FFFFFF;
	font-size:34px;
	background-color:#969792;}
.box_xx_4{
	margin-top:30px;
	width:100%;
	float:left;
	font-size:36px;
	text-align:left;
	color:#191919;}	
.box_xx_5{
	margin-top:30px;
	width:100%;
	float:left;
	font-size:36px;
	text-align:left;
	color:#FF0000;
	font-weight:bold;}
.box_button{
	margin-top:50px;
	width:100%;
	float:left;
	height:60px;
	background-color:#299afb;
	text-align:center;
	padding-top:12px;
	font-size:34px;
	color:#FFFFFF;
	font-weight:bold;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;}
.srk{
	width:97%;
	height:50px;
	border:1px #545454 solid;
	font-size:24px;
	background-color:#f2f2f2;
	padding-left:3%;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;}
.top{
	width:100%;
	float:left;
	font-size:34px;
	text-align:center;
	background-image:url(images/jt.png);
	background-repeat:no-repeat;
	float:left;
	background-color:#299afb;
	padding-top:10px;
	padding-bottom:10px;
	margin-bottom:50px;
	color:#fff;}
</style>
 <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters;?>,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    // alert(res.err_msg);
                    // alert('<?php echo $jsApiParameters;?>');
                    // alert(res.err_code);
                    // alert(res.err_desc);
                    if(res.err_msg=='get_brand_wcpay_request:ok'){
                        window.location.href ="http://xypay.xingyatrip.com/dwxpay/payRes.php?order_no=<?php echo $tradeno; ?>";
						//alert('支付成功');
                    }
                }
            );
        }
        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
<body class="bgc2">
<div class="quan">
	<div class="top">确认订单</div>
  <div class="box">
		<div style="border-left:1px solid #666666; border-right:1px solid #666666; background-color:#fff;">
			<div class="box_xx_1">商品名称</div>
			<div class="box_xx_2"><?php echo $item; ?></div>
			<div class="box_xx_1">有效期</div>
			<div class="box_xx_2">购买之日起，一年内有效，出行前15天预约即可。</div>
			<div class="box_xx_1">订单号</div>
			<div class="box_xx_2"><?php echo $tradeno; ?></div>
			<div class="box_xx_1">单价</div>
			<div class="box_xx_2" style="border-bottom:1px solid #666666;"><?php echo $price; ?>元</div>
		</div>
		<div class="box_4">
			<div class="box_4_1" >姓名</div>
			<div class="box_xx_3">&nbsp;<?php echo $user; ?></div>
			<div class="box_4_1" >手机号</div>
			<div class="box_xx_3">&nbsp;<?php echo $tel; ?></div>
			<div class="box_4_1">身份证后六位</div>
			<div class="box_xx_3">&nbsp;<?php echo $sf; ?></div>

		</div>
		<div class="box_xx_4">数量：<?php echo $num; ?></div>
		<div class="box_xx_5">合计：<?php echo $amount; ?>元</div>
		<div class="box_button" onclick="wxsubmit()">确定付款</div>
		<div style="height:100px; width:10px; float:left;"></div>
  </div>
</div>
</body>
<script>
    function wxsubmit(){
        callpay();
    }
</script>
</html>