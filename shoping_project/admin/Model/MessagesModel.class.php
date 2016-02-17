<?php
//后台查看留言
	class MessagesModel extends Model{
		
		//
		protected $table='messages';
		
		//取出所有留言信息
		public function getAll(){
			$sql="select * from {$this->getTableName()}";
			return $this->db_selectAll($sql);
		}
	}












