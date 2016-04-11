<?php
/**
 * @todo 微信企业号接口
 * 
 * */
class qyapi {
    private static $baseurl = 'https://qyapi.weixin.qq.com/cgi-bin/';
    private static $access_token = '';
    
    //生成加密对象
    public static function wxcpt($corpId, $token, $encodingAesKey) {
        include_once k::$ROOT_PATH.'third_party/wxcrypt/WXBizMsgCrypt.php';
        return new WXBizMsgCrypt($token, $encodingAesKey, $corpId);
    }
    //验证回调URL
    public static function verify_url($wxcpt) {
        $sVerifyMsgSig = isset($_GET['msg_signature'])?trim($_GET['msg_signature']):'';
        $sVerifyTimeStamp = isset($_GET['timestamp'])?trim($_GET['timestamp']):'';
        $sVerifyNonce = isset($_GET['nonce'])?trim($_GET['nonce']):'';
        $sVerifyEchoStr = isset($_GET['echostr'])?trim($_GET['echostr']):'';
        $EchoStr = "";
        
        $errCode = $wxcpt->VerifyURL($sVerifyMsgSig, $sVerifyTimeStamp, $sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
        if ($errCode == 0) {
        	return $sEchoStr;
        } else {
        	return '';
        }
    }
    //对用户回复的消息解密
    public static function decrypt_msg($wxcpt) {
        $sReqMsgSig = isset($_GET['msg_signature'])?trim($_GET['msg_signature']):'';
        $sReqTimeStamp = isset($_GET['timestamp'])?trim($_GET['timestamp']):'';
        $sReqNonce = isset($_GET['nonce'])?trim($_GET['nonce']):'';
        $sReqData = isset($GLOBALS["HTTP_RAW_POST_DATA"])?$GLOBALS["HTTP_RAW_POST_DATA"]:'';
        $sMsg = '';
        $errCode = $wxcpt->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
        if($errCode == 0) {
            $xml = new DOMDocument();
        	$xml->loadXML($sMsg);
        	return $xml->getElementsByTagName('Content')->item(0)->nodeValue;
        }else {
            return false;
        }
    }
    //企业回复用户消息的加密
    public static function encrypt_msg($wxcpt, $sRespData) {
        $sReqTimeStamp = isset($_GET['timestamp'])?trim($_GET['timestamp']):'';
        $sReqNonce = isset($_GET['nonce'])?trim($_GET['nonce']):'';
        $sEncryptMsg = "";
        $errCode = $wxcpt->EncryptMsg($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg);
        if ($errCode == 0) {
        	return $sEncryptMsg;
        } else {
        	return false;
        }
    }
    
    //建立连接
    /**
     * 主动调用
     * 获取AccessToken
     * $corpid 企业ID
     * $corpsecret 管理组的凭证密钥
     * 
     * access_token有效期7200秒
     * */
    public static function gettoken($corpid, $corpsecret) {
        $url = self::$baseurl.'gettoken?corpid='.$corpid.'&corpsecret='.$corpsecret;
        $res = self::curl_get($url);
        $res = json_decode($res, true);
        if(isset($res['access_token']) && !empty($res['access_token'])) {
            self::$access_token = $res['access_token'];
            return true;
        }else {
            return false;
        }
    }
    //通讯录
    /**
     * @todo 创建部门
     * 正确返回 {"errcode": 0,"errmsg": "created", "id":2}
     * */
    public static function department_create($name, $parentid=1) {
        $url = self::$baseurl.'department/create?access_token='.self::$access_token;
        $data = array(
        'name'      =>$name,
        'parentid'  =>$parentid
        );
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    /**
     * @todo 更新部门
     * 正确返回 {"errcode": 0,"errmsg": "updated"}
     * */
    public static function department_update($id, $name) {
        $url = self::$baseurl.'department/create?access_token='.self::$access_token;
        $data = array(
        'name'  =>$name,
        'id'    =>$id
        );
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    /**
     * @todo 删除部门
     * 注：不能删除根部门；不能删除含有子部门、成员的部门
     * 正确返回 {"errcode": 0,"errmsg": "deleted"}
     * */
    public static function department_delete($id) {
        $url = self::$baseurl.'department/delete?access_token='.self::$access_token.'&id='.$id;
        $res = self::curl_get($url);
        return json_decode($res, true);
    }
    /**
     * @todo 获取部门列表
     * */
    public static function department_list() {
        $url = self::$baseurl.'department/list?access_token='.self::$access_token;
        $res = self::curl_get($url);
        return json_decode($res, true);
    }
    
    /**
     * @todo 创建成员
     * @userid 员工UserID。对应管理端的帐号，企业内必须唯一
     * @name 成员名称。长度为1~64个字符
     * @department 每个部门的直属员工上限为1000个
     * @position 长度为0~64个字符
     * @mobile 手机号码。企业内必须唯一，mobile/weixinid/email三者不能同时为空
     * @gender =0表示男，=1表示女。默认gender=0
     * @tel 办公电话。长度为0~64个字符
     * @email 邮箱。长度为0~64个字符。企业内必须唯一
     * @weixinid 微信号。企业内必须唯一
     * 
     * 正确返回 {"errcode": 0,"errmsg": "created"}
     * */
    public static function user_create($userid, $name, $department, $position, $mobile, $gender, $tel, $email, $weixinid) {
        $url = self::$baseurl.'user/create?access_token='.self::$access_token;
        $data = array(
        'userid'        =>$userid,
        'name'          =>$name,
        'department'    =>$department,
        'position'      =>$position,
        'position'      =>$position,
        'mobile'        =>$mobile,
        'gender'        =>$gender,
        'tel'           =>$tel,
        'email'         =>$email,
        'weixinid'      =>$weixinid
        );
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    /**
     * @todo 更新成员
     * @userid 员工UserID。对应管理端的帐号，企业内必须唯一
     * @name 成员名称。长度为1~64个字符
     * @department 每个部门的直属员工上限为1000个
     * @position 长度为0~64个字符
     * @mobile 手机号码。企业内必须唯一，mobile/weixinid/email三者不能同时为空
     * @gender =0表示男，=1表示女。默认gender=0
     * @tel 办公电话。长度为0~64个字符
     * @email 邮箱。长度为0~64个字符。企业内必须唯一
     * @weixinid 微信号。企业内必须唯一
     * @enable 启用/禁用成员。1表示启用成员，0表示禁用成员
     * 
     * 正确返回 {"errcode": 0,"errmsg": "updated"}
     * */
    public static function user_update($userid, $name, $department, $position, $mobile, $gender, $tel, $email, $weixinid, $enable) {
        $url = self::$baseurl.'user/update?access_token='.self::$access_token;
        $data = array(
        'userid'        =>$userid,
        'name'          =>$name,
        'department'    =>$department,
        'position'      =>$position,
        'position'      =>$position,
        'mobile'        =>$mobile,
        'gender'        =>$gender,
        'tel'           =>$tel,
        'email'         =>$email,
        'weixinid'      =>$weixinid,
        'enable'        =>$enable
        );
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    /**
     * @todo 删除成员
     * 正确返回 {"errcode": 0,"errmsg": "deleted"}
     * */
    public static function user_delete($userid) {
        $url = self::$baseurl.'user/delete?access_token='.self::$access_token.'&userid='.$userid;
        $res = self::curl_get($url);
        return json_decode($res, true);
    }
    /**
     * @todo 获取成员
     * */
    public static function user_get($userid) {
        $url = self::$baseurl.'user/get?access_token='.self::$access_token.'&userid='.$userid;
        $res = self::curl_get($url);
        return json_decode($res, true);
    }
    /**
     * @todo 获取部门成员
     * @department_id 部门id
     * @fetch_child 1/0：是否递归获取子部门下面的成员
     * @status 0获取全部员工，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加
     * */
    public static function user_simplelist($department_id, $fetch_child, $status) {
        $url = self::$baseurl.'user/simplelist?access_token='.self::$access_token.'&department_id='.$department_id.'&fetch_child='.$fetch_child.'&status='.$status;
        $res = self::curl_get($url);
        return json_decode($res, true);
    }
    
    /**
     * @todo 创建标签
     * @tagname 标签名称。长度为1~64个字符，标签不可与其他同组的标签重名，也不可与全局标签重名
     * 
     * 正确返回 {"errcode": 0,"errmsg": "created","tagid":1}
     * */
    public static function tag_create($tagname) {
        $url = self::$baseurl.'tag/create?access_token='.self::$access_token;
        $data = array('tagname'=>$tagname);
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    /**
     * @todo 更新标签
     * @tagid 标签ID
     * @tagname 最长64个字符
     * 
     * 正确返回 {"errcode": 0,"errmsg": "updated"}
     * */
    public static function tag_update($tagid, $tagname) {
        $url = self::$baseurl.'tag/update?access_token='.self::$access_token;
        $data = array('tagid'=>$tagid, 'tagname'=>$tagname);
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    /**
     * @todo 删除标签
     * @tagid 标签ID
     * 正确返回 {"errcode": 0,"errmsg": "deleted"}
     * */
    public static function tag_delete($tagid) {
        $url = self::$baseurl.'tag/delete?access_token='.self::$access_token.'&tagid='.$tagid;
        $res = self::curl_get($url);
        return json_decode($res, true);
    }
    /**
     * @todo 获取标签成员
     * 正确返回 {"errcode": 0,"errmsg": "deleted"}
     * */
    public static function tag_get($tagid) {
        $url = self::$baseurl.'tag/get?access_token='.self::$access_token.'&tagid='.$tagid;
        $res = self::curl_get($url);
        return json_decode($res, true);
    }
    /**
     * @todo 添加标签成员
     * @tagid 标签ID
     * @userlist 企业员工ID列表
     * 
     * 正确返回 {"errcode": 0,"errmsg": "ok"}
     * 若部分userid非法，则返回{"errcode": 0,"errmsg": "invalid userlist failed","invalidlist"："usr1|usr2|usr"}
     * 当包含userid全部非法时返回{"errcode": 40070,"errmsg": "all list invalid "}
     * */
    public static function tag_addtagusers($tagid, $userlist) {
        $url = self::$baseurl.'tag/addtagusers?access_token='.self::$access_token;
        $data = array('tagid'=>$tagid, 'userlist'=>$userlist);
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    /**
     * @todo 删除标签成员
     * @tagid 标签ID
     * @userlist 企业员工ID列表
     * 
     * 正确返回 {"errcode": 0,"errmsg": "deleted"}
     * 若部分userid非法，则返回{"errcode": 0,"errmsg": "invalid userlist failed","invalidlist"："usr1|usr2|usr"}
     * 当包含userid全部非法时返回{"errcode": 40070,"errmsg": "all list invalid "}
     * */
    public static function tag_deltagusers($tagid, $userlist) {
        $url = self::$baseurl.'tag/deltagusers?access_token='.self::$access_token;
        $data = array('tagid'=>$tagid, 'userlist'=>$userlist);
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    
    
    //多媒体
    /**
     * @todo 上传媒体文件
     * @return
     * 正确返回 {"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
     * 错误返回 {"errcode":40004,"errmsg":"invalid media type"}
     * */
    public static function media_upload($filepath, $type) {
        if(!in_array($type, array('image', 'voice', 'video', 'file'))) {
            return false;
        }
        $url = self::$baseurl.'media/upload?access_token='.self::$access_token.'&type='.$type;
        $data = array('media'=>'@'.$filepath);
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    /**
     * @todo 下载媒体文件
     * @return
     * 正确返回 {"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
     * 错误返回 {"errcode":40004,"errmsg":"invalid media type"}
     * */
    public static function media_get($media_id) {
        $url = self::$baseurl.'media/get?access_token='.self::$access_token.'&media_id='.$media_id;
        $res = self::curl_get($url);
        return json_decode($res, true);
    }
    
    //接收消息
    
    //发送消息
    /**
     * $msgtype = text, image, voice, video, file, news, mpnews
     * $touser UserID列表（多个接收者用‘|’分隔）, @all 表示所有
     * $agentid 企业应用的id
     * $safe 表示是否是保密消息，0表示否，1表示是，默认0
     * $content
     *   text:   array('content'=>'')
     *   image:  array("media_id": "MEDIA_ID")
     *   voice:  array("media_id": "MEDIA_ID")
     *   video:  array( "media_id": "MEDIA_ID","title": "Title","description": "Description")
     *   file:   array("media_id": "MEDIA_ID")
     *   news:   array("articles"=>array(array("title": "Title","description": "Description","url": "URL","picurl": "PIC_URL"), array(), ...)))
     *   mpnews: array("articles"=>array(array("thumb_media_id": "id","author": "Author","content_source_url": "URL","content": "Content""digest": "Digest description","show_cover_pic": "0"), array(), ...))
     * 
     * */
    public static function message_send($content, $touser, $toparty, $totag, $msgtype, $agentid, $safe=0) {
        $url = self::$baseurl.'message/send?access_token='.self::$access_token;
        $data = array(
        'touer'=>$touser,
        'toparty'=>$toparty,
        'totag'=>$totag,
        'msgtype'=>$msgtype,
        'agentid'=>$agentid,
        'safe'=>$safe,
        $msgtype=>$content
        );
        $res = self::curl_post($url, $data);
        return json_decode($res, true);
    }
    
    //自定义菜单
    //添加自定义菜单
    public static function menu_create($agentid, $data) {
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
		$url = self::$baseurl.'menu/create?access_token='.self::$access_token.'&agentid='.$agentid;
		$res = self::curl_post($url, $menu);
		return json_decode($res, true);
    }
    //获取自定义菜单
    public function menu_get($agentid) {
        $url = self::$host.'menu/get?access_token='.self::$access_token.'&agentid='.$agentid;
		$res = self::curl_get($url);
		return json_decode($res, true);
	}
    //删除自定义菜单
	public function menu_delete($agentid) {
		$url = self::$host.'menu/delete?access_token='.self::$access_token.'&agentid='.$agentid;
		$res = self::curl_get($url);
		$res = json_decode($res);
		if($res->errcode==0) {
			return true;
		}else {
			return false;
		}
	}
    
    //Oauth2验证
    public static function oauth2_authorize($appid, $callbackurl, $scope='snsapi_base') {
        $_SESSION['wx_state'] = md5(microtime(true).'vsapp');
        $login_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.urlencode($callbackurl).'&response_type=code&scope='.$scope.'&state='.$_SESSION['wx_state'].'#wechat_redirect';
        return $login_url;
    }
    public static function user_getuserinfo($agentid) {
        if(isset($_REQUEST["code"]) && $_REQUEST["code"] && isset($_REQUEST['state']) && $_REQUEST['state'] && $_REQUEST['state'] == $_SESSION['wx_state']) {
            $_SESSION['wx_state'] = '';
            $url = self::$host.'user/getuserinfo?access_token='.self::$access_token.'&code='.$_REQUEST["code"].'&agentid='.$agentid;
            return json_decode(file_get_contents($url), true);
        }
        return false;
    }
    
    //二次验证
    /**
     * $userid 员工UserID
     * 正确返回 array("errcode": "0","errmsg": "ok")
     * */
    public static function user_authsucc($userid) {
        $url = self::$baseurl.'user/authsucc?access_token='.self::$access_token.'&userid='.$userid;
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
?>