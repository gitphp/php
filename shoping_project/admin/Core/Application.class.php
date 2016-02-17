<?php
//网站初始化文件，9大初始化
if(!defined('ACCESS')){
	echo '非法入侵';
	exit;
}
	class Application{
		//1，header
		private static function setHeader(){
			header("Content-type:text/html;charset=utf-8");
		}
		//2，error错误
		private static function seterrors(){
			ini_set('display_errors',1);
			error_reporting(E_ALL);
		}
		//3，const 
		private static function setConst(){
			//根目录路径:ROOT_DIR
			define('ROOT_DIR',str_replace('\\','/',dirname(__DIR__)));
			define('ACTION_DIR',ROOT_DIR . '/Action/');
			define('CONFIG_DIR',ROOT_DIR . '/Config/');
			define('CORE_DIR',ROOT_DIR . '/Core/');
			define('MODEL_DIR',ROOT_DIR . '/Model/');
			define('PUBLIC_DIR',ROOT_DIR . '/Public/');
			define('VIEW_DIR',ROOT_DIR . '/View/');
		}
		//4，session
		private static function setSession(){
			$sess=new Session();
			@session_start();
		}
		//9，config
		private static function setConfig(){
			$GLOBALS['config']=require_once(CONFIG_DIR . 'config.php');
		}
		//6，__autoload,先加载3个文件夹的类库，在调用 spl_autoload_register 函数
		private static function loadCore($class){
			//引入核心类文件
			if(file_exists(CORE_DIR . "$class.class.php")){
				require_once(CORE_DIR . "$class.class.php");
			}
		}
		
		private static function loadAction($class){
			//引入核心类文件
			if(file_exists(ACTION_DIR . "$class.class.php")){
				require_once(ACTION_DIR . "$class.class.php");
			}
		}
		
		private static function loadModel($class){
			//引入核心类文件
			if(file_exists(MODEL_DIR . "$class.class.php")){
				require_once(MODEL_DIR . "$class.class.php");
			}
		}
		//自动加载类文件方法
		private static function autoload(){
			//这个函数有2中传参的方法，数组和字符串
			spl_autoload_register(array('Application','loadCore'));
			spl_autoload_register(array('Application','loadAction'));
			spl_autoload_register(array('Application','loadModel'));
		}
		//7，权限验证
		private static function setPrivilege(){
			//菲一下几种请求，就直接跳转到index
			if(!(MODULE=='Privilege' && (ACTION=='login' || ACTION=='captcha' || ACTION=='sigin'))){
				// $_SESSION['user']=1;
				if(!isset($_SESSION['user'])){
					header("Location:index.php");
				}
			}
		}
		//5，url
		private static function setUrl(){
			$module= isset($_REQUEST['m']) ? $_REQUEST['m'] : 'Privilege';
			$action= isset($_REQUEST['a']) ? $_REQUEST['a'] : 'login';
			//把变量小写化
			$module=strtolower($module);
			$action=strtolower($action);
			//首字母大写，因为控制器类的名字是首字母大写
			$module=ucfirst($module);
			//定义2个常量用来保存这2个变量信息
			define('MODULE',$module);
			define('ACTION',$action);
		}
		//8，分发url
		private static function setPath(){
			$module=MODULE . 'Action';
			$action=ACTION;
			
			// 实例化控制器
			$module=new $module();
			$module->$action();
		}
		
		
		//run函数，在index被调用的函数，调用内部初始化私有静态方法
		public static function run(){
			//设置header字符集方法
			self::setHeader();
			//设置常量路径信息
			self::setConst();
			//设置php提示错误类型
			self::seterrors();
			//载入配置文件
			self::setConfig();
			//自动加载类库
			self::autoload();
			//开启session
			self::setSession();			
			//接收url
			self::setUrl();
			//判断权限
			self::setPrivilege();
			//分发url
			self::setPath();
		}
	}