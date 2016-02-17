<?php
namespace Home\Controller;
use Think\Controller;

// 权限控制器
class AuthController extends BaseController{
	// 添加权限
	public function add(){
		$model=D('Auth');
		if(IS_POST){
			if($model->create()){
				// 验证post数据里面的id值，防止恶意攻击
				// 这里可以用表单一个一个接收数据，然后传入add方法里面（方法一）
				// 方法二 删除表单里面的id字段
				if(isset($_POST['p_id'])){
					unset($_POST['p_id']);
					// $model->id=null; 或者设置它的值为null
				}
				if($model->add()){
					$this->success('添加成功',U('Auth/add'));exit;
				}else{
					die('添加失败');
				}
			}else{
				$this->success($model->getError());exit;
			}
		}else{
			//取出数据显示父级,无限层级分类显示
			$this->data=$model->getAuth();
			$this->display();
		}
		
	}

	// 删除权限
	public function del($id){
		// 删除栏目的时候还要判断是否还有子栏目
		$model=D('Auth');
		if($model->delete($id)){
			$this->success('删除成功了！哦',U('Auth/lst'));exit;
		}else{
			$this->success($model->getError(),U('Auth/lst'));exit;
		}
	}

	// 权限列表
	public function lst(){
		$model=D('Auth');
		$this->data=$model->getAuth();
		$this->display();
	}

	// 修改权限
	public function edit(){
		$model=D('Auth');
		if(IS_POST){
			// 继续判断用户是否选择了子栏目
			if($model->create()){
				if($model->save()){
					//修改成功
					$this->success('success' , U('Auth/lst'));exit;
				}
			}
			$this->success($model->getError());
		}
		//取出数据显示父级,无限层级分类显示-----------
		$this->data=$model->getAuth();
		$id=I('get.id');
		// 取出当前栏目的所有子栏目的ids集合
		$ids=$model->getIds($id);
		$ids[]=$id;
		$this->ids=$ids;
		// 取出当前数据显示
		
		
		$this->auth=$model->where("p_id=$id")->find();
		$this->display();
	}
}