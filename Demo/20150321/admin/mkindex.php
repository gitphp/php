<?php
// admin index
$conn = mysql_connect("localhost",'root','root');
mysql_query("use bbs");
mysql_query("set names utf8");
$sql="select * from  news";
$list=array();
$res = mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($res)){
    $list[]=$row;
}
ob_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<script type="text/javascript">

</script>

<style type="text/css">
</style>
</head>
    <body>
            <h1>新闻列表页面</h1>
            <h1><a href="mkindex.php">前台首页</a></h1>
            <table width="500" border="1">
                <tr><td>新闻标题</td><td>新闻详情</td></tr>
                <?php foreach($list as $v){?>
                    <tr><td><?php echo $v['title']?></td><td><a href="<?php echo $v['filename']?>">新闻详情</a></td></tr>
                <?php }?>
            </table>
    </body>
</html>
<?php
$str=ob_get_contents();
ob_clean();
file_put_contents('../index.html',$str);

echo '<a href="../index.html">Index__index</a>';

?>


