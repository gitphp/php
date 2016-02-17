<?php
namespace Wife\Controller;
use Think\Controller;
class ArticleController extends WifeController{
	
	/**
	 * 显示文章列表
	 */
	public function index(){
		$art=new \Model\ArticleModel();
		$p=$_GET['p']?$_GET['p']:1;
		$list = $art->page($p.',10')->select();
		$this->assign('data',$list);
		$count      = $art->count();
		$Page       = new \Think\Page($count,10);
		$show       = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出	
		// dump($list);
		$this->display();
		// $data=$art->find(2);
		// $data['content']=htmlspecialchars_decode($data['content']);
		// echo $data['content'];
		/* 
		load('extend');			// 导入扩展函数(对中文字符串的截取)
		import("ORG.Util.Page");// 导入分页类
			
		$n = M('news');
		$count = $n->count();
		$page = new Page($count,12);
		$show = $page->show();

		if (!isset($_GET['search'])){
			$list = checkTrip($n->order('add_time desc')->limit($page->firstRow.','.$page->listRows)->select());
		}else{
			//按留言标题、留言姓名
			$methodone = isset($_GET['search_bzb']) ?$_GET['search_bzb'] : '';
			$bzb = $_GET['bzb'];

			if ($bzb !== ''){
				$sql = $methodone.' like "%'.$bzb.'%"';
			}			
			
			//按添加时间排序
			$methodtwo = $_GET['search_tdb'];
			$px = $_GET['order'];
			$order = $methodtwo.' '.$px;
			
			//筛选
			if (isset($_GET['sh'])){
				if ($_GET['sh'] != 'status'){
					$ha = 'sh = '.$_GET['sh']; 
				}		
			}
	
			foreach ($_GET as $k=>$v){
				if ($_GET[$k]==='') unset($_GET[$k]);
			}
			//查找记录后,更新显示条数
			$count = count($n->where($sql)->having($ha)->select());
			
			$page = new Page($count,12);

			$list = checkTrip($n->where($sql)->having($ha)->order($order)->limit($page->firstRow.','.$page->listRows)->select());
			$show = $page->show();	
					
			foreach($list as $key=>$val){
				 $val[$methodone] = str_replace($bzb,'<p>'.$bzb.'</p>',$val[$methodone]);
				 $list[$key][$methodone] = $val[$methodone];
			}		
		}
		
		$this->assign('list',$list);
		$this->assign('page',$show); */

		$this->display();
	}
	
	//添加新闻
	public function add(){
		$wen=new \Model\ArticleModel();
		if(IS_POST){
			if($wen->create()){
				if($wen->add()){
					$this->success('添加成功');exit;
				}
			}
			$this->error($wen->getError());
		}
		$cat=new \Model\CategoryModel();
		$this->data=$cat->getCats();
		$this->display();	
	}
	
	
	
	//删除新闻
	public function del(){
		// 批量删除这里就不做了，本来删除数据就不允许，怎么还可以批量删除呢
		$wen=new \Model\ArticleModel();	
		$id=I('get.id');
		echo $id;exit;
		if($wen->delete('$id')){
			$this->success('删除文章成功');exit;
		}else{
			$this->error('删除文章失败');
		}
	}
	/*
	 * 修改文章内容方法
	 */
	public function edit(){
		$wen=new \Model\ArticleModel();	
		if(IS_POST){
			if($wen->create()){
				$wen->edittime=time();
				if($wen->save()){
					$this->success('修改成功',U('Article/index'));exit;
				}
			}
			$this->error('修改失败');
		}
		$cat=new \Model\CategoryModel();
		$this->data=$cat->getCats();
		$id=I('get.id');
		$this->data1=$wen->find($id);
		$this->display();
	}

	/*
	 * ajax 动态切换发布与不发布状态
	 */
	public function fb(){
		$wen=new \Model\ArticleModel();	
		$id = I('post.id');
		$list = $wen->field('status')->where('id='.$id)->find();
		$status = $list['status']==0 ? 1 : 0;
		if($wen->where('id='.$id)->save(array('status'=>$status))){
			echo $status;
		}
	}


