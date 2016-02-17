<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// 商品控制器
class Goods extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('goods_model');
		$this->load->model('attribute_model');
		$this->load->model('goodstype_model');
		$this->load->model('category_model');
	}
	// 显示
	public function show(){
		$this->load->view('goods_list.html');
	}
	// 增加
	public function add(){
		if(isset($_POST['g_name'])){
			// doubi($_POST);
			$_POST['promote_start_time']=strtotime($_POST['promote_start_time']);
			$_POST['promote_end_time']=strtotime($_POST['promote_end_time']);
			// 接收附加表的信息，接收到了之后就干掉，删除$_POST
			$attr_ids=$this->input->post('attr_id');
			$attrs_vals=$this->input->post('attr_value');
			unset($_POST['attr_id']);
			unset($_POST['attr_value']);
			// doubi($attr_ids);
			// doubi($attrs_vals);exit;
			// doubi($_POST);exit;
			// 执行图片文件上传操作
			$config['upload_path']='./public/uploads/';
			$config['allowed_types']='gif|png|jpg|jpeg|pjpeg';
			$config['max_size']=3000;	//kb单位

			$this->load->library('upload',$config);
			// 在构造函数里面加载的话，可以使用一个外部的配置文件upload.php
			if(! $this->upload->do_upload('g_img')){
				die($this->upload->display_errors());
			}
			// 获取信息
			$info=$this->upload->data();
			$_POST['g_img']=$info['file_name'];
			//执行缩略图
			$config_img['source_image']='./public/uploads/'.$info['file_name'];
			$config_img['create_thumb']=true;
			$config_img['maintain_ratio']=true;
			$config_img['width']=160;
			$config_img['height']=160;




			$this->load->library('image_lib',$config_img);
			if($this->image_lib->resize()){
				$_POST['g_thumb']=$info['raw_name'].$this->image_lib->thumb_marker.$info['file_ext'];
			}else{
				echo $this->image_lib->display_errors();
			}

			if($goods_id=$this->goods_model->add_goods($_POST)){
				// 添加商品成功之后，处理属性附加表的添加
				
				foreach($attr_ids as $k=>$vall){
					$data1['goods_id']=$goods_id;
					$data1['attr_id']=$vall;
					$data1['attr_value']=$attrs_vals[$k];
					#完成插入
					$this->db->insert('goods_attr',$data1);
				}
				//成功
				redirect('admin/goods/show');
				
			}else{
				echo 'no';
			}
		}else{
			// 获得商品类型
			$data['goodstype']=$this->goodstype_model->getall_types();
			// doubi($data);
			$this->load->view('goods_add.html',$data);
		}
	}

	
	//ajax获取商品属性的方法-----------------------------
	public function attr(){
		$type_id=$this->input->get('type_id');
		// 根据id获取属性表的值
		$attrs=$this->attribute_model->get_attrs($type_id);
		// doubi($attrs);
		// 循环变量attrs的值，组织html代码，输出给客户端
		$html='';
		foreach($attrs as $k=>$v){
			$html.='<tr>';
			$html.='<td class="label">'.$v['a_name'].'</td>';
			$html.="<td><input type='hidden' name='attr_id[]' value=".$k.'>';
			//判断当前属性的输入方式
			switch($v['a_input_type']){
				case 0:
				// 文本框手动输入
					$html.="<input name='attr_value[]' type='text' size='40'>";
					break;
				case 1:
				// 下拉框输入,把数组炸开
					$arr=explode(PHP_EOL, $v['a_value']);
					$html.="<select name='attr_value[]'>";
					$html .= "<option value=''>请选择...</option>";
					foreach ($arr as $v) {
						$html .= "<option value='$v'>$v</option>";
					}								  
					$html .= "</select>";
					break;

				case 2:
				//文本域
					$html.="<textarea name='attr_value[]' id='' cols='40' rows='10'></textarea>";
					break;
				default:
					break;
			}
			
			$html.='</td></tr>';
		}
		echo $html;
	}

}
/*

	
<td>	
	
	<input name="attr_value_list[]" type="text" value="MicroSD" size="40">  
	<input type="hidden" name="attr_price_list[]" value="0">
</td>

 */