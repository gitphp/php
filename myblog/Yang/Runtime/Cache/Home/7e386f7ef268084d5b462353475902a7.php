<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<?php foreach ($css as $v):?>
	<link rel="stylesheet" href="/Public/Home/css/<?php echo $v;?>" type="text/css">
<?php endforeach;?>
<?php foreach ($js as $v):?>	
	<script type="text/javascript" src="/Public/Home/js/<?php echo $v;?>"></script>
<?php endforeach;?>
<!--[if lt IE 9]>
<script src="skin/2014/js/modernizr.js"></script>
<![endif]-->
<meta property="qc:admins" content="432060664761167116375" />
</head>
<body>

 <header>
  <div id="logo"><a href="/"></a></div>
  <nav class="topnav" id="topnav">
	  <a href="/"><span>首页</span><span class="en">Protal_index</span></a>
	  <a href="/index.php/Home/About/index"><span>关于我</span><span class="en">SongYoung</span></a>
	  <a href="/index.php/Home/Life/index"><span>IT生活</span><span class="en">IT_Life</span></a>
	  <a href="/index.php/Home/Shuo/index"><span>细言细语</span><span class="en">Say_Any</span></a>
	  <a href="/index.php/Home/Article/index"><span>模板下载</span><span class="en">Share_Html</span></a>
	  <a href="/index.php/Home/Article/index"><span>技术分享</span><span class="en">Learn_Every</span></a>
	  <a href="/index.php/Home/Wish/index"><span>许愿墙</span><span class="en">Wish_Now</span></a>
	  <a href="/index.php/Home/Message/index"><span>留言版</span><span class="en">Guest_Book</span></a></nav>
  </nav>
</header>

 

<div class="banner">
  <section class="box">
    <ul class="texts">
      <p><?php echo $msg[0]['msg1'];?></p>
      <p><?php echo $msg[0]['msg2'];?></p>
      <p><?php echo $msg[0]['msg3'];?></p>
    </ul>
    <div class="avatar"><a href="/index.php/Home/About/index"><span>杨松</span></a> </div>
  </section>
</div>
<div class="template">
  <div class="box">
    <h3><p><span>个人博客</span>模板 Templates</p></h3>


    <ul>
      <?php foreach($top_arcs as $top):?>
      <li>
        <a href="/index.php/Home/Article/detail/id/<?php echo $top['id']?>" title="<?php echo $top['title']?>" >
        <img src="<?php echo IMG_URL . $top['arc_pic']?>" alt="<?php echo $top['title']?>">
        </a>
        <span><?php echo $top['title']?></span>
      </li>
       <?php endforeach;?>
    </ul>


  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
<!--文章推荐-->
  <div class="bloglist left">
<?php foreach($arc_list as $v):?>

    <h3><a href="/index.php/Home/Article/detail/id/<?php echo $v['id']?>" ><?php echo $v['title']?></a></h3>
    <figure><img src="<?php echo IMG_URL . $v['arc_pic']?>" alt="<?php echo $v['title']?>"></figure>
    <ul>
      <p><?php echo $v['remark']?></p>
      <a title="<?php echo $v['title']?>" href="/index.php/Home/Article/detail/id/<?php echo $v['id']?>"  target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview"><span><?php echo date('Y-m-d', $v['addtime'])?></span><span>作者：<?php echo $v['author']?></span><span>个人博客：[<a href=/index.php/Home/Article/index/id/<?php echo $v['cat_id']?>><?php echo $v['catname']?></a>]</span></p>    
    
<?php endforeach;?>
  </div>

  <aside class="right">
    <div class="weather"></div>
    <div class="news">
<!--最新文章-->
    <h3>
      <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
<?php foreach($new_arcs as $vv):?>

       <li><a href="/index.php/Home/Article/detail/id/<?php echo $vv['id']?>" title="<?php echo $vv['title']?>" target="_blank"><?php echo $vv['title']?></a></li>
<?php endforeach;?>
    </ul>
<!--点击排行-->
    <h3 class="ph">
      <p>模板<span>排行</span></p>
    </h3>
    <ul class="paih">
<?php foreach($click_arcs as $vvv):?>
     <li><a href="/index.php/Home/Article/detail/id/<?php echo $vvv['id']?>" title="<?php echo $vvv['title']?>" target="_blank"> <?php echo $vvv['title']?></a></li>
<?php endforeach;?>
    </ul>

<!--友情链接-->
    <h3 class="links">
      <p>友情<span>链接</span></p>
    </h3>
    <ul class="website">
  <?php foreach($links as $li):?>
      <li><a href="<?php echo $li['link_url']?>" target="_blank"><?php echo $li['link_name']?></a></li>
  <?php endforeach;?>
    </ul>     

<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<div class="guanzhu">扫描二维码关注<span>杨松博客</span>官方微信公众账号</div>   
    <a href="/" class="weixin"></a></aside>
</article>

<div id="tbox"> <a id="togbook" href="/"></a> <a id="gotop" href="javascript:void(0)"></a> </div>




 <footer>
  <p>Design by SoungYoung - 2015 copyright <a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备4873473号-18868</a> 
  <script type="text/javascript">
	var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
	document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Ff655f558c510211e38805f6b586e6b15' type='text/javascript'%3E%3C/script%3E"));
	</script>
</p>
</footer>
<script src="/Public/Home/js/silder.js"></script>
<script type="text/javascript">
    /*图 推广-juulu.com*/
var cpro_id = "u1685956";
</script>
<script src="../cpro.baidustatic.com/cpro/ui/i.js" type="text/javascript"></script>
<script type="text/javascript">
    /*yangsong内文- 创建于 2015-11-29*/
var cpro_id = "u1831141";
</script>
<script src="../cpro.baidustatic.com/cpro/ui/cnw.js" type="text/javascript"></script>
</body>
</html>