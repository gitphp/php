<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<title>杨松博客后台管理中心</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>

</head>
<frameset rows="64,*"  frameborder="NO" border="0" framespacing="0">
	<frame src="<?php echo U('top');?>" noresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0" target="main" />
  <frameset cols="200,*"  rows="700,*" id="frame">
	<frame src="<?php echo U('left');?>" name="leftFrame"  scrolling="auto" target="main" />
	<frame src="<?php echo U('Webconfig/index');?>" name="main" marginwidth="0" marginheight="0" frameborder="0" scrolling="auto" target="_self" />
<noframes>
  <body></body>
    </noframes>
</html>