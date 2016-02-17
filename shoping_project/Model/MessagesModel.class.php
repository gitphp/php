<?php
//留言类
	class MessagesModel extends Model{
		protected $table='messages';
		//
		public function getAllMsg(){
			$sql="select m_title from {$this->getTableName()} limit 7";
			return $this->db_selectAll($sql);
		}
	}