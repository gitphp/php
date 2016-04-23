<%
'==============
'参数配置页面
'==============
 const DEBUG_		= true	'调试信息输出开关，注意：调试信息中带有密钥等信息,配置自己的商户信息后请关闭调试
 const PARTNER		= "1220729301" 	'财付通商户号
 const PARTNER_KEY	= "4c45cdb2c20769b481f469952a952800"	'财付通密钥
 const APP_ID		= "wx05399835f11281d7"	'appid
 const APP_SECRET	= "55e736d4991d80b13e7cf71042ce39b7"	'appsecret
 const APP_KEY		= "7Xkakynopxcplr7Av1AdR6PQBYlDtulMES5s96JBiuP1KsJd1kXeSyojMCDU1KFikaxYCkMgHlcRYe8fDWYJGJLT1o1430WhfgBMCZmkUzaLVEemkwG7K0xQSZd48Pq3"	'paysignkey 128位字符串(非appkey)
 const NOTIFY_URL	= "http://*/notify_url.asp"  '支付完成后的回调处理页面,*替换成notify_url.asp所在路径
 const LOGING_DIR	= ""  '日志保存路径
%>