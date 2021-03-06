<%@LANGUAGE="VBSCRIPT" CODEPAGE="936"%>
<!--#include file="./config.asp"-->
<!--#include file="./classes/PayResponseHandler.asp"-->
<%
'---------------------------------------------------------
'微信支付接口处理回调示例，商户按照此示例进行开发即可
'---------------------------------------------------------
'==================
'通知验证逻辑
'==================
log_result("notify:qstring:"&chr(10)&request.querystring&chr(10))

'创建支付应答对象
Dim resHandler
Set resHandler = new PayResponseHandler

'初始化页面提交过来的参数
resHandler.Init
resHandler.setKey PARTNER_KEY, APP_KEY

log_result("notify:"&chr(10)&resHandler.getDebugInfo&chr(10))
'判断签名
If resHandler.isValidSign() = True Then
	If resHandler.isWXsign() = True Then
		Dim notify_id
		Dim transaction_id
		Dim total_fee
		Dim out_trade_no
		Dim discount
		Dim trade_state
		'商户在收到后台通知后根据通知ID向财付通发起验证确认，采用后台系统调用交互模式	
		notify_id = resHandler.getParameter("notify_id")	 '通知id

		'商户交易单号
		out_trade_no = resHandler.getParameter("out_trade_no")	

		'财付通交易单号
		transaction_id = resHandler.getParameter("transaction_id")

		'商品金额,以分为单位
		total_fee = resHandler.getParameter("total_fee")
		
		'如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
		discount = resHandler.getParameter("discount")
		
		'支付结果
		trade_state = resHandler.getParameter("trade_state")
		
		'可获取的其他参数还有
		'bank_type			银行类型,默认：BL
		'fee_type			现金支付币种,目前只支持人民币,默认值是1-人民币
		'input_charset		字符编码,取值：GBK、UTF-8，默认：GBK。
		'partner			商户号,由财付通统一分配的10位正整数(120XXXXXXX)号
		'product_fee		物品费用，单位分。如果有值，必须保证transport_fee + product_fee=total_fee
		'sign_type			签名类型，取值：MD5、RSA，默认：MD5
		'time_end			支付完成时间
		'transport_fee		物流费用，单位分，默认0。如果有值，必须保证transport_fee +  product_fee = total_fee
		'判断签名及结果
		If "0" = trade_state Then
			'----------------------
			'即时到帐处理业务开始
			'-----------------------
			'处理数据库逻辑
			'注意交易单不要重复处理
			'注意判断返回金额
			'-----------------------
			'即时到帐处理业务完毕
			'-----------------------
			'给财付通系统发送成功信息，给财付通系统收到此结果后不在进行后续通知
			log_result("success 后台通知成功")
		Else  
			log_result("fail 支付失败")
		End If
		'回复服务器处理成功
		Response.Write("success")
	Else'SHA1签名失败
		Response.Write("fail -SHA1 failed")
		log_result("debugInfo:" & resHandler.getDebugInfo & chr(10))
	End If
Else'MD5签名失败
	Response.Write("fail -Md5 failed")
	log_result("debugInfo:" & resHandler.getDebugInfo & chr(10))
End If
%>