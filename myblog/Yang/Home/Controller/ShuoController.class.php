<?php
namespace Home\Controller;
use Think\Controller;

/*
 * 个人说说控制器
*/
class ShuoController extends HomeController {
	/*
	 * 首页显示方法
	*/
    public function index(){
        // 取出所有的说说数据、分页(20)条
        $dao=new \Model\ShuoModel();
        $p=$_GET['p']?$_GET['p']:1;
        $list = $dao->page($p.',10')->order('id desc')->select();
        $this->assign('data',$list);
        $count      = $dao->count();
        $Page       = new \Think\Page($count,10);
        // $Page->setConfig('prev','上一页');
        // $Page->setConfig('next','下一页');
        $Page->setConfig('header','总'.$count.'共');

        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出   
    	// 分配title,keywords,description,样式,Js
    	$this->assign(array(
    		'title'=>'个人说说—分享我的IT生活的个人网站',
    		'keywords'=>'巨鹿博客,PHP技术博客,个人网站,后端程序开发',
    		'description'=>'杨松个人PHP博客，是一个刚入门web后端开发的程序员个人技术博客，提供个人技术分享，免费PHP教程分享的个人原创网站。',
    		'css'=>array('mood.css','base.css'),
			'js'=>array('jquery-1.9.1.min.js','js.js'),
    	));
		$this->display();
    }

    
}