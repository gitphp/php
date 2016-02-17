<?php
namespace Wife\Controller;
use Think\Controller;
/**
 * 后台说说控制器
 */
class ShuoController extends WifeController {
	/**
	 * 添加个人说说，时间轴
	 */
	public function add(){
		$dao=new \Model\ShuoModel();
		if(IS_POST){
			if($dao->create()){
				$dao->addtime = time();
				if($dao->add()){
					$this->success('添加成功');exit;
				}
			}
			$this->error('添加失败');
		}
		$this->display();
    }

    /**
     * 后台显示说说列表
     */
    
    public function index(){
    	// 数据分页显示
    	$art=new \Model\ShuoModel();
		$p=$_GET['p']?$_GET['p']:1;
		$list = $art->page($p.',10')->select();
		$this->assign('data',$list);
		$count      = $art->count();
		$Page       = new \Think\Page($count,10);
		$show       = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出	
    	$this->display();
    }
    /**
     * 删除方法
     */
    public function del(){
    	$id=I('get.id');
    	$this->error('辛辛苦苦写的东西，不可以随便删除的');
    }
}// end