<?php

//user类
	class AdminModel extends Model{
		protected $table='admin';
		//增加插入方法
		public function addUser($username,$password,$name,$phone,$email){
			$password=md5($password);
			$t=time();
			$ip=$_SERVER['REMOTE_ADDR'];
			$sql="insert into {$this->getTableName()} values (null,'{$username}','{$password}',default,'{$name}',default,'{$email}','{$phone}',default,default,default,'{$t}','{$ip}')";
			return $this->db_insert($sql);
		}
		//通过id取用户名
		public function getusername($id){
			$sql="select u_username from {$this->getTableName()} where u_id={$id}";
			return $this->db_selectOne($sql);
		}
		
		
		
		
	}