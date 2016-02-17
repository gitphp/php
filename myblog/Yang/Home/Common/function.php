<?php
/**
 * 系统函数库，可以直接调用的函数
 * Author：Young、
 * AddTime：2015-11-21 19:26:00
 */

// 1、wish许愿板块替换表情函数
function replace_phiz($content){
	preg_match_all('/\[.*?\]/is',$content,$arr);
	if($arr[0]){
		// $phiz = F('phiz','','./Data/');
		$phiz=C('BIAO_QING');
		//print_r($arr[0]);
		foreach($arr[0] as $v){
			foreach($phiz as $key => $value){
				if($v == '[' . $value . ']'){
					//D:\c\myblog\Song\Public\Home\images\wish\phiz
					$content = str_replace($v,'<img src = "' . __ROOT__ . '/Public/Home/images/wish/phiz/' . $key . '.gif"/>',$content);
				}
			}
		}
	}
	return $content;
}


// 2、其他公共函数
