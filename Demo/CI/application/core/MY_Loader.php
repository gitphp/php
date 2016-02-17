<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader{
	// 定义前台主题,根目录下面的、themes/default下面的文件夹
	protected $_themes ='default/';

	public function switch_themes_on(){
		$this->_ci_view_paths = array(FCPATH.THEMES_DIR.$this->_themes => TRUE);
		// var_dump($this->_ci_view_paths);
	}
	public function switch_themes_off(){
		#just do nothing
	}
}

