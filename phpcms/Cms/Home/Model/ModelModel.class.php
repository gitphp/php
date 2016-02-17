<?php
namespace Home\Model;
use Think\Model;
// 模型表
class ModelModel extends Model{
	// 定义验证规则
	protected $_validate=array(
		array('m_name','require','模型名字为空'),
		array('m_tablename','require','填写表名'),
		
	);
	//完成添加模型之后，创建对应的模型表
	public function _after_insert(){
		$table='cms_'.I('post.m_tablename');
		$sql="create table $table (aid smallint unsigned primary key)charset utf8";
		$this->execute($sql);
	}
	// 删除模型之后，要删除对应的附加表
	public function _before_delete($data){
		// doubi($data);
		$id=$data['where']['m_id'];
		// 取出对应的表名
		$table=$this->find($id);
		$table=C('DB_PREFIX').$table['m_tablename'];
		$sql="drop table $table";
		if($this->execute($sql)===false){
			$this->error='表删除失败';
			return false;
		}else{
			return true;
		}
		

	}
}