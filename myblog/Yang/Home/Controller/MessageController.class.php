<?php
namespace Home\Controller;
use Think\Controller;

/*
 * 个人留言板控制器
 * EditTile:2015-11-21 17:12:59
 * Auth:Young、
 */
class MessageController extends HomeController {
	/*
	 * 首页显示方法
	*/
    public function index(){
    	// 分配title,keywords,description
    	$this->assign(array(
    		'title'=>'关于巨鹿博客—一个刚入门web后端开发的码农程序员的个人网站',
    		'keywords'=>'巨鹿博客-默认留言分类',
    		'description'=>'杨松个人PHP博客，是一个刚入门web后端开发的程序员个人技术博客，提供个人技术分享，免费PHP教程分享的个人原创网站。',
    		'css'=>array('base.css','book.css'),
			'js'=>array('list.js'),
    	));
		$this->display();
    }

    /**
     * 网站用户添加留言
     * @return status
     */
    public function add_msg(){
        

        
    }
}