<?php
namespace Home\Model;
use Think\Model;

class FieldsModel extends Model{
	// 定义验证规则
	protected $_validate=array(
		array('f_cname','require','字段名为空'),
		array('f_ename','require','英文名为空'),
		array('f_ename','checkfield','字段重复',1,'callback'),
		array('f_type','require','字段类型为空',1),
	);

	// 自定义验证重复方法
	protected function checkfield(){
		$ename=I('post.f_ename');
		$m_id=I('post.model_id');
		$c=$this->where("model_id=$m_id and f_ename='$ename'")->count();
		if(!$c){
			return true;
		}else{
			return false;
		}
	}
	// 添加数据的同时，完成附加表的字段创建语句
	public function _before_insert($data){
		// 取出附加表名
		$id=$data['model_id'];
		$res=D('Model')->find($id);
		$table=C('DB_PREFIX').$res['m_tablename'];
		// 判断type的类型，创建不同的字段类型
		$type=$data['f_type'];
		$ename=$data['f_ename'];
		$sql="alter table $table add $ename";
		switch ($type) {
			case 'int':
				$sql.=" int not null default 0";
				break;
			case 'float':
				$sql.=" float not null default 0.0";
				break;
			case 'textarea':
				$sql.=" varchar(256) not null default ''";
				break;
			case 'text':
			case 'radio':
			case 'select':
			case 'checkbox':
				$sql.=" varchar(32) not null default ''";
				break;
		}

		if($this->execute($sql)!==false){
			return true;
		}else{
			$this->error='附加表字段创建失败';
			return false;
		}
	}

}