<?php
namespace Wife\Controller;
use Think\Controller;
class CategoryController extends WifeController{
	//首页栏目展示
	public function index(){
		$cat=new \Model\CategoryModel();
		$this->data=$cat->getCats();
		$this->display();
	}
	
	//添加文章分类
	public function addCate(){
		$cat=new \Model\CategoryModel();
		if(IS_POST){
			if($cat->create()){
				$cat->id=null;
				if($cat->add()){
					$this->success('添加成功');exit;
				}
			}
			$this->error('添加失败:'.$cat->getError());
		}
		// 取出父类，显示
		$this->data=$cat->getCats();
		$this->display();
	}
	
	//接收添加栏目的数据
	public function addData(){
		
		$_GET['pid'] = $_POST['id'];
		$c = D('cate');
		
		//修改与增加根栏目
		if (isset($_FILES['lmlogo'])){
			//文件上传配置
			import('ORG.Net.uploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 1000000 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->allowTypes = array('image/jpg','image/jpeg','image/pjpeg','image/x-png','image/png','image/gif');
			$upload->savePath =  './Public/Uploads/lmlogo/';// 设置附件上传目录
			$upload->saveRule = 'uniqid';	
	
			//开始上传
			if(!$upload->upload()){
				$this->error($upload->getErrorMsg());
			}else{
				$info =  $upload->getUploadFileInfo();
			}	
			
			$_POST['lmlogo'] = $info[0]['savename'];	
			


			//判断用户在添加还是在修改(在已选择文件域的情况下)
			if (isset($_POST['act']) && $_POST['act']=='edit'){	//修改
				$data = $_POST;
				
				//取出原图片名称,进行删除
				$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
				$list = checkTrip($c->where('id='.$id)->field('lmlogo')->find());
				$oldPic = './Public/Uploads/lmlogo/'.$list['lmlogo'];
			
				if ($c->where('id='.$id)->save($data)){
					$this->success('更新成功');
					unlink($oldPic);
				}else{
					$this->error('没有记录被影响');
				}
			}else{											//添加
				if ($c->create()){
					if ($c->add()){
						$this->success('保存成功');	
					}else{
						$this->error('没有记录被影响');
					}
				}else{
					$this->error();
				}
				exit;
			}
				
		}else{
			$data = $_POST;
			if (isset($_POST['act']) && $_POST['act']=='edit'){	//没有图片时的修改
				$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
				if ($c->where('id='.$id)->save($data)){
					$this->success('更新成功');
				}else{
					$this->error('没有更新记录被影响');
				}				
			}else{
				$_GET['pid'] = $_POST['id'];							//添加子栏目
				$_POST['pid'] = $_POST['id'];			
				$d = $c->create();
				unset($d['id']);
				
				if ($c->add($d)){
					$this->success('添加子栏目成功');	
				}else{
					$this->error('添加子栏目失败');
				}
				
			}
			exit;
		}
		
		//二级栏目与一级栏目,二级不允许上传图片
		if (!isset($_POST['id'])){		//表示添加子栏目
			//文件上传配置
			import('ORG.Net.uploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 1000000 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->allowTypes = array('image/jpg','image/jpeg','image/pjpeg','image/x-png','image/png','image/gif');
			$upload->savePath =  './Public/Uploads/lmlogo/';// 设置附件上传目录
			$upload->saveRule = 'uniqid';	
	
			//开始上传
			if(!$upload->upload()){
				$this->error($upload->getErrorMsg());
			}else{
				$info =  $upload->getUploadFileInfo();
			}	
			
			$_POST['lmlogo'] = $info[0]['savename'];			
			
		}else{
				//....
		}

	}
	
	//添加子栏目
	public function addzcate(){
		$cat=new \Model\CategoryModel();
		$pid=I('get.pid');
		$this->pdata=$cat->find($pid);
		$this->display();
	}
	
	//修改栏目[根据传递过来的class判断是修改根栏目还是子栏目,从页跳转到不同的处理页面]
	public function edit(){
		$cat=new \Model\CategoryModel();
		if(IS_POST){
			if($cat->create()){
				if($cat->save()){
					$this->success('修改成功',U('Category/index'));exit;
				}
			}
			$this->error($cat->getError());
		}
		$id=I('get.id');
		$this->pdata=$cat->find($id);
		$this->data=$cat->getCats();
		$this->display();
	}
	
	
	//删除栏目
	public function delCate(){
		$id = I('get.id') + 0;
		if ($id==0){
			$this->error('请按正常流程操作');
		}

		$cat=new \Model\CategoryModel();
		
		if($cat->delete($id)){
			$this->success('删除成功');exit;
		}
		$this->error('删除失败:'.$cat->getError());
	}
	
	
	
}
?>