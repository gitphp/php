<?php
//后台admin表操作类，基础基类Model
	class AdminModel extends Model{
		//定义后台user表名，前缀是**
		protected $table='admin';
		/**
		 * 校验用户登录信息
		*/
		public function checkUser($username,$password){
			//sql注入，密码md5
			$username=addslashes($username);
			$password=md5($password);
			$sql="select * from {$this->getTableName()} where u_username='{$username}' and u_password='{$password}' limit 1";
			//返回一行用户信息数据
			return $this->db_selectOne($sql);
		}
		/**
		 * 更新用户信息的方法
		*/
		public function updateUser($id){
			$t=time();
			$ip=$_SERVER['REMOTE_ADDR'];
			$sql="update {$this->getTableName()} set u_logintime='{$t}',u_ip='{$ip}' where u_id='{$id}'";
			return $this->db_update($sql);
		}
		/**
		 * 获取所有用户信息
		*/
		public function getAllUser($offset,$b){
			$sql="select * from {$this->getTableName()} limit {$offset},{$b}";
			return $this->db_selectAll($sql);
		}
		/**
		 * getUserById获取一行数据
		*/
		public function getUserById($id){
			$sql="select * from {$this->getTableName()} where u_id='{$id}' limit 1 ";
			return $this->db_selectOne($sql);
		}
		public function updateById($id,$data){
			// var_dump($data);
			$sql="update {$this->getTableName()} set ";
			foreach($data as $k=>$v){
				$sql.=$k."='".$v."',";
			}
			$sql=trim($sql,',');
			$sql.=" where u_id=$id";
			//执行
			return $this->db_update($sql);
		}
		
		//取出所有行数
		public function getCounts(){
			$sql="select count(u_id) as c from {$this->getTableName()}";
			$res=$this->db_selectOne($sql);
			if($res){
				return $res['c'];
			}
		}
		
		
		
		
		
		
		
		
		
		
		
	}