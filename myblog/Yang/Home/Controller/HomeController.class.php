<?php
namespace Home\Controller;
use Think\Controller;
/*
 * 前台首页基类控制器
*/
class HomeController extends Controller {
	

	// 后期有登陆验证操作，在这里实现





	/**
     * 空方法操作
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function _empty($name){
        //把所有城市的操作解析到city方法        
        $this->error($name.'方法不存在呀，别乱点击撒'); 
    }

}