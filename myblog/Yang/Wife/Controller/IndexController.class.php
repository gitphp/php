<?php
namespace Wife\Controller;
use Think\Controller;
/**
 * 后台首页控制器
 */
class IndexController extends WifeController {
  public function index(){
		/* 	
		// 获取头部无限极分类导航
		$c=new \Model\CategoryModel();
	    $navs=$c->getNav();
		} */
		$this->display();
    }
	//后台主页头部
	public function top(){
		$this->t=date('Y-m-d:H:i:s');
		$this->display();
	}
	// 左边
	public function left(){
		$this->display();
	}
	
}
?>