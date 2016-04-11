<?php
class wxmenu {
	private static $access_token;
    private static $domain = 'api.weixin.qq.com';
	private static $host = 'https://api.weixin.qq.com/cgi-bin/';
	public function token($appid, $secret) {
		if(self::$access_token) {
			return true;
		}
		$url = self::$host.__FUNCTION__.'?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
		$res = json_decode(self::curl_get($url));
		if(isset($res->errcode) && $res->errcode) {
			return false;
		}
		self::$access_token = $res->access_token;
		return true;
	}
	public function create($data) {
		if(empty(self::$access_token)) {
			return false;
		}
		$menu = new stdClass();
		$menu->button = array();
		$menu_name_arr = array();
		foreach ($data as $k=>$r) {
			$menu_name_key = 'menu_name_'.$k.'_key';
			$menu_name_arr[$menu_name_key] = $r['name'];
			if(empty($r['sub_button'])) {
				$obj = new stdClass();
				$obj->type = $r['type'];
				$obj->name = $menu_name_key;
                if($r['type']=='click') {
                    $obj->key = $r['key'];
                }else {
                    $obj->url = $r['url'];
                }
				$menu->button[] = $obj;
			}else {
				$sub_button = array();
				foreach ($r['sub_button'] as $k2=>$r2) {
					$menu_name_key2 = 'menu_name_'.$k.'_'.$k2.'_key';
					$menu_name_arr[$menu_name_key2] = $r2['name'];
					$obj = new stdClass();
					$obj->type = $r2['type'];
					$obj->name = $menu_name_key2;
                    if($r2['type']=='click') {
                        $obj->key = $r2['key'];
                    }else {
                        $obj->url = $r2['url'];
                    }
					$sub_button[] = $obj;
				}
				$obj = new stdClass();
				$obj->name = $menu_name_key;
				$obj->sub_button = $sub_button;
				$menu->button[] = $obj;
			}
		}
		$menu = str_replace(array_keys($menu_name_arr), $menu_name_arr, json_encode($menu));
		$url = self::$host.'menu/'.__FUNCTION__.'?access_token='.self::$access_token;
		$res = self::curl_post($url, $menu);
		$res = json_decode($res);
		if($res->errcode==0) {
			return $menu;
		}else {
			return false;
		}
	}
	public function get() {
		if(empty(self::$access_token)) {
			return false;
		}
		$url = self::$host.'menu/'.__FUNCTION__.'?access_token='.self::$access_token;
		$res = self::curl_get($url);
		$res = json_decode($res, true);
		if(isset($res['errcode']) && $res['errcode']) {
			return false;
		}else {
			return $res['menu']['button'];
		}
	}
	public function delete() {
		if(empty(self::$access_token)) {
			return false;
		}
		$url = self::$host.'menu/'.__FUNCTION__.'?access_token='.self::$access_token;
		$res = self::curl_get($url);
		$res = json_decode($res);
		if($res->errcode==0) {
			return true;
		}else {
			return false;
		}
	}
    
