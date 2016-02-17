<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();	//微信接口验证文件，首次验证，需打开此方法
$wechatObj ->responseMsg();	//验证完后请打开此方法

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                //接收用户发送的信息（关键词）
                $keyword = trim($postObj->Content);
                //判断用户发送的信息类型
                $msgType = $postObj -> MsgType;
                //接收经纬度信息
                $longitude = $postObj->Location_Y;
                $latitude = $postObj->Location_X;
                
                //事件变量
                $event = $postObj -> Event;
                // 接收按钮的键值
                $eventKey = $postObj->EventKey;
                
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>"; 
                //创建图文模版
                $newsTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<ArticleCount>%s</ArticleCount>
                            %s
							</xml>";
                //创建音乐模版
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
                //判断用户发送的信息类型            
				if($msgType == 'text'){
				    //用户发送的信息为文本类型
				    if(!empty( $keyword )){
				        //如果用户发送的信息不为空，那么就判断用户的动作
				        if($keyword == '?' || $keyword == '？' || $keyword == '你好'){
				            //反回给用户的信息类型
				            $msgType = "text";
				            //要回复给用户的内容
				            $contentStr = "您好，请回复【 】中的数字，会有新发现哦^_^!!\n【1】本店最新动态\n【2】本店最新产品\n【3】听首歌放松一下吧\n【4】最新上映电影\n【5】今天天气查询\n【6】酒店查询\n【7】周边美食";
				            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				            echo $resultStr;
				            exit;
				        }elseif($keyword == '1'){
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
				        }elseif($keyword == '2' || $keyword == '衣服' || $keyword == '新品'){
				            //设置回复类型为：多图文
				            //引入数据库文件
				            include_once 'init.php';
				            //执行sql语句查找数据
				            $sql = "select * from goods order by id desc limit 5";
				            $res = mysql_query($sql);
				            //定义一个空数组
				            $data = array();
				            while ($row = mysql_fetch_assoc($res)){
				                $data[] = $row;
				            }
				            //计算数组的长度
				            $count = count($data);
				            $msgType = 'news';	            
				            $count = 5;
				            $str = '<Articles>';
				            //遍历数组
				            for($i=0;$i<$count;$i++){
				                $str .= "<item>
				                <Title><![CDATA[{$data[$i]['title']}]]></Title>
				                <Description><![CDATA[{$data[$i]['des']}]]></Description>
				                <PicUrl><![CDATA[{$data[$i]['pic']}]]></PicUrl>
				                <Url><![CDATA[{$data[$i]['url']}]]></Url>
				                </item>";
				            }
				            $str .= '</Articles>';
				            
				                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $str);
				                echo $resultStr;
				                exit;
				         }elseif($keyword == '3' || $keyword == '音乐'){
				             //随机音乐
				             //引入数据库文件
				             include_once 'init.php';
				             //sql语句
				             $sql = "select * from music";
				             $res = mysql_query($sql);
				             //定义一个空数组 保存数据
				             $data = array();
				             while ($row = mysql_fetch_assoc($res)){
				                 $data[] = $row;
				             }
				             //计算数据库里音乐信息有多少条
				             $count = count($data);
				             //定义反回类型为音乐类型
				             $msgType = 'music';
				             //自定义data数组的随机下标
				             $i = rand(0,($count-1));
				             $title = $data[$i]['title'];
				             $Description = $data[$i]['des'];
				             //设置音乐地址
				             $url = $data[$i]['url'];
				             //设置高清音乐地址
				             $hqurl = $data[$i]['hqurl'];
				             
				             $resultStr = sprintf($musicTpl, $fromUsername, $toUsername, $time, $msgType,$title, $Description,$url,$hqurl);
				             echo $resultStr;
				             exit;
				             
				         }elseif($keyword == '4' || $keyword == '电影'){
				           $url='http://api.map.baidu.com/telematics/v3/movie?qt=hot_movie&location=广州&output=json&ak=RvZZQqixew0ixBiZebPOX0Iu';
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
				            
				        }elseif($keyword == '5' || $keyword == '天气'){
				            $url="http://api.map.baidu.com/telematics/v3/weather?location=广州&output=json&ak=RvZZQqixew0ixBiZebPOX0Iu";
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
				            
				         }elseif ($keyword == '6' || $keyword == '酒店'){
				            $url="http://api.map.baidu.com/telematics/v3/local?location=113.331222,23.156737&keyWord=%E9%85%92%E5%BA%97&output=json&ak=RvZZQqixew0ixBiZebPOX0Iu";
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
				            
				        }elseif($keyword == '7' || $keyword == '美食'){
				            $url='http://api.map.baidu.com/telematics/v3/local?location=113.398294,23.132483&keyWord=%E7%BE%8E%E9%A3%9F&output=json&ak=RvZZQqixew0ixBiZebPOX0Iu';
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
				        }else{
			       		    $apiKey = "bd3512691476c99b6ce0b3cce86fb48f";
        				    $apiURL = "http://www.tuling123.com/openapi/api?key=KEY&info=INFO";
        				    
        				    // 设置报文头, 构建请求报文
        				    $reqInfo = $keyword;
        				    $url = str_replace("INFO", $reqInfo, str_replace("KEY", $apiKey, $apiURL));
        				    
        				    /** 方法一、用file_get_contents 以get方式获取内容 */
        				    $res =file_get_contents($url);
        				    $json = json_decode($res);
        
        				    $msgType = "text";
        				    $contentStr = $json->text;
        				    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        				    echo $resultStr;
        				}
				        
				    }else{
				        
                	   echo "Input something...";
                    }
                }elseif($msgType == 'voice'){
				    	$msgType = "text";
				        $contentStr = "亲，您的声音真好听。";
				        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				        echo $resultStr;
				}elseif($msgType == 'image'){
    				    $msgType = "text";
    				    $contentStr = "亲，你发的图片好黄好暴力啊";
    				    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    				    echo $resultStr;
				}elseif($msgType == 'video'){
    				    $msgType = "text";
    				    $contentStr = "亲，您发送的视频该不会是很黄很暴力的吧...";
    				    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    				    echo $resultStr;
				}elseif($msgType == 'location'){
    				      $url = "http://api.map.baidu.com/telematics/v3/local?location={$longitude},{$latitude}&keyWord=酒店&output=json&ak=RvZZQqixew0ixBiZebPOX0Iu";
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
				}elseif($msgType == 'link'){
				    $msgType = "text";
				    $contentStr = "亲，您发送的不会是种子吧...";
				    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				    echo $resultStr;
				//自定义菜单开始-------------------------------------------------------
				}elseif($msgType == 'event' || $event == 'CLICK'){
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
				            //引入数据库文件
				            include_once 'init.php';
				            //执行sql语句查找数据
				            $sql = "select * from goods order by id desc limit 5";
				            $res = mysql_query($sql);
				            //定义一个空数组
				            $data = array();
				            while ($row = mysql_fetch_assoc($res)){
				                $data[] = $row;
				            }
				            //计算数组的长度
				            $count = count($data);
				            $msgType = 'news';	            
				            $count = 5;
				            $str = '<Articles>';
				            //遍历数组
				            for($i=0;$i<$count;$i++){
				                $str .= "<item>
				                <Title><![CDATA[{$data[$i]['title']}]]></Title>
				                <Description><![CDATA[{$data[$i]['des']}]]></Description>
				                <PicUrl><![CDATA[{$data[$i]['pic']}]]></PicUrl>
				                <Url><![CDATA[{$data[$i]['url']}]]></Url>
				                </item>";
				            }
				            $str .= '</Articles>';
				            
				                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $str);
				                echo $resultStr;
				                exit;
				    
				     }elseif($eventKey == 'music'){
				                 //随机音乐
				             //引入数据库文件
				             include_once 'init.php';
				             //sql语句
				             $sql = "select * from music";
				             $res = mysql_query($sql);
				             //定义一个空数组 保存数据
				             $data = array();
				             while ($row = mysql_fetch_assoc($res)){
				                 $data[] = $row;
				             }
				             //计算数据库里音乐信息有多少条
				             $count = count($data);
				             //定义反回类型为音乐类型
				             $msgType = 'music';
				             //自定义data数组的随机下标
				             $i = rand(0,($count-1));
				             $title = $data[$i]['title'];
				             $Description = $data[$i]['des'];
				             //设置音乐地址
				             $url = $data[$i]['url'];
				             //设置高清音乐地址
				             $hqurl = $data[$i]['hqurl'];
				             
				             $resultStr = sprintf($musicTpl, $fromUsername, $toUsername, $time, $msgType,$title, $Description,$url,$hqurl);
				             echo $resultStr;
				             exit;
				             
			          }elseif($eventKey == 'movie'){
				           $url='http://api.map.baidu.com/telematics/v3/movie?qt=hot_movie&location=广州&output=json&ak=RvZZQqixew0ixBiZebPOX0Iu';
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
				            $url="http://api.map.baidu.com/telematics/v3/weather?location=广州&output=json&ak=RvZZQqixew0ixBiZebPOX0Iu";
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
				            $url="http://api.map.baidu.com/telematics/v3/local?location=113.331222,23.156737&keyWord=%E9%85%92%E5%BA%97&output=json&ak=RvZZQqixew0ixBiZebPOX0Iu";
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
				 }elseif($msgType == 'event' || $event == 'subscribe'){
				    
				        $msgType = "text";
				        $contentStr = "亲，感谢您关注Sall时尚丽人！！请回复【 】中的数字，会有新发现哦^_^!!\n【1】本店最新动态\n【2】本店最新产品\n【3】听首歌放松一下吧\n【4】最新上映电影\n【5】今天天气查询\n【6】酒店查询\n【7】周边美食";
				        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				        echo $resultStr;
				    
				}

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}
?>