<?php
namespace Home\Controller;
use Think\Controller;
/*
 * 前台首页控制器
*/
class WishController extends HomeController {
	/*
	 * 首页显示方法
	*/
    public function index(){
		$w=new \Model\WishModel();
		$this->data=$w->limit(99)->select();
		$this->assign(array(
    		'title'=>'杨松个人PHP技术博客 - 一个刚入门web后端开发的码农程序员的个人网站',
    		'keywords'=>'个人博客,杨松PHP博客,程序员技术博客,静态模板,PHP个人网站',
    		'description'=>'杨松个人PHP博客，是一个刚入门web后端开发的程序员个人技术博客，提供个人技术分享，免费PHP教程分享的个人原创网站。',
    		'css'=>array('base.css','index.css')
    	));
		$this->display();
    }
	/*
	 * 添加ajax传过来的数据
	*/
	public function addAjaxData(){
		$w=new \Model\WishModel();
		if(!empty($_POST)){
			$data['username']=I('post.username');
			$data['content']=I('post.content');
			$data['addtime']=time();
			$data['user_ip']=get_client_ip();
		}
		// 判断一个ip是否留言多次：我们规定一个ip只可以留言2次
		$res=$w->where('user_ip="'.$data['user_ip'].'"')->count();
		if($res >= 2){
			echo '你已经许过2次愿了，请给别人多一次机会吧';exit;
		}
		// 执行添加数据入库
		if($w->add($data)){
			echo '恭喜你，许愿成功!等待博主帮您实现愿望...';exit;
		}else{
			echo '不好意思，许愿失败了...'.$w->getLastSql();
		}
	}
}