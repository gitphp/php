﻿# Host: localhost  (Version: 5.6.21)
# Date: 2015-04-10 00:15:45
# Generator: MySQL-Front 5.3  (Build 2.42)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

DROP DATABASE IF EXISTS `shop_ci`;
CREATE DATABASE `shop_ci` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `shop_ci`;

#
# Source for table "ci_admin"
#

DROP TABLE IF EXISTS `ci_admin`;
CREATE TABLE `ci_admin` (
  `a_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员编号',
  `a_username` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `a_password` char(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `a_email` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `a_addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`a_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

#
# Data for table "ci_admin"
#

INSERT INTO `ci_admin` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','admin@itcast.cn',0),(2,'admin','admin','admin@itcast.cn',0);

#
# Source for table "ci_attribute"
#

DROP TABLE IF EXISTS `ci_attribute`;
CREATE TABLE `ci_attribute` (
  `a_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品属性ID',
  `a_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品属性名称',
  `a_type_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '商品属性所属类型ID',
  `a_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性是否可选 0 为唯一，1为单选，2为多选',
  `a_input_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '属性录入方式 0为手工录入，1为从列表中选择，2为文本域',
  `a_value` text COMMENT '属性的值',
  `a_sort` tinyint(4) NOT NULL DEFAULT '50' COMMENT '属性排序依据',
  PRIMARY KEY (`a_id`),
  KEY `type_id` (`a_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='商品属性列表';

#
# Data for table "ci_attribute"
#

INSERT INTO `ci_attribute` VALUES (1,'颜色',3,0,0,NULL,50),(2,'尺寸',3,0,1,'M码\r\nS码\r\nL码\r\nXL码\r\nXXL码',50),(3,'音质',5,0,0,NULL,50),(4,'尺寸',2,0,1,'14寸\r\n15寸',50),(5,'款式',3,0,0,NULL,50),(6,'重量',4,0,0,NULL,50),(7,'长度',7,0,0,NULL,50),(8,'类型',9,0,0,NULL,50),(9,'容量',14,0,0,NULL,50),(10,'款式',1,0,0,NULL,50),(11,'风格',6,0,0,NULL,50),(12,'上市日期',1,0,0,NULL,50),(13,'内存容量',0,0,0,NULL,50),(14,'操作系统',1,0,0,NULL,50),(15,'办公功能',6,0,0,NULL,50),(16,'MP3播放器',7,0,0,NULL,50),(17,'CPU频率',2,0,0,NULL,50),(18,'视频播放',2,0,0,NULL,50),(19,'屏幕分辨率',2,0,1,'100px\r\n300px\r\n900px\r\n1630px',50),(20,'格力',12,0,0,NULL,50),(21,'粗细',15,0,0,NULL,50),(22,'无线蓝牙',8,0,0,NULL,50),(23,'单击双击',10,0,0,NULL,50),(24,'材料',13,0,0,NULL,50),(25,'功能分类',11,0,0,NULL,50),(26,'樱桃',11,0,2,NULL,50),(28,'作词',5,0,0,NULL,50),(29,'作曲',5,0,0,NULL,50),(30,'描述',1,0,2,NULL,50);

#
# Source for table "ci_brand"
#

DROP TABLE IF EXISTS `ci_brand`;
CREATE TABLE `ci_brand` (
  `b_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品品牌ID',
  `b_name` varchar(30) NOT NULL DEFAULT '' COMMENT '商品品牌名称',
  `b_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品品牌描述',
  `b_url` varchar(100) NOT NULL DEFAULT '' COMMENT '商品品牌网址',
  `b_logo` varchar(64) NOT NULL DEFAULT '' COMMENT '品牌logo',
  `b_sort` tinyint(3) unsigned NOT NULL DEFAULT '50' COMMENT '商品品牌排序依据',
  `b_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示，默认显示',
  PRIMARY KEY (`b_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='商品品牌表';

#
# Data for table "ci_brand"
#

INSERT INTO `ci_brand` VALUES (1,'华为','www.huawei.com','www.huawei.com','0.jpg',11,1),(2,'苹果','www.huawei.com','www.huawei.com','1.jpg',50,1),(3,'华硕','www.huawei.com','www.huawei.com','2.jpg',50,1),(4,'戴尔','www.huawei.com','www.huawei.com','3.jpg',50,1),(5,'魅族','www.huawei.com','www.huawei.com','5.jpg',50,1);

#
# Source for table "ci_category"
#

DROP TABLE IF EXISTS `ci_category`;
CREATE TABLE `ci_category` (
  `c_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类别ID',
  `c_name` varchar(30) NOT NULL DEFAULT '' COMMENT '商品类别名称',
  `c_pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类别父ID',
  `c_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '商品类别描述',
  `c_sort` tinyint(4) NOT NULL DEFAULT '50' COMMENT '排序依据',
  `c_unit` varchar(15) NOT NULL DEFAULT '' COMMENT '单位',
  `c_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示，默认显示',
  PRIMARY KEY (`c_id`),
  KEY `pid` (`c_pid`)
) ENGINE=InnoDB AUTO_INCREMENT=995 DEFAULT CHARSET=utf8 COMMENT='商品分类表';

#
# Data for table "ci_category"
#

INSERT INTO `ci_category` VALUES (1,'图书、音像、数字商品',0,'',39,'',1),(6,'家用电器',0,'',40,'',1),(11,'手机、数码',0,'',41,'',1),(16,'电脑、办公',0,'',42,'',1),(17,'家居、家具、家装、厨具',0,'',43,'',1),(18,'服饰鞋帽',0,'',44,'',1),(19,'个护化妆',0,'',45,'',1),(20,'礼品箱包、钟表、珠宝',0,'',46,'',1),(21,'运动健康',0,'',47,'',1),(22,'汽车用品',0,'',48,'',1),(23,'母婴、玩具乐器',0,'',49,'',1),(24,'食品饮料、保健食品',0,'',50,'',1),(25,'彩票、旅行、充值、游戏',0,'',51,'',1),(26,'电子书',1,'',1,'',1),(27,'数字音乐',1,'',2,'',1),(28,'音像',1,'',3,'',1),(29,'文艺',1,'',4,'',1),(30,'人文社科',1,'',5,'',1),(31,'经管励志',1,'',6,'',1),(32,'生活',1,'',7,'',1),(33,'科技',1,'',8,'',1),(34,'少儿',1,'',9,'',1),(35,'教育',1,'',10,'',1),(36,'其它',1,'',11,'',1),(37,'大家电',6,'',1,'',1),(38,'生活电器',6,'',2,'',1),(39,'厨房电器',6,'',3,'',1),(40,'个护健康',6,'',4,'',1),(41,'五金家装',6,'',5,'',1),(42,'手机通讯',11,'',1,'',1),(43,'运营商',11,'',2,'',1),(44,'手机配件',11,'',3,'',1),(45,'摄影摄像',11,'',4,'',1),(46,'数码配件',11,'',5,'',1),(47,'时尚影音',11,'',6,'',1),(48,'彩票',25,'',1,'',1),(49,'机票',25,'',2,'',1),(50,'国内机票',49,'',1,'',1),(51,'酒店',25,'',3,'',1),(52,'旅行',25,'',4,'',1),(53,'充值',25,'',5,'',1),(54,'游戏',25,'',6,'',1),(55,'票务',25,'',7,'',1),(56,'应用商店',25,'',8,'',1),(57,'保险',25,'',9,'',1),(58,'汽车保险',57,'',1,'',1),(59,'意外保险',57,'',2,'',1),(60,'健康医疗',57,'',3,'',1),(61,'少儿女性',57,'',4,'',1),(62,'移动游戏',56,'',1,'',1),(63,'移动软件',56,'',2,'',1),(64,'网页应用',56,'',3,'',1),(65,'电影票',55,'',1,'',1),(66,'演唱会',55,'',2,'',1),(67,'话剧',55,'',3,'',1),(68,'歌剧',55,'',4,'',1),(69,'音乐会',55,'',5,'',1),(70,'体育赛事',55,'',6,'',1),(71,'舞蹈芭蕾',55,'',7,'',1),(72,'戏曲综艺',55,'',8,'',1),(73,'游戏点卡',54,'',1,'',1),(74,'QQ充值',54,'',2,'',1),(75,'网页游戏',54,'',3,'',1),(76,'游戏周边',54,'',4,'',1),(77,'手机充值',53,'',1,'',1),(78,'度假',52,'',1,'',1),(79,'景点',52,'',2,'',1),(80,'租车',52,'',3,'',1),(81,'旅游团购',52,'',4,'',1),(82,'国内酒店',51,'',1,'',1),(83,'酒店团购',51,'',2,'',1),(84,'双色球',48,'',1,'',1),(85,'大乐透',48,'',2,'',1),(86,'福彩3D',48,'',3,'',1),(87,'排列三',48,'',4,'',1),(88,'排列五',48,'',5,'',1),(89,'七星彩',48,'',6,'',1),(90,'七乐彩',48,'',7,'',1),(91,'竞彩足球',48,'',8,'',1),(92,'竞彩篮球',48,'',9,'',1),(93,'新时时彩',48,'',10,'',1),(94,'食尚礼券',24,'',1,'',1),(95,'进口食品',24,'',2,'',1),(96,'地方特产',24,'',3,'',1),(97,'休闲食品',24,'',4,'',1),(98,'粮油调味',24,'',5,'',1),(99,'酒饮冲调',24,'',6,'',1),(100,'营养健康',24,'',7,'',1),(101,'亚健康',24,'',8,'',1),(102,'健康礼品',24,'',9,'',1),(103,' 生鲜食品',24,'',9,'',1),(104,'大闸蟹',94,'',1,'',1),(106,'奶粉',23,'',1,'',1),(107,'营养辅食',23,'',2,'',1),(108,'尿裤湿巾',23,'',3,'',1),(109,'洗护用品',23,'',4,'',1),(110,'童车童床',23,'',5,'',1),(111,'喂养用品',23,'',6,'',1),(112,'寝具服饰',23,'',7,'',1),(113,'妈妈专区',23,'',8,'',1),(114,'玩具乐器',23,'',9,'',1),(115,'电子电器',22,'',1,'',1),(116,'系统养护',22,'',2,'',1),(117,'改装配件',22,'',3,'',1),(118,'汽车美容',22,'',4,'',1),(119,'座垫脚垫',22,'',5,'',1),(120,'内饰精品',22,'',6,'',1),(121,'安全自驾',22,'',7,'',1),(122,'户外鞋服',21,'',1,'',1),(123,'户外装备',21,'',2,'',1),(124,'运动器械',21,'',3,'',1),(125,'纤体瑜伽',21,'',4,'',1),(126,'体育娱乐',21,'',5,'',1),(127,'成人用品',21,'',6,'',1),(128,'保健器械',21,'',7,'',1),(129,'急救卫生',21,'',8,'',1),(130,'潮流女包',20,'',1,'',1),(131,'时尚男包',20,'',2,'',1),(132,'功能箱包',20,'',3,'',1),(133,'礼品',20,'',4,'',1),(134,'奢侈品',20,'',5,'',1),(135,'钟表',20,'',6,'',1),(136,'珠宝首饰',20,'',7,'',1),(137,'婚庆',20,'',8,'',1),(138,'面部护理',19,'',1,'',1),(139,'身体护理',19,'',2,'',1),(140,'口腔护理',19,'',3,'',1),(141,'女性护理',19,'',4,'',1),(142,'男士护理',19,'',5,'',1),(143,'魅力彩妆',19,'',6,'',1),(144,'香水SPA',19,'',7,'',1),(145,'女装',18,'',1,'',1),(146,'男装',18,'',2,'',1),(147,'内衣',18,'',3,'',1),(148,'运动',18,'',4,'',1),(149,'女鞋',18,'',5,'',1),(150,'男鞋',18,'',6,'',1),(151,'配饰',18,'',7,'',1),(152,'童装',18,'',8,'',1),(153,'厨具',17,'',1,'',1),(154,'宠物生活',17,'',2,'',1),(155,'家纺',17,'',3,'',1),(156,'家具',17,'',4,'',1),(157,'灯具',17,'',5,'',1),(158,'生活日用',17,'',6,'',1),(159,'清洁用品',17,'',8,'',1),(160,'家装建材',17,'',9,'',1),(161,'电脑整机',16,'',1,'',1),(162,'电脑配件',16,'',2,'',1),(163,'外设产品',16,'',3,'',1),(164,'网络产品',16,'',4,'',1),(165,'办公打印',16,'',5,'',1),(166,'办公文仪',16,'',6,'',1),(167,'服务产品',16,'',7,'',1),(168,'免费',26,'',1,'',1),(169,'小说',26,'',2,'',1),(170,'励志与成功',26,'',3,'',1),(171,'生活',26,'',4,'',1),(172,'文学',26,'',5,'',1),(173,'管理',26,'',6,'',1),(174,'畅读VIP',26,'',7,'',1),(175,'冬瓜片',26,'',8,'',1),(176,'通俗流行',27,'',1,'',1),(177,'古典音乐',27,'',2,'',1),(178,'摇滚说唱',27,'',3,'',1),(179,'爵士蓝调',27,'',4,'',1),(180,'乡村民谣',27,'',5,'',1),(181,'有声读物',27,'',6,'',1),(182,'音乐',28,'',1,'',1),(183,'影视',28,'',2,'',1),(184,'教育音像',28,'',3,'',1),(185,'游戏',28,'',4,'',1),(186,'小说',29,'',1,'',1),(187,'文学',29,'',2,'',1),(188,'青春文学',29,'',3,'',1),(189,'传记',29,'',4,'',1),(190,'艺术',29,'',5,'',1),(191,'历史',30,'',1,'',1),(192,'心理学',30,'',2,'',1),(193,'政治/军事',30,'',3,'',1),(194,'国学/古籍',30,'',4,'',1),(195,'哲学/宗教',30,'',5,'',1),(196,'社会科学',30,'',6,'',1),(197,'经济',31,'',1,'',1),(198,'金融与投资',31,'',2,'',1),(199,'管理',31,'',3,'',1),(200,'励志与成功',31,'',4,'',1),(201,'家庭与育儿',32,'',1,'',1),(202,'旅游/地图',32,'',2,'',1),(203,'烹饪/美食',32,'',3,'',1),(204,'时尚/美妆',32,'',4,'',1),(205,'家居',32,'',5,'',1),(206,'婚恋与两性',32,'',6,'',1),(207,'娱乐/休闲',32,'',7,'',1),(208,'健身与保健',32,'',8,'',1),(209,'动漫/幽默',32,'',9,'',1),(210,'体育/运动',32,'',10,'',1),(211,'科普',33,'',1,'',1),(212,'IT',33,'',2,'',1),(213,'建筑',33,'',3,'',1),(214,'医学',33,'',4,'',1),(215,'工业技术',33,'',5,'',1),(216,'电子/通信',33,'',6,'',1),(217,'农林',33,'',7,'',1),(218,'科学与自然',33,'',8,'',1),(219,'少儿',34,'',1,'',1),(220,'0-2岁',34,'',2,'',1),(221,'3-6岁',34,'',3,'',1),(222,'7-10岁',34,'',4,'',1),(223,'11-14岁',34,'',5,'',1),(224,'教材教辅',35,'',1,'',1),(225,'考试',35,'',2,'',1),(226,'外语学习',35,'',3,'',1),(227,'英文原版书',36,'',1,'',1),(228,'港台图书',36,'',2,'',1),(229,'工具书',36,'',3,'',1),(230,'套装书',36,'',4,'',1),(231,'杂志/期刊',36,'',5,'',1),(232,'平板电视',37,'',1,'',1),(233,'空调',37,'',2,'',1),(234,'冰箱',37,'',3,'',1),(235,'洗衣机',37,'',4,'',1),(236,'家庭影院',37,'',5,'',1),(237,'DVD迷你音响',37,'',6,'',1),(238,'烟机/灶具',37,'',7,'',1),(239,'热水器',37,'',8,'',1),(240,'消毒柜/洗碗机',37,'',9,'',1),(241,'酒柜/冷柜',37,'',10,'',1),(242,'家电配件',37,'',11,'',1),(243,'净化器',38,'',1,'',1),(244,'电风扇',38,'',2,'',1),(245,'吸尘器',38,'',3,'',1),(246,'加湿器',38,'',4,'',1),(247,'净水设备',38,'',5,'',1),(248,'饮水机',38,'',6,'',1),(249,'冷风扇',38,'',7,'',1),(250,'挂烫机/熨斗',38,'',8,'',1),(251,'电话机插座',38,'',9,'',1),(252,'收录/音机',38,'',10,'',1),(253,'除湿/干衣机',38,'',11,'',1),(254,'清洁机',38,'',12,'',1),(255,'取暖电器',38,'',13,'',1),(256,'其它生活电器',38,'',14,'',1),(257,'料理/榨汁机',39,'',1,'',1),(258,'豆浆机',39,'',2,'',1),(259,'电饭煲',39,'',3,'',1),(260,'电压力锅',39,'',4,'',1),(261,'面包机',39,'',5,'',1),(262,'咖啡机',39,'',6,'',1),(263,'微波炉',39,'',7,'',1),(264,'电烤箱',39,'',8,'',1),(265,'电磁炉',39,'',9,'',1),(266,'电饼铛/烧烤盘',39,'',10,'',1),(267,'煮蛋器',39,'',11,'',1),(268,'酸奶机',39,'',12,'',1),(269,'电水壶/热水瓶',39,'',13,'',1),(270,'电炖锅',39,'',14,'',1),(271,'多用途锅',39,'',15,'',1),(272,'果蔬解毒机',39,'',16,'',1),(273,'其它厨房电器',39,'',17,'',1),(274,'剃须刀',40,'',1,'',1),(275,'剃/脱毛器',40,'',2,'',1),(276,'口腔护理',40,'',3,'',1),(277,'电吹风',40,'',4,'',1),(278,'美容美发',40,'',5,'',1),(279,'按摩器',40,'',6,'',1),(280,'按摩椅',40,'',7,'',1),(281,'足浴盆血压计',40,'',8,'',1),(282,'健康秤/厨房秤',40,'',9,'',1),(283,'血糖仪',40,'',10,'',1),(284,'体温计',40,'',11,'',1),(285,'计步器/脂肪检测仪',40,'',12,'',1),(286,'其它健康电器',40,'',13,'',1),(287,'电动工具',41,'',1,'',1),(288,'手动工具',41,'',2,'',1),(289,'仪器仪表',41,'',3,'',1),(290,'浴霸/排气扇',41,'',4,'',1),(291,'灯具',41,'',5,'',1),(292,'LED灯',41,'',6,'',1),(293,'洁身器',41,'',7,'',1),(294,'水槽',41,'',8,'',1),(295,'龙头',41,'',9,'',1),(296,'淋浴花洒',41,'',10,'',1),(297,'厨卫五金',41,'',11,'',1),(298,'家具五金',41,'',12,'',1),(299,'门铃',41,'',13,'',1),(300,'电气开关',41,'',14,'',1),(301,'插座',41,'',15,'',1),(302,'电工电料',41,'',16,'',1),(303,'监控安防',41,'',17,'',1),(304,'电线/线缆',41,'',18,'',1),(305,'手机',42,'',1,'',1),(306,'对讲机',42,'',2,'',1),(307,'购机送费',43,'',1,'',1),(308,'0元购机',43,'',2,'',1),(309,'选号入网',43,'',3,'',1),(310,'电池',44,'',1,'',1),(311,'蓝牙耳机',44,'',2,'',1),(312,'充电器/数据线',44,'',3,'',1),(313,'手机耳机',44,'',4,'',1),(314,'贴膜',44,'',5,'',1),(315,'存储卡',44,'',6,'',1),(316,'保护套',44,'',7,'',1),(317,'车载',44,'',8,'',1),(318,'iPhone配件',44,'',9,'',1),(319,'其它配件',44,'',10,'',1),(320,'数码相机',45,'',1,'',1),(321,'单电/微单相机',45,'',2,'',1),(322,'单反相机',45,'',3,'',1),(323,'摄像机',45,'',4,'',1),(324,'拍立得',45,'',5,'',1),(325,'镜头',45,'',6,'',1),(326,'滤镜',45,'',7,'',1),(327,'闪光灯/手柄',45,'',8,'',1),(328,'单反配件',45,'',9,'',1),(329,'存储卡',46,'',1,'',1),(330,'电池/充电器',46,'',2,'',1),(331,'读卡器',46,'',3,'',1),(332,'移动电源',46,'',4,'',1),(333,'数码包',46,'',5,'',1),(334,'数码贴膜',46,'',6,'',1),(335,'三脚架/云台',46,'',7,'',1),(336,'相机清洁',46,'',8,'',1),(337,'MP3/MP4',47,'',1,'',1),(338,'MID',47,'',2,'',1),(339,'耳机/耳麦',47,'',3,'',1),(340,'音箱',47,'',4,'',1),(341,'高清播放器',47,'',5,'',1),(342,'电子书',47,'',6,'',1),(343,'电子词典',47,'',8,'',1),(344,'MP3/MP4配件',47,'',9,'',1),(345,'录音笔',47,'',10,'',1),(346,'麦克风',47,'',11,'',1),(347,'专业音频',47,'',12,'',1),(348,'电子教育',47,'',13,'',1),(349,'数码相框',47,'',14,'',1),(350,'苹果配件',47,'',15,'',1),(351,'笔记本',161,'',1,'',1),(352,'超极本',161,'',2,'',1),(353,'上网本',161,'',3,'',1),(354,'平板电脑',161,'',4,'',1),(355,'平板电脑配件',161,'',5,'',1),(356,'台式机',161,'',6,'',1),(357,'服务器',161,'',7,'',1),(358,'笔记本配件',161,'',8,'',1),(359,'CPU',162,'',1,'',1),(360,'主板',162,'',2,'',1),(361,'显卡',162,'',3,'',1),(362,'硬盘',162,'',4,'',1),(363,'内存',162,'',5,'',1),(364,'机箱',162,'',6,'',1),(365,'电源',162,'',7,'',1),(366,'显示器',162,'',8,'',1),(367,'刻录机/光驱',162,'',9,'',1),(368,'声卡/扩展卡',162,'',10,'',1),(369,'散热器',162,'',11,'',1),(370,'装机配件',162,'',12,'',1),(371,'鼠标',163,'',1,'',1),(372,'键盘',163,'',2,'',1),(373,'游戏设备',163,'',3,'',1),(374,'U盘',163,'',4,'',1),(375,'移动硬盘',163,'',5,'',1),(376,'电视盒',163,'',6,'',1),(377,'摄像头',163,'',7,'',1),(378,'线缆',163,'',8,'',1),(379,'鼠标垫',163,'',9,'',1),(380,'手写板',163,'',10,'',1),(381,'外置盒',163,'',11,'',1),(382,'电脑工具',163,'',12,'',1),(383,'电脑清洁',163,'',13,'',1),(384,'UPS插座',163,'',14,'',1),(385,'路由器',164,'',1,'',1),(386,'网卡交换机',164,'',2,'',1),(387,'网络存储',164,'',3,'',1),(388,'3G上网',164,'',4,'',1),(389,'打印机',165,'',1,'',1),(390,'一体机',165,'',2,'',1),(391,'投影机',165,'',3,'',1),(392,'投影配件',165,'',4,'',1),(393,'传真机',165,'',5,'',1),(394,'复合机',165,'',6,'',1),(395,'碎纸机',165,'',7,'',1),(396,'扫描仪',165,'',8,'',1),(397,'墨盒',165,'',9,'',1),(398,'硒鼓',165,'',10,'',1),(399,'墨粉',165,'',11,'',1),(400,'色带',165,'',12,'',1),(401,'办公文具',166,'',1,'',1),(402,'文件管理',166,'',2,'',1),(403,'笔类',166,'',3,'',1),(404,'纸类',166,'',4,'',1),(405,'本册/便签',166,'',5,'',1),(406,'学生文具',166,'',6,'',1),(407,'财务用品',166,'',7,'',1),(408,'计算器',166,'',8,'',1),(409,'激光笔',166,'',9,'',1),(410,'白板/封装',166,'',10,'',1),(411,'考勤机',166,'',11,'',1),(412,'刻录碟片/附件',166,'',12,'',1),(413,'点钞机',166,'',13,'',1),(414,'支付设备/POS机',166,'',14,'',1),(415,'安防监控',166,'',15,'',1),(416,'呼叫/会议设备',166,'',16,'',1),(417,'保险柜',166,'',17,'',1),(418,'京东服务',167,'',1,'',1),(419,'电脑软件',167,'',2,'',1),(420,'烹饪锅具',153,'',1,'',1),(421,'刀剪砧板',153,'',2,'',1),(422,'收纳保鲜',153,'',3,'',1),(423,'水具',153,'',4,'',1),(424,'酒具',153,'',5,'',1),(425,'餐具',153,'',6,'',1),(426,'宠物主粮',154,'',1,'',1),(427,'宠物零食',154,'',2,'',1),(428,'营养品',154,'',3,'',1),(429,'家居日用',154,'',4,'',1),(430,'玩具服饰',154,'',5,'',1),(431,'出行装备',154,'',6,'',1),(432,'医护美容',154,'',7,'',1),(433,'床品件套',155,'',1,'',1),(434,'被子',155,'',2,'',1),(435,'枕芯枕套',155,'',3,'',1),(436,'床单被罩',155,'',4,'',1),(437,'毛巾被/毯',155,'',5,'',1),(438,'床垫/床褥',155,'',6,'',1),(439,'蚊帐/凉席',155,'',7,'',1),(440,'抱枕坐垫',155,'',8,'',1),(441,'毛巾家纺',155,'',9,'',1),(442,'电热毯',155,'',10,'',1),(443,'窗帘/窗纱',155,'',11,'',1),(444,'酒店用品',155,'',12,'',1),(445,'书架层架',156,'',1,'',1),(446,'衣柜/衣架',156,'',2,'',1),(447,'电脑桌椅',156,'',3,'',1),(448,'休闲椅/凳',156,'',4,'',1),(449,'晒衣架/烫衣板',156,'',5,'',1),(450,'家用梯',156,'',6,'',1),(451,'边桌/茶几',156,'',7,'',1),(452,'鞋架/鞋柜',156,'',8,'',1),(453,'电视储物柜',156,'',9,'',1),(454,'儿童家具',156,'',10,'',1),(455,'配件',156,'',11,'',1),(456,'大家具',156,'',12,'',1),(457,'台灯',157,'',1,'',1),(458,'节能灯',157,'',2,'',1),(459,'装饰灯',157,'',3,'',1),(460,'多用灯',157,'',4,'',1),(461,'手电LED灯',157,'',5,'',1),(462,'吸顶灯',157,'',6,'',1),(463,'五金电器',157,'',7,'',1),(464,'氛围照明',157,'',8,'',1),(465,'吊灯',157,'',9,'',1),(466,'收纳用品',158,'',1,'',1),(467,'雨伞雨具',158,'',2,'',1),(468,'浴室用品',158,'',3,'',1),(469,'缝纫用品',158,'',4,'',1),(470,'家装软饰',158,'',5,'',1),(471,'洗晒用品',158,'',6,'',1),(472,'净化除味',158,'',7,'',1),(473,'纸品湿巾',159,'',1,'',1),(474,'衣物清洁',159,'',2,'',1),(475,'清洁工具',159,'',3,'',1),(476,'驱虫用品',159,'',4,'',1),(477,'居室清洁',159,'',5,'',1),(478,'皮具护理',159,'',6,'',1),(479,'瓷砖',160,'',1,'',1),(480,'地板',160,'',2,'',1),(481,'厨卫',160,'',3,'',1),(482,'门窗',160,'',4,'',1),(483,'移门/壁柜',160,'',5,'',1),(484,'油漆/壁纸',160,'',6,'',1),(485,'五金工具',160,'',7,'',1),(486,'散热器',160,'',8,'',1),(487,'园艺',160,'',9,'',1),(488,'装修设计',160,'',10,'',1),(489,'装修施工',160,'',11,'',1),(490,'更多>>',160,'',12,'',1),(491,'T恤',145,'',1,'',1),(492,'衬衫',145,'',2,'',1),(493,'针织衫',145,'',3,'',1),(494,'雪纺衫',145,'',4,'',1),(495,'卫衣',145,'',5,'',1),(496,'马甲',145,'',6,'',1),(497,'连衣裙',145,'',7,'',1),(498,'半身裙',145,'',8,'',1),(499,'牛仔裤',145,'',9,'',1),(500,'休闲裤',145,'',10,'',1),(501,'打底裤',145,'',11,'',1),(502,'正装裤',145,'',12,'',1),(503,'西服',145,'',13,'',1),(504,'短外套',145,'',14,'',1),(505,'风衣',145,'',15,'',1),(506,'大衣',145,'',16,'',1),(507,'皮衣皮草',145,'',17,'',1),(508,'棉服',145,'',18,'',1),(509,'羽绒服',145,'',19,'',1),(510,'孕妇装',145,'',20,'',1),(511,'大码装',145,'',21,'',1),(512,'中老年装',145,'',22,'',1),(513,'婚纱礼服',145,'',23,'',1),(514,'衬衫',146,'',1,'',1),(515,'T恤',146,'',2,'',1),(516,'POLO衫',146,'',3,'',1),(517,'针织衫',146,'',4,'',1),(518,'羊绒衫',146,'',5,'',1),(519,'卫衣',146,'',6,'',1),(520,'马甲/背心',146,'',7,'',1),(521,'夹克',146,'',8,'',1),(522,'风衣',146,'',9,'',1),(523,'大衣',146,'',10,'',1),(524,'皮衣',146,'',11,'',1),(525,'外套',146,'',12,'',1),(526,'西服',146,'',13,'',1),(527,'棉服',146,'',14,'',1),(528,'羽绒服',146,'',15,'',1),(529,'牛仔裤',146,'',16,'',1),(530,'休闲裤',146,'',17,'',1),(531,'西裤',146,'',18,'',1),(532,'西服套装',146,'',19,'',1),(533,'大码装',146,'',20,'',1),(534,'中老年装',146,'',21,'',1),(535,'唐装',146,'',22,'',1),(536,'工装',146,'',23,'',1),(537,'文胸',147,'',1,'',1),(538,'女式内裤',147,'',2,'',1),(539,'男式内裤',147,'',3,'',1),(540,'家居睡衣',147,'',4,'',1),(541,'塑身衣',147,'',5,'',1),(542,'睡袍/浴袍',147,'',6,'',1),(543,'泳衣',147,'',7,'',1),(544,'背心',147,'',8,'',1),(545,'抹胸',147,'',9,'',1),(546,'连裤袜',147,'',10,'',1),(547,'美腿袜',147,'',11,'',1),(548,'男袜',147,'',12,'',1),(549,'女袜',147,'',13,'',1),(550,'情趣内衣',147,'',14,'',1),(551,'保暖内衣',147,'',15,'',1),(552,'休闲鞋',148,'',1,'',1),(553,'帆布鞋',148,'',2,'',1),(554,'跑步鞋',148,'',3,'',1),(555,'篮球鞋',148,'',4,'',1),(556,'足球鞋',148,'',5,'',1),(557,'训练鞋',148,'',6,'',1),(558,'乒羽鞋',148,'',7,'',1),(559,'拖鞋',148,'',8,'',1),(560,'卫衣',148,'',9,'',1),(561,'夹克',148,'',10,'',1),(562,'T恤',148,'',11,'',1),(563,'棉服/羽绒服',148,'',12,'',1),(564,'运动裤',148,'',13,'',1),(565,'套装运动包',148,'',14,'',1),(566,'运动配件',148,'',15,'',1),(567,'平底鞋',149,'',1,'',1),(568,'高跟鞋',149,'',2,'',1),(569,'单鞋',149,'',3,'',1),(570,'休闲鞋',149,'',4,'',1),(571,'凉鞋',149,'',5,'',1),(572,'女靴',149,'',6,'',1),(573,'雪地靴',149,'',7,'',1),(574,'拖鞋',149,'',8,'',1),(575,'商务休闲鞋',150,'',1,'',1),(576,'正装鞋',150,'',2,'',1),(577,'休闲鞋',150,'',3,'',1),(578,'凉鞋/沙滩鞋',150,'',4,'',1),(579,'男靴',150,'',5,'',1),(580,'功能鞋',150,'',6,'',1),(581,'拖鞋',150,'',7,'',1),(582,'太阳镜',151,'',1,'',1),(583,'框镜',151,'',2,'',1),(584,'皮带',151,'',3,'',1),(585,'围巾',151,'',4,'',1),(586,'手套',151,'',5,'',1),(587,'帽子',151,'',6,'',1),(588,'领带',151,'',7,'',1),(589,'袖扣',151,'',8,'',1),(590,'其他配件',151,'',9,'',1),(591,'女童',152,'',1,'',1),(592,'男童',152,'',2,'',1),(593,'宝宝服饰',152,'',3,'',1),(594,'儿童配饰',152,'',4,'',1),(595,'亲子装',152,'',5,'',1),(596,'童鞋',152,'',6,'',1),(597,'洁面乳',138,'',1,'',1),(598,'爽肤水',138,'',2,'',1),(599,'精华露',138,'',3,'',1),(600,'乳液面霜',138,'',4,'',1),(601,'面膜',138,'',5,'',1),(602,'面贴',138,'',6,'',1),(603,'眼部护理',138,'',7,'',1),(604,'颈部护理',138,'',8,'',1),(605,'T区护理',138,'',9,'',1),(606,'护肤套装',138,'',10,'',1),(607,'防晒隔离',138,'',11,'',1),(608,'洗发',139,'',1,'',1),(609,'护发',139,'',2,'',1),(610,'染发/造型',139,'',3,'',1),(611,'沐浴',139,'',4,'',1),(612,'磨砂/浴盐',139,'',5,'',1),(613,'身体乳',139,'',6,'',1),(614,'手工/香皂',139,'',7,'',1),(615,'香薰精油',139,'',8,'',1),(616,'纤体瘦身',139,'',9,'',1),(617,'脱毛膏',139,'',10,'',1),(618,'手足护理',139,'',11,'',1),(619,'洗护套装',139,'',12,'',1),(620,'牙膏/牙粉',140,'',1,'',1),(621,'牙刷/牙线',140,'',2,'',1),(622,'漱口水',140,'',3,'',1),(623,'卫生巾',141,'',1,'',1),(624,'卫生护垫',141,'',2,'',1),(625,'洗液',141,'',3,'',1),(626,'美容食品',141,'',4,'',1),(627,'其它',141,'',5,'',1),(628,'脸部',142,'',1,'',1),(629,'眼部',142,'',2,'',1),(630,'身体护理',142,'',3,'',1),(631,'男士香水',142,'',4,'',1),(632,'剃须',142,'',5,'',1),(633,'防脱洗护',142,'',6,'',1),(634,'唇膏',142,'',7,'',1),(635,'粉底/遮瑕',143,'',1,'',1),(636,'腮红',143,'',2,'',1),(637,'眼影/眼线',143,'',3,'',1),(638,'眉笔',143,'',4,'',1),(639,'睫毛膏',143,'',5,'',1),(640,'唇膏唇彩',143,'',6,'',1),(641,'彩妆组合',143,'',7,'',1),(642,'卸妆',143,'',8,'',1),(643,'美甲',143,'',9,'',1),(644,'彩妆',143,'',10,'',1),(645,'工具',143,'',11,'',1),(646,'假发',143,'',12,'',1),(647,'女士香水',144,'',1,'',1),(648,'男士香水',144,'',2,'',1),(649,'组合套装',144,'',3,'',1),(650,'迷你香水',144,'',4,'',1),(651,'香体走珠',144,'',5,'',1),(652,'钱包/卡包',130,'',1,'',1),(653,'手拿包',130,'',2,'',1),(654,'单肩包',130,'',3,'',1),(655,'双肩包',130,'',4,'',1),(656,'手提包',130,'',5,'',1),(657,'斜挎包',130,'',6,'',1),(658,'钱包/卡包',131,'',1,'',1),(659,'男士手包',131,'',2,'',1),(660,'腰带/礼盒',131,'',3,'',1),(661,'商务公文包',131,'',4,'',1),(662,'电脑数码包',132,'',1,'',1),(663,'拉杆箱',132,'',2,'',1),(664,'旅行包',132,'',3,'',1),(665,'旅行配件',132,'',4,'',1),(666,'休闲运动包',132,'',5,'',1),(667,'登山包',132,'',6,'',1),(668,'妈咪包',132,'',7,'',1),(669,'书包',132,'',8,'',1),(670,'火机烟具',133,'',1,'',1),(671,'礼品文具',133,'',2,'',1),(672,'瑞士军刀',133,'',3,'',1),(673,'收藏品',133,'',4,'',1),(674,'工艺礼品',133,'',5,'',1),(675,'创意礼品',133,'',6,'',1),(676,'礼卡礼券',133,'',7,'',1),(677,'鲜花速递',133,'',8,'',1),(678,'婚庆用品',133,'',9,'',1),(679,'京东礼品卡',133,'',10,'',1),(680,'GUCCI',134,'',1,'',1),(681,'PRADA',134,'',2,'',1),(682,'FENDI',134,'',3,'',1),(683,'BURBERRY',134,'',4,'',1),(684,'MONTBLANC',134,'',5,'',1),(685,'ARMAN',134,'',6,'',1),(686,'ICOACH',134,'',7,'',1),(687,'RIMOWARA',134,'',8,'',1),(688,'Y-BAN',134,'',9,'',1),(689,'更多品牌',134,'',10,'',1),(690,'奢侈品箱包',134,'',11,'',1),(691,'钱包',134,'',12,'',1),(692,'服饰',134,'',13,'',1),(693,'腰带',134,'',14,'',1),(694,'太阳镜',134,'',15,'',1),(695,'眼镜配件',134,'',16,'',1),(696,'瑞士品牌',135,'',1,'',1),(697,'国产品牌',135,'',2,'',1),(698,'日本品牌',135,'',3,'',1),(699,'时尚品牌',135,'',4,'',1),(700,'闹钟',135,'',5,'',1),(701,'挂钟',135,'',6,'',1),(702,'儿童手表',135,'',7,'',1),(703,'纯金K金饰品',136,'',1,'',1),(704,'金银投资',136,'',2,'',1),(705,'银饰',136,'',3,'',1),(706,'钻石饰品',136,'',4,'',1),(707,'翡翠玉石',136,'',5,'',1),(708,'水晶玛瑙',136,'',6,'',1),(709,'宝石珍珠',136,'',7,'',1),(710,'时尚饰品',136,'',8,'',1),(711,'婚嫁首饰',137,'',1,'',1),(712,'婚纱摄影',137,'',2,'',1),(713,'婚纱礼服',137,'',3,'',1),(714,'婚庆服务',137,'',4,'',1),(715,'婚庆礼品/用品',137,'',5,'',1),(716,'婚宴',137,'',6,'',1),(717,'户外服装',122,'',1,'',1),(718,'户外鞋袜',122,'',2,'',1),(719,'户外配饰',122,'',3,'',1),(720,'帐篷',123,'',1,'',1),(721,'睡袋',123,'',2,'',1),(722,'登山',123,'',3,'',1),(723,'攀岩',123,'',4,'',1),(724,'户外背包',123,'',5,'',1),(725,'户外照明',123,'',6,'',1),(726,'户外垫子',123,'',7,'',1),(727,'户外仪表',123,'',8,'',1),(728,'户外工具',123,'',9,'',1),(729,'望远镜',123,'',10,'',1),(730,'垂钓用品',123,'',11,'',1),(731,'旅游用品',123,'',12,'',1),(732,'便携桌椅床',123,'',13,'',1),(733,'烧烤用品',123,'',14,'',1),(734,'野餐炊具',123,'',15,'',1),(735,'军迷用品',123,'',16,'',1),(736,'游泳用具',123,'',17,'',1),(737,'泳衣',123,'',18,'',1),(738,'健身器械',124,'',1,'',1),(739,'运动器材',124,'',2,'',1),(740,'防护器具',124,'',3,'',1),(741,'骑行运动',124,'',4,'',1),(742,'极限轮滑',124,'',5,'',1),(743,'武术搏击',124,'',6,'',1),(744,'瑜伽垫',125,'',1,'',1),(745,'瑜伽服',125,'',2,'',1),(746,'瑜伽配件',125,'',3,'',1),(747,'瑜伽套装',125,'',4,'',1),(748,'舞蹈鞋服',125,'',5,'',1),(749,'羽毛球',126,'',1,'',1),(750,'乒乓球',126,'',2,'',1),(751,'篮球',126,'',3,'',1),(752,'足球',126,'',4,'',1),(753,'网球',126,'',5,'',1),(754,'排球',126,'',7,'',1),(755,'高尔夫球',126,'',8,'',1),(756,'棋牌麻将',126,'',9,'',1),(757,'其他',126,'',10,'',1),(758,'安全避孕',127,'',1,'',1),(759,'验孕',127,'',2,'',1),(760,'测孕',127,'',3,'',1),(761,'人体润滑',127,'',4,'',1),(762,'情爱玩具',127,'',5,'',1),(763,'情趣内衣',127,'',6,'',1),(764,'组合套装',127,'',7,'',1),(765,'养生器械',128,'',1,'',1),(766,'保健用品',128,'',2,'',1),(767,'康复辅助',128,'',3,'',1),(768,'家庭护理',128,'',4,'',1),(769,'跌打损伤',129,'',1,'',1),(770,'烫伤止痒',129,'',2,'',1),(771,'防裂抗冻',129,'',3,'',1),(772,'口腔咽部',129,'',4,'',1),(773,'眼部保健',129,'',5,'',1),(774,'风湿骨痛',129,'',6,'',1),(775,'生殖泌尿',129,'',7,'',1),(776,'美体塑身',129,'',8,'',1),(777,'便携式GPS导航',115,'',1,'',1),(778,'嵌入式导航',115,'',2,'',1),(779,'安全预警仪',115,'',3,'',1),(780,'行车记录仪',115,'',4,'',1),(781,'跟踪防盗器',115,'',5,'',1),(782,'倒车雷达',115,'',6,'',1),(783,'车载电源',115,'',7,'',1),(784,'车载影音',115,'',8,'',1),(785,'车载净化器',115,'',9,'',1),(786,'车载冰箱',115,'',10,'',1),(787,'车载吸尘器',115,'',11,'',1),(788,'充气泵',115,'',12,'',1),(789,'胎压监测',115,'',13,'',1),(790,'车载生活电器',115,'',14,'',1),(791,'机油',116,'',1,'',1),(792,'添加剂',116,'',2,'',1),(793,'防冻冷却液',116,'',3,'',1),(794,'附属油',116,'',4,'',1),(795,'底盘装甲',116,'',5,'',1),(796,'空调清洗剂',116,'',6,'',1),(797,'金属养护',116,'',7,'',1),(798,'雨刷',117,'',1,'',1),(799,'车灯',117,'',2,'',1),(800,'轮胎',117,'',3,'',1),(801,'贴膜',117,'',4,'',1),(802,'装饰贴',117,'',5,'',1),(803,'后视镜',117,'',6,'',1),(804,'机油滤',117,'',8,'',1),(805,'空气滤',117,'',9,'',1),(806,'空调滤',117,'',10,'',1),(807,'燃油滤',117,'',11,'',1),(808,'火花塞',117,'',12,'',1),(809,'喇叭',117,'',13,'',1),(810,'刹车片',117,'',14,'',1),(811,'刹车盘',117,'',15,'',1),(812,'减震器',117,'',16,'',1),(813,'车身装饰',117,'',18,'',1),(814,'尾喉/排气管',117,'',19,'',1),(815,'踏板',117,'',20,'',1),(816,'蓄电池',117,'',21,'',1),(817,'其他配件',117,'',22,'',1),(818,'漆面美',118,'',1,'',1),(819,'容漆面',118,'',2,'',1),(820,'修复内',118,'',3,'',1),(821,'饰清洁',118,'',4,'',1),(822,'玻璃美容',118,'',5,'',1),(823,'补漆笔',118,'',6,'',1),(824,'轮胎轮毂清洗',118,'',7,'',1),(825,'洗车器',118,'',8,'',1),(826,'洗车水枪',118,'',9,'',1),(827,'洗车配件',118,'',10,'',1),(828,'洗车液',118,'',11,'',1),(829,'车掸',118,'',12,'',1),(830,'擦车巾/海绵',118,'',13,'',1),(831,'凉垫',119,'',1,'',1),(832,'四季垫',119,'',2,'',1),(833,'毛垫',119,'',3,'',1),(834,'专车专用座垫',119,'',4,'',1),(835,'专车专用座套',119,'',5,'',1),(836,'通用座套',119,'',6,'',1),(837,'多功能垫',119,'',7,'',1),(838,'专车专用脚垫',119,'',8,'',1),(839,'通用脚垫',119,'',9,'',1),(840,'后备箱垫',119,'',10,'',1),(841,'车用香水',120,'',1,'',1),(842,'车用炭包',120,'',2,'',1),(843,'空气净化',120,'',3,'',1),(844,'颈枕/头枕',120,'',4,'',1),(845,'抱枕/腰靠',120,'',5,'',1),(846,'方向盘套',120,'',6,'',1),(847,'挂件',120,'',7,'',1),(848,'摆件',120,'',8,'',1),(849,'布艺软饰',120,'',9,'',1),(850,'功能用品',120,'',10,'',1),(851,'整理收纳',120,'',11,'',1),(852,'CD夹',120,'',12,'',1),(853,'儿童安全座椅',121,'',1,'',1),(854,'应急救援',121,'',2,'',1),(855,'汽修工具',121,'',3,'',1),(856,'自驾野营',121,'',4,'',1),(857,'自驾照明',121,'',5,'',1),(858,'保温箱',121,'',6,'',1),(859,'置物箱',121,'',7,'',1),(860,'车衣',121,'',8,'',1),(861,'遮阳挡雪挡',121,'',9,'',1),(862,'车锁地锁',121,'',10,'',1),(863,'摩托车装备',121,'',11,'',1),(864,'饼干蛋糕',95,'',1,'',1),(865,'糖果巧克力',95,'',2,'',1),(866,'休闲零食',95,'',3,'',1),(867,'冲调饮品',95,'',4,'',1),(868,'粮油调味',95,'',5,'',1),(869,'华北',96,'',1,'',1),(870,'西北',96,'',2,'',1),(871,'西南',96,'',3,'',1),(872,'东北',96,'',4,'',1),(873,'华南',96,'',5,'',1),(874,'华东',96,'',6,'',1),(875,'华中',96,'',7,'',1),(876,'休闲零食',97,'',1,'',1),(877,'坚果炒货',97,'',2,'',1),(878,'肉干肉松',97,'',3,'',1),(879,'蜜饯果脯',97,'',4,'',1),(880,'糖果/巧克力',97,'',5,'',1),(881,'饼干蛋糕',97,'',6,'',1),(882,'米面杂粮',98,'',1,'',1),(883,'食用油',98,'',2,'',1),(884,'调味品',98,'',3,'',1),(885,'南北干货',98,'',4,'',1),(886,'方便食品',98,'',5,'',1),(887,'有机食品',98,'',6,'',1),(888,'白酒/黄酒',99,'',1,'',1),(889,'葡萄酒',99,'',2,'',1),(890,'洋酒',99,'',3,'',1),(891,'啤酒',99,'',4,'',1),(892,'饮料',99,'',5,'',1),(893,'冲调',99,'',6,'',1),(894,'咖啡/奶茶',99,'',7,'',1),(895,'茗茶',99,'',8,'',1),(896,'牛奶',99,'',9,'',1),(897,'基础营养',100,'',1,'',1),(898,'美体养颜',100,'',2,'',1),(899,'滋补调养',100,'',3,'',1),(900,'骨骼健康',100,'',4,'',1),(901,'保健茶饮',100,'',5,'',1),(902,'成分保健',100,'',6,'',1),(903,'无糖食品',100,'',7,'',1),(904,'调节三高',101,'',1,'',1),(905,'心脑养护',101,'',2,'',1),(906,'改善睡眠',101,'',3,'',1),(907,'肝肾养护',101,'',4,'',1),(908,'免疫调节',101,'',5,'',1),(909,'更多调理',101,'',6,'',1),(910,'参茸礼品',102,'',1,'',1),(911,'更多礼品',102,'',2,'',1),(912,'水果',103,'',1,'',1),(913,'蔬菜',103,'',2,'',1),(914,'海鲜水产',103,'',3,'',1),(915,'禽蛋',103,'',4,'',1),(916,'鲜肉',103,'',5,'',1),(917,'加工类肉食',103,'',6,'',1),(918,'冻品',103,'',7,'',1),(919,'半成品',103,'',8,'',1),(920,'品牌奶粉',106,'',1,'',1),(921,'特殊配方',106,'',2,'',1),(922,'妈妈奶粉',106,'',3,'',1),(923,'1段奶粉',106,'',4,'',1),(924,'2段奶粉',106,'',5,'',1),(925,'3段奶粉',106,'',6,'',1),(926,'4段奶粉',106,'',7,'',1),(927,'羊奶粉',106,'',8,'',1),(928,'成人奶粉',106,'',9,'',1),(929,'婴幼营养',107,'',1,'',1),(930,'初乳',107,'',2,'',1),(931,'米粉/菜粉',107,'',3,'',1),(932,'果泥/果汁',107,'',4,'',1),(933,'肉松/饼干',107,'',5,'',1),(934,'辅食',107,'',6,'',1),(935,'面条/粥',107,'',7,'',1),(936,'孕期营养',107,'',8,'',1),(937,'清火/开胃',107,'',9,'',1),(938,'品牌尿裤',108,'',1,'',1),(939,'新生儿',108,'',2,'',1),(940,'S号',108,'',3,'',1),(941,'M号',108,'',4,'',1),(942,'L号',108,'',5,'',1),(943,'XL/XXL号',108,'',6,'',1),(944,'裤型',108,'',7,'',1),(945,'尿裤',108,'',8,'',1),(946,'湿巾',108,'',9,'',1),(947,'尿布/尿垫',108,'',10,'',1),(948,'成人尿裤',108,'',11,'',1),(949,'宝宝护肤',109,'',1,'',1),(950,'护理用品',109,'',2,'',1),(951,'洗发沐浴',109,'',3,'',1),(952,'清洁用品',109,'',4,'',1),(953,'洗浴用品',109,'',5,'',1),(954,'妈妈护肤',109,'',6,'',1),(955,'婴儿推车',110,'',1,'',1),(956,'安全座椅 ',110,'',2,'',1),(957,'餐椅摇椅',110,'',3,'',1),(958,'婴儿床',110,'',4,'',1),(959,'自行车',110,'',5,'',1),(960,'学步车',110,'',6,'',1),(961,'三轮车',110,'',7,'',1),(962,'电动车',110,'',8,'',1),(963,'健身车',110,'',9,'',1),(964,'奶瓶',111,'',1,'',1),(965,'奶嘴',111,'',2,'',1),(966,'吸奶器',111,'',3,'',1),(967,'暖奶/消毒',111,'',4,'',1),(968,'餐具',111,'',5,'',1),(969,'水具',111,'',6,'',1),(970,'牙胶/安抚',111,'',7,'',1),(971,'婴儿服',112,'',1,'',1),(972,'婴儿家居',112,'',2,'',1),(973,'婴儿鞋袜',112,'',3,'',1),(974,'安全用品',112,'',4,'',1),(975,'包/背婴带',113,'',1,'',1),(976,'妈妈护理',113,'',2,'',1),(977,'产后塑身',113,'',3,'',1),(978,'孕妇内衣',113,'',4,'',1),(979,'防辐射服',113,'',5,'',1),(980,'孕妇装',113,'',6,'',1),(981,'孕妇食品',113,'',7,'',1),(982,'妈妈美容',113,'',8,'',1),(983,'适用年龄',114,'',1,'',1),(984,'遥控/电动',114,'',2,'',1),(985,'毛绒布艺',114,'',3,'',1),(986,'娃娃玩具',114,'',4,'',1),(987,'模型玩具',114,'',5,'',1),(988,'健身玩具',114,'',6,'',1),(989,'动漫玩具',114,'',7,'',1),(990,'益智玩具',114,'',8,'',1),(991,'积木拼插',114,'',9,'',1),(992,'DIY玩具',114,'',10,'',1),(993,'创意减压',114,'',11,'',1),(994,'乐器相关',114,'',12,'',1);

#
# Source for table "ci_goods"
#

DROP TABLE IF EXISTS `ci_goods`;
CREATE TABLE `ci_goods` (
  `g_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `g_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '商品货号',
  `g_name` varchar(100) NOT NULL DEFAULT '' COMMENT '商品名称',
  `g_brief` varchar(255) NOT NULL DEFAULT '' COMMENT '商品简单描述',
  `g_desc` text COMMENT '商品详情',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属类别ID',
  `brand_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品所属品牌ID',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `shop_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '本店价格',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销起始时间',
  `promote_end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '促销截止时间',
  `g_img` varchar(50) NOT NULL DEFAULT '' COMMENT '商品图片',
  `g_thumb` varchar(50) NOT NULL DEFAULT '' COMMENT '商品缩略图',
  `g_number` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  `g_click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型ID',
  `is_promote` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否促销，默认为0不促销',
  `is_best` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否精品,默认为0',
  `is_new` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否新品，默认为0',
  `is_hot` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否热卖,默认为0',
  `is_onsale` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架,默认为1',
  `g_addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`g_id`),
  KEY `cat_id` (`cat_id`),
  KEY `brand_id` (`brand_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='商品goods表';

#
# Data for table "ci_goods"
#

INSERT INTO `ci_goods` VALUES (1,'ECS000032','诺基亚N85','sssssssssddddd','<p>ssssssss<br/></p>',3,1,3612.00,3010.00,2750.00,1243785600,1417276800,'61.jpg','61_thumb.jpg',4,0,1,1,1,1,1,1,0),(2,'ECS000032','诺基亚N85','ddddddd','<p>ssssssss<br/></p>',3,1,3612.00,3010.00,2750.00,1243785600,1417276800,'6.jpg','6_thumb.jpg',4,0,1,1,1,1,1,1,0),(3,'ECS000032','诺基亚N85','ddddddd','<p>ssssssss<br/></p>',3,1,3612.00,3010.00,2750.00,1243785600,1417276800,'6.jpg','6_thumb.jpg',4,0,1,1,1,1,1,1,0),(4,'ECS000032','诺基亚N85','ddddddd','<p>ssssssss<br/></p>',3,1,3612.00,3010.00,2750.00,1243785600,1417276800,'61.jpg','61_thumb.jpg',4,0,1,1,1,1,1,1,0),(5,'ECS000032','诺基亚N85','ddddddd','<p>ssssssss<br/></p>',3,1,3612.00,3010.00,2750.00,1243785600,1417276800,'62.jpg','62_thumb.jpg',4,0,1,1,1,1,1,1,0);

#
# Source for table "ci_goods_attr"
#

DROP TABLE IF EXISTS `ci_goods_attr`;
CREATE TABLE `ci_goods_attr` (
  `ga_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品的ID',
  `attr_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '属性的ID',
  `attr_value` varchar(255) NOT NULL DEFAULT '' COMMENT '属性的值',
  `attr_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '属性的价格',
  PRIMARY KEY (`ga_id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商品和属性的中间表';

#
# Data for table "ci_goods_attr"
#

INSERT INTO `ci_goods_attr` VALUES (1,5,0,'aa',0.00),(2,5,1,'bb',0.00),(3,5,2,'bb',0.00);

#
# Source for table "ci_goods_type"
#

DROP TABLE IF EXISTS `ci_goods_type`;
CREATE TABLE `ci_goods_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类型ID',
  `type_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='商品的类型表';

#
# Data for table "ci_goods_type"
#

INSERT INTO `ci_goods_type` VALUES (1,'手机'),(2,'电脑'),(3,'服装'),(4,'手机配件'),(5,'音乐'),(6,'办公用品'),(7,'耳机'),(8,'蓝牙'),(9,'化妆品'),(10,'鼠标'),(11,'键盘'),(12,'空调'),(13,'桌椅'),(14,'电饭锅'),(15,'圆珠笔');

#
# Source for table "ci_news"
#

DROP TABLE IF EXISTS `ci_news`;
CREATE TABLE `ci_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `author` varchar(30) NOT NULL DEFAULT '',
  `content` text,
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "ci_news"
#

/*!40000 ALTER TABLE `ci_news` DISABLE KEYS */;
INSERT INTO `ci_news` VALUES (1,'yang','song','aaaaaaaaaaa',0),(2,'admin','admin','bbbbbbbbbbbbbb',0),(3,'你是谁啊','2015年3月31日18:58:27','是我的',0),(4,'真的是','地球人都懂的','那你是知道我的',0),(5,'真的是','地球人都懂的','那你是知道我的',1427799601);
/*!40000 ALTER TABLE `ci_news` ENABLE KEYS */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;