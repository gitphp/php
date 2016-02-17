<?php

namespace Model;
use Think\Model;

/*
 * FlieName:ArticleModel.class.php
 * Auth:Young\
 * Location:Yang/Model/
 * AddTime:2015年11月21日10:20:11
 * Deacription:文章模型
 */

class ArticleModel extends Model{
	// 定义验证规则
	protected $_validate=array(
		array('title','require','标题不可以为空'),
		array('author','require','作者为空'),
		array('content','require','内容不可以为空'),
		array('keywords','require','关键字不可以为空'),
		array('remark','require','描述不可以为空'),
	);

	/**
	 * 前置方法操作
	 */
	public function _before_insert(&$data, $option){
		// $data['addtime'] = date('Y-m-d H:i:s');
					// 判断用户是否上传了图片
		if(isset($_FILES['arc_pic']) && $_FILES['arc_pic']['error'] == 0){
			// 从配置文件中取出允许上传的图片的类型
			$auf = C('ALLOW_UPLOAD_FILETYPE');
			// 从配置文件中取出图片的最大尺寸
			$muf = C('MAX_UPLOAD_FILESIZE');
			// 从php.ini中读出系统对图片的硬限制
			$umf = ini_get('upload_max_filesize');
			// 实际的限制应该是以上两项中小者
			$maxFileSize = (int)min($muf, $umf);
			// 插入数据库之前先上传logo图片
			$upload = new \Think\Upload();// 实例化上传类
		    $upload->maxSize = $maxFileSize * 1024 * 1024;
		    $upload->exts = $auf;// 设置附件上传类型
		    $upload->autoSub=false;// 关闭自动子目录功能
		    $upload->rootPath = './Uploads/'; // 设置附件上传根目录
		    $upload->savePath = 'Article/'; // 设置附件上传（子）目录

		    // 本来图片上传之后是要缩略处理的，这里就没处理了，上传的时候选择合适尺寸的图片上传即可，免的麻烦
		    
		    // 上传文件 
		    $info = $upload->upload(array('logo' => $_FILES['arc_pic']));
		    if($info){
		    	// 先拼出缩略图的名字
		    	$data['arc_pic'] = $info['logo']['savepath'] . $info['logo']['savename'];
		    	$data['addtime'] = time();
		    	$data['add_ip']  = get_client_ip();
		    }
		   	else {
		   		// 把错误信息放到这个模型中，然后在控制器中通过$model->getError()方法获取这个错误信息
		   		$this->error = $upload->getError();
		   		return FALSE;
		   	}
		}
	}

	/**
	 * 取出一篇文章详情
	 * @return detail
	 */
	public function get_detail($id) {
		return $this->find($id);
	}

	/**
	 * 取出文章列表
	 * @return
	 */
	public function get_list() {


	}

}// class end