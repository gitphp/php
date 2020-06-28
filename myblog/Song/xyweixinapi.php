<?php

/* 
 * FileName:xywechat.php
 * AddTime:2016-04-18 10:08:43
 * Author:Young\
 * Description:星雅微信订阅号接口文件
 * APPID:wx8054595961b1ffde
 * AppSecret:
 * 星雅假日微信公众号【订阅号】
 * 公众号微信账号：xy-trip
 * 公众号密码：dingding024000
 */


// 定义token秘钥常量
define("TOKEN", "x2I0n1g6Y04a18");
// 实例化微信对象
$wechatObj = new wechatCallbackapiTest();

if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}


// 微信API类
class wechatCallbackapiTest{

    private static $access_token;
    private $appid;
    private $secret;
    private $domain;
    private $host;

    public function __construct() {
        $config = include_once('config.php');
        
        $this->appid  = $config['appid'];
        $this->secret = $config['secret'];
        $this->domain = $config['domain'];
        $this->host   = $config['host'];

        $this->token($this->appid, $this->secret);
    }

    // 获取access_token
    public function token($appid, $secret) {
        if(self::$access_token) {
            return true;
        }
        $url = $this->host.__FUNCTION__.'?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
        $res = json_decode(self::curl_get($url));
        if(isset($res->errcode) && $res->errcode) {
            return false;
        }
        self::$access_token = $res->access_token;
        return true;
    }

