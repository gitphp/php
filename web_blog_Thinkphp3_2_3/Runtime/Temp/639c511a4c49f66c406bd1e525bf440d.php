<?php
//000000000010a:5:{i:0;a:15:{s:4:"a_id";s:3:"110";s:5:"a_img";s:28:"/Upload/Thumb/1457318158.jpg";s:7:"a_title";s:24:"PHP实现下载TXT文件";s:8:"a_remark";s:214:"在项目有终于到一个问题，就是当我用a链接打开的是文件的时候大部分是可以下载的，在TXT的时候却是在浏览器中直接打开，于是在网上找了下下载TXT文件的方法";s:9:"a_keyword";s:19:"下载TXT,PHP下载";s:3:"pid";s:1:"1";s:6:"a_time";s:10:"1449643683";s:9:"a_content";s:1506:"<p>在项目有终于到一个问题，就是当我用a链接打开的是文件的时候大部分是可以下载的，在TXT的时候却是在浏览器中直接打开，于是在网上找了下下载TXT文件的方法</p><p>首先是看下效果图：</p><p style="text-align:center"><img src="/Upload/20151209/1449643851536989.png" title="1449643851536989.png" alt="blob.png"/></p><p>要实现的效果是：</p><p style="text-align:center"><img src="/Upload/20151209/1449643867176044.png" title="1449643867176044.png" alt="QQ截图20151209144614.png"/></p><p>这里用到的函数：</p><pre class="brush:php">&lt;?php
function&nbsp;download($filename){
//检测是否设置文件名和文件是否存在&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;if&nbsp;((isset($filename))&amp;&amp;(file_exists($filename))){&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;header(&quot;Content-length:&nbsp;&quot;.filesize($filename));&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;header(&#39;Content-Type:&nbsp;application/octet-stream&#39;);&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;header(&#39;Content-Disposition:&nbsp;attachment;&nbsp;filename=&quot;&#39;&nbsp;.&nbsp;$filename&nbsp;.&nbsp;&#39;&quot;&#39;);&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;readfile(&quot;$filename&quot;);&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;}&nbsp;else&nbsp;{&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;文件不存在!&quot;;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;}&nbsp;
}
download(&#39;./now.txt&#39;);</pre><p><br/></p>";s:6:"a_view";s:1:"2";s:5:"a_hit";s:3:"504";s:10:"a_original";s:1:"1";s:6:"a_from";s:5:"Win 7";s:8:"a_author";s:6:"隆航";s:4:"a_ip";s:9:"127.0.0.1";s:5:"a_num";s:1:"0";}i:1;a:15:{s:4:"a_id";s:3:"112";s:5:"a_img";s:28:"/Upload/Thumb/1450067094.jpg";s:7:"a_title";s:32:"支付宝即时交易整合TP3.2";s:8:"a_remark";s:261:"因为公司的项目需要用到支付宝的即时交易，而且个人是有轻微强迫症，不太喜欢把不相关的集成到一起，所以这里单独整合了支付宝的即时交易，和担保交易很类似的，于是写下来方便之后再用。";s:9:"a_keyword";s:22:"即时交易,支付宝";s:3:"pid";s:1:"1";s:6:"a_time";s:10:"1450065488";s:9:"a_content";s:13440:"<p>做支付宝或者其他第三方的都需要去申请接口，需要自己的去申请的。</p><p><span style="color: rgb(255, 0, 0);">即时交易需要企业支付宝和备案号的网站，而且网站是建设的完全。</span></p><blockquote><p>注册地址：<a href="https://www.alipay.com/" _src="https://www.alipay.com/">https://www.alipay.com/</a> </p></blockquote><p>注册的时候选择企业版的支付宝，然后按照他的流程注册，注册完成后就可以去 <span style="color: rgb(255, 0, 0);">产品商店</span> 去签约 <span style="color: rgb(255, 0, 0);">即时交易&nbsp;</span>了</p><p style="text-align:center"><img src="/Upload/20151214/1450066035717394.png" title="1450066035717394.png" alt="blob.png"/></p><p>签约之后就是等待了，在这里就可以去整合支付宝了，等申请的 KEY 和 PID 下来就可以测试了。</p><p>支付宝签约后的即时交易下载包地址：（我自己留了一份）<a href="http://pan.baidu.com/s/1pJRcYvT" _src="http://pan.baidu.com/s/1pJRcYvT">http://pan.baidu.com/s/1pJRcYvT</a> </p><p>下载好之后解压-文件里面有详细的说明，这里目录我就不一一介绍了，自己看说明文档</p><p>第一步就是完成集成，所以需要做的是：</p><p style="text-align: center;"><img src="/Upload/20151214/1450066119162449.png" title="1450066119162449.png" alt="blob.png"/></p><blockquote><p>文件重命名</p></blockquote><pre class="brush:php">alipay_core.function.php&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Corefunction.php
alipay_notify.class.php&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Notify.php
alipay_submit.class.php&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Submit.php
alipay_md5.function.php&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Md5function.php</pre><p>这样的话就符合TP的命名方式了。</p><blockquote><p>修改文件</p></blockquote><p>其中 Notify.php 和 Md5function.php 需要删除前面引入的两行代码</p><pre class="brush:php">require_once(&quot;alipay_core.function.php&quot;);
require_once(&quot;alipay_md5.function.php&quot;);</pre><p>然后把文件放入&nbsp;<span style="color: rgb(255, 0, 0);">\ThinkPHP\Library\Vendor\Alipay</span> 目录下</p><blockquote><p>增加配置文件</p></blockquote><p>把 签名文件 <span style="color: rgb(255, 0, 0);">cacert.pem</span> 放在网站的跟目录</p><p>然后再对应需要支付的模块的conf/config.php中添加支付宝的参数：(没申请下来这里就先预留)</p><pre class="brush:php">	&#39;alipay_config&#39;		=&gt;	array(									//支付宝配置参数
	&nbsp;&nbsp;&nbsp;&nbsp;&#39;partner&#39;&nbsp;		=&gt;	&#39;2088021447698852&#39;,&nbsp;&nbsp;&nbsp;					//这里是你在成功申请支付宝接口后获取到的PID；
	&nbsp;&nbsp;&nbsp;&nbsp;&#39;key&#39;			=&gt;	&#39;m94r73neschynziad6kx3ovgu19p0ikn&#39;,		//这里是你在成功申请支付宝接口后获取到的Key
	&nbsp;&nbsp;&nbsp;&nbsp;&#39;sign_type&#39;		=&gt;	strtoupper(&#39;MD5&#39;),
	&nbsp;&nbsp;&nbsp;&nbsp;&#39;input_charset&#39;	=&gt;	strtolower(&#39;utf-8&#39;),
	&nbsp;&nbsp;&nbsp;&nbsp;&#39;cacert&#39;		=&gt;	getcwd().&#39;\\cacert.pem&#39;,				//liunx这里需要注意&nbsp;\\&nbsp;和&nbsp;/&nbsp;在liunx的区别
	&nbsp;&nbsp;&nbsp;&nbsp;&#39;transport&#39;		=&gt;	&#39;http&#39;,
	&nbsp;&nbsp;&nbsp;&nbsp;&#39;seller_email&#39;	=&gt;	&#39;mingyu_lmy@foxmail.com&#39;,				//&nbsp;这里是你的收款账号，
	),
	
	&#39;alipay&#39;&nbsp;&nbsp;	&nbsp;		=&gt;	array(
		&#39;notify_url&#39;	=&gt;	&#39;http://www.7fei.wang/Home/Alipay/notifyurl&#39;,
		&#39;return_url&#39;	=&gt;	&#39;http://www.7fei.wang/Home/Alipay/returnurl&#39;,	&nbsp;	
	),</pre><blockquote><p>添加逻辑方法</p></blockquote><pre class="brush:php">&lt;?php
