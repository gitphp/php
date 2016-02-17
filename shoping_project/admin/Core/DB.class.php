<?php
header("content-type:text/html;charset=utf-8");
	//封装一个db类
	class DB{
		//私有属性7个
		private $host;
		private $port;
		private $user;
		private $pass;
		private $dbname;
		private $charset;
		public  $link;
		//加一个属性，是前缀属性
		private $prefix;
		/*
		 * 构造方法
		 * @param1 array $arr = array()，配置项数组
		 * @示例：$arr = array('host' => 'localhost','port' => '3306'...)
		 * 构造方法没有返回值：不需要返回值
		*/
		public function __construct($arr = array()){
			// $configs= include_once(ADMIN_INCL.'init.php');
			//如果用户在创建DB类对象的时候，没有传入参数，想使用系统提供的默认参数
			$this->host = isset($arr['host']) 		? $arr['host'] 		: $GLOBALS['config']['mysql']['host'];
			$this->port = isset($arr['port']) 		? $arr['port'] 		: $GLOBALS['config']['mysql']['port'];
			$this->user = isset($arr['user']) 		? $arr['user'] 		: $GLOBALS['config']['mysql']['user'];
			$this->pass = isset($arr['pass']) 		? $arr['pass'] 		: $GLOBALS['config']['mysql']['pass'];
			$this->dbname = isset($arr['dbname']) 	? $arr['dbname'] 	: $GLOBALS['config']['mysql']['dbname'];
			$this->charset = isset($arr['charset']) ? $arr['charset'] 	: $GLOBALS['config']['mysql']['charset'];
			$this->prefix = isset($arr['prefix']) 	? $arr['prefix'] 	: $GLOBALS['config']['mysql']['prefix'];
			
			$this->db_link();//连接数据库			
			$this->db_charset();//设置字符集			
			$this->db_name();//选择数据库
		}
		
		//私有链接数据库的方法
		private function db_link(){
			@$this->link=mysql_connect($this->host.':'.$this->port,$this->user,$this->pass);
			if(!$this->link){
				echo '<br/>链接数据库失败';
				echo mysql_error().'<br/>';
				echo mysql_errno().'<br/>';
			}
		}
		//私有选择数据库方法
		private function db_name(){
			$sql = "use {$this->dbname}";
			$this->db_query($sql);
		}
		
		//私有设置字符集方法
		private function db_charset(){
			$sql = "set names {$this->charset}";
			$this->db_query($sql);
		}
		
		//私有公共query方法
		private function db_query($sql){
			@$res = mysql_query($sql);
			if(!$res){
				echo "sql执行语法错误。{$sql}<br/>";
				echo "sql错误信息是：".mysql_error().'<br/>';
				echo "sql错误编号是：".mysql_errno().'<br/>';
			}
			return $res;
		}
		
		//公有插入sql方法db_insert
		protected function db_insert($sql){
			$this->db_query($sql);
			return mysql_insert_id();
		}
		
		//公有删除sql方法db_delete
		protected function db_delete($sql){
			$this->db_query($sql);
			return mysql_affected_rows();
			
		}
		
		//公有更新sql方法db_update
		protected function db_update($sql){
			$this->db_query($sql);
			return mysql_affected_rows();
		}
		
		//公有查询单行sql方法db_selectrow
		protected function db_selectone($sql){
			$res = $this->db_query($sql);
			return mysql_fetch_assoc($res);
		} 
		
		//公有查询多行sql方法db_selectrows
		protected function db_selectall($sql){
			$res = $this->db_query($sql);
			$rows= array();
			while($row = mysql_fetch_assoc($res)){
				$rows[] = $row;
			}
			mysql_free_result($res);			//记得释放结果集资源
			return $rows;
		}
		
		//关闭链接的方法
		public function db_close(){
		   if(!empty($this->link)){
			   mysql_close($this->link);
		   }
		}
		
		//__sleep魔法方法
		public function __sleep(){
			return array('host','port','user','pass','dbname','charset','prefix');
		}
		//__wakeup魔术方法
		public function __wakeup(){
			$this->db_link();
			$this->db_charset();
			$this->db_name();
		}
		//增加一个获取表全名的方法
		protected function getTableName(){
			//把表的前缀和表名链接起来，并返回一个string
			return $this->prefix . $this->table;
		}
		//如果有外接表的话，就用下面这个方法
		protected function getJoinTable($table=''){
			// 假如table没传值的话，默认就用子类的表名，有值的话，就用当前的表名
			return $table ? $this->prefix . $table : $this->prefix . $this->table;
		}
		
	}






