<?php
namespace Home\Controller;
use Think\Controller;

// 权限控制器
class AdminController extends BaseController{
	// ajax 无刷新分页
	public function ajaxPage(){
        //引入分页类
            // 导入分页类  注意导入的是自己写的AjaxPage类
        //实例化对象
        $admin = D('Admin');
        //获取数据长度
        $count = $admin -> count();  //计算记录数
        $limitRows = 2;         // 设置每页记录数
        $p = new \page\AjaxPage($count, $limitRows,"ajaxPage"); //第三个参数是你需要调用换页的ajax函数名
         $limit_value = $p->firstRow . "," . $p->listRows;
   
        //$data = $admin -> order('id desc')->limit($limit_value) -> select(); // 查询数据
        $page = $p->show(); // 产生分页信息，AJAX的连接在此处生成
        
        //分配模版变
        $this -> assign('page',$page);
        //显示模版
		$this->users=D('Admin')->limit($limit_value)->field('a.*,c.*')->join("a left join cms_user_role b on a.a_id=b.user_id left join cms_role c on b.role_id=c.r_id")->select();

    	$this -> display('page');
    }
	// 显示用户列表
	public function lst(){
		// 链表查出角色名字
// select a.*,c.* from cms_admin a 
// left join cms_user_role b on a.a_id=b.user_id 
// left join cms_role c on b.role_id=c.r_id;
// join(a left join cms_user_role b on a.a_id=b.user_id left join cms_role c on b.role_id=c.r_id)
		$this->display();
	}
	// 添加用户
	public function add(){
		if(IS_POST){
			$model=D('Admin');
			//密码加密，和加盐操作
			$str=substr(uniqid(),-8);
			$pass=I('post.a_password');
			$pass=md5(md5($pass).$str);
			$_POST['a_password']=$pass;	// 重新赋值密码
			$_POST['a_salt']=$str;		// 赋值salt
			if($model->validate($model->_yanzheng)->create()){
				if($model->add()){
					$this->success('添加成功','lst');exit;
				}
			}
			$this->error($model->getError());
		}
		$this->roles=D('Role')->select();
		$this->display();
	}
	// 删除用户
	public function del($id){
		echo $id;
	}
	public function ddel(){

		$str=implode(',',$_POST['ids']);
		echo $str;
	}
	// 编辑用户
	public function edit($id){
		echo $id;
		$this->display();
	}
}