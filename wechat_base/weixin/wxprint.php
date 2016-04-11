<?php
class wxprint {
	/**
	 * 微信创打印接口
	 */
	private static $host = 'http://servertest1weixinprint.com/weixin?publicUserId='; //测试地址
	//http://weixin.elianon.com/weixin?publicUserId=
	private static $ToUserName = ''; //开发者微信号
	

	//消息推送
	public static function sendMsg($uid, $data) {
		//http://inleader.weixinprint.com/weixin?publicUserId=3756
		$url = 'http://inleader.weixinprint.com/weixin?publicUserId=' . $uid;
		
		return self::curl_post($url, $data);

	}

	//图片消息
	public static function imageMsg($uid, $data) {
		$url = 'http://inleader.weixinprint.com/weixin?publicUserId=' . $uid;
		
		return self::curl_post($url, $data);
	}

	//回复文本消息
	public static function replyMsg($uid, $data) {
		$url = 'http://inleader.weixinprint.com/weixin?publicUserId=' . $uid;
		
		return self::curl_post($url, $data);
	}

	public static function curl_post($url, $data) {
		$ch = curl_init();//初始化curl
		$header[] = "Content-type: text/html; charset=utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$res = curl_exec($ch);//运行curl
		curl_close($ch);
		return $res;
	}


	//------------------------------------------------------------------------------------/

	//微信账号新增接口
	public static function addWeixin($orgId, $img, $type, $name) {
		if (!is_numeric($orgId) || !is_numeric($type) || empty($name)) return false;

		$method = 'addWeixinByOrgId';
		$param = array('orgId' => $orgId,
						'weiXinCodeImg' => $img,
						'versionType' => $type,
						'publicUserName' => $name
				);
		
		return self::common_fun($method, $param);
	}

	//微信账号修改
	public static function editWeixin($pid, $img, $type) {
		if (!is_numeric($pid) || !is_numeric($type)) return false;

		$method = 'editWeixinBypublicId';
		$param = array('publicId' => $pid, 'weiXinCodeImg' => $img, 'versionType' => $type); //publicUserName 名称

		return self::common_fun($method, $param);
	}

	//微信回复修改
	public static function editWeixinReply($pid, $code, $desc) {
		if (!is_numeric($pid)) return false;

		$method = 'editWeixinProcedureBypublicId';
		$param = array('publicId' => $pid, 'weiXinProcedureCode' => $code, 'weiXinProcedureDesc' => $desc);
		
		return self::common_fun($method, $param);
	}

	//---------------------------------------------------------------------------------------------/

	//设备列表(根据orgId)显示
	public static function getClientInfo($orgId) {
		if (!is_numeric($orgId)) return false;

		$method = 'getClientInfoByorgId';
		$param = array('orgId' => $orgId);
		
		return self::common_product($method, $param);
	}

	//设备列表（根据publicId）显示
	public static function getClientInfoBypid($pid) {
		if (!is_numeric($pid)) return false;

		$method = 'getClientInfoBypublicId';
		$param = array('publicId' => $pid);
		
		return self::common_product($method, $param);
	}

	//设备修改
	public static function editClientInfo($params) {
		if (!is_numeric($params['publicId'])) return false;

		$method = 'editClientInfoByclientInfoId';
		//$param = array('publicId' => $orgId);
		
		return self::common_product($method, $params);
	}

	//设备广告图片修改
	public static function editClientTempBaaner($params) {
		//if (!is_numeric($params['publicId'])) return false;

		$method = 'editClientTempBaaner';
		//$param = array('publicId' => $orgId);
		
		return self::common_product($method, $params);
	}

	//5.获取广告模版信息
	public static function getClientTempBanner($clientId, $tempId) {
		if (!is_numeric($clientId) || !is_numeric($tempId)) return false;

		$method = 'getClientTempBanner';
		$param = array('clientId' => $clientId, 'tempId' => $tempId);
		
		return self::common_product($method, $param);
	}

	//6.获取设备打印统计信息
	public static function getPrintStatistics($orgId, $clientId, $startTime, $endTime) {
		if (!is_numeric($clientId) || !is_numeric($orgId)) return false;

		$method = 'getPrintStatistics';
		$param = array('orgId' => $orgId, 'clientId' => $clientId, 'startTime' => $startTime, 'endTime' => $endTime);
		
		return self::common_product($method, $param);
	}
	
	//7.打印详细统计
	public static function getPrintTaskId($clientId, $startTime, $endTime, $type) {
		if (!is_numeric($clientId) || !is_numeric($type)) return false;

		$method = 'getPrintTaskId';
		$param = array('clientId' => $clientId, 'startTime' => $startTime, 'endTime' => $endTime, 'type' => $type);
		
		return self::common_product($method, $param);
	}

	//8.打印机统计月份数量
	public static function getChartByMonth($clientId, $time, $type) {
		if (!is_numeric($clientId) || !is_numeric($type)) return false;

		$method = 'getChartByMonth';
		$param = array('clientId' => $clientId, 'time' => $time, 'type' => $type);
		
		return self::common_product($method, $param);
	}

	
	/**********************************************************************************/

	public static function common_fun($method, $param) {
		$uri = 'http://admin.weixinprint.com/inleader/services/mobileVsins';
		$client = new SoapClient(null,array('location' => $uri . '?wsdl','uri' => $uri));

		return $client->__call($method, $param);
	}

	//后端设置接口调用
	public static function common_product($method, $param) {
		$uri = 'http://admin.weixinprint.com/inleader/services/mobileClient';
		//$uri = 'http://140.206.95.61:8069/admin/services/mobileClient'; //测试地址
		$client = new SoapClient(null,array('location' => $uri . '?wsdl','uri' => $uri));

		return $client->__call($method, $param);
	}
}