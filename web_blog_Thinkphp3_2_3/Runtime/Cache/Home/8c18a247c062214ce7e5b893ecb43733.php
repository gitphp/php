<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title><?php echo ($info["a_title"]); ?> - <?php echo (C("NAME")); ?></title>
    <meta name="keywords" content="<?php echo ($info["a_keyword"]); ?>" />
    <meta name="description" content="<?php echo ($info["a_remark"]); ?>" />
	<meta name="version" content="<?php echo (C("NAME")); ?> v<?php echo ($version); ?>" />
	<meta name="author" content="<?php echo ($system["author"]); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="/Public/Css/shCore.min.css" />
	<script src="/Public/Js/shCore.min.js" ></script>
	<script type="text/javascript">
		SyntaxHighlighter.config.clipboardSwf = '/Public/Img/clipboard.swf';
		SyntaxHighlighter.all();
	</script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--[if lt IE 9]>
<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->        
<meta property="qc:admins" content="73113635665455576375" />
<link rel="stylesheet" href="/Public/Css/bootstrap.min.css" />
<link rel="shortcut icon" href="/Public/Img/icon/favicon.ico" />
<link rel="stylesheet" href="/Public/Css/my.css" />
    </head>
    <body>  
        <div class="top-top">
            <div class="container">
                <div class="col-md-5 top-left"><a class="from"><?php echo getOs();?></a></div>
                <div class="col-md-5 top-right">
                    <?php if(empty($_SESSION['nickname'])): ?><a href="<?php echo U('Common/loginqq',array("type"=>"qq"));?>" class="from" >QQ访问</a>
					<?php else: ?>
						<?php echo (session('nickname')); ?> <a class='from' href="<?php echo U('Common/out');?>">退出</a><?php endif; ?>
                </div>
            </div>
        </div>
        <div class="container ">
            <div class="row header">
                <div class="col-md-4 logo">
                    <a title="<?php echo (C("NAME")); ?>" href="/"><img src="/Public/Img/icon/logo.png" /></a>
                    <h5 class="hidden-xs"><?php echo ($system["title2"]); ?></h5>               
                </div>
                <div class="nav-dh col-md-5 col-xs-12">
                    <nav class="navbar navbar-default">
                        	<div class="navbar-header">
	                          	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	                            <span class="sr-only">导航</span>
	                            <span class="icon-bar"></span>
	                            <span class="icon-bar"></span>
	                            <span class="icon-bar"></span>
	                          	</button>
	                           	<a class="navbar-brand visible-xs" href="#">博客导航</a>
	                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                           	<ul class="nav navbar-nav">
	                            <li class="<?php echo ($index); ?> dh"><a href="<?php echo U('/index');?>">首页</a></li>
	                            <li class="<?php echo ($about); ?> dh"><a href="<?php echo U('/about');?>">关于我</a></li>
	                            <li class="dropdown dh <?php echo ($class); ?>">
	                              	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">分类<span class="caret"></span></a>
	                              	<ul class="dropdown-menu" role="menu">
	                                <?php if(is_array($pid)): $i = 0; $__LIST__ = $pid;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('/class-'.$vo['t_id']);?>" ><i class="icon-ok-sign"></i> <?php echo ($vo["t_name"]); ?></a></li>
	                                    <li class="divider"></li><?php endforeach; endif; else: echo "" ;endif; ?>           
	                              </ul>
	                            </li>
	                            <li class="dh <?php echo ($feel); ?>"><a href="<?php echo U('/feel');?>">说说</a></li>
	                            <li class="dh <?php echo ($album); ?>"><a href="<?php echo U('/album');?>">相册</a></li>
	                            <li class="dh <?php echo ($friends); ?>"><a href="<?php echo U('/friends');?>">邻居</a></li>
	                            <li class="dh <?php echo ($gust); ?>"><a href="<?php echo U('/gust');?>">留言板</a></li>
                          	</ul>
                        </div>
                    </nav>
                </div>    
            </div>
    <div class="row aerousel">
        <ol class="breadcrumb">
            <li><a href="index.html">网站首页</a></li>
            <li class="active">学海无涯&nbsp;|&nbsp;<?php echo ($info["t_name"]); ?></li>
        </ol>
        <div class="col-md-8 row-l articles">
		<h5>
			<?php if(($$info["a_original"]) == "1"): ?><span class="original">【原创】</span>
			<?php else: ?>
				<span class="reprint">【转载】</span><?php endif; ?>
			<a href="<?php echo U('/article-'.$v['a_id']);?>"><?php echo ($info["a_title"]); ?></a>
		</h5>
           	<div class="a-write">栏目：<?php echo ($info["t_name"]); ?>&nbsp;&nbsp;作者：<?php echo ($info["a_author"]); ?>&nbsp;&nbsp;阅读：（<?php echo ($info["a_hit"]); ?>）<span class="hidden-xs">更新于：<?php echo (getTime($info["a_time"])); ?></span></div>
            <div class="a-content"><?php echo ($info["a_content"]); ?></div>
            <div class="article-copy hidden-xs">
                <?php if(($info["a_original"]) == "1"): ?><p>非特殊说明，本文版权归<?php echo ($info["a_author"]); ?>所有，转载请注明出处.</p>
                	<p>本文标题：<?php echo ($info["a_title"]); ?></p>
                	<p>本文网址：<a><?php echo (C("SITE_URL")); ?>.com/article-<?php echo ($info["a_id"]); ?>.html</a>.</p>
                	<p>本文标签：<a><?php echo ($info["a_keyword"]); ?></a></p>
                <?php else: ?>
                	<p>本文系<?php echo ($info["a_author"]); ?>创作，可自由转载、引用，但需署名作者且注明文章出处..</p>
                	<p>本文标题：<?php echo ($info["a_title"]); ?></p>
                	<p>原文网址：<a>功能暂未开放</a>.</p>
                	<p>本文标签：<a><?php echo ($info["a_keyword"]); ?></a></p>
                	发表自：&nbsp;<?php echo ($info["a_from"]); ?>&nbsp;&nbsp;位于：<?php echo (getIp($info["a_ip"])); ?>&nbsp;&nbsp;评论：&nbsp;<?php echo (count($common)); ?>&nbsp;&nbsp;关键词：&nbsp;<?php echo ($info['a_keyword']?$info['a_keyword']:'暂无标签'); ?>&nbsp;&nbsp;<?php endif; ?>
            </div>
            <hr />
			<div class="bdsharebuttonbox fenxiang hidden-xs">
				<a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
				<a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
				<a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
				<a href="#" class="bds_youdao" data-cmd="youdao" title="分享到有道云笔记"></a>
				<a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a></div>
			<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
			<div class="a-up"><p>上一篇：<?php if(empty($up["a_id"])): ?>&nbsp;没有了<?php else: ?><a title='<?php echo ($up["a_title"]); ?>' href="<?php echo U('/article-'.$up['a_id']);?>">&nbsp;<?php echo (msubstr($up["a_title"],0,40,'utf-8',ture)); ?></a><?php endif; ?></p></div>
            <div class="a-down"><p>下一篇：<?php if(empty($down["a_id"])): ?>&nbsp;没有了<?php else: ?><a title='<?php echo ($down["a_title"]); ?>' href="<?php echo U('/article-'.$down['a_id']);?>">&nbsp;<?php echo (msubstr($down["a_title"],0,40,'utf-8',ture)); ?></a><?php endif; ?></p></div>
            <hr />  
            <?php if(is_array($common)): $i = 0; $__LIST__ = $common;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="media connect">
            	<div class="media-left">
	                <?php if(!empty($vo["ac_url"])): ?><a href="<?php echo ($vo["ac_url"]); ?>" target="_blank" rel="nofollow" title="浏览 <?php echo ($vo["ac_name"]); ?> 的网站?"><img class="media-object img-circle  img-50" src="<?php echo ($vo["ac_img"]); ?>" alt="<?php echo ($vo["ac_name"]); ?>"></a>
	                <?php else: ?>
	                <img src="<?php echo ($vo["ac_img"]); ?>" class="media-object img-circle img-50" alt="<?php echo ($vo["ac_name"]); ?>"/><?php endif; ?>
                </div>
                <div class="media-body">
					<div class="fool">#<?php echo ($vo["ac_id"]); ?></div>
                    <p class="media-heading"><a><span class="glyphicon glyphicon-user"></span></a>&nbsp;&nbsp;&nbsp;<?php echo ($vo["ac_name"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a><span class="glyphicon glyphicon-time"></span></a>&nbsp;<?php echo (getTime($vo["ac_time"])); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a class="from"><?php echo ($vo["ac_from"]); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a><span class="glyphicon glyphicon-map-marker"></span></a>&nbsp;&nbsp;<?php echo ($vo["ip"]); ?></p>
                    <div class="connect-box"> <?php echo (reFace($vo["ac_content"])); ?></div>
                    <?php if(!empty($vo["ac_rtime"])): ?><hr />
                    <div class="media">
                        <div class="media-left">
                        <a><img class="media-object img-circle img-50" src="<?php echo ($system["admin_img"]); ?>" alt="<?php echo ($vo["ac_rname"]); ?>"></a>
                        </div>
                        <div class="media-body">
                        <p class="media-heading"><a><span class="glyphicon glyphicon-king"></span></a>&nbsp;&nbsp;&nbsp;<?php echo ($vo["ac_rname"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a><span class="glyphicon glyphicon-send"></span></a>&nbsp;<?php echo (date("m-d H:i",$vo["ac_rtime"])); ?>&nbsp;&nbsp;&nbsp;&nbsp;回复&nbsp;<a>@<?php echo ($vo["ac_name"]); ?></a>&nbsp;中说到：</p>
                        <div class="connect-box"><?php echo (reFace($vo["ac_rcontent"])); ?></div>
                        </div>
                    </div><?php endif; ?>
                </div>
            </div>
            <hr /><?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="home-from">
                <div class="home-from-model" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">留下脚印</div>
                <div class="collapse" id="collapseExample">
                    <div class="well">
                    <div method="post" >
					<input id="aid" type="hidden" value="<?php echo ($info["a_id"]); ?>" />
					<input id="atitle" type="hidden"  value="<?php echo ($info["a_title"]); ?>" />
					<input id="jump" type="hidden"  value="/article-112.html" />
					<div class="input-group home-from-box">
    <span class="input-group-addon" id="basic-addon1">昵称</span>
    <input type="text" class="form-control" placeholder="昵称" aria-describedby="basic-addon1" name="name" <?php if(!empty($_SESSION['nickname'])): ?>value="<?php echo (session('nickname')); ?>"<?php else: ?>value="<?php echo (cookie('name')); ?>"<?php endif; ?> id="name">
	<span class="glyphicon glyphicon-remove form-control-feedback hidden" aria-hidden="true"></span>
</div>
<div class="input-group home-from-box">
    <span class="input-group-addon" id="basic-addon1">邮箱</span>
    <input type="email" class="form-control" placeholder="邮箱" aria-describedby="basic-addon1" name="email" id="email" value="<?php echo (cookie('email')); ?>">
	<span class="glyphicon glyphicon-remove form-control-feedback hidden" aria-hidden="true"></span>
</div>
<div class="input-group home-from-box">
    <span class="input-group-addon" id="basic-addon1">域名</span>
    <input type="url" class="form-control" placeholder="(选填)带http://" aria-describedby="basic-addon1" id="url" value="<?php echo (cookie('url')); ?>">
</div>
<div class="form-group home-from-box">
    <a href="javascript:void(0);" id="rl_exp_btn"><span class="emotion hidden-xs"></span></a>
	<div class="rl_exp" id="rl_bq" style="display:none;">
		<ul class="rl_exp_tab clearfix">
			<li><a href="javascript:void(0);" class="selected">默认</a></li>
			<li><a href="javascript:void(0);">拜年</a></li>
			<li><a href="javascript:void(0);">暴走漫画</a></li>
		</ul>
		<ul class="rl_exp_main clearfix rl_selected"></ul>
		<ul class="rl_exp_main clearfix" style="display:none;"></ul>
		<ul class="rl_exp_main clearfix" style="display:none;"></ul>
		<a href="javascript:void(0);" class="close">×</a>
	</div>
    &nbsp;<input name="rember" type="checkbox" />  <samll>记住</samll>  <input type="checkbox" name="send" />  <small>通知博主</small>
</div>
<div class="form-group home-from-box">
    <textarea class="form-control" id="content-text" name="content" rows="3" placeholder="请输入评论内容" rows="7"></textarea>
</div>
<div class="input-group home-from-box ">
    <span class="input-group-addon" id="basic-addon1">验证码</span>
    <div class="input-group check-text">
    <input type="text" class="form-control" name="txt_check" id="txt_check" placeholder="验证码">
    <span class="glyphicon glyphicon-remove form-control-feedback hidden" aria-hidden="true"></span>
    </div>
    <img style="cursor:pointer" class="img"  src="<?php echo U('Home/Common/verify');?>" onClick="this.src=this.src+'?'+Math.random();" title="看不清楚?点击刷新验证码?">    
</div>
					
					<div class="form-group home-from-box">
					    <button class="btn btn-default btn-add" >提交</button>
					</div>
                    </div>
                    </div>
               	</div>
            </div>
        </div>
    <div class="col-md-4 row-r">
	<div class="sider-box sider-box2">
	    <div class="search-box">
	        <div class="input-group search-input">
	        <form action="<?php echo U('Class/search');?>" method="get" class="form-search">
	          	<input type="text" class="form-control" placeholder="请输入关键词" name="key">
	          	<span class="input-group-btn">
	            	<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
	          	</span>
	        </form>
	        </div>
	    </div>
		
    </div>
	<div class="sider-box2">    
	<h4><span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;我的标签</h4>
	    <ul class="tag-ul">
	      	<?php if(is_array($tag)): $i = 0; $__LIST__ = $tag;if( count($__LIST__)==0 ) : echo "暂时没有标签" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v['key'] % 6 ==1): ?><li class="label label-default"><a href="<?php echo U('/article-'.$v['a_id']);?>"><?php echo (getTag($v["a_keyword"])); ?></a></li><?php endif; ?>
	      	<?php if($v['key'] % 6 ==2): ?><li class="label label-primary "><a href="<?php echo U('/article-'.$v['a_id']);?>"><?php echo (getTag($v["a_keyword"])); ?></a></li><?php endif; ?>
	      	<?php if($v['key'] % 6 ==3): ?><li class="label label-success "><a href="<?php echo U('/article-'.$v['a_id']);?>"><?php echo (getTag($v["a_keyword"])); ?></a></li><?php endif; ?>
	        <?php if($v['key'] % 6 ==4): ?><li class="label label-info "><a href="<?php echo U('/article-'.$v['a_id']);?>"><?php echo (getTag($v["a_keyword"])); ?></a></li><?php endif; ?>
	        <?php if($v['key'] % 6 ==5): ?><li class="label label-warning "><a href="<?php echo U('/article-'.$v['a_id']);?>"><?php echo (getTag($v["a_keyword"])); ?></a></li><?php endif; ?>
	        <?php if($v['key'] % 6 ==0): ?><li class="label label-danger  tag-end "><a href="<?php echo U('/article-'.$v['a_id']);?>"><?php echo (getTag($v["a_keyword"])); ?></a></li><?php endif; endforeach; endif; else: echo "暂时没有标签" ;endif; ?>
	    </ul>
	</div>
	<div class="sider-box2">
	<h4><span class="glyphicon glyphicon-retweet"></span>&nbsp;&nbsp;随机文章</h4>   	
	    <ul class="rand-ul">
	      	<?php if(is_array($s_article)): $i = 0; $__LIST__ = $s_article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(!empty($vo["a_id"])): ?><li>
	           		<a href="<?php echo U('/article-'.$vo['a_id']);?>" title="<?php echo ($vo["a_title"]); ?>" class="rand-img image-light"><img src="<?php echo ($vo["a_img"]); ?>" class="article-img" alt="<?php echo ($vo["a_title"]); ?>" title="<?php echo ($vo["a_title"]); ?>" /></a>
	           		<div class="rand-title"><a href="<?php echo U('/article-'.$vo['a_id']);?>"><?php echo (msubstr($vo["a_title"],0,15,'utf-8',true)); ?></a></div>
	           		<div class="rand-remark"><?php echo (msubstr(strip_tags($vo["a_remark"]),0,35,'utf-8',true)); ?></div>
	              </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
	    </ul>
	</div>
	<div class="sider-box2">
	<h4><span class="glyphicon glyphicon-random"></span>&nbsp;&nbsp;最新互动</h4>
	  	<div class="tab"  id="tab">
	        <ul class="nav nav-tabs" >
	           <li class="active"><a href="#home" data-toggle="tab">最新评论</a></li>
	           <li><a href="#content" data-toggle="tab">最新留言</a></li>
	           <li><a href="#hot" data-toggle="tab">最多点击</a></li>
	        </ul>
	  	</div>
	  	<div class="tab-content">
	     	<div class="tab-pane active" id="home">
	        <ul class="content-ul">
	      		<?php if(is_array($s_content)): $i = 0; $__LIST__ = $s_content;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(!empty($vo["ac_id"])): ?><li>
	        				<?php if(!empty($vo["ac_url"])): ?><a href="<?php echo ($vo["ac_url"]); ?>" target="_blank" rel="nofollow" title="访问 <?php echo ($vo["ac_name"]); ?> 的网站?">
	            				<img src="<?php echo ($vo["ac_img"]); ?>" class="img-circle img-45"/></a>
	        				<?php else: ?>
	        					<img src="<?php echo ($vo["ac_img"]); ?>" class="img-circle img-45"/><?php endif; ?>
	          				<div class="content-name"><a><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;</a><?php echo ($vo["ac_name"]); ?></div>
	          				<div class="content-remark">
	          					<span class="label label-success ">文章</span>&nbsp;&nbsp;<a href="<?php echo U('/article-'.$vo['ac_pid']);?>" title="<?php echo (delFace($vo["ac_content"])); ?>.." ><?php echo (msubstr(strip_tags(delFace($vo["ac_content"])),0,19,'utf-8',ture)); ?></a>
	          				</div>
	        			</li><?php endif; ?>
	        		<?php if(!empty($vo["alc_id"])): ?><li>
	        				<?php if(!empty($vo["alc_url"])): ?><a href="<?php echo ($vo["alc_url"]); ?>" target="_blank" rel="nofollow" title="访问 <?php echo ($vo["alc_name"]); ?> 的网站?">
	                    		<img src="<?php echo ($vo["alc_img"]); ?>" class="img-circle img-45"/>
	                    	<?php else: ?>
	                    		<img src="<?php echo ($vo["alc_img"]); ?>" class="img-circle img-45"/><?php endif; ?>
	        				<div class="content-name"><a><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;</a><?php echo ($vo["alc_name"]); ?></div>
	                  		<div class="content-remark">
	                  			<span class="label label-primary ">相册</span>&nbsp;&nbsp;<a href="<?php echo U('/album-'.$vo['alc_pid']);?>" title="<?php echo (delFace($vo["alc_content"])); ?>" ><?php echo (msubstr(strip_tags(delFace($vo["alc_content"])),0,19,'utf-8',ture)); ?></a>
	                  		</div>
	                	</li><?php endif; ?>
	        		<?php if(!empty($vo["sc_id"])): ?><li>
	        				<?php if(!empty($vo["sc_url"])): ?><a href="<?php echo ($vo["sc_url"]); ?>" target="_blank" rel="nofollow" title="浏览 <?php echo ($vo["s_c_name"]); ?> 的网站？">
	             				<img src="<?php echo ($vo["sc_img"]); ?>" class="img-circle img-45"/></a>
	             			<?php else: ?>
	             				<img src="<?php echo ($vo["sc_img"]); ?>" class="img-circle img-45"/><?php endif; ?>
	           				<div class="content-name"><a><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;</a><?php echo ($vo["sc_name"]); ?></div>
	          				<div class="content-remark">
	         					<span class="label label-info ">说说</span>&nbsp;&nbsp;<a href="<?php echo U('/feel-'.$vo['sc_pid']);?>" title="<?php echo (delFace($vo["sc_content"])); ?>" ><?php echo (msubstr(strip_tags(delFace($vo["sc_content"])),0,19,'utf-8',ture)); ?></a>
	          				</div>               				
	        			</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
	      	</ul>
	     	</div>
	        <div class="tab-pane " id="content">
	        <ul class="content-ul">
	            <?php if(is_array($gusts)): $i = 0; $__LIST__ = $gusts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
	          			<?php if(!empty($v["g_url"])): ?><a href="<?php echo ($v["g_url"]); ?>" target="_blank" rel="nofollow" title="浏览 <?php echo ($v["g_name"]); ?> 的网站?">
	                		<img src="<?php echo ($v["g_img"]); ?>" class="img-circle img-45"/></a>
	                	<?php else: ?>
	                		<img src="<?php echo ($v["g_img"]); ?>" class="img-circle img-45"/><?php endif; ?>
	          			<div class="content-name"><a><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;</a><?php echo ($v["g_name"]); ?></div>
	          			<div class="content-remark">
	          				<a href="<?php echo U('/gust');?>" title="<?php echo (delFace($v["g_content"])); ?>" ><?php echo (msubstr(strip_tags(delFace($v["g_content"])),0,19,'utf-8',ture)); ?></a>
	          			</div>
	          		</li><?php endforeach; endif; else: echo "" ;endif; ?>
	        </ul>
	        </div>
	     	<div class="tab-pane " id="hot">
	        <ul class="hot-ul">
	          	<?php if(is_array($hits)): $i = 0; $__LIST__ = $hits;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><a><span class="glyphicon glyphicon-fire"></span></a>&nbsp;&nbsp;<a href="<?php echo U('/article-'.$v['a_id']);?>" ><?php echo (mb_substr($v["a_title"],0,25,'utf-8')); ?></a>(<?php echo ($v["a_hit"]); ?>)</li><?php endforeach; endif; else: echo "" ;endif; ?>
	        </ul>
	     	</div>
	  	</div>
	</div>
	<div class="sider-box2">
  	<h4 class="link"><span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;友情链接</h4>
	  	<ul class="link-ul">
	    	<?php if(is_array($link)): $i = 0; $__LIST__ = $link;if( count($__LIST__)==0 ) : echo "暂时没有友情链接" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($v["l_url"]); ?>" target="_blank" title="<?php echo ($v["l_name"]); ?>"><?php echo ($v["l_name"]); ?></a></li><?php endforeach; endif; else: echo "暂时没有友情链接" ;endif; ?>
	  	</ul>
	</div>
</div>
</div>
</div>
    <div class="container-footer">
	<div class="container footer">
		<div class="row footer-all">
			<div class="col-md-3 hidden-xs">
				<h4>程序统计</h4>
					<p class="foot-box1">
						<a><span class="glyphicon glyphicon-comment"></span></a>&nbsp;&nbsp;微说：&nbsp;<?php echo (chenkNum($num["say"])); ?> 条
						<span class="foot-box1-r">
						<a><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;文章：&nbsp;<?php echo (chenkNum($num["article"])); ?> 篇
						</span>
					</p> 
					<p class="foot-box1">
						<a><span class="glyphicon glyphicon-envelope"></span></a>&nbsp;&nbsp;评论：&nbsp;<?php echo (chenkNum($num["comment"])); ?> 条
						<span class="foot-box1-r">
						<a><span class="glyphicon glyphicon-send"></span></a>&nbsp;&nbsp;留言：&nbsp;<?php echo (chenkNum($num["gust"])); ?> 条
						</span>
					</p>
					<p class="foot-box1">
						<a><span class="glyphicon glyphicon-home"></span></a>&nbsp;&nbsp;建站：&nbsp;<?php echo (getDay($system["createtime"])); ?> 天
						<span class="foot-box1-r">
						<a><span class="glyphicon glyphicon-camera"></span></a>&nbsp;&nbsp;相册：&nbsp;<?php echo (chenkNum($num["album"])); ?> 个
						</span>
					</p>
					<p class="foot-box1">
						<a><span class="glyphicon glyphicon-picture"></span></a>&nbsp;&nbsp;图片：&nbsp;<?php echo (chenkNum($num["picture"])); ?> 张
						<span class="foot-box1-r">
						<a><span class="glyphicon glyphicon-link"></span></a>&nbsp;&nbsp;链接：&nbsp;<?php echo (chenkNum($num["link"])); ?> 条
						</span>
					</p>
					<p class="foot-box1">
						<a><span class="glyphicon glyphicon-tree-conifer"></span></a>&nbsp;&nbsp;访问：&nbsp;<?php echo (chenkNum($system["hit"])); ?> 次
					</p> 
			</div>
			<div class="col-md-3 ">
				<h4>程序交流</h4>
					<p class="foot-box1">
						Q群：<a href="http://jq.qq.com/?_wv=1027&k=dSjBgy" target="_blank" class="foot-my"><strong>455466010</strong></a>
						<span class="foot-box1-r">
						<a><span class="glyphicon glyphicon-heart-empty"></span></a>
						&nbsp;<a href="http://koubei.baidu.com/w/loveteemo.com" target="_blank" class="foot-my">&nbsp;邀你点评</a>
						</span>
					</p>
					<p class="foot-box1">
						程序：&nbsp;<?php echo (C("NAME")); ?>
						<span class="foot-box1-r">
						版本：&nbsp;Beta <?php echo ($version); ?>
						</span>
					</p> 
					<p class="foot-box1">
						框架：&nbsp;<?php echo (C("FRAME")); ?>
						<span class="foot-box1-r">
						语言：&nbsp;<?php echo (C("LANG")); ?>
						</span>
					</p> 
					<p class="foot-box1">
						编码：&nbsp;<?php echo (C("CHARSET")); ?>
						<span class="foot-box1-r">
						作者：&nbsp;<?php echo (C("AUTHOR")); ?>
						</span>
					</p>
					<p class="foot-box1">
						源码声明：&nbsp;请参考&nbsp;&nbsp;<a href="http://www.kancloud.cn/iamhappy/blog?token=crMXYD8ksUyt" class="foot-my">使用手册</a>
					</p>
			</div>
			<div class="col-md-3 hidden-xs">
				<h4>推荐文章</h4>
					<?php if(is_array($f_article)): $i = 0; $__LIST__ = $f_article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><p class="foot-box3"><a><span class="glyphicon glyphicon-thumbs-up"></span></a>&nbsp;&nbsp;<a href="<?php echo U('/article-'.$vo['a_id']);?>" title="<?php echo ($vo["a_title"]); ?>" class="foot-my"><?php echo ($vo["a_title"]); ?></a></p><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<div class="col-md-3 hidden-xs">
			<h4>我的相册</h4>
				<ul class="picture-ul">
					<?php if(is_array($foot_album)): $i = 0; $__LIST__ = $foot_album;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
						<a href="<?php echo U('/album-'.$vo['al_id']);?>" target="_blank" title="<?php echo ($vo["al_name"]); ?>"><img class="img-rounded img-50" src="<?php echo ($vo["al_img"]); ?>" alt="<?php echo ($vo["al_name"]); ?>"></a>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</div>
		</div>
		<div class="row bottom">
			<div class="col-md-6 col-sm-5 bottom-left">
				<?php echo ($system["copy"]); ?>
			</div>     
			<div class="col-md-6 col-sm-7 bottom-right hidden-xs">
				<?php echo ($system["footer"]); ?>&nbsp;|&nbsp;<?php echo ($system["icp"]); ?>
			</div> 
		</div>
	</div>
</div>
<div id="toTop" class="hidden-xs" style="display: none;"><span class="glyphicon glyphicon-chevron-up toTop-img"></span></div>
<!-- 新年雪花效果开始 -->
<style type='text/css'>
/*@media (min-width: 767px){*/
/*.snowwrap,.snow-container{position: fixed; top: 0; left: 0; width: 100% !important; height: 100%; pointer-events: none; z-index: 100001;}*/
/*}*/
</style>
<!-- <div class="snowwrap hidden-xs"> -->
    <!-- <div class="snow-container hidden-xs"></div> -->
<!-- </div> -->
<!-- 新年雪花效果结束 -->
<script src="/Public/Js/jquery-1.10.1.min.js" ></script>
<!-- 雪花效果JS -->
<!-- <script src='/Public/Js/snow.js'></script> -->
<script src="/Public/Js/bootstrap.min.js" ></script>
<script src="/Public/Js/common.js"></script>
<script src="/Public/Js/rl_exp.js"></script>   	
<script src="/Public/Js/jquery.fancybox.js"></script>	
</body>
</html>