//&nbsp;+----------------------------------------------------------------------
//&nbsp;|&nbsp;ThinkPHP&nbsp;[&nbsp;WE&nbsp;CAN&nbsp;DO&nbsp;IT&nbsp;JUST&nbsp;THINK&nbsp;IT&nbsp;]
//&nbsp;+----------------------------------------------------------------------
//&nbsp;|&nbsp;Copyright&nbsp;(c)&nbsp;2015&nbsp;http://ming-yu.com&nbsp;All&nbsp;rights&nbsp;reserved.
//&nbsp;+----------------------------------------------------------------------
//&nbsp;|&nbsp;Licensed&nbsp;(&nbsp;http://www.apache.org/licenses/LICENSE-2.0&nbsp;)
//&nbsp;+----------------------------------------------------------------------
//&nbsp;|&nbsp;Author:&nbsp;long&nbsp;&lt;admin@loveteemo.com&gt;
//&nbsp;+----------------------------------------------------------------------
namespace&nbsp;Home\Controller;
use&nbsp;Think\Controller;
class&nbsp;AlipayController&nbsp;extends&nbsp;Controller{
	
	/**
	&nbsp;*&nbsp;函数说明：引入支付宝参数
	&nbsp;*/
	public&nbsp;function&nbsp;&nbsp;_initialize(){
		vendor(&#39;Alipay.Corefunction&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vendor(&#39;Alipay.Md5function&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vendor(&#39;Alipay.Notify&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;vendor(&#39;Alipay.Submit&#39;);&nbsp;
	}
	
	/**
	&nbsp;*&nbsp;函数说明：生成订单-支付
	&nbsp;*&nbsp;传递参数：
	&nbsp;*&nbsp;$_POST[&#39;WIDout_trade_no&#39;];&nbsp;	商户订单号
	&nbsp;*&nbsp;$_POST[&#39;WIDsubject&#39;];&nbsp;		订单名称&nbsp;必填
	&nbsp;*&nbsp;$_POST[&#39;WIDtotal_fee&#39;];		付款金额&nbsp;必填
	&nbsp;*&nbsp;$_POST[&#39;WIDbody&#39;];			订单描述&nbsp;&nbsp;
	&nbsp;*&nbsp;$_POST[&#39;WIDshow_url&#39;];		商品展示地址&nbsp;
	&nbsp;*/
	//生成订单
	public&nbsp;function&nbsp;dowithpay(){
		if(!IS_POST){
			$this-&gt;error(&quot;非法请求&quot;);
		}
		$info&nbsp;				=		xxx;//根据传递的订单号，信息查询
		if(!$info){
			$this-&gt;error(&quot;参数非法&quot;);
		}&nbsp;
		$alipay_config		=		C(&#39;alipay_config&#39;);		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$payment_type&nbsp;		=&nbsp;		&quot;1&quot;;							//支付类型&nbsp;必填，不能修改&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$notify_url&nbsp;		=&nbsp;		C(&#39;alipay.notify_url&#39;);			//服务器异步通知页面路径&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$return_url&nbsp;		=&nbsp;		C(&#39;alipay.return_url&#39;);			//页面跳转同步通知页面路径
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$out_trade_no&nbsp;		=&nbsp;		$info[&#39;onumber&#39;];				//商户订单号&nbsp;商户网站订单系统中唯一订单号，必填
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$subject&nbsp;			=&nbsp;		$info[&#39;oname&#39;];					//订单名称&nbsp;必填
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$total_fee&nbsp;			=&nbsp;		$info[&#39;opay&#39;];					//付款金额&nbsp;必填
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$body&nbsp;				=&nbsp;		$info[&#39;oname&#39;];					//订单描述&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$show_url&nbsp;			=&nbsp;		&#39;&#39;;								//商品展示地址&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$anti_phishing_key&nbsp;	=&nbsp;		&quot;&quot;;								//防钓鱼时间戳
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$exter_invoke_ip&nbsp;	=&nbsp;		&quot;&quot;;								//非局域网的外网IP地址，如：221.0.0.1
		/************************************************************/
		$parameter&nbsp;			=&nbsp;		array(
				&quot;service&quot;&nbsp;			=&gt;&nbsp;&quot;create_direct_pay_by_user&quot;,
				&quot;partner&quot;&nbsp;			=&gt;&nbsp;trim($alipay_config[&#39;partner&#39;]),
				&quot;seller_email&quot;&nbsp;		=&gt;&nbsp;trim($alipay_config[&#39;seller_email&#39;]),
				&quot;payment_type&quot;		=&gt;&nbsp;$payment_type,
				&quot;notify_url&quot;		=&gt;&nbsp;$notify_url,
				&quot;return_url&quot;		=&gt;&nbsp;$return_url,
				&quot;out_trade_no&quot;		=&gt;&nbsp;$out_trade_no,
				&quot;subject&quot;			=&gt;&nbsp;$subject,
				&quot;total_fee&quot;			=&gt;&nbsp;$total_fee,
				&quot;body&quot;				=&gt;&nbsp;$body,
				&quot;show_url&quot;			=&gt;&nbsp;$show_url,
				&quot;anti_phishing_key&quot;	=&gt;&nbsp;$anti_phishing_key,
				&quot;exter_invoke_ip&quot;	=&gt;&nbsp;$exter_invoke_ip,
				&quot;_input_charset&quot;	=&gt;&nbsp;trim(strtolower($alipay_config[&#39;input_charset&#39;]))
		);
		//建立请求
		$alipaySubmit&nbsp;		=&nbsp;		new&nbsp;\AlipaySubmit($alipay_config);
		$html_text&nbsp;			=&nbsp;		$alipaySubmit-&gt;buildRequestForm($parameter,&quot;get&quot;,&nbsp;&quot;确认&quot;);
		echo&nbsp;$html_text;
	}
	
	/**
	&nbsp;*&nbsp;函数说明：支付宝回调异步函数
	&nbsp;*&nbsp;附带操作数据库
	&nbsp;*/
	public&nbsp;function&nbsp;notifyurl(){		
		header(&quot;Content-Type:text/html;charset=utf-8&quot;);&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$alipay_config		=	C(&#39;alipay_config&#39;);
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$alipayNotify&nbsp;		=&nbsp;	new&nbsp;\AlipayNotify($alipay_config);
		$verify_result&nbsp;		=	$alipayNotify-&gt;verifyNotify();			//计算得出通知验证结果
		if($verify_result)&nbsp;{											//验证成功	
			$out_trade_no&nbsp;	=	$_POST[&#39;out_trade_no&#39;];					//商户订单号			
			$trade_no&nbsp;		=	$_POST[&#39;trade_no&#39;];						//支付宝交易号		
			$trade_status&nbsp;	=	$_POST[&#39;trade_status&#39;];					//交易状态	
		&nbsp;&nbsp;&nbsp;&nbsp;if($_POST[&#39;trade_status&#39;]&nbsp;==&nbsp;&#39;TRADE_FINISHED&#39;)&nbsp;{
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
					//如果有做过处理，不执行商户的业务程序
					//用户登陆支付宝的时候把支付宝的订单存入数据库，而状态修改为&nbsp;98
					//M(&#39;order&#39;)-&gt;where(array(&quot;onumber&quot;=&gt;$out_trade_no,&quot;ostatic&quot;=&gt;98))-&gt;save(array(&quot;ostatic&quot;=&gt;1,&quot;etime&quot;=&gt;time()));					
				//注意：
				//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
		&nbsp;&nbsp;&nbsp;&nbsp;}
		&nbsp;&nbsp;&nbsp;&nbsp;else&nbsp;if&nbsp;($_POST[&#39;trade_status&#39;]&nbsp;==&nbsp;&#39;TRADE_SUCCESS&#39;)&nbsp;{
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
					//如果有做过处理，不执行商户的业务程序
					M(&#39;order&#39;)-&gt;where(array(&quot;onumber&quot;=&gt;$out_trade_no,&quot;ostatic&quot;=&gt;0))-&gt;save(array(&quot;opaynumber&quot;=&gt;$trade_no,&quot;ostatic&quot;=&gt;1));
					
				//注意：
				//付款完成后，支付宝系统发送该交易状态通知
				//logResult(&quot;付款完成，订单号：&quot;.$out_trade_no&nbsp;.&quot;,支付宝交易号：&quot;.$trade_no.&quot;,交易状态：&quot;.$trade_status.&quot;&quot;);
		&nbsp;&nbsp;&nbsp;&nbsp;}
			echo&nbsp;&quot;success&quot;;												//请不要修改或删除
		}else&nbsp;{
		&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;fail&quot;;												//验证失败
		}
	}

	/**
	&nbsp;*&nbsp;函数说明：支付宝成功支付后的转跳页面
	&nbsp;*&nbsp;
	&nbsp;*/
	public&nbsp;function&nbsp;returnurl(){
		header(&quot;Content-Type:text/html;charset=utf-8&quot;);&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$alipay_config		=	C(&#39;alipay_config&#39;);
		$alipayNotify&nbsp;		=	new&nbsp;\AlipayNotify($alipay_config);
		$verify_result&nbsp;		=	$alipayNotify-&gt;verifyReturn();
		if($verify_result)&nbsp;{											//验证成功
			$out_trade_no&nbsp;	=	$_GET[&#39;out_trade_no&#39;];					//商户订单号
			$trade_no&nbsp;		=	$_GET[&#39;trade_no&#39;];						//支付宝交易号
			$trade_status	=	$_GET[&#39;trade_status&#39;];					//交易状态
		&nbsp;&nbsp;&nbsp;&nbsp;if($_GET[&#39;trade_status&#39;]&nbsp;==&nbsp;&#39;TRADE_FINISHED&#39;&nbsp;||&nbsp;$_GET[&#39;trade_status&#39;]&nbsp;==&nbsp;&#39;TRADE_SUCCESS&#39;)&nbsp;{
				redirect(U(&#39;Home/Member/orderpay&#39;,array(&quot;onumber&quot;=&gt;$out_trade_no)));
		&nbsp;&nbsp;&nbsp;&nbsp;}
&nbsp;&nbsp;&nbsp;&nbsp;		else&nbsp;{
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			echo&nbsp;&quot;trade_status=&quot;.$_GET[&#39;trade_status&#39;];
&nbsp;&nbsp;&nbsp;&nbsp;		}
			echo&nbsp;&quot;验证成功&lt;br&nbsp;/&gt;&quot;;
		}
		else&nbsp;{
		&nbsp;&nbsp;&nbsp;&nbsp;echo&nbsp;&quot;验证失败&quot;;
		}
	}
		
}</pre><p>到这里基本算完成了，需要等到申请的 KEY 和 PID 下来就可以测试了，需要注意的是：<br/></p><p><span style="color: rgb(255, 0, 0);">notifyurl需要在服务器上才能用，本地测试这里写的任何逻辑是无效的。</span></p><p>文章写到这里基本完成了，自己做过的东西拿出来分享，有疑问请留言告诉我，谢谢~</p>";s:6:"a_view";s:1:"2";s:5:"a_hit";s:3:"556";s:10:"a_original";s:1:"1";s:6:"a_from";s:5:"Win 7";s:8:"a_author";s:6:"隆航";s:4:"a_ip";s:13:"111.172.247.5";s:5:"a_num";s:1:"0";}i:2;a:15:{s:4:"a_id";s:3:"113";s:5:"a_img";s:28:"/Upload/Thumb/1450245129.jpg";s:7:"a_title";s:50:"2015年年度网络流行语，你肯定都说过~";s:8:"a_remark";s:236:"每年的年度流行语都体现了网友“城会玩”的一面，更重要的是网络流行语也给了大家一种新的吐槽方式。转眼之间2015年已经接近尾声了，那么今年
的十大流行语到底是哪些呢？";s:9:"a_keyword";s:29:"网络流行词,2015流行语";s:3:"pid";s:1:"1";s:6:"a_time";s:10:"1450244175";s:9:"a_content";s:6024:"<p>每年的年度流行语都体现了网友“城会玩”的一面，更重要的是网络流行语也给了大家一种新的吐槽方式。转眼之间2015年已经接近尾声了，那么今年的十大流行语到底是哪些呢？<br/></p><blockquote><p>上交给国家</p></blockquote><p style="text-align: center;"><img src="/Upload/20151216/1450244360958620.jpg" title="1450244360958620.jpg" alt="1.jpg"/></p><p>“上交给国家”出自于《盗墓笔记》电视剧版中男主角吴邪的台词。原本应该是“盗墓”主角的吴邪，却口口声声要将所有看到的文物“上交国家”。</p><p style="text-align: center;"><img src="/Upload/20151216/1450244387184474.jpg" title="1450244387184474.jpg" alt="2.jpg"/></p><p>于是从开篇的牛头到随后出现的藏宝图，都逃脱不了“上交国家”的命运，由于这句话有悖于南派三叔原著中的情节和盗墓精神，</p><p style="text-align: center;"><img src="/Upload/20151216/1450244421291364.jpg" title="1450244421291364.jpg" alt="3.jpg"/></p><p><br/></p><p>所以引发原著粉和看剧党的大规模的吐槽，此句也由此流行起来啦~</p><blockquote><p>我的内心几乎是崩溃的</p></blockquote><p style="text-align:center"><img src="/Upload/20151216/1450244486324047.jpg" title="1450244486324047.jpg" alt="4.jpg"/></p><p><br/></p><p>2014年12月前后，90后漫画作者陈安妮以真实经历创作的《对不起，我只过1%生活》的漫画在网络上走红。后来支付宝用此来嘲讽WP用户选择百分之一的生活，结果遭WP用户反击“支付婊”。</p><p style="text-align:center"><img src="/Upload/20151216/1450244521831363.jpg" title="1450244521831363.jpg" alt="5.jpg"/></p><p>吓得支付宝马上发招聘信息招WP工程师了......</p><blockquote><p>吓死宝宝了</p></blockquote><p style="text-align:center"><img src="/Upload/20151216/1450244561814536.jpg" title="1450244561814536.jpg" alt="6.jpg"/></p><p>有人说是奔跑吧兄弟中王宝强说的吓死宝宝了……</p><p>也有人说是一位叫“宝宝”的LOL女主播先说出来的，她在主持中，现场抽奖，让画面随机选人头像，突然有一个很黑很肥的胖子出现在画面，然后她就说了句：“吓死宝宝了”之后这句话就被很多人用了！</p><p style="text-align:center"><img src="/Upload/20151216/1450244587929410.jpg" title="1450244587929410.jpg" alt="7.jpg"/></p><p>还有人说这句话本身是网上本就很流行的一句“吓死爹了”，是后来被网友改编成“吓死宝宝了”</p><blockquote><p>狗带“godie”<br/></p></blockquote><p style="text-align:center"><img src="/Upload/20151216/1450244665902921.jpg" title="1450244665902921.jpg" alt="8.jpg"/></p><p>“狗带”是“go die”的谐音，源自中国艺人黄子韬在一次演唱会上表演的灵魂Rap。<br/></p><p>被《暴走大事件》挖出后让广大网友玩坏~</p><blockquote><p>你们城里人真会玩<br/></p></blockquote><p style="text-align:center"><img src="/Upload/20151216/1450244693928574.jpg" title="1450244693928574.jpg" alt="9.jpg"/></p><p>&nbsp;<br/></p><p>早些时候，前EXO成员吴亦凡在上海某所大学拍摄电影，结果有人假扮吴亦凡让那些狗仔以为是吴亦凡本人，并且狗仔把照片上传到微博上，然后才发现并不是吴亦凡本人，之后就出来了这句你们城里人真会玩。</p><blockquote><p>然并卵</p></blockquote><p style="text-align:center"><img src="/Upload/20151216/1450244721672642.jpg" title="1450244721672642.jpg" alt="10.jpg"/>&nbsp;</p><p>这个词最早来自于某地方言，</p><p style="text-align:center"><img src="/Upload/20151216/1450244740586945.jpg" title="1450244740586945.jpg" alt="11.jpg"/></p><p>之后被《暴走大事件》里的张全蛋采用，凭借一个《质检leader张全蛋怒揭电视机行业内幕》让这个词迅速走红。</p><blockquote><p>我单方面宣布</p></blockquote><p style="text-align:center"><img src="/Upload/20151216/1450244767183222.jpg" title="1450244767183222.jpg" alt="12.jpg"/></p><p>一名女孩在观看NBA球赛时发现梅西就坐在起身后，她掩饰不住自己的兴奋，鼓起勇气要求与梅西合影，梅西答应了她的要求。之后女孩在自己的推特上宣布她将在2015年6月单方面与梅西结婚。之后也是没有逃脱广大网友的跟风恶搞，<br/></p><p>由此成为了网络流行用语......</p><blockquote><p>重要的事情说三遍<br/></p></blockquote><p style="text-align:center"><img src="/Upload/20151216/1450244787146843.jpg" title="1450244787146843.jpg" alt="13.jpg"/></p><p>出自动漫《潜行吧，奈亚子》用法：记得说三遍，说三遍，说三遍就好了，会有神奇的效果发生。其实我觉得这应该是出自骆宾王的《咏鹅》，“鹅，鹅，鹅”重要的事说三遍！！！<br/></p><blockquote><p>世界那么大<br/></p></blockquote><p style="text-align:center"><img src="/Upload/20151216/1450244810276411.jpg" title="1450244810276411.jpg" alt="14.jpg"/></p><p>“世界那么大，我想去看看”来源于郑州实验中学一位老师的最具情怀的辞职信，<br/></p><p>不久后该老师微博声称自己决定裸婚，过上幸福的生活~</p><blockquote><p>哔了狗了<br/></p></blockquote><p style="text-align:center"><img src="/Upload/20151216/1450244835756835.jpg" title="1450244835756835.jpg" alt="15.jpg"/></p><p>《暴走大事件》张全蛋在吐槽进口马桶圈时说的一句话。本来是一句R了狗了，由于说成R了狗了也会被后期哔音和谐。<br/></p><p>所以他就干脆说成了哔了狗了~</p><p style="text-align:center"><img src="/Upload/20151216/1450244856399730.jpg" title="1450244856399730.jpg" alt="16.jpg"/></p><p>以上就是2015年年度流行语啦，作为一名新潮的暴走小伙伴你是不是早就有听过啦？最后感谢一下度娘提供的帮助哦~按照每年的惯例，这些网络流行语我们就等着春晚见吧~</p>";s:6:"a_view";s:1:"2";s:5:"a_hit";s:3:"481";s:10:"a_original";s:1:"0";s:6:"a_from";s:5:"Win 7";s:8:"a_author";s:6:"网络";s:4:"a_ip";s:13:"111.172.247.5";s:5:"a_num";s:1:"0";}i:3;a:15:{s:4:"a_id";s:3:"114";s:5:"a_img";s:28:"/Upload/Thumb/1451639362.jpg";s:7:"a_title";s:27:"给博客添加节日雪花";s:8:"a_remark";s:226:"转眼就是2016年的圣诞和元旦到了，然后剩下的就是春节，节日多了当然气氛就要嗨起来嘛，这里给大家分享一个比较不错的雪花特效，简单、粗暴。需要的可以进来瞧瞧。";s:9:"a_keyword";s:15:"雪花,jq特效";s:3:"pid";s:1:"1";s:6:"a_time";s:10:"1451638806";s:9:"a_content";s:1961:"<p>二话不说先上效果图:</p><p style="text-align:center"><img src="/Upload/20160101/1451638951632614.png" title="1451638951632614.png" alt="QQ截图20160101170138.png"/></p><p>需要的朋友请看下面的说明，对JQ比较了解的朋友可以直接下载。</p><blockquote><p>下载地址：</p></blockquote><p><a href="http://pan.baidu.com/s/1mgO5nLY" _src="http://pan.baidu.com/s/1mgO5nLY">http://pan.baidu.com/s/1mgO5nLY</a>（也可以在下载区下载）</p><blockquote><p>操作方法</p></blockquote><ol class=" list-paddingleft-2" style="list-style-type: decimal;"><li><p>把下面代码加入需要显示的文件，因为我是公用底部，所以我添加在底部</p></li></ol><pre class="brush:html">&lt;!--&nbsp;新年雪花效果开始&nbsp;--&gt;
&lt;style&nbsp;type=&#39;text/css&#39;&gt;
.snowwrap,.snow-container{position:&nbsp;fixed;&nbsp;top:&nbsp;0;&nbsp;left:&nbsp;0;&nbsp;width:&nbsp;100%;&nbsp;height:&nbsp;100%;&nbsp;pointer-events:&nbsp;none;&nbsp;z-index:&nbsp;100001;}
&lt;/style&gt;
&lt;div&nbsp;class=&quot;snowwrap&quot;&gt;
&nbsp;&nbsp;&nbsp;&nbsp;&lt;div&nbsp;class=&quot;snow-container&quot;&gt;&lt;/div&gt;
&lt;/div&gt;
&lt;!--&nbsp;新年雪花效果结束&nbsp;--&gt;</pre><p>2.引入核心JQ文件</p><pre class="brush:html">&lt;!--&nbsp;雪花效果JS&nbsp;--&gt;
&lt;script&nbsp;src=&#39;__JS__/snow.js&#39;&gt;&lt;/script&gt;</pre><p>然后就可以看到效果了。具体请参考本博客现在的效果。<br/></p><blockquote><p>注意事项<br/></p></blockquote><ol class=" list-paddingleft-2" style="list-style-type: decimal;"><li><p>snow.js的2958行需要指定雪花图片的地址</p></li><li><p>需要在snow.js前面引入JQ文件</p></li></ol><p>应该没什么了，如果遇到问题可以留言和我说下。另外新版博客剩下后台的部分代码修改，预计春节发布2.0版本。</p><p>元旦到了2016年的新开始，祝大家新的一天学业有成，心想事成。</p>";s:6:"a_view";s:1:"2";s:5:"a_hit";s:3:"459";s:10:"a_original";s:1:"1";s:6:"a_from";s:5:"Win 7";s:8:"a_author";s:6:"隆航";s:4:"a_ip";s:12:"58.53.107.63";s:5:"a_num";s:1:"0";}i:4;a:15:{s:4:"a_id";s:3:"115";s:5:"a_img";s:28:"/Upload/Thumb/1457318139.jpg";s:7:"a_title";s:27:"PHP获取时间戳的毫秒";s:8:"a_remark";s:106:"php获取时间戳就是time()函数，那么当我们需要毫秒级别的时间的时候怎么获取呢?";s:9:"a_keyword";s:16:"毫秒,PHP时间";s:3:"pid";s:1:"1";s:6:"a_time";s:10:"1456495260";s:9:"a_content";s:1802:"<p>php获取时间的方式是time();<br/></p><p>那么如果是涉及游戏或者其他需要精细的时间，那么怎么获取呢？</p><pre class="brush:php">&nbsp;/**&nbsp;获取当前时间戳，精确到毫秒&nbsp;*/
function&nbsp;microtime_float()
{
&nbsp;&nbsp;&nbsp;list($usec,&nbsp;$sec)&nbsp;=&nbsp;explode(&quot;&nbsp;&quot;,&nbsp;microtime());
&nbsp;&nbsp;&nbsp;return&nbsp;((float)$usec&nbsp;+&nbsp;(float)$sec);
}
/**&nbsp;格式化时间戳，精确到毫秒，x代表毫秒&nbsp;*/
function&nbsp;microtime_format($tag,&nbsp;$time)
{
&nbsp;&nbsp;&nbsp;list($usec,&nbsp;$sec)&nbsp;=&nbsp;explode(&quot;.&quot;,&nbsp;$time);
&nbsp;&nbsp;&nbsp;$date&nbsp;=&nbsp;date($tag,$usec);
&nbsp;&nbsp;&nbsp;return&nbsp;str_replace(&#39;x&#39;,&nbsp;$sec,&nbsp;$date);
}</pre><p><br/>使用方法：<br/>1.&nbsp;获取当前时间戳(精确到毫秒)：microtime_float()<br/>2.&nbsp;时间戳转换时间：microtime_format(&#39;Y年m月d日&nbsp;H时i分s秒&nbsp;x毫秒&#39;,&nbsp;1270626578.66000000)&nbsp;<br/></p><p>这里需要用到的是list()函数</p><blockquote><p>list（）定义和用法</p></blockquote><p style="margin-top: 12px; margin-bottom: 0px; padding: 0px; border: 0px; line-height: 18px; font-family: Verdana, Arial, 宋体; font-size: 12px; white-space: normal; background-color: rgb(249, 249, 249);">list() 函数用于在一次操作中给一组变量赋值。</p><p class="note" style="margin-top: 12px; margin-bottom: 0px; padding: 0px; border: 0px; line-height: 18px; font-family: Verdana, Arial, 宋体; font-size: 12px; white-space: normal; background-color: rgb(249, 249, 249);"><span style="margin: 0px; padding: 0px; border: 0px; font-weight: bold;">注释：</span>该函数只用于数字索引的数组，且假定数字索引从 0 开始。</p><p><br/></p>";s:6:"a_view";s:1:"2";s:5:"a_hit";s:2:"81";s:10:"a_original";s:1:"1";s:6:"a_from";s:5:"Win 7";s:8:"a_author";s:6:"隆航";s:4:"a_ip";s:9:"127.0.0.1";s:5:"a_num";s:1:"0";}}
?>