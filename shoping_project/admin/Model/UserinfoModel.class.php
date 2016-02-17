<?php
	//userinfo表
	class UserinfoModel extends Model{
		protected $table='userinfo';
		//添加用户信息，地址，姓名，电话
		public function addinfo($username,$name,$addr,$phone){
			$sql="insert into {$this->getTableName()} values(null,'{$username}','{$name}','{$addr}','{$phone}')";
			return $this->db_insert($sql);
		}
		//取出用户的信息,通过用户名user
		public function getaddr($user){
			//
			$sql="select * from {$this->getTableName()} where u_username='{$user}'";
			return $this->db_selectOne($sql);
		}
	}