    //------------------------------------------------------------------------------------
    //创建二维码ticket $action_name = QR_SCENE 临时 | QR_LIMIT_SCENE 永久
    public static function create_ticket($scene_id, $action_name='QR_LIMIT_SCENE') {
        $url = self::$host.'qrcode/create?access_token='.self::$access_token;
        if($action_name=='QR_SCENE') {
            $data = '{"expire_seconds": 1800, "action_name": "'.$action_name.'", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
        }else {
            $data = '{"action_name": "'.$action_name.'", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
        }
        $res = self::curl_post($url, $data);
		$res = json_decode($res, true);
        if(isset($res['errcode']) && !empty($res['errcode'])) {
            return false;
        }else {
            return $res['ticket'];
        }
    }
    //通过ticket换取二维码
    public static function showqrcode($ticket) {
        return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket);
    }
    
    //通知微信发货
    public static function deliver_notice($appid, $appkey, $openid, $transid, $out_trade_no, $deliver_timestamp, $deliver_status, $deliver_msg) {
        $params = array(
        'appid'=>$appid,
        'appkey'=>$appkey,
        'openid'=>$openid,
        'transid'=>$transid,
        'out_trade_no'=>$out_trade_no,
        'deliver_timestamp'=>$deliver_timestamp,
        'deliver_status'=>$deliver_status,
        'deliver_msg'=>$deliver_msg
        );
        ksort($params);
        $query_arr = array();
        foreach($params as $k=>$v) {
            $query_arr[] = $k.'='.$v;
        }
        $signature_str = implode('&', $query_arr);
        $signature_value = sha1($signature_str);
        
        $data = array(
        'appid'=>$appid,
        'openid'=>$openid,
        'transid'=>$transid,
        'out_trade_no'=>$out_trade_no,
        'deliver_timestamp'=>$deliver_timestamp,
        'deliver_status'=>$deliver_status,
        'deliver_msg'=>$deliver_msg,
        'app_signature'=>$signature_value,
        'sign_method'=>'sha1'
        );
        //log_message('error', serialize($data));
        $url = 'https://'.self::$domain.'/pay/delivernotify?access_token='.self::$access_token;
        $res = self::curl_post($url, json_encode($data));
        return json_decode($res, true);
    }
    
    /**
     * @todo 根据OpenID列表群发消息，每个用户每个月只能接收四条，每天只能发送100次。
     * @param $openid_arr Array 如 array('openid1', 'openid2', ...)
     * @param $type
     * mpnews 图文 $data = array("media_id"   =>"123dsdajkasd231jhksad")
     * text   文本 $data = array("content"    =>"hello from boxer.")
     * voice  语音 $data = array("media_id"   =>"mLxl6paC7z2Tl-NJT64yzJve8T9c8u9K2x-Ai6Ujd4lIH9IBuF6-2r66mamn_gIT")
     * image  图片 $data = array("media_id"   =>"BTgN0opcW3Y5zV_ZebbsD3NFKRWf6cb7OPswPi9Q83fOJHK2P67dzxn11Cp7THat")
     * video  视频 $data = array("media_id"   =>"123dsdajkasd231jhksad", "title":"TITLE","description":"DESCRIPTION")
     * 
     * @return
     * 正确返回
     * {
     *      "errcode":0,
     *      "errmsg":"send job submission success",
     *      "msg_id":34182
     * }
     **/

    public static function wxmass_by_openid($openid_arr, $type, $data) {
        $return = array('touser'=>$openid_arr, 'msgtype'=>$type, $type=>$data);
        $url = self::$host."message/mass/send?access_token=".self::$access_token;
        $return = json_encode($return);
        $return = urldecode($return);
        $res = self::curl_post($url, $return);
        return json_decode($res, true);
    }
    
    /**
     * @todo 根据群组ID群发消息，每个用户每个月只能接收四条，每天只能发送100次。
     * @param $group_id int
     * @param $type
     * mpnews 图文 $data = array("media_id"   =>"123dsdajkasd231jhksad")
     * text   文本 $data = array("content"    =>"hello from boxer.")
     * voice  语音 $data = array("media_id"   =>"mLxl6paC7z2Tl-NJT64yzJve8T9c8u9K2x-Ai6Ujd4lIH9IBuF6-2r66mamn_gIT")
     * image  图片 $data = array("media_id"   =>"BTgN0opcW3Y5zV_ZebbsD3NFKRWf6cb7OPswPi9Q83fOJHK2P67dzxn11Cp7THat")
     * video  视频 $data = array("media_id"   =>"123dsdajkasd231jhksad", "title":"TITLE","description":"DESCRIPTION")
     * 
     * @return
     * 正确返回
     * {
     *      "errcode":0,
     *      "errmsg":"send job submission success",
     *      "msg_id":34182
     * }
     **/
    public function wxmass_by_group($group_id, $type, $data) {
        $return = array('filter'=>array('group_id'=>$group_id), 'msgtype'=>$type, $type=>$data);
        $url = self::$host."message/mass/sendall?access_token=".self::$access_token;
        $return = json_encode($return);
        $return = urldecode($return);
        $res = self::curl_post($url, $return);
        return json_decode($res, true);
    }
    
    /**
     * @上传多媒体文件
     * $media (form-data中媒体文件标识，有filename、filelength、content-type等信息)
     * 返回：{"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
     */
    public static function upload_media($filepath, $type = 'image') {
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=" . self::$access_token . "&type=" . $type;
        $data = array('media' => '@'.$filepath);
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    
    public static function get_token() {
        return self::$access_token;
    }
    
    /**
     * @上传图文消息素材
     * 
     */
    public static function upload_news($param) {
        $param = urldecode(json_encode($param));
        //print_r($param);exit;
        $url = self::$host . "media/uploadnews?access_token=" . self::$access_token;
        $res = self::curl_post($url, $param);
        return json_decode($res, true);
    }
    
    /**
     * @todo 创建分组
     * @param $name string length 30
     * 
     * */
     public static function groups_create($name) {
        $url = self::$host . "groups/create?access_token=" . self::$access_token;
        $data = '{"group":{"name":"'.$name.'"}}';
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
     }
     
     /**
     * @todo 修改分组
     * @param $group_id int
     * @param $name string length 30
     * 
     * */
     public static function groups_update($group_id, $name) {
        $url = self::$host . "groups/update?access_token=" . self::$access_token;
        $data = '{"group":{"id":'.$group_id.',"name":"'.$name.'"}}';
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
     }
     
     /**
     * @todo 移动用户分组
     * @param $openid string
     * @param $to_groupid int
     * 
     * */
     public static function groups_members_update($openid, $to_groupid) {
        $url = self::$host . "groups/members/update?access_token=" . self::$access_token;
        $data = '{"openid":"'.$openid.'","to_groupid":'.$to_groupid.'}';
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
     }
     
     /**
     * @todo 查询所有分组
     * @param $openid string
     * @param $to_groupid int
     * 
     * */
     public static function groups_get() {
        $url = self::$host . "groups/get?access_token=" . self::$access_token;
        $res = self::curl_get($url);
        return json_decode($res, true);
     }
     
     /**
     * @todo 查询用户所在分组
     * @param $openid string
     * @param $to_groupid int
     * 
     * */
     public static function groups_getid($openid) {
        $url = self::$host . "groups/getid?access_token=" . self::$access_token;
        $res = self::curl_post($url, array('openid'=>$openid));
        return json_decode($res, true);
     }
     
     /**
     * @todo 获取关注者列表
     * @param $next_openid string
     * 
     * */
     public static function user_get($next_openid='') {
        $url = self::$host . "user/get?access_token=".self::$access_token.'&next_openid='.$next_openid;
        $res = self::curl_get($url);
        return json_decode($res, true);
     }
     
     /**
     * @todo 获取用户基本信息
     * @param $next_openid string
     * 
     * */
     public static function user_info($openid='') {
        $url = self::$host . "user/info?access_token=" . self::$access_token . '&openid=' . $openid . '&lang=zh_CN';
        $res = self::curl_get($url);
        return json_decode($res, true);
     }
	//------------------------------------------------------------------------------------
	private static function curl_get($url) {
		$ch = curl_init();//初始化curl
		curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 0);//get提交方式
		$data = curl_exec($ch);//运行curl
		curl_close($ch);
		return $data;
	}
	private static function curl_post($url, $data) {
		$ch = curl_init();//初始化curl
		curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$data = curl_exec($ch);//运行curl
		curl_close($ch);
		return $data;
	}
}