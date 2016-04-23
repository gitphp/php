<?php  
    if(isset($_GET['order_no'])){
        require "../asp/tj/core/data/common2.inc.php";

        $conn = mysql_connect($cfg_dbhost,$cfg_dbuser,$cfg_dbpwd);
	    mysql_select_db($cfg_dbname);
	    mysql_query("set names 'UTF8'");

        $tradeno = $_GET['order_no'];
        $sql = "select * from order1 where tradeno='$tradeno' AND status='已付款'";
	    $order = mysql_fetch_assoc(mysql_query($sql));
		if(!$order){
            exit('服务器正在同步您的付款数据，如果您已经付款成功，稍后会短信通知您，谢谢！');
		}
        
        extract($order);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=640, user-scalable=no">
<title>购买成功</title>
<style type="text/css">
* {margin:0; padding:0;}
html, body {width:100%; height:100%;}
body {margin:0 auto; width:640px; overflow:hidden; font-family:"微软雅黑";}
input {-webkit-appearance:none; -webkit-tap-highlight-color:rgba(0,0,0,0); border:0 none; font:36px/1 sans-serif;}

#content {height:100%; background:url(images/b5.jpg)}

.box{
	width:72%;
	padding-top:20px;
	margin:0px auto;
	}
.box_7{
	margin-top:10px;
	text-align:center;
	font-size:32px;
	color:#515151;}
.box_8{
	margin-top:25px;
	text-align:center;
	font-size:26px;
	color:#515151;}
.box_9{
	margin-top:10px;
	text-align:center;
	font-size:36px;
	color:#0f6959;
	font-weight:bold;}
.box_10{
	margin-top:20px;
	text-align:center;
	font-size:34px;
	color:#0f6959;}
</style>
</head>
<body>
    <div id="content">
		<div class="box">
		<div class="box_10">购买成功</div>
		<div class="box_9"><?php echo $item; ?></div>
		<div class="box_8">订单号</div>
		<div class="box_7"><?php echo $tradeno; ?></div>
		<div class="box_8">购买时间</div>
		<div class="box_7"><?php echo date('Y年m月d日'); ?></div>
		<div class="box_8">有效期至</div>
		<div class="box_7"><?php echo date('Y年m月d日',strtotime('+1 year')); ?></div>
		<div class="box_8">24小时内星雅客服将与您联系，请保持手机畅通！</div>
	</div>
	</div>
</body>
</html>