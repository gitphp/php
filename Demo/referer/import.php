<?Php
if(isset($_SERVER['HTTP_REFERER'])){
 //取出来
 // $_SERVER['HTTP_REFERVER']是不是以http://localhost开头
   if(strpos($_SERVER['HTTP_REFERER'],"http://www.s.com/Demo/referer")==0){
      echo"我的账号是184626101<br/>";
      echo"我的密码是qw4598765fkdg";
   }else{
    // 跳转
	 header("Location:warning.php");
   }
}else{
 // 跳转
  header("Location:warning.php");
}


?>