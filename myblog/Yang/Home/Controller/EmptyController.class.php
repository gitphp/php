<?php
namespace Home\Controller;
use Think\Controller;

class EmptyController extends Controller{

    public function index(){
        //根据当前控制器名来判断要执行那个城市的操作        
        $cityName = CONTROLLER_NAME;        
        $this->city($cityName);
        $this->error($cityName.'控制器不存在呀，别乱点击哦');
        // $this->error('操作失败','/Article/error',5);  
    }    
    //注意 city方法 本身是 protected 方法    
    protected function city($name){
            //和$name这个城市相关的处理         
            echo '您当前访问的控制器是：' . $name;   
    }


}