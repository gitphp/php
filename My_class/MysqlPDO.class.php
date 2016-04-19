<?php

//封装pdo类
	class MysqlPDO{
		//设置属性
		private $type;			//有2个值，mysql和Oracle
		private $host;
		private $port;
		private $dbname;
		private $user;
		private $pass;
		private $charset;
		private $prefix;		//表前缀
		
		private $p;				//保存pdo对象
		private $stmt;			//保存Pdostatement对象
		/*
		 * 构造方法
		 * @param1 array $arr，数据库信息，关联数组
		*/
		public function __construct($arr=array()){
			// 初始化
			$this->type=isset($arr['type'])		? $arr['type'] 		: 'mysql';
			$this->host=isset($arr['host']) 	? $arr['host'] 		: 'localhost';
			$this->port=isset($arr['port'])		? $arr['port'] 		: '3306';
			$this->dbname=isset($arr['dbname']) ? $arr['dbname'] 	: 's_shop';
			$this->user=isset($arr['user']) 	? $arr['user'] 		: 'root';
			$this->pass=isset($arr['pass']) 	? $arr['pass'] 		: 'root';
			$this->charset=isset($arr['charset']) ? $arr['charset'] : 'utf8';
			$this->prefix=isset($arr['prefix']) ? $arr['prefix'] 	: 'b_';
			//链接
			$this->db_link();
			//字符集
			$this->db_charset();
			//开启异常,记得要在链接数据库后面开启
			$this->p->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		}
		//链接
		private function db_link(){
			$this->p=new PDO("{$this->type}:{$this->port};host={$this->host};port={$this->port};dbname={$this->dbname}",$this->user,$this->pass);
			//判断链接是否成功
			if(!is_object($this->p)){
				echo "pdo初始化失败了";exit;
			}
		}
		
		//字符集
		private function db_charset(){
			$this->db_exec("set names {$this->charset}");
		}
		
		/*
		 * exec错误处理方式
		 * @param1 string $sql，要执行的SQL语句，没有结果返回的SQL语句
		 * @return 返回受影响的行数
		*/
		private function db_exec($sql){
			//try
			try{
				 return $this->p->exec($sql);
				//捕获异常处理
			}catch(PDOException $e){
				echo "sql执行错误<br/>";
				echo "错误代码是：".$e->getCode().'<br/>';
				echo "错误行号是：".$e->getLine().'<br/>';
				echo "错误信息是：".$e->errorInfo[2].'<br/>';
				exit;
			}	
		}
		// pdo->query方法
		private function db_query($sql){
			//try
			try{
				$this->stmt=$this->p->query($sql);
				//捕获异常处理
			}catch(PDOException $e){
				echo "sql执行错误<br/>";
				echo "错误代码是：".$e->getCode().'<br/>';
				echo "错误行号是：".$e->getLine().'<br/>';
				echo "错误信息是：".$e->errorInfo[2].'<br/>';
				exit;
			}	
		}
		//--------------------------------------
		/*
		 * 插入数据
		 * @param1 string $sql，insertSQL语句
		 * @return 自增ID
		*/
		public function db_insert($sql){
			$this->db_exec($sql);
			$num=$this->p->lastInsertId();
			return !is_int($num) ? $num : 0;		//判断返回值
		}
		
		//update方法
		public function db_update($sql){
			return $this->db_exec($sql);
		}
		
		//delete方法
		public function db_delete($sql){
			return $this->db_exec($sql);
		}
		/**
		 * pdoselect方法(查询一条记录方法)
		 * $param string $sql语句
		 * return $arr数组
		*/
		public function db_selectOne($sql){
			$this->db_query($sql);
			//取出一行数据，按照关联数组格式，并返回结果
			$res=$this->stmt->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		//-------------------------------------------------------
		/**
		 * pdoselect方法(查询多条记录方法)
		 * $param string $sql语句
		 * return $arr数组
		*/
		public function db_selectAll($sql){
			$this->db_query($sql);
			//取出全部数据，按照关联数组格式，并返回结果数组
			$res=$this->stmt->fetchAll(PDO::FETCH_ASSOC);
			return $res;
		}
		//魔术睡眠方法
		public function __sleep(){
			return array('type','host','port','dbname','user','pass','charset','prefix','p','stmt');
		}
		//魔术叫醒方法
		public function __wakeup(){
			$this->db_link;
			$this->db_charset;
		}
		/*
		 * 增加一个组合表名和前缀的方法
		 * 
		*/
		protected function getTableName($table=''){
			//用户有传用户名的话，就有用户传的，没有的话就默认用子类继承的表名
			return $table ? $this->prefix . $table : $this->prefix . $this->table;
		}
	}