	//AJAX上传
function upfile(){//上传文件
	header('Content-Type: text/html; charset=UTF-8');
	$inputName='filedata';//表单文件域name
	$attachDir='Public/Uploads/upimgs';//上传文件保存路径，结尾不要带/
	$dirType=1;//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
	$maxAttachSize=2097152;//最大上传大小，默认是2M
	$upExt='txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';//上传扩展名
	$msgType=2;//返回上传参数的格式：1，只返回url，2，返回参数数组
	$immediate=isset($_GET['immediate'])?$_GET['immediate']:0;//立即上传模式
	ini_set('date.timezone','Asia/Shanghai');//时区
	$err = "";
	$msg = "''";
	$tempPath=$attachDir.'/'.date("YmdHis").mt_rand(10000,99999).'.tmp';  //临时文件
	$localName=''; //上传文件名称

if(isset($_SERVER['HTTP_CONTENT_DISPOSITION'])&&preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info)){//HTML5上传
	file_put_contents($tempPath,file_get_contents("php://input"));
	$localName=urldecode($info[2]);
}else{//标准表单式上传
	$upfile=@$_FILES[$inputName];
	if(!isset($upfile)){
		$err='文件域的name错误';
	}elseif(!empty($upfile['error'])){
		switch($upfile['error'])
		{
			case '1':
				$err = '文件大小超过了php.ini定义的upload_max_filesize值';
				break;
			case '2':
				$err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
				break;
			case '3':
				$err = '文件上传不完全';
				break;
			case '4':
				$err = '无文件上传';
				break;
			case '6':
				$err = '缺少临时文件夹';
				break;
			case '7':
				$err = '写文件失败';
				break;
			case '8':
				$err = '上传被其它扩展中断';
				break;
			case '999':
			default:
				$err = '无有效错误代码';
		}
	}elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none'){
		$err = '无文件上传';
	}else{
		move_uploaded_file($upfile['tmp_name'],$tempPath);
		$localName=$upfile['name'];  
	}
}
if($err==''){//如果没有错将刚上传的文件移动到指定的目录
	$fileInfo=pathinfo($localName);
	$extension=$fileInfo['extension'];
	if(in_array($extension,explode(',',$upExt)))
	{
		$bytes=filesize($tempPath);
		if($bytes > $maxAttachSize){
			$err='请不要上传大小超过'.formatBytes($maxAttachSize).'的文件';
		}else{
			switch($dirType)
			{
				case 1: $attachSubDir = 'day_'.date('ymd'); break;
				case 2: $attachSubDir = 'month_'.date('ym'); break;
				case 3: $attachSubDir = 'ext_'.$extension; break;
			}
			$attachDir = $attachDir.'/'.$attachSubDir;
			if(!is_dir($attachDir))
			{
				@mkdir($attachDir, 0777);
			}
			$newFilename=date("YmdHis").mt_rand(100,999).'.'.$extension;
			$targetPath = $attachDir.'/'.$newFilename;
			@chmod($targetPath,0755);
			rename($tempPath,$targetPath);
			//$targetPath=$this->jsonString($targetPath);
			$msg="{'url':'".$this->baseroot.'/'.$targetPath."','localname':'".$this->jsonString($localName)."'}";
			$f = @fopen($this->notetxt,'a+');
			fwrite($f,$this->baseroot.'/'.$targetPath."\r\n");
		}
	}else $err='上传文件扩展名必需为：'.$upExt;
	
	@unlink($tempPath); //删除临时文件
}
echo "{'err':'".$this->jsonString($err)."','msg':".$msg."}";
}	

protected function jsonString($str)
{
	return preg_replace("/([\\\\\/'])/",'\\\$1',$str);
}

protected function getimg($cont){//获取内容中所有图片
	preg_match_all('/<img src="(.*?)".*?\/>/',$cont,$arr);
	return $arr[1];
}

protected function noteimg($path='public/files.txt'){//获取文本中记录的所有图片
	$files =  file($path);
	foreach($files as &$f){
		$f = preg_replace('/\s$/m','',$f);
	}
	return $files;
}

protected function delfile($more,$few){
	$files = array_diff($more,$few);
	$fs = $this->noteimg();
	$delfs = array();
	foreach($files as $v){
		$v1=str_replace($this->baseroot.'/','',$v);
		if(is_file($v1)){
			if(unlink($v1)){
				$delfs[] = $v."\r\n";
			}	
		}	
	}
	$f = str_replace($delfs,'',file_get_contents($this->notetxt)); //将已删除的文件路径从public/files.txt中删除
	file_put_contents($this->notetxt,$f);
}




}

?>