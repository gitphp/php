<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function t(){
        $data=D('Admin')->getMenu();
        doubi($data);
    }
    // 后台主页显示控制器，方法
    public function index(){
    	$this->display();
    }
    public function top(){
    	$this->display();
    }
    public function left(){
        // 根据不同角色生成不同的菜单
        $this->data=D('Admin')->getMenu();//分配到left模板
    	$this->display();
    }
    public function main(){
    	$this->display();
    }
}