<?php
namespace Wife\Controller;
use Think\Controller;
/**
 * 后台说说控制器
 */
class XiangceController extends WifeController {
	/**
	 * 添加相册
	 */
	public function add(){
		$dao=D('Xiangce');
		if(IS_POST){
			if($_POST['id']){
				unset($_POST['id']);
			}
			if($dao->create()){
				$dao->addtime=time();
				if($dao->add()){
					$this->success('添加成功');exit;
				}
			}
			$this->error('添加失败');
		}
		$this->display();
    }
    /**
     * 添加pic图片
     */
    public function addpic(){
    	if(IS_POST){
    		$dao=D('Photo');
    		if(isset($_FILES['pic_url']) && $_FILES['pic_url']['error'] == 0){
				$auf = C('ALLOW_UPLOAD_FILETYPE');
				$muf = C('MAX_UPLOAD_FILESIZE');
				$umf = ini_get('upload_max_filesize');
				$maxFileSize = (int)min($muf, $umf);
				$upload = new \Think\Upload();
			    $upload->maxSize = $maxFileSize * 1024 * 1024;
			    $upload->exts = $auf;// 设置附件上传类型
			    $upload->autoSub=false;// 关闭自动子目录功能
			    $upload->rootPath = './Uploads/'; // 设置附件上传根目录
			    $upload->savePath = 'Xiangce/'; // 设置附件上传（子）目录
			    $info = $upload->upload(array('logo' => $_FILES['pic_url']));
			    if($info){
			    	// 先拼出缩略图的名字
			    	$_POST['pic_url'] = $info['logo']['savepath'].$info['logo']['savename'];
			    	$_POST['addtime']=time();
			    }else {
			   		// 把错误信息放到这个模型中，然后在控制器中通过$model->getError()方法获取这个错误信息
			   		$this->error ($upload->getError());
			   	}
			}
			if($dao->create()){
				if($dao->add()){
					$this->success('上传图片成功');exit;
				}
			}
			$this->error('上传图片失败了');
    	}
    	// 显示上传表单
    	$this->data=D('Xiangce')->select();
    	$this->display();
    }

}// end