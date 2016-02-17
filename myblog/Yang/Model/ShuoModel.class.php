<?php
namespace Model;
use Think\Model;
class ShuoModel extends Model{
	protected $insertFields = array('content');
	// 定义验证规则
	protected $_validate=array(
		array('content','require','内容为空'),
	);

	/**
	 * 前置方法操作
	 */
	public function _before_insert(&$data, $option){
		if(isset($_FILES['img_url']) && $_FILES['img_url']['error'] == 0){
			$auf = C('ALLOW_UPLOAD_FILETYPE');
			$muf = C('MAX_UPLOAD_FILESIZE');
			$umf = ini_get('upload_max_filesize');
			$maxFileSize = (int)min($muf, $umf);
			// 插入数据库之前先上传logo图片
			$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize = $maxFileSize * 1024 * 1024;
		    $upload->exts = $auf;// 设置附件上传类型
		    $upload->autoSub=false;// 关闭自动子目录功能
		    $upload->rootPath = './Uploads/'; // 设置附件上传根目录
		    $upload->savePath = 'Shuo/'; // 设置附件上传（子）目录
		    $info = $upload->upload(array('logo' => $_FILES['img_url']));
		    if($info){
		    	// 先拼出缩略图的名字
		    	$data['img_url'] = $info['logo']['savepath'] . $info['logo']['savename'];
		    } else {
		   		// 把错误信息放到这个模型中，然后在控制器中通过$model->getError()方法获取这个错误信息
		   		$this->error = $upload->getError();
		   		return FALSE;
		   	}
		}
	}
}