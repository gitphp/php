<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/Public/Wife/css/admin.css" />
</head>
<body>
<div id="main">
	<div class="title">基本配置</div>
	<div class="content">
	<table width="98%" cellpadding="0" cellspacing="0" class="mytab">
		<tr>
			<td colspan="6" valign="top" class="tit">个人信息</td>
	    </tr>
		<tr>
			<td width="7%" valign="top">姓名</td>
		    <td width="15%" valign="top"><?php echo ($_SESSION['user']['real_name']); ?></td>
		    <td width="5%" valign="top"> 登录IP </td>
		    <td width="22%" valign="top"><?php echo get_client_ip();?></td>
		    <td width="10%" valign="top">登录时间为</td>
		    <td width="41%" valign="top"><?php echo (date('Y-m-d H:i:s',$_SESSION['user']['login_time'])); ?></td>
		</tr>
		<tr>
		  <td valign="top">所属用户组</td>
		  <td valign="top"><span style="color:red; font-weight:900">超级</span>管理员</td>
		  <td valign="top">&nbsp;</td>
		  <td valign="top"></td>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
	  </tr>
	</table>
	
	<table width="98%" cellpadding="0" cellspacing="0" class="mytab">
		<tr>
			<td colspan="4" class="tit">留言信箱</td>
        </tr>
		<?php if($lastmsg == ''): ?><tr>
			<td colspan="4" align="center">暂时没有留言</td>
	      </tr>
		<?php else: ?>
		<tr>
			<td width="18%">您有<a href="<?php echo U('msg/index?act/nread/allmsg/0');?>"><strong><?php echo ($count); ?></strong></a>条未读留言</td>
		    <td width="49%">最后一次留言：来源于 <strong><?php echo ($lastmsg["m_ip"]); ?></strong> | <strong><?php echo ($lastmsg["m_name"]); ?></strong> | <strong><?php echo (date('y-m-d H:i:s',$lastmsg["m_time"])); ?></strong></td>
		    <td width="13%">共有留言<strong><?php echo ($allmsg); ?></strong>条</td>
		    <td width="20%"><a href="<?php echo U('msg/index');?>">打开留言信箱</a></td>
		</tr><?php endif; ?>
	</table>
	<table width="98%" cellpadding="0" cellspacing="0" class="mytab">
		<tr>
			<td colspan="4" valign="top" class="tit">系统信息</td>
	    </tr>
		<tr>
			<td width="19%" valign="top">服务器操作系统</td>
		    <td width="32%" valign="top"><?php echo ($_ENV['OS']); ?></td>
		    <td width="22%" valign="top">软件版本</td>
		    <td width="27%" valign="top"><?php echo ($_SERVER['SERVER_SOFTWARE']); ?></td>
		</tr>
		<tr>
		  <td valign="top">服务器协议</td>
		  <td valign="top"><?php echo ($_SERVER['SERVER_PROTOCOL']); ?></td>
		  <td valign="top">服务器名称</td>
		  <td valign="top"><?php echo ($_SERVER['SERVER_NAME']); ?></td>
	  </tr>
		<tr>
		  <td valign="top">网关接口</td>
		  <td valign="top"><?php echo ($_SERVER['GATEWAY_INTERFACE']); ?></td>
		  <td valign="top">服务器IP</td>
		  <td valign="top"><?php echo ($_SERVER['SERVER_ADDR']); ?></td>
	  </tr>
		<tr>
		  <td valign="top">Socket支持</td>
		  <td valign="top">是</td>
		  <td valign="top">时区设置</td>
		  <td valign="top">中华人民共和国</td>
	  </tr>
		<tr>
		  <td valign="top">是否开启文件上传</td>
		  <td valign="top"><?php echo ini_get('file_uploads') ?>
		    &nbsp;&nbsp;[1代表开启,0代表关闭]</td>
		  <td valign="top">文件上传的最大大小</td>
		  <td valign="top"><?php echo ini_get('upload_max_filesize') ?></td>
	  </tr>
		<tr>
		  <td valign="top">编码</td>
		  <td valign="top">UTF-8</td>
		  <td valign="top">是否自动转义</td>
		  <td valign="top"><?php echo ini_get('magic_quotes_gpc'); ?></td>
	  </tr>
	</table>
	<table width="98%" cellpadding="0" cellspacing="0" style="margin-top:10px;" class="mytab">
		<tr>
			<td colspan="6" valign="top" class="tit">网站高级配置<?php if($list != ''): ?><a href="<?php echo U('advanced');?>">[修改]</a><?php endif; ?></td>
	    </tr>
		<?php if($list == ''): ?><tr>
			<td style="text-align:center;" colspan="6">没有相应配置! <a href="<?php echo U('advanced');?>">[现在配置]</a></td>
		</tr>
		<?php else: ?>
		<tr>
			<td width="8%">网站名称：</td>
			<td width="36%"><strong><?php echo ($list["webname"]); ?></strong></td>
			<td width="11%">网站Logo</td>
			<td width="45%"><img src="/<?php echo ($list["weblogo"]); ?>"/></td>
		</tr>
		<tr>
			<td>网站标题：</td>
			<td><?php echo ($list["webtitle"]); ?></td>
			<td width="11%">开通时间：</td>
			<td width="45%"><?php echo (date("Y-m-d H:i:s",$list["dredgetime"])); ?></td>
		</tr>
		<tr>
			<td colspan="4">关键字：<?php echo ($list["webkeys"]); ?></td>
			
		</tr>
		<tr>
			<td colspan="4">网站描述：<?php echo ($list["webdesc"]); ?></td>
		  </tr><?php endif; ?>
	</table>
	
	</div>
</div>
</body>
</html>