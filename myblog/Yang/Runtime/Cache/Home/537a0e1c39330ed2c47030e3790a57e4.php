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

 

<div class="moodlist">
  <h1 class="t_nav"><span>写写姗姗，点点滴滴，生活本应如此，却还是继续坚持。</span><a href="/" class="n1">网站首页</a><a href="#" class="n2">细说细雨</a></h1>
  <div class="bloglist">

  <?php foreach($data as $v):?>
    <ul class="arrow_box">
     <div class="sy">
     <p>
     <?php  if ($v['img_url']) { echo "<img width='150px' src='" . IMG_URL.$v['img_url'] ."' alt='" . substr($v['content'],0,30) ."' />"; } echo $v['content']; ?>
     
     </p>
     </div>
      <span class="dateview"><?php echo date('Y-m-d',$v['addtime']);?></span>
    </ul>    
  <?php endforeach;?>

  </div>

<?php echo $page?>

<div id="tbox"> <a id="togbook" href="/index.php/Home/Message/index"></a> <a id="gotop" href="javascript:void(0)"></a> </div>

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