    // 验证方法
	public function valid()
    {
        // 接收参数
        $echoStr = $_GET["echostr"];

        //valid signature , option
        // 验证成功的话，就exit退出
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    
    public function responseMsg(){

	    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){

                libxml_disable_entity_loader(true);
                // 解析xml数据
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                // 发送人，一般是手机的id码
                $fromUsername = $postObj->FromUserName;
                // 接收人，一般是微信公众平台
                $toUsername = $postObj->ToUserName;
                // 接收用户传递的文本关键字
                $keyword = trim($postObj->Content);
                // 接收用户传递的数据类型格式----自己添加的------
                $msgType = $postObj->MsgType;
                // 获取用户关注时候的事件
                $event   = $postObj->Event;
                 // 接收按钮的键值
                $eventKey = $postObj->EventKey;

                $x=$postObj->Location_X;
                $y=$postObj->Location_Y;
                // 时间戳
                $time = time();
                // 组装文本消息xml数据格式内容返回
                $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";
                //发送时音乐消息XML模板返回
                $musicTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Music>
                            <Title><![CDATA[%s]]></Title>
                            <Description><![CDATA[%s]]></Description>
                            <MusicUrl><![CDATA[%s]]></MusicUrl>
                            <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                            </Music>
                            </xml>";
                //发送时图文消息XML模板返回
                $newsTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <ArticleCount>%s</ArticleCount>
                            %s
                            </xml>";



                // 判断用户发送的数据格式是什么
                if($msgType=='text'){
                    if(!empty( $keyword )){
                        // 匹配不同的关键词，然后回复不同的信息
                        if($keyword=='?' || $keyword=='？'){
                            
                            $msgType = "text";
                            $contentStr = "回复以下数字\n【6】星雅轻商城\n【1】活动精选\n【2】品牌故事\n【3】官方微博\n【4】星雅团队\n【5】联系客服\n可以获取更多内容...";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit; 
                            
                        }elseif($keyword=='旅游'){
                            
                            


                        // 调用机器人自动回复功能
                        }else{
                            $apiKey = "163e2790318a524857bb822308702361"; 
                            $apiURL = "http://www.tuling123.com/openapi/api?key=KEY&info=INFO";
                            header("Content-type: text/html; charset=utf-8"); 
                            $reqInfo = $keyword; 
                            $url = str_replace("INFO", $reqInfo, str_replace("KEY", $apiKey, $apiURL)); 
                            $res =file_get_contents($url); 
                            $res=json_decode($res,true);
                            $contentStr=$res['text'];
                            $msgType = "text";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit;

                        }


                    }else{
                        echo "正在输入...";
                    }
                    
                // 判断用户发的内容的图片格式
                }elseif($msgType=='image'){
                    
                    
                // 判断用户发送的内容的声音格式
                }elseif($msgType=='voice'){
                    
                    
                // 视频格式
                }elseif($msgType=='video'){
                    
                    
                // 判断用户发送的内容是地理位置
                }elseif($msgType=='location'){
                    
                    
                // 判断用户发送的是图文信息链接
                }elseif($msgType=='link'){
                    
                    
                // 判断用户关注时候的时间信息
                }elseif($msgType=='event' && $event=='subscribe'){
                    // 获取用户的信息
                    $userInfo = self::user_info($fromUsername);
                    $name = $userInfo['nickname'];
                    $msgType = "text";
                    $contentStr = "终于等到你【 ".$name." 】，我是日生君噢😘
旅行新模式：先旅游后付费mo-胜利
轻商城现已上线，点击菜单惊喜等你 😘
想去哪里玩，回复【目的地】
快加我吧，和星雅小秘书一起互动：xy-xms✌️
咨询请call：0755-25161807 ❤️";
                    
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;exit;
                

                // 菜单点击事件
                }elseif($msgType=='event' && $event=='CLICK'){

                    if($eventKey == 'huodong'){
                        // 活动精选
                        //设置回复类型为：多图文
                        $data = array(
                               1 => array(
                                    'title' => '【有信用，任性游】凭芝麻分随心出境游，最低预付8元！',
                                    'des' => '2015年9月24日，星雅假日作为旅游行业的业界良心，成功实现“先旅游后付费”的首创者，进驻“支付宝·芝麻信用分”，为大家带来高品质的境外游产品。',
                                    'pic' => 'http://www.xingyatrip.com/zhima_wc/Puket/img/3.jpg',
                                    'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzIxNjI2NQ==&mid=403489870&idx=1&sn=6629eca883fe9926995c2b37bc507b72#rd'
                                ),
                               2 => array(
                                    'title' => '欠自己的旅行，有一天，一定要还给自己！ ',
                                    'des' => '旅行，是解读这个世界最好的办法。那些高山，湖泊，草原，大海，都是上帝遗落在人间的美景。他们都在安静的等着我们去发现。',
                                    'pic' => 'http://www.xingyatrip.com/zhima_wc/Puket/img/banner-9-16pjd.jpg',
                                    'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzIxNjI2NQ==&mid=403489870&idx=2&sn=2bf83ff6b2a1a76f71c4237317e58961#rd'
                                ),
                               3 => array(
                                'title' => '预付488，来一场与沙巴的小情趣旅行',
                                'des' => '位于马来西亚东部婆罗洲北端的沙巴，以前被称为北婆罗洲',
                                'pic' => 'http://www.xingyatrip.com/shabab/img/banner.jpg',
                                'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzIxNjI2NQ==&mid=403489870&idx=3&sn=8c793914d9201a52ebd8a2464dc39568#rd'
                                ),
                               4 => array(
                                    'title' => '2399起去柬埔寨吴哥感受阳光静好，听一段用时光写就的故事',
                                    'des' => '吴哥之美并不光在印度教文明曾经的灿烂，和真腊族雕刻曾经的绚丽',
                                    'pic' => 'http://www.xingyatrip.com/zhima_wc/Puket/img/2.jpg',
                                    'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzIxNjI2NQ==&mid=403489870&idx=4&sn=f7d068b1541aca63f8d0b421788b8821#rd'
                                )
                                
                            );
                            //
                            $msgType='news';
                            $count = 4;
                            $str = '<Articles>';
                            for($i=1;$i<=$count;$i++){
                                $newTitile = $data[$i]['title'];
                                $newDes = $data[$i]['des'];
                                $newPic = $data[$i]['pic'];
                                $newUrl = $data[$i]['url'];
                                $str .= "<item>
                                <Title><![CDATA[$newTitile]]></Title>
                                <Description><![CDATA[$newDes]]></Description>
                                <PicUrl><![CDATA[$newPic]]></PicUrl>
                                <Url><![CDATA[$newUrl]]></Url>
                                </item>";
                            }
                            $str .= '</Articles>';

                                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $str);
                                echo $resultStr;
                                exit;   

                    }elseif($eventKey == 'kefu'){

                        $contentStr = '我是日生，很高兴为您服务。咨询订单问题，可以拨打星雅客服电话：
0755-25161807';
                        $msgType = "text";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;exit;

                    }elseif($eventKey == 'tuandui'){

                        // 活动精选
                        //设置回复类型为：多图文
                        $data = array(
                               1 => array(
                                    'title' => '寒冷是他们的，热闹是我们的，日生家的年会不一“young” ',
                                    'des' => '年会主题定为“不一‘young’的星球——放肆嗨”，作为星雅星球的颜值担当，没我日生宝宝，怎么嗨~',
                                    'pic' => 'https://mmbiz.qlogo.cn/mmbiz/Ob0SXNUuKnex9XIShY2FDBSuxcWdAKUEeJf547BibPiaD2icoPHwhaqLjGibkmjj4mNVSvALMHoc0rrCI2XQaViayAA/0?wx_fmt=jpeg',
                                    'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzIxNjI2NQ==&mid=403490230&idx=1&sn=d1a4b3750df4a28c699d421ca86bf476#rd'
                                ),
                               2 => array(
                                    'title' => '这是日生家的圣诞派对 ',
                                    'des' => '看看我们的星雅星球~嗯哼，浓浓的节日氛围，想不想来呀~~~',
                                    'pic' => 'https://mmbiz.qlogo.cn/mmbiz/Ob0SXNUuKnex9XIShY2FDBSuxcWdAKUEeb34mEwsUsiazHx9kXJhASLsO5RZl9khTjltFTImb8NwsoVE7VMlHHQ/0?wx_fmt=jpeg',
                                    'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5MzIxNjI2NQ==&mid=403490230&idx=2&sn=84f9f44d935b1ca8bfc5e351143ac942#rd'
                                )
                               
                                
                            );
                            //
                            $msgType='news';
                            $count = 2;
                            $str = '<Articles>';
                            for($i=1;$i<=$count;$i++){
                                $newTitile = $data[$i]['title'];
                                $newDes = $data[$i]['des'];
                                $newPic = $data[$i]['pic'];
                                $newUrl = $data[$i]['url'];
                                $str .= "<item>
                                <Title><![CDATA[$newTitile]]></Title>
                                <Description><![CDATA[$newDes]]></Description>
                                <PicUrl><![CDATA[$newPic]]></PicUrl>
                                <Url><![CDATA[$newUrl]]></Url>
                                </item>";
                            }
                            $str .= '</Articles>';

                                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $str);
                                echo $resultStr;
                                exit; 
                    }

                }

        }else {
            // 如果没有接收到数据就输出''
        	echo "";
            // 直接死掉
        	exit;
        }
    }


    /**
     * @todo 获取用户基本信息
     * @param $next_openid string
     * @access_token 时间有效期
     */
    public static function user_info($openid='') {

        $access_token = self::$access_token ;
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $res = self::curl_get($url);
        return json_decode($res, true);
    }



    // 验证秘钥方法------------------------------
    private function checkSignature(){

        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);

        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
                return true;
        }else{
                return false;
        }
    }

    private function getNews() {
        // $media_id = '5fkm0KObOHZJs8uX3Qsh36YwnbG1tqYty6RoqKXeIlI';
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=Gny25WdErGkr3KDoLYtXFeiy49pNzyRKUKWWT5mcfMWL2c-DvrjM9VCzNRVlCVjRY6SX-nssyjvNsxee7A3slpIk-2fvuHYKPxNDL8wNPJYVGLhCFAEPU';
        $data = '{
                    "type":"news",
                    "offset":0,
                    "count":20
                }';
        $data1 = '{
                    "media_id":"5fkm0KObOHZJs8uX3Qsh36YwnbG1tqYty6RoqKXeIlI"
                }';
        $ret = self::curl_post($url, $data1);
        var_dump($ret);

    }

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


