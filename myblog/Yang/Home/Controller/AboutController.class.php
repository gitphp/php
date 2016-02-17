<?php
namespace Home\Controller;
use Think\Controller;

/*
 * 关于作者控制器
*/
class AboutController extends HomeController {
	/*
	 * 首页显示方法
	*/
    public function index(){
    	// 分配title,keywords,description
    	$this->assign(array(
    		'title'=>'关于巨鹿博客—一个刚入门web后端开发的码农程序员的个人网站',
    		'keywords'=>'巨鹿博客,PHP技术博客,个人网站,后端程序开发',
    		'description'=>'杨松个人PHP博客，是一个刚入门web后端开发的程序员个人技术博客，提供个人技术分享，免费PHP教程分享的个人原创网站。',
    		'css'=>array('about.css','base.css')
    	));
		$this->display();
    }
}