<?php
namespace Home\Controller;
use Think\Controller;
// 父类控制器
class ModelController extends BaseController{
	/**
	 * 添加模型的方法
	 */
	public function add(){
		$model=D('Model');
		if(IS_POST){
			if($model->create()){
				// doubi($_POST);exit;
				$model->m_id=null;
				if($model->add()){
					$this->success('添加成功',U('Model/add'));exit;
				}else{
					die('添加失败');
				}
			}else{
				$this->success($model->getError());exit;
			}
		}else{
			$this->display();
		}
		
	}

	// 删除模型
	public function del($id){
		// 删除模型的时候要删除对应的附加表
		$model=D('Model');
		if($model->delete($id)){
			$this->success('删除成功了！哦',U('Model/lst'));exit;
		}else{
			$this->success($model->getError(),U('Model/lst'));exit;
		}
	}

	// 权限列表
	public function lst(){
		$model=D('Model');
		$this->data=$model->select();
		$this->display();
	}

	// 修改权限
	public function edit(){
		$model=D('Model');
		if(IS_POST){
			// 继续判断用户是否选择了子栏目
			if($model->create()){
				if($model->save()){
					//修改成功
					$this->success('success' , U('Model/lst'));exit;
				}
			}
			$this->success($model->getError());
		}
		$id=I('get.id');
		// 取出当前栏目的所有子栏目的ids集合
		$this->data=$model->find($id);
		$this->display();
	}

}