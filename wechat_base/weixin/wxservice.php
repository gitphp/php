<?php
class wxservice
{
	public static $postObj;
	public static $postStr;
	public static function valid($token)
    {
        $echoStr = isset($_GET["echostr"])?$_GET["echostr"]:'';
        if(self::checkSignature($token)){
            ob_clean();
        	die($echoStr);
        }
    }

    public static function receive()
    {
		self::$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"])?$GLOBALS["HTTP_RAW_POST_DATA"]:'';
		if (empty(self::$postStr)){
			return false;
        }
        self::$postObj = simplexml_load_string(self::$postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    }

	public static function response($data) {
		if(!isset(self::$postObj)) {
			return false;
		}
		$data['CreateTime'] = time();
		$data['ToUserName'] = self::$postObj->FromUserName;
		$data['FromUserName'] = self::$postObj->ToUserName;
		if(!isset($data['FuncFlag'])) {
			$data['FuncFlag'] = 0;
		}
		switch($data['MsgType']) {
			case 'text':
				$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>%s</FuncFlag>
							</xml>";
				$result = sprintf($textTpl, $data['ToUserName'], $data['FromUserName'], $data['CreateTime'], $data['Content'], $data['FuncFlag']);
				echo $result;
			break;
			case 'image':
				$textTpl = "<xml>
							<ToUserName><![CDATA[".$data['ToUserName']."]]></ToUserName>
							<FromUserName><![CDATA[".$data['FromUserName']."]]></FromUserName>
							<CreateTime>".$data['CreateTime']."</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<Content><![CDATA[]]></Content>
							<ArticleCount>".count($data['items'])."</ArticleCount>
							<Articles>";
				foreach($data['items'] as $item){
					$textTpl .= "<item>
							<Title><![CDATA[".$item['Title']."]]></Title>
							<Description><![CDATA[".$item['Description']."]]></Description>
							<PicUrl><![CDATA[".$item['PicUrl']."]]></PicUrl>
							<Url><![CDATA[".$item['Url']."]]></Url>
							</item>";
				}
				$textTpl .= "</Articles>
							<FuncFlag>".$data['FuncFlag']."</FuncFlag>
							</xml>";
				echo $textTpl;
			break;
			case 'music':
				$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[music]]></MsgType>
							<Music>
							<Title><![CDATA[%s]]></Title>
							<Description><![CDATA[%s]]></Description>
							<MusicUrl><![CDATA[%s]]></MusicUrl>
							<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
							</Music>
							<FuncFlag>%s</FuncFlag>
							</xml>";
				$result = sprintf($textTpl, $data['ToUserName'], $data['FromUserName'], $data['CreateTime'], $data['Title'], $data['Description'], $data['MusicUrl'], $data['HQMusicUrl'], $data['FuncFlag']);
				echo $result;
			break;
            case 'transfer_customer_service':
                $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[transfer_customer_service]]></MsgType>
                            </xml>";
                $result = sprintf($textTpl, $data['ToUserName'], $data['FromUserName'], $data['CreateTime']);
				echo $result;
            break;
		}
		return true;
	}
		
	private static function checkSignature($token)
	{
        $signature = isset($_GET["signature"])?$_GET["signature"]:'';
        $timestamp = isset($_GET["timestamp"])?$_GET["timestamp"]:'';
        $nonce = isset($_GET["nonce"])?$_GET["nonce"]:'';
        
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}