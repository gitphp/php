<?Php
if(isset($_SERVER['HTTP_REFERER'])){
 //ȡ����
 // $_SERVER['HTTP_REFERVER']�ǲ�����http://localhost��ͷ
   if(strpos($_SERVER['HTTP_REFERER'],"http://www.s.com/Demo/referer")==0){
      echo"�ҵ��˺���184626101<br/>";
      echo"�ҵ�������qw4598765fkdg";
   }else{
    // ��ת
	 header("Location:warning.php");
   }
}else{
 // ��ת
  header("Location:warning.php");
}


?>