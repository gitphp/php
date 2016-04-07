<?php
//通用分类类信息
	class Page{
		/*
		 * @param1 $uri		要提交的页面
		 * @param1 $rows	总行数记录
		 * @param1 $page	当前页
		 * @param1 $length	每页显示多少条信息
		 * @param1 $act		用户的动作
		 * @return string	分类字符串
		*/
		public function getPage($uri,$rows,$page,$length,$act){
			//计算分页信息
			$pagetotal = ceil($rows / $length);
			
			// style1,获取字符串信息-----------------------------------
			$page_str="共有{$rows}行记录，当前第{$page}页/共{$pagetotal}页，每页{$length}条记录";
			
			// style2,获取数字分页信息---------------------------------
			$num_str='';
			for($i=1;$i<=$pagetotal;$i++){
				$num_str.= "<a href='{$uri}?act={$act}&page={$i}'>$i &nbsp;</a>";
				
			}
			// style3,下拉框分页信息展示----加onchange事件改变当前页面的uri
			$select_str="<select onchange=\"location.href='{$uri}?act={$act}&page='+this.value\">";
			for($i=1;$i<=$pagetotal;$i++){
				if($page==$i){
					$select_str.="<option value='{$i}' selected='selected'>{$i}</option>";				
				}else{
					$select_str.="<option value='{$i}'>{$i}</option>";
				}			
			}
			$select_str.='</select>';
			// style4,input框输入要显示的页面信息----------------------
			$input_str='';
			$input_str.=<<<xxx
				<form action='{$uri}?act={$act}' method='post'>
					<input type='text' name='page' style=width:30px;/>
					<input type='hidden' name='act' value='{$act}'/>
					<input type='submit' name='' value='Go'/>	
				</form>

xxx;
			// style5,上下页，首尾页------------------------------------
			//计算上下页信息
			$pre = $page<=1 ? 1 : $page - 1;
			$next= $page>=$pagetotal ? $pagetotal : $page + 1;
			$navigate=<<<bbb
				<a href='{$uri}?act={$act}&page=1'>首页</a>
				<a href='{$uri}?act={$act}&page={$pre}'>上一页</a>
				<a href='{$uri}?act={$act}&page={$next}'>下一页</a>
				<a href='{$uri}?act={$act}&page={$pagetotal}'>末页</a>
bbb;
			
			
			return $page_str . $num_str . $select_str . $input_str . $navigate;
			
		}
		// 写一个函数随机获得各种字符串,因为返回的字符串不是类的属性，所以这里不好用，
		// 除非把这个功能直接在上级方法里面直接写，直接判断，输出即可。
			/* public function getNavigate($case){
				switch($case){
					case 1 :
						return $page_str . $num_str . $select_str;
						break;
					case 2 :
						return $page_str . $select_str . $input_str;
						break;
					case 3 :
						return $page_str . $input_str . $navigate;
						break;
					case 4 :
						return $page_str . $num_str . $select_str . $input_str . $navigate;
						break;
				}
			} */
		
	}