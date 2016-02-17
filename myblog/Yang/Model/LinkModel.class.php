<?php
namespace Model;
use Think\Model;
class LinkModel extends Model{
	// 定义验证规则
	protected $_validate=array(
		array('link_name','require','名字不可以为空'),
		array('link_url','require','链接地址为空'),
		array('start_time','require','开始时间为空'),
		array('end_time','require','结束时间为空'),
	);
	/**
	 * 图片上传
	 * @param  [type] &$data  [description]
	 * @param  [type] $option [description]
	 * @return [type]         [description]
	 */
	public function _before_insert(&$data, $option){
		// $data['addtime'] = date('Y-m-d H:i:s');
					// 判断用户是否上传了图片
		if(isset($_FILES['l_logo']) && $_FILES['l_logo']['error'] == 0){
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
		    $upload->savePath = 'Links/'; // 设置附件上传（子）目录
		    // 上传文件 
		    $info = $upload->upload(array('logo' => $_FILES['l_logo']));
		    if($info){
		    	// 先拼出缩略图的名字
		    	$data['pic_url'] = $info['logo']['savepath'] . $info['logo']['savename'];
		    	$data['start_time']=strtotime(I('post.start_time'));
		    	$data['end_time']=strtotime(I('post.end_time'));
		    }
		   	else {
		   		// 把错误信息放到这个模型中，然后在控制器中通过$model->getError()方法获取这个错误信息
		   		$this->error = $upload->getError();
		   		return FALSE;
		   	}
		}
	}



	// end
}