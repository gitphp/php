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

 

<article class="blogs">
<h1 class="t_nav"><span>好咖啡要和朋友一起品尝，好“模板”也要和同样喜欢它的人一起分享。 </span><a href="/" class="n1">网站首页</a><a href="#" class="n2">模板分享</a></h1>
<div class="newblog left">
  
<!--文章列表-->
<?php foreach($data as $v):?>

    <h2><a title="<?php echo $v['title']?>" href="/index.php/Home/Article/detail/id/<?php echo $v['id']?>" ><?php echo $v['title']?></a></h2>
    <p class="dateview">
      <span>发布时间：<?php echo date('Y-m-d',$v['addtime'])?></span>
      <span>作者：<?php echo $v['author']?></span>
      <span>[<a href=/>PHP技术分享</a>]</span>
    </p>
    <figure>
      <a title="<?php echo $v['title']?>" href="/index.php/Home/Article/detail/id/<?php echo $v['id']?>" >
        <img src="<?php echo IMG_URL . $v['arc_pic']?>" alt="<?php echo $v['title']?>" >
      </a>
    </figure>
    <ul class="nlist">
      <p><?php echo $v['remark']?></p>
      <a href="/index.php/Home/Article/detail/id/<?php echo $v['id']?>" title="<?php echo $v['title']?>" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <div class="line"></div>

<?php endforeach;?>
<!--文章列表-->


    <div class="blank"></div>
   <div class="page">
   <?php echo $page?>
   </div>
</div>
<aside class="right">
<script type="text/javascript">document.write(unescape('%3Cdiv id="bdcs"%3E%3C/div%3E%3Cscript charset="utf-8" src="http://znsv.baidu.com/customer_search/api/js?sid=14370360379971546235') + '&plate_url=' + (encodeURIComponent(window.location.href)) + '&t=' + (Math.ceil(new Date()/3600000)) + unescape('"%3E%3C/script%3E'));</script>
<div class="blank"></div>
   <div class="rnav">
      <h2>栏目导航</h2>
      <ul>


      <?php foreach($cats as $k=>$v):?>
      <li class="rnav<?php echo $k+1;?>">
      <?php if($v['id']==9):?>
      <a href="/index.php/Home/Article/xc" target="_blank">
        <?php echo $v['catname'];?>
      <?php else:?>
      <a href="/index.php/Home/Article/index/id/<?php echo $v['id'];?>" target="_blank">
      <?php echo $v['catname'];?>
      <?php endif;?>
      </a>
      </li>
    <?php endforeach;?>


     </ul>      
    </div>
<div class="rnavs">
      <h2>栏目导航</h2>
      <ul>

      <?php foreach($cats as $k=>$v):?>
        <li class="rnav<?php echo $k+1;?>">
        <a href="/index.php/Home/Article/index/id/<?php echo $v['id'];?>" target="_blank">
          <?php echo $v['catname'];?>
        </a>
        </li>
      <?php endforeach;?> 

     </ul>      
    </div>
<div class="news">
<h3>
      <p>最新<span>模板</span></p>
    </h3>
    <ul class="rank">
      <?php foreach($new_arcs as $v):?>
        <li><a href="/index.php/Home/Article/detail/id/<?php echo $v['id']?>" title="<?php echo $v['title']?>" target="_blank"><?php echo $v['title']?></a></li>
      <?php endforeach;?>    
    </ul>
    <h3 class="ph">
      <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
      <?php foreach($click_arcs as $vv):?>
        <li><a href="/index.php/Home/Article/detail/id/<?php echo $vv['id']?>" title="<?php echo $vv['title']?>" target="_blank"><?php echo $vv['title']?></a></li>
        <?php endforeach;?> 
    </ul>
    </div>
<a href="http://shop35160146.taobao.com/index.htm" target="_blank">
  <img src="<?php echo IMG_URL.'Ad/shi.jpg'?>" alt="美国进口健康零食">
</a>
<script type="text/javascript">
var cpro_id="u2063915";
(window["cproStyleApi"] = window["cproStyleApi"] || {})[cpro_id]={at:"3",rsi0:"250",rsi1:"250",pat:"6",tn:"baiduCustNativeAD",rss1:"#FFFFFF",conBW:"1",adp:"1",ptt:"1",ptc:"%E7%8C%9C%E4%BD%A0%E6%84%9F%E5%85%B4%E8%B6%A3",ptFS:"14",ptFC:"#000000",ptBC:"#F2F2F2",titFF:"%E5%BE%AE%E8%BD%AF%E9%9B%85%E9%BB%91",titFS:"14",rss2:"#000000",titSU:"0",ptbg:"90",piw:"0",pih:"0",ptp:"0"}
</script>
<script src="../../cpro.baidustatic.com/cpro/ui/c.js" type="text/javascript"></script>

   <div class="visitors">
      <h3><p>最近访客</p></h3>




<ul class="ds-recent-visitors"  data-num-items="24"></ul>
<!--多说js加载开始，一个页面只需要加载一次 -->
<script type="text/javascript">
var duoshuoQuery = {short_name:"youngsong"};
(function() {
    var ds = document.createElement('script');
    ds.type = 'text/javascript';ds.async = true;
    ds.src = 'http://static.duoshuo.com/embed.js';
    ds.charset = 'UTF-8';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
})();
</script>
<!--多说js加载结束，一个页面只需要加载一次 -->




    </div>
</aside>
</article>
<div id="tbox"> <a id="togbook" href=""></a> <a id="gotop" href="javascript:void(0)"></a> </div>

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