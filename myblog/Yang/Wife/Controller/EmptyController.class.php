<?php
namespace Wife\Controller;
use Think\Controller;
class EmptyController extends WifeController{
	public function _empty(){
        echo "<img src='".A_IMG."404.gif' alt=''>";
    }
}