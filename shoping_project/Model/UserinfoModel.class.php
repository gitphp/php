<?php
	//userinfo表
	class UserinfoModel extends Model{
		protected $table='userinfo';
		//添加
		public function addinfo($username,$name,$addr,$phone){
			$sql="insert into {$this->getTableName()} values(null,'{$username}','{$name}','{$addr}','{$phone}')";
			return $this->db_insert($sql);
		}
	}