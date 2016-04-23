<?php
 //file_put_contents('test.txt',date('Y-m-d H:i:s'));
 
/*foreach ($_GET as $key=>$value)  
{
    logger("Key: $key; Value: $value");
}
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
logger($postStr);

if (isset($_GET)){
    echo "success";
}*/
		require '../WxPayPubHelper.php'; //引入支付类库文件
		require '../WxPay.config.php'; //引入支付类库文件
		require "../../asp/tj/core/data/common2.inc.php";
		require "../../asp/sendOnce.php";
		//微信支付的参数

		//支付配置数据准备
		$payinfo['mchid'] = MCHID;
		$payinfo['key'] = PAYKEY;
		//使用通用通知接口
		$notify = new Notify_pub($payinfo);
		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$notify->saveData($xml);

		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if ($notify->checkSign() == FALSE) {
			$notify->setReturnParameter("return_code", "FAIL"); //返回状态码
			$notify->setReturnParameter("return_msg", "签名失败"); //返回信息
		} else {
			$notify->setReturnParameter("return_code", "SUCCESS"); //设置返回码
		}
		$returnXml = $notify->returnXml();
		echo $returnXml;

		//==商户根据实际情况设置相应的处理流程，此处仅作举例=======

		if ($notify->checkSign() == TRUE) {
			if ($notify->data["return_code"] == "FAIL") {
				//通信出错
			} elseif ($notify->data["result_code"] == "FAIL") {
				//业务出错
			} else {
				//支付成功更新订单状态 start
				$tradeno = $notify->data['out_trade_no']; //从通知消息中获取订单号
				//$transaction_id = $notify->data['transaction_id']; //从通知消息中获取微信支付订单号
				//$return_code = $notify->data['return_code']; //从通知消息中获取返回状态码
				$notify_id = ''; //微信支付没有通知消息id

                $conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	            mysql_select_db($cfg_dbname);
	            mysql_query("set names 'UTF8'");

                $sql = "update order1 set status='已付款' where tradeno='$tradeno'";
	            $res = mysql_query($sql);
				if ($res) {
                    $sql = "select * from order1 where tradeno='$tradeno' AND status='已付款'";
	                $order = mysql_fetch_assoc(mysql_query($sql));			        
					if ($order) {
						//发信息
                        $c = "尊敬的".$order['user']."：您好！您的订单".$order['tradeno']."已付款，恭喜您成功申购".$order['item'].$order['num']."份，".date('Y年m月d日',strtotime("+1 year"))."前有效。请至少提前15个工作日致电客服中心，预约出行成功后，再订机票。服务热线：4000-619-388";
                        $m = $order['tel'];
	            		$res = sendSMS($url,$ac,$authkey,$cgid,$m,$c,$csid,$t);
						if($res){
					         file_put_contents('sms.log',$order['tradeno'].'sms send fail---'.date('Y-m-d H:i:s')."\r\n",FILE_APPEND);
						}
					}
					echo "SUCCESS"; //返回给微信的状态码
				}
				//更新订单状态 end
			}

		}
//日志记录
function logger($log_content)
{
    $max_size = 100000;
    $log_filename = "log.xml";
    if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
    file_put_contents($log_filename, date('Y-m-d H:i:s')." ".$log_content."\r\n", FILE_APPEND);
}

 ?>