<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>博客后台管理页面</title>
<script src="/Public/Wife/js/prototype.lite.js" type="text/javascript"></script>
<script src="/Public/Wife/js/moo.fx.js" type="text/javascript"></script>
<script src="/Public/Wife/js/moo.fx.pack.js" type="text/javascript"></script>
<style>
body {
	font-size:12px;
	font-family:"宋体";
	color: #000;
	background-color: #EEF2FB;
	margin: 0px;
}

a {text-decoration: none;};
a,ul,li,h3{margin:0; padding:0}

#container {
	width: 182px;
	margin-left:5px;
}
h3 {
	font-size: 12px;
	margin: 0px;
	width: 182px;
	cursor: pointer;
	height: 30px;
	line-height: 20px;	
	margin:0;
	padding:0;
}
h3 a {
	display: block;
	width: 182px;
	color: #000;
	height: 30px;
	text-decoration: none;
	moz-outline-style: none;
	background-image: url(/Public/Wife/images/menu_bgS.gif);
	background-repeat: no-repeat;
	line-height: 30px;
	text-align: center;
}
.content{
	width: 182px;
}

.MM li {
	height: 26px;
	width: 182px;	
	list-style:none;
}
.MM {
	width: 182px;
	margin: 0px;
	padding: 0px;
	left: 0px;
	top: 0px;
	right: 0px;
	bottom: 0px;
	clip: rect(0px,0px,0px,0px);
}
.MM a:link,.MM a:visited {
	line-height: 26px;
	color: #333333;
	background-image: url(/Public/Wife/images/menu_bg1.gif);
	background-repeat: no-repeat;
	height: 26px;
	width: 182px;
	display: block;
	text-align: center;
}
.MM a:hover{font-weight:bold}
.MM a:hover {
	color: #006600;
	background-image: url(/Public/Wife/images/menu_bg2.gif);
	background-repeat: no-repeat;
}
</style>
</head>

<body style="background:#fff">
<div id="container">
      <h3 class="type"><a href="javascript:void(0)">网站配置</a></h3>
      <div class="content">
		<div style="background:url(/Public/Wife/images/menu_topline.gif); width:182px; height:5px; overflow:hidden"></div>
        <ul class="MM">
          	<li><a href="<?php echo U('Webconfig/index');?>" target="main">博客基本信息</a></li>	
			<li><a href="<?php echo U('Webconfig/advanced');?>" target="main">博客高级配置</a></li>	
			<li><a href="<?php echo U('Shuo/index');?>" target="main">博主说说</a></li>	
			<li><a href="<?php echo U('Shuo/add');?>" target="main">添加时间说说</a></li>	
        </ul>
	  </div>
      
	  <h3 class="type"><a href="javascript:void(0)">博客管理</a></h3>
      <div class="content">
		<div style="background:url(/Public/Wife/images/menu_topline.gif); width:182px; height:5px; overflow:hidden"></div>
        <ul class="MM">
			<li><a href="<?php echo U('Company/index');?>" target="main">基本设置</a></li>
			<li><a href="<?php echo U('Xiangce/add');?>" target="main">添加相册</a></li>
			<li><a href="<?php echo U('Company/gywm');?>" target="main">关于我们</a></li>
			<li><a href="<?php echo U('Xiangce/addpic');?>" target="main">上传相册图片</a></li>
			<li><a href="<?php echo U('Company/ygPic');?>" target="main">员工风采</a></li>
			<li><a href="<?php echo U('Company/honour');?>" target="main">公司荣誉</a></li>
        </ul>
	  </div>
	
	  <h3 class="type"><a href="javascript:void(0)">首页导航</a></h3>
      <div class="content">
		<div style="background:url(/Public/Wife/images/menu_topline.gif); width:182px; height:5px; overflow:hidden"></div>
        <ul class="MM">
			<li><a href="<?php echo U('Category/index');?>" target="main">文章分类</a></li>
			<li><a href="<?php echo U('Category/addCate');?>" target="main">添加分类</a></li>
        </ul>
	  </div>

	  <h3 class="type"><a href="javascript:void(0)">文章管理</a></h3>
      <div class="content">
		<div style="background:url(/Public/Wife/images/menu_topline.gif); width:182px; height:5px; overflow:hidden"></div>
        <ul class="MM">
          <li><a href="<?php echo U('Article/index');?>" target="main">文章管理</a></li>
		   <li><a href="<?php echo U('Article/add');?>" target="main">添加文章</a></li>
        </ul>
	  </div>
	 
	  <h3 class="type"><a href="javascript:void(0)">商品管理</a></h3>
      <div class="content">
		<div style="background:url(/Public/Wife/images/menu_topline.gif); width:182px; height:5px; overflow:hidden"></div>
        <ul class="MM">
          <li><a href="<?php echo U('Goods/index');?>" target="main">商品列表</a></li>
		   <li><a href="<?php echo U('Goods/addGoods');?>" target="main">添加商品</a></li>
		   <li><a href="<?php echo U('Goods/classList');?>" target="main">商品分类</a></li>
        </ul>
	  </div>
	
	  <h3 class="type"><a href="javascript:void(0)">留言管理</a></h3>
      <div class="content">
		<div style="background:url(/Public/Wife/images/menu_topline.gif); width:182px; height:5px; overflow:hidden"></div>
        <ul class="MM">
          <li><a href="<?php echo U('Message/index');?>" target="main">查看留言</a></li>
        </ul>
	  </div>
	  <h3 class="type"><a href="javascript:void(0)">友情链接</a></h3>
      <div class="content">
		<div style="background:url(/Public/Wife/images/menu_topline.gif); width:182px; height:5px; overflow:hidden"></div>
        <ul class="MM">
          <li><a href="<?php echo U('Link/index');?>" target="main">查看所有</a></li>
		  <li><a href="<?php echo U('Link/addlink');?>" target="main">添加新的</a></li>
        </ul>
	  </div>
	  <h3 class="type"><a href="javascript:void(0)">用户管理</a></h3>
      <div class="content">
		<div style="background:url(/Public/Wife/images/menu_topline.gif); width:182px; height:5px; overflow:hidden"></div>
        <ul class="MM">
          <li><a href="<?php echo U('User/index');?>" target="main">查看用户</a></li>
		  <li><a href="<?php echo U('User/adduser');?>" target="main">添加管理员</a></li>
        </ul>
	  </div>
	  <h3 class="type"><a href="javascript:void(0)">系统设置</a></h3>
      <div class="content">
		<div style="background:url(/Public/Wife/images/menu_topline.gif); width:182px; height:5px; overflow:hidden"></div>
        <ul class="MM">
          <li><a href="<?php echo U('System/index');?>" target="main">修改密码</a></li>
        </ul>
	  </div>
</div>
	  <script>
	  	var contents = document.getElementsByClassName('content');
		var toggles = document.getElementsByClassName('type');
		var myAccordion = new fx.Accordion(
			toggles, contents, {opacity: true, duration: 400}
		);
		myAccordion.showThisHideOpen(contents[0]);
	  </script>
</body>
</html>