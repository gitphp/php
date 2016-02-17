<?php
namespace Wife\Controller;
use Think\Controller;
class MessageController extends WifeController{
	public function index(){
		$m=new \Model\MessageModel(); 
		$p=$_GET['p']?$_GET['p']:1;
		$list = $m->where('mess_status=1')->page($p.',10')->select();
		$this->assign('list',$list);
		$count      = $m->where('mess_status=1')->count();
		$Page       = new \Think\Page($count,10);
		$show       = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		$this->display(); // 输出模板
		/* 
		load('extend');			// 导入扩展函数(对中文字符串的截取,过滤html)
		import("ORG.Util.Page");// 导入分页类
		
		$m = M('msgs');
		$count = $m->count();
		$page = new Page($count,20);
		$show = $page->show();
		
		//后台的首页查看未读留言
		if (isset($_GET['allmsg']) && isset($_GET['act'])){
			if ($_GET['allmsg'] ==0 && $_GET['act']=='nread'){
				$list = checkTrip($m->where('m_status=0')->order('m_id desc')->select());
			}
			$this->assign('list',$list);
			$this->display();
			return;
		}
		
		if (!isset($_GET['search'])){
			$list = checkTrip($m->order('m_time desc')->limit($page->firstRow.','.$page->listRows)->select());
		}else{
			//查看所有留言、已读、未读
			$sql = '';
			if (isset($_GET['allmsg'])){
				if ($_GET['allmsg']!='status'){
					$sql = 'm_status='.$_GET['allmsg'];
				}
			}
			
			//按留言标题、姓名查找
			$methodone = isset($_GET['search_bzb']) ?$_GET['search_bzb'] : '';
			$bzb = $_GET['bzb'];
			
			if ($bzb !== ''){
				$and = (isset($_GET['allmsg']) && $_GET['allmsg']!='status')  ? ' and ' : '';
				$sql .= $and.$methodone.' like "%'.$bzb.'%"';
			}
			
			//按添加时间排序
			$methodtwo = $_GET['search_tdb'];
			$px = $_GET['order'];
			$order = $methodtwo.' '.$px;
			
			foreach ($_GET as $k=>$v){
				if ($_GET[$k]==='') unset($_GET[$k]);
			}
			
			//查找记录后,更新显示条数
			$count = $m->where($sql)->order($order)->count();
			$page = new Page($count,20);
			$show = $page->show();
						
			$list = checkTrip($m->where($sql)->order($order)->limit($page->firstRow.','.$page->listRows)->select());
			
			foreach($list as $key=>$val){
				 $val[$methodone] = str_replace($bzb,'<p>'.$bzb.'</p>',$val[$methodone]);
				 $list[$key][$methodone] = $val[$methodone];
			}
		}
		
		$this->assign('list',$list);
		$this->assign('page',$show); */
		
	}
	
	//阅读留言
	public function readMsg(){
		$m=new \Model\MessageModel(); 
		$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
		$list = $m->find($id);
		$this->assign('list',$list);
		$this->display();
	}
	
	//删除留言
	public function delNew(){
		header('Content-Type:text/html;charset=utf-8');
		$m = M('msgs');		
		
		$ids = rtrim($_GET['mid'],',');

		if ($m->where('m_id in('.$ids.')')->delete()){
			echo '<script>alert("删除成功");location.href="'.__URL__.'"</script>';
		}else{
			echo '<script>alert("删除失败");location.href="'.__URL__.'"</script>';
		}
	}
}