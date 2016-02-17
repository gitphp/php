<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// 扩展自动加载类
class MY_Loader extends CI_Loader{
	protected $_tmemes='default/';
	#开启默认模板
	public function themes_on(){
		$this->_ci_view_paths = array(FCPATH.THEMES_DIR.$this->_tmemes => TRUE);
	}
	#关闭默认模板
	public function themes_off(){
		//just do nothing
	}
}