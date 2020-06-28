<?php
/**
  * 微信开发测试文档
  * yangsong 2015年3月11日
  */

// 定义token秘钥常量
define("TOKEN", "weixin");
// 实例化微信对象
$wechatObj = new wechatCallbackapiTest();
// 调用验证方法valid，当接口连接成功后，
// 要注释这个方法，然后调用responseMsg()方法
// $wechatObj->valid();     //第一次连接的时候，打开一次即可
// 调用responseMsg方法,返回数据
$wechatObj->responseMsg();
// 微信类
class wechatCallbackapiTest
{
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
    // 接收数据，返回数据方法---------------------------------------
    public function responseMsg()
    {
		//get post data, May be due to the different environments
        //接收用户传递的数据，一般而言，使用 php://input 代替 $HTTP_RAW_POST_DATA。
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                // 防止xml攻击漏洞
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
                    if(!empty( $keyword ))
                    {
                        // 匹配不同的关键词，然后回复不同的信息
                        if($keyword=='?' || $keyword=='？'){
                            $msgType = "text";
                            $contentStr = "回复以下数字\n【6】常用号码\n【1】音乐欣赏\n【2】查询全国城市天气信息：北京天气\n【3】附近酒店\n【4】美女欣赏\n【5】女士服装欣赏\n【7】附近美食\n【8】找工作\n【9】开心一笑\n";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit; 
                        }elseif($keyword=='6'){
                            $msgType = "text";
                            $contentStr = "火警：119\n匪警：110\n急救：112\n美女电话：18811888505";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit;
                        }elseif($keyword=='1'){
                            $msgType='music';//返回音乐格式消息
                            $title='《眼泪的错觉》';//音乐标题
                            $description='很黄很暴力的哦，敢打开么？';//音乐描述
                            $url = 'http://www.yyzljg.com/wechat/music.mp3';//标准音乐地址
                            $hqurl = 'http://www.yyzljg.com/wechat/music.mp3';//高清音乐地址
                            $resultStr = sprintf($musicTpl, $fromUsername, $toUsername, $time, $msgType, $title,$description,$url,$hqurl);
                            echo $resultStr;
                        }elseif($keyword=='2'){
                            $msgType = "text";
                            $contentStr = "请输入：城市+天气\n例如：北京天气\n或者：深圳天气\n";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit;
                        }elseif(substr ( $keyword, - 6, strlen ( $keyword ) ) == "天气"){
                            $keyword = trim ( substr ( $keyword, 0, strlen ( $keyword ) - 6 ) );
                            if ($keyword == "") {
                                $keyword = "深圳";
                            }
                            $url="http://api.map.baidu.com/telematics/v3/weather?location={$keyword}&output=json&ak=YViOZrXwbOtGMHqZU4MAOnrG";
                            $res=file_get_contents($url);
                            $res=json_decode($res,true);
                            $msgType = "text";
                            $contentStr= $res['results'][0]['currentCity']."\n";
                            $contentStr.= $res['results'][0]['index'][0]['zs']."\n";
                            $contentStr.= $res['results'][0]['index'][0]['des']."\n";
                            $contentStr.= $res['results'][0]['weather_data'][0]['date']."\n";
                            $contentStr.= $res['results'][0]['weather_data'][0]['temperature']."\n";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit;


                        }elseif($keyword=='3'){
                            $url="http://api.map.baidu.com/telematics/v3/local?location=113.331222,23.156737&keyWord=%E9%85%92%E5%BA%97&output=json&ak=YViOZrXwbOtGMHqZU4MAOnrG";
                            $res=file_get_contents($url);
                            $res=json_decode($res,true);
                            $data=array();
                            foreach ($res['pointList'] as $v) {
                                $data[]=$v['name']."\n".$v['address']."\n".$v['additionalInformation']['price']."\n";
                                
                            }
                            // echo $name,$addr;
                            $msgType = "text";
                            // echo '<pre>';
                            // var_dump($data);
                            $contentStr='';
                            foreach ($data as $val) {
                                $contentStr.=$val;
                            }

                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit;
                            // echo $contentStr;
                            //
                        }elseif($keyword=='4'){
                            //
                            $msgType='news';
                            $num=1;
                            $str='<Articles>';
                            $str.="<item>
                    <Title><![CDATA[俄罗斯美女]]></Title> 
                    <Description><![CDATA[更多美女请进入www.aitef.com]]></Description>
                    <PicUrl><![CDATA[http://img02.taobaocdn.com/imgextra/i2/1883953875/TB2_NtqcXXXXXXdXpXXXXXXXXXX_!!1883953875.jpg]]></PicUrl>
                    <Url><![CDATA[http://www.aitef.com]]></Url>
                    </item>";

                            $str.='</Articles>';
                            $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, $num, $str);
                            echo $resultStr;

                
                        }elseif($keyword=='5'){
                            $data = array(
                               1 => array(
                                    'title' => '艾依裳时尚店',
                                    'des' => '想知道最新的服装前线，就来裳衣时尚',
                                    'pic' => 'http://a.vpimg4.com/upload/actpics/pingou/2015/3m/11/ROEM/R_02.jpg',
                                    'url' => 'http://www.vip.com/show-372983.html'
                                ),
                               2 => array(
                                    'title' => '白/深藏蓝色圆领淑女无袖针织连衣裙',
                                    'des' => '49.2%腈纶，45.9%羊毛，4.3%其他纤维，0.6%氨纶',
                                    'pic' => 'http://a.vpimg3.com/upload/merchandise/300524/ROEM-RCOU34T01M39-1.jpg',
                                    'url' => 'http://www.vip.com/detail-372983-48663524.html'
                                ),
                               3 => array(
                                'title' => '粉红/蓝色个性波点盖肩袖连衣裙',
                                'des' => '面料：79.5%粘纤，20.5%锦纶；腰带配料：100%聚酯纤维；里料：100%聚酯纤维',
                                'pic' => 'http://a.vpimg2.com/upload/merchandise/372983/ROEM-RCOW22404C25-1.jpg',
                                'url' => 'http://www.vip.com/detail-372983-48663356.html'
                                ),
                               4 => array(
                                    'title' => '红/白色时尚拼接短袖连衣裙',
                                    'des' => '上身面料：100%聚酯纤维；下身面料：83%聚酯纤维，15%棉，2%氨纶；里料：100%聚酯纤维',
                                    'pic' => 'http://a.vpimg4.com/upload/merchandise/372983/ROEM-RCOW32303C80-1.jpg',
                                    'url' => 'http://www.vip.com/detail-372983-48663359.html'
                                ),
                                5 => array(
                                    'title' => '藏青/白色甜美淑女短袖连衣裙',
                                    'des' => '面料/里料：100%聚酯纤维；配料：100%棉',
                                    'pic' => 'http://a.vpimg4.com/upload/merchandise/372983/ROEM-RCOW42402M59-1.jpg',
                                    'url' => 'http://www.vip.com/detail-372983-48663399.html'
                                )
                            );
                            //
                            $msgType='news';
                            $count = 5;
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
                            //
                        }elseif($keyword=='7'){
                            $url='http://api.map.baidu.com/telematics/v3/movie?qt=hot_movie&location=%E6%B7%B1%E5%9C%B3&output=json&ak=YViOZrXwbOtGMHqZU4MAOnrG';
                            $res=file_get_contents($url);
                            $res=json_decode($res);
                            // echo '<pre>';
                            // var_dump($res);
                            // echo $res->result->movie[0]->movie_name;
                            $msgType='news';
                            $count = 5;
                            $str = '<Articles>';
                            for($i=0;$i<$count;$i++){

                                $str .= "<item>
                                <Title><![CDATA[{$res->result->movie[$i]->movie_name}]]></Title>
                                <Description><![CDATA[{$res->result->movie[$i]->movie_name}]]></Description>
                                <PicUrl><![CDATA[{$res->result->movie[$i]->movie_picture}]]></PicUrl>
                                <Url><![CDATA[{$res->result->movie[$i]->movie_big_picture}]]></Url>
                                </item>";
                            }
                            $str .= '</Articles>';
                            $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $str);
                                echo $resultStr;
                                exit;
                            //
                        }elseif($keyword=='8'){
                            $msgType = "text";
                            $contentStr = "猪场技术员、饲养员：\n一、任职条件： \n1、技术员大专以上学历，饲养员初中以上学历； \n2、年龄25-45周岁，有经验者可放宽年龄；\n3、身体好，能吃苦，不怕脏、累；\n4、热爱养猪事业，愿意长期在养殖场工作；\n5、有猪场人工授精、母猪饲养工作经验者优先。\n电话：18811888555 朱老师 80878066";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit;
                            //
                        }elseif($keyword=='9'){
                            $curl = curl_init();
                            // 获取数据但是不输出
                            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
                            // 设置请求地址url
                            $url="http://www.kuitao8.com/api/joke";
                            curl_setopt($curl,CURLOPT_URL, $url);
                            curl_setopt($curl,CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
                            // 执行curl
                            $resp = curl_exec($curl);
                            // 关闭资源
                            curl_close($curl);
                            $resp = json_decode($resp,true);
                            $contentStr= $resp['content'];
                            //--------------
                            $msgType = "text";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit;
                        
                        }elseif($keyword=='美食'){
                            $url='http://api.map.baidu.com/telematics/v3/local?location=113.398294,23.132483&keyWord=%E7%BE%8E%E9%A3%9F&output=json&ak=YViOZrXwbOtGMHqZU4MAOnrG';
                            $res=file_get_contents($url);
                            $res=json_decode($res);
                            // echo '<pre>';
                            // var_dump($res);

                            $pic=array(
                                'http://img04.taobaocdn.com/imgextra/i4/1883953875/TB2VLpkcXXXXXbUXpXXXXXXXXXX_!!1883953875.jpg',
                                'http://img02.taobaocdn.com/imgextra/i2/1883953875/TB2Q5FscXXXXXalXXXXXXXXXXXX_!!1883953875.jpg',
                                'http://img03.taobaocdn.com/imgextra/i3/1883953875/TB2KVxucXXXXXXzXXXXXXXXXXXX_!!1883953875.jpg',
                                'http://img04.taobaocdn.com/imgextra/i4/1883953875/TB2x6XpcXXXXXcuXXXXXXXXXXXX_!!1883953875.jpg',
                                'http://img04.taobaocdn.com/imgextra/i4/1883953875/TB2myXocXXXXXcWXXXXXXXXXXXX_!!1883953875.jpg'
                                );
                            $msgType='news';
                            $count = 5;
                            $str = '<Articles>';
                            for($i=0;$i<$count;$i++){
                                // $newTitile = $data[$i]['title'];
                                // $newDes = $data[$i]['des'];
                                // $newPic = $data[$i]['pic'];
                                // $newUrl = $data[$i]['url'];
                                $str .= "<item>
                                <Title><![CDATA[{$res->pointList[$i]->name}]]></Title>
                                <Description><![CDATA[{$res->pointList[$i]->address}]]></Description>
                                <PicUrl><![CDATA[{$pic[$i]}]]></PicUrl>
                                <Url><![CDATA[http:www.aitef.com]]></Url>
                                </item>";
                            }
                            $str .= '</Articles>';
                            $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $str);
                            echo $resultStr;
                            exit;


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

                            // 小贱鸡机器人---------------------------
                            /*$ch=curl_init();
                            $url="http://www.xiaohuangji.com/ajax.php";
                            curl_setopt($ch,CURLOPT_URL,$url);
                            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                            curl_setopt($ch,CURLOPT_POST,1);
                            $data=array('para'=>$keyword);
                            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
                            $contentStr=curl_exec($ch);
                            curl_close($ch);
                            //设置回复
                            $msgType = "text";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;exit;*/
                        }


                    }else{
                        echo "正在输入...";
                    }
                // 判断用户发的内容的图片格式
                }elseif($msgType=='image'){
                    $msgType = "text";
                    $contentStr = "你发的图片好黄好暴力啊";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;exit;
                // 判断用户发送的内容的声音格式
                }elseif($msgType=='voice'){
                    $msgType = "text";
                    $contentStr = "亲，发的声音很黄很暴力啊！来来来，给爷唱首歌吧...";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                // 视频格式
                }elseif($msgType=='video'){
                    $msgType = "text";
                    $contentStr = "亲，您发送的视频该不会是很黄很暴力的吧...";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    exit;
                // 判断用户发送的内容是地理位置
                }elseif($msgType=='location'){
                    $hotel = array(
                        'http://img.elongstatic.com/index/termini/termini_it1_tb.jpg',
                        'http://img.elongstatic.com/index/termini/termini_it1_qm.jpg',
                        'http://img.elongstatic.com/index/termini/termini_it1_jzd.jpg',
                        'http://img.elongstatic.com/index/termini/termini_it1_bhd.jpg',
                        'http://img.elongstatic.com/index/termini/bfhh-wy.jpg'        
                    );
                     $url = "http://api.map.baidu.com/telematics/v3/local?location={$y},{$x}&keyWord=酒店&output=json&ak=YViOZrXwbOtGMHqZU4MAOnrG";
                            $str = file_get_contents($url);
                            
                            $json = json_decode($str);
                            //设置回复类型为：多图文
                            $msgType = 'news';
                            $count = 5;
                            $str = '<Articles>';
                            for($i=0;$i<$count;$i++){
                                $str .= "<item>
                                <Title><![CDATA[{$json->pointList[$i]->name}]]></Title>
                                    <Description><![CDATA[{$json->pointList[$i]->address}]]></Description>
                                    <PicUrl><![CDATA[{$hotel[$i]}]]></PicUrl>
                                    <Url><![CDATA[{$json->pointList[$i]->additionalInformation->link[0]->url}]]></Url>
                                    </item>";
                                    }
                                    $str .= '</Articles>';
                            
                                    $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $str);
                                    echo $resultStr;
                                    exit;
                // 判断用户发送的是图文信息链接
                }elseif($msgType=='link'){
                    $msgType = "text";
                    $contentStr = "你发的什么链接信息呀，打不开啦";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;exit;
                // 判断用户关注时候的时间信息
                }elseif($msgType=='event' && $event=='subscribe'){
                    // 获取用户的信息
                    $msgType = "text";
                    $contentStr = "您好!欢迎进入木木de微信世界😘\n
回复【?】获得更多精彩内容，很黄很暴力哦!!!👨‍👩‍👧‍👦\n
我的网址http://www.juulu.com😝";

                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;exit;
                //菜单点击事件
                }elseif($msgType=='event' && $event=='CLICK'){
                    // 当点击菜单新闻的时候
                    if($eventKey == 'news'){
                        //设置回复类型为：单图文
                        $msgType = 'news';
                        $count = 1;
                        $str = '<Articles>';
                        $str .= "<item>
                                <Title><![CDATA[Sall时尚丽人]]></Title>
                                <Description><![CDATA[想知道最新的服装前线，就来Sall时尚丽人]]></Description>
                                <PicUrl><![CDATA[http://a.vpimg4.com/upload/actpics/pingou/2015/3m/11/ROEM/R_02.jpg]]></PicUrl>
                                <Url><![CDATA[http://www.vip.com/show-372983.html]]></Url>
                                </item>";
                        $str .= '</Articles>';
                        
                        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $str);
                        echo $resultStr;
                        exit;
                    }elseif($eventKey == 'goods'){

                        //设置回复类型为：多图文
                        $data = array(
                               1 => array(
                                    'title' => '艾依裳时尚店',
                                    'des' => '想知道最新的服装前线，就来裳衣时尚',
                                    'pic' => 'http://a.vpimg4.com/upload/actpics/pingou/2015/3m/11/ROEM/R_02.jpg',
                                    'url' => 'http://www.vip.com/show-372983.html'
                                ),
                               2 => array(
                                    'title' => '白/深藏蓝色圆领淑女无袖针织连衣裙',
                                    'des' => '49.2%腈纶，45.9%羊毛，4.3%其他纤维，0.6%氨纶',
                                    'pic' => 'http://a.vpimg3.com/upload/merchandise/300524/ROEM-RCOU34T01M39-1.jpg',
                                    'url' => 'http://www.vip.com/detail-372983-48663524.html'
                                ),
                               3 => array(
                                'title' => '粉红/蓝色个性波点盖肩袖连衣裙',
                                'des' => '面料：79.5%粘纤，20.5%锦纶；腰带配料：100%聚酯纤维；里料：100%聚酯纤维',
                                'pic' => 'http://a.vpimg2.com/upload/merchandise/372983/ROEM-RCOW22404C25-1.jpg',
                                'url' => 'http://www.vip.com/detail-372983-48663356.html'
                                ),
                               4 => array(
                                    'title' => '红/白色时尚拼接短袖连衣裙',
                                    'des' => '上身面料：100%聚酯纤维；下身面料：83%聚酯纤维，15%棉，2%氨纶；里料：100%聚酯纤维',
                                    'pic' => 'http://a.vpimg4.com/upload/merchandise/372983/ROEM-RCOW32303C80-1.jpg',
                                    'url' => 'http://www.vip.com/detail-372983-48663359.html'
                                ),
                                5 => array(
                                    'title' => '藏青/白色甜美淑女短袖连衣裙',
                                    'des' => '面料/里料：100%聚酯纤维；配料：100%棉',
                                    'pic' => 'http://a.vpimg4.com/upload/merchandise/372983/ROEM-RCOW42402M59-1.jpg',
                                    'url' => 'http://www.vip.com/detail-372983-48663399.html'
                                )
                            );
                            //
                            $msgType='news';
                            $count = 5;
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
                    
                     }elseif($eventKey == 'music'){
                        //随机音乐
                        $msgType='music';//返回音乐格式消息
                            $title='《眼泪的错觉》';//音乐标题
                            $description='很黄很暴力的哦，敢打开么？';//音乐描述
                            $url = 'http://www.yyzljg.com/wechat/music.mp3';//标准音乐地址
                            $hqurl = 'http://www.yyzljg.com/wechat/music.mp3';//高清音乐地址
                            $resultStr = sprintf($musicTpl, $fromUsername, $toUsername, $time, $msgType, $title,$description,$url,$hqurl);
                            echo $resultStr;     
                             
                      }elseif($eventKey == 'movie'){
                           $url='http://api.map.baidu.com/telematics/v3/movie?qt=hot_movie&location=深圳&output=json&ak=YViOZrXwbOtGMHqZU4MAOnrG';
                            $res=file_get_contents($url);
                            $res=json_decode($res);

                            $msgType='news';
                            $count = 5;
                            $str = '<Articles>';
                            for($i=0;$i<$count;$i++){
                            
                                $str .= "<item>
                                <Title><![CDATA[{$res->result->movie[$i]->movie_name}]]></Title>
                                <Description><![CDATA[{$res->result->movie[$i]->movie_name}]]></Description>
                                <PicUrl><![CDATA[{$res->result->movie[$i]->movie_picture}]]></PicUrl>
                                <Url><![CDATA[{$res->result->movie[$i]->movie_big_picture}]]></Url>
                                </item>";
                            }
                            $str .= '</Articles>';
                            
                            $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $str);
                            echo $resultStr;
                            exit;
                            
                        }elseif($eventKey == 'weather'){
                            $url="http://api.map.baidu.com/telematics/v3/weather?location=深圳&output=json&ak=YViOZrXwbOtGMHqZU4MAOnrG";
                            $res=file_get_contents($url);
                            $res=json_decode($res,true);
                            $msgType = "text";
                            $contentStr= $res['results'][0]['currentCity']."\n";
                            $contentStr.= $res['results'][0]['index'][0]['zs']."\n";
                            $contentStr.= $res['results'][0]['index'][0]['des']."\n";
                            $contentStr.= $res['results'][0]['weather_data'][0]['date']."\n";
                            $contentStr.= $res['results'][0]['weather_data'][0]['temperature']."\n";
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                            exit;
                            
                         }elseif ($eventKey == 'hotel'){
                            $url="http://api.map.baidu.com/telematics/v3/local?location=114.067262,22.546479&keyWord=%E9%85%92%E5%BA%97&output=json&ak=YViOZrXwbOtGMHqZU4MAOnrG";
                            $res=file_get_contents($url);
                            $res=json_decode($res,true);
                            $data=array();
                            foreach ($res['pointList'] as $v) {
                                $data[]=$v['name']."\n".$v['address']."\n".$v['additionalInformation']['price']."\n";
                            
                            }
                            
                            $msgType = "text";

                            $contentStr='';
                            foreach ($data as $val) {
                                $contentStr.=$val;
                            }
                            
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
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
     *  没有认证的号是没有这个权限的
     */
     public static function user_info($openid='') {
        $access_token = 'aW1PjZjRYZl1cbv10zT8jWqha-5SVPZe0B_nbu-zeXlMmhSvZhZ-q2I-_R66VhqdnjK9aCEx_XtluTFQEJ222FDNmYFg8YE5Qp4Y5H_tlwfw5ADRIfuEQfMvG-wF07qqGUKfAEAYMC';
        // https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN 
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $res = self::curl_get($url);
        return json_decode($res, true);
     }




	// 验证秘钥方法------------------------------
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        // 没有定义token的话就跑出异常
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        // 接收平台传输过来的4个参数
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        // 字典发排序abcde
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
        // 哈希加密算法
		$tmpStr = sha1( $tmpStr );
		// 对比加密后的字符串和传过来的秘钥是否一样，是的话返回数据
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
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



?>