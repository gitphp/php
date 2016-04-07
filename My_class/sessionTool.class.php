<?php
include "DB.class.php";
//session 入库类封装
	class sessionTool{
		private $db;		//用于保存db类的实例化对象
		//构造，初始化session处理机制
		public function __construct(){
			session_set_save_handler(
				//6大参数
				array($this,'sessOpen'),
				array($this,'sessClose'),
				array($this,'sessRead'),
				array($this,'sessWrite'),
				array($this,'sessDestroy'),
				array($this,'sessGc')
			);
			//开启session
			session_start();
		}
		/**
		 * @6大方法：开-关-读-写-析-回
		 * @设置session入库的6大处理器
		*/
		public function sessOpen(){
			//获得BD类的对象
			$this->db=new DB();
			
		}
		public function sessClose(){
			//不做任何处理
			return true;
		}
		public function sessRead($sessid){
			//读出数据库一条记录(session的内容)
			$sql="select * from sessionn where sid='{$sessid}' limit 1";
			$res=$this->db->db_selectone($sql);
			return (string)$res['scontent'];	//返回字符串
		}
		public function sessWrite($sessid,$sessdata){
			$t=time();
			//数据入库，插入一条记录，on duplicate 主键冲突,sessid不用更新
			$sql="insert into sessionn values ('$sessid','$sessdata','$t') on duplicate key update scontent='{$sessdata}',stime='{$t}'";
			return $this->db->db_insert($sql);
		}
		public function sessDestroy($sessid){
			//删除一条记录
			$sql="delete from sessionn where sid='{$sessid}'";
			return $this->db->db_delete($sql);
		}
		public function sessGc($time){
			//垃圾回收机制，判断过期时间
			$t=time()-$time;
			$sql="delete from sessionn where stime < $t";
			return $this->db->db_delete($sql);
		}
	}