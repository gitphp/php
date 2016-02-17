<?php
namespace Home\Controller;
use Think\Controller;

// 模型字段控制器
class FieldsController extends BaseController{
	// 添加模型字段
	public function add(){
		$model=D('fields');
		if(IS_POST){
			if($model->create()){
				$model->f_id=null;	//防止攻击
				$m_id=I('post.model_id');
				if($model->model_id==null){
					die('请先选择要添加的模型');
				}
				if($model->add()){
					// 添加字段的同时，也要创建对应的字段语句，附加表里面
					$this->success('添加成功',U('Home/fields/index/id/'.$m_id));exit;
				}else{
					echo('添加失败');
				}
			}else{
				$this->success($model->getError());exit;
			}
		}else{
			// 显示添加表单
			$this->display();
		}
		
	}

	// 显示字段列表
	public function index(){
		$model=D('fields');
		$model_id=I('get.id');
		$this->fields=$model->where("model_id=$model_id")->select();
		// doubi($this->fields);
		$this->display();
	}
	public function del($id){
		echo '删除第 ',$id,' 条数据成功（模拟删除）';
	}
	public function edit($id){
		echo '更新第 ',$id,' 条数据成功（模拟更新）';
	}
}