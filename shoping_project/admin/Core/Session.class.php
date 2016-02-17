<?php
if(!defined('ACCESS')){
	echo '非法';
	exit;
}
//session 入库类封装
	class Session extends Model{
		protected $table='session';		//表名
		//构造，初始化session处理机制
		public function __construct(){
			//初始化构造，连接数据库
			parent::__construct();
			//设置session6大处理器
			session_set_save_handler(
				array($this,'sessOpen'),
				array($this,'sessClose'),
				array($this,'sessRead'),
				array($this,'sessWrite'),
				array($this,'sessDestroy'),
				array($this,'sessGc')
			);
			//开启session
			// session_start();
		}
		/**
		 * @6大方法：开-关-读-写-析-回
		 * @设置session入库的6大处理器
		*/
		public function sessOpen(){
			return true;
			
		}
		public function sessClose(){
			//不做任何处理
			return true;
		}
		/**
		 * 读取 数据库中的session值
		*/
		public function sessRead($sessid){
			$t=time()-ini_get('session.gc_maxlifetime');
			//读出数据库一条记录(session的内容)
			$sql="select * from {$this->getTableName()} where s_id='{$sessid}' and s_expire >={$t} ";
			$res=$this->db_selectone($sql);
			if($res){
				return (string)$res['s_data'];	//返回字符串
			}
			
		}
		/**
		 * 写入session的值到数据库
		*/
		public function sessWrite($sessid,$sessdata){
			$t=time();
			//数据入库，插入一条记录，on duplicate 主键冲突,sessid不用更新
			// $sql="insert into {$this->getTableName()} values ('$sessid','$sessdata','$t') on duplicate key update sess_data='{$sessdata}',sess_expire='{$t}'";
			$sql="replace into {$this->getTableName()} values('{$sessid}','{$sessdata}',{$t})";
			return $this->db_insert($sql);
		}
		/**
		 * 销毁session
		*/
		public function sessDestroy($sessid){
			//删除一条记录
			$sql="delete from {$this->getTableName()} where s_id='{$sessid}'";
			return $this->db_delete($sql);
		}
		/**
		 * session 垃圾回收
		*/
		public function sessGc(){
			//垃圾回收机制，判断过期时间
			$t=time()-int_get('session.gc_maxlifetime');
			$sql="delete from {$this->getTableName()} where s_expire < $t";
			return $this->db_delete($sql);
		}
	}