# Host: localhost  (Version 5.7.24)
# Date: 2020-11-04 17:55:23
# Generator: MySQL-Front 6.0  (Build 1.116)


#
# Structure for table "process_flow"
#

DROP TABLE IF EXISTS `process_flow`;
CREATE TABLE `process_flow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `flow_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '流程名称',
  `flow_code` varchar(16) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '标签:财务(CW),人事(RS)',
  `flow_desc` varchar(512) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '流程简介说明',
  `flow_node` varchar(4096) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '平台自定义的流程节点json格式',
  `copy_user_id` varchar(512) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '抄送用户id：逗号分隔',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '流程类型id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人：用户id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1=删除禁用,0=正常',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='流程管理：流程表';

#
# Data for table "process_flow"
#

INSERT INTO `process_flow` VALUES (1,'车费报销','CFBX','车费报销金额小于1000元','','',1,1,0,'2020-11-04 10:44:10','2020-11-04 10:44:10',NULL),(4,'货车申请','HCSQ','大车申请一部','[{\"node_id\":1,\"type\":2,\"role_id\":0,\"user_id\":5,\"need\":1,\"user_name\":\"张维维12\"},{\"node_id\":2,\"type\":2,\"role_id\":0,\"user_id\":130,\"need\":1,\"user_name\":\"李白\"},{\"node_id\":3,\"type\":2,\"role_id\":0,\"user_id\":61,\"need\":1,\"user_name\":\"汪微君\"}]',',126,127,',4,1,0,'2020-11-04 10:47:28','2020-11-04 10:47:28',NULL),(5,'劳动合同','LDHT','劳动合同必须人事审批','[{\"node_id\":1,\"type\":2,\"role_id\":0,\"user_id\":5,\"need\":1,\"user_name\":\"张维维12\"}]',',100,72,',2,1,0,'2020-11-04 10:50:35','2020-11-04 10:50:35',NULL),(6,'文具申领','WJSL','文具申领，明细必须填','','',6,1,0,'2020-11-04 10:52:06','2020-11-04 10:52:06',NULL),(7,'合同续签','HTXQ','合同续签112233','','',2,1,0,'2020-11-04 10:53:35','2020-11-04 10:53:35',NULL),(8,'租房合同','ZFHT','租房合同','[{\"node_id\":1,\"type\":2,\"role_id\":0,\"user_id\":6,\"need\":1,\"user_name\":\"马化腾\"},{\"node_id\":2,\"type\":2,\"role_id\":0,\"user_id\":7,\"need\":1,\"user_name\":\"刘强东\"}]',',130,77,',2,1,0,'2020-11-04 10:57:01','2020-11-04 10:57:01',NULL),(9,'购车合同','GCHT','法拉利一辆','','',2,1,0,'2020-11-04 10:58:08','2020-11-04 10:58:08',NULL),(10,'物品领用','WPLY','物品领取','[{\"node_id\":1,\"type\":2,\"role_id\":0,\"user_id\":5,\"need\":1,\"user_name\":\"张维维12\"},{\"node_id\":2,\"type\":2,\"role_id\":0,\"user_id\":6,\"need\":1,\"user_name\":\"马化腾\"}]',',7,1,',5,1,0,'2020-11-04 14:50:03','2020-11-04 14:50:03',NULL),(11,'财务审批A','CWSP','财务审批A','[{\"node_id\":1,\"type\":2,\"role_id\":0,\"user_id\":127,\"need\":1,\"user_name\":\"杨天战\"},{\"node_id\":2,\"type\":2,\"role_id\":0,\"user_id\":3,\"need\":1,\"user_name\":\"砍价靠\"}]',',127,3,',1,1,0,'2020-11-04 15:16:50','2020-11-04 15:16:50',NULL),(12,'财务审批B','CWSP','财务审批B','','',1,1,0,'2020-11-04 17:11:32','2020-11-04 17:11:32',NULL),(13,'财务审批C','CWSP','财务审批C','','',1,1,0,'2020-11-04 17:15:36','2020-11-04 17:15:36',NULL);

#
# Structure for table "process_form"
#

DROP TABLE IF EXISTS `process_form`;
CREATE TABLE `process_form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `flow_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流程id',
  `type` varchar(32) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '字段类型',
  `field_length` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '字段长度',
  `field_desc` varchar(128) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '字段注释',
  `input_id` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '表单类型id',
  `field_name` varchar(64) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '字段名',
  `must` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1=必填,0=正常',
  `is_del` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1=删除,0=正常',
  `input_title` varchar(128) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '表单标题',
  `placeholder` varchar(128) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '表单提示',
  `key_value` varchar(1024) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '单选多选下拉框：字段可选值：json',
  `time_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0=年月日时分,1=年月日时,2=年月日,3=年月',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flow_id` (`flow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='流程管理：流程表单字段表';

#
# Data for table "process_form"
#

INSERT INTO `process_form` VALUES (1,1,'varchar',255,'单行文本',0,'title0',1,0,'标题','请输入标题','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:44:10','2020-11-04 10:44:10',NULL),(2,1,'text',0,'多行文本',1,'content0',0,0,'事由','请输入事由','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:44:10','2020-11-04 10:44:10',NULL),(3,1,'int',0,'时间区间',8,'timeBetween0',0,0,'时间','请选择时间','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:44:10','2020-11-04 10:44:10',NULL),(4,1,'varchar',255,'下拉框',6,'chooseValue0',0,0,'状态','请选择状态','[{\"key\":\"\\u72b6\\u60011\",\"value\":1},{\"key\":\"\\u72b6\\u60012\",\"value\":2},{\"key\":\"\\u72b6\\u60013\",\"value\":3}]',0,'2020-11-04 10:44:10','2020-11-04 10:44:10',NULL),(5,1,'varchar',255,'上传附件',9,'fileName0',0,0,'附件','请上传附件','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:44:10','2020-11-04 10:44:10',NULL),(16,4,'varchar',255,'单行文本',0,'title0',1,0,'标题','请输入标题','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:47:28','2020-11-04 10:47:28',NULL),(17,4,'text',0,'多行文本',1,'content0',0,0,'内容','请输入内容','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:47:28','2020-11-04 10:47:28',NULL),(18,4,'int',0,'时间区间',8,'timeBetween0',1,0,'时间','请选择时间','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:47:28','2020-11-04 10:47:28',NULL),(19,4,'varchar',255,'复选框',5,'checkbox0',0,0,'复选框','请选择复选框','[{\"key\":\"\\u8ba2\\u5355\",\"value\":1},{\"key\":\"\\u54c8\\u54c8\",\"value\":2},{\"key\":\"\\u521a\\u521a\",\"value\":3}]',0,'2020-11-04 10:47:28','2020-11-04 10:47:28',NULL),(20,5,'varchar',255,'单行文本',0,'title0',1,0,'标题','请输入标题','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:50:35','2020-11-04 10:50:35',NULL),(21,5,'text',0,'多行文本',1,'content0',0,0,'内容','请输入内容','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:50:35','2020-11-04 10:50:35',NULL),(22,5,'int',0,'时间',7,'time0',0,0,'时间','请选择时间','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:50:35','2020-11-04 10:50:35',NULL),(23,5,'varchar',255,'上传附件',9,'fileName0',0,0,'附件','请上传附件','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:50:35','2020-11-04 10:50:35',NULL),(24,6,'varchar',255,'单行文本',0,'title0',1,0,'标题','请输入标题','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:52:06','2020-11-04 10:52:06',NULL),(25,6,'text',0,'多行文本',1,'content0',0,0,'内容','请输入内容','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:52:06','2020-11-04 10:52:06',NULL),(26,6,'varchar',255,'单选框',4,'chooseOne0',0,0,'单选按钮','请选择单选按钮','[{\"key\":\"\\u5355\\u4f11\",\"value\":1},{\"key\":\"\\u53cc\\u4f11\",\"value\":2},{\"key\":\"\\u5927\\u5c0f\\u5468\",\"value\":3}]',0,'2020-11-04 10:52:06','2020-11-04 10:52:06',NULL),(27,6,'int',11,'整数',3,'num0',1,0,'金额','请输入金额','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:52:06','2020-11-04 10:52:06',NULL),(28,6,'char',11,'手机号',2,'phone0',1,0,'手机','请输入手机','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:52:06','2020-11-04 10:52:06',NULL),(29,7,'varchar',255,'单行文本',0,'title0',1,0,'标题','请输入标题','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:53:35','2020-11-04 10:53:35',NULL),(30,7,'text',0,'多行文本',1,'content0',0,0,'内容','请输入内容','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:53:35','2020-11-04 10:53:35',NULL),(31,7,'int',0,'时间',7,'time0',0,0,'时间','请选择时间','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:53:35','2020-11-04 10:53:35',NULL),(32,7,'varchar',255,'上传附件',9,'fileName0',0,0,'附件','请上传附件','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:53:35','2020-11-04 10:53:35',NULL),(33,7,'int',0,'时间区间',8,'timeBetween0',1,0,'合同时间','请选择合同时间','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:53:35','2020-11-04 10:53:35',NULL),(34,8,'varchar',255,'单行文本',0,'title0',1,0,'标题','请输入标题','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:57:01','2020-11-04 10:57:01',NULL),(35,8,'int',0,'时间区间',8,'timeBetween0',1,0,'合同时间','请选择合同时间','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:57:01','2020-11-04 10:57:01',NULL),(36,8,'int',11,'整数',3,'num0',1,0,'金额','请输入金额','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:57:01','2020-11-04 10:57:01',NULL),(37,8,'text',0,'多行文本',1,'content0',0,0,'内容','请输入内容','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:57:01','2020-11-04 10:57:01',NULL),(38,8,'varchar',255,'复选框',5,'checkbox0',0,0,'复选合同','请选择复选合同','[{\"key\":\"\\u5408\\u540c\",\"value\":1},{\"key\":\"\\u5927\\u540c\",\"value\":2},{\"key\":\"\\u5c0f\\u6850\",\"value\":3}]',0,'2020-11-04 10:57:01','2020-11-04 10:57:01',NULL),(39,8,'varchar',255,'上传附件',9,'fileName0',0,0,'附件','请上传附件','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:57:01','2020-11-04 10:57:01',NULL),(40,9,'varchar',255,'单行文本',0,'title0',1,0,'标题','请输入标题','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:58:08','2020-11-04 10:58:08',NULL),(41,9,'text',0,'多行文本',1,'content0',1,0,'配置参数','请输入配置参数','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:58:08','2020-11-04 10:58:08',NULL),(42,9,'int',0,'时间',7,'time0',1,0,'购车时间','请选择购车时间','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 10:58:08','2020-11-04 10:58:08',NULL),(43,10,'text',0,'多行文本',1,'content0',1,0,'用途1','请输入用途1','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 14:50:03','2020-11-04 14:50:03',NULL),(44,10,'varchar',255,'单行文本',0,'title0',1,0,'物品名称','请输入物品名称','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 14:50:03','2020-11-04 14:50:03',NULL),(45,10,'varchar',255,'单行文本',0,'title1',1,0,'物品数量','请输入物品数量','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 14:50:03','2020-11-04 14:50:03',NULL),(46,10,'varchar',255,'上传附件',9,'fileName0',0,0,'附件','请上传附件','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 14:50:03','2020-11-04 14:50:03',NULL),(47,11,'varchar',255,'单行文本',0,'title0',1,0,'姓名','请输入姓名','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 15:16:50','2020-11-04 15:16:50',NULL),(48,11,'char',11,'手机号',2,'phone0',1,0,'手机号','请输入手机号','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 15:16:50','2020-11-04 15:16:50',NULL),(49,11,'int',11,'整数',3,'num0',1,0,'金额','请输入金额','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 15:16:50','2020-11-04 15:16:50',NULL),(50,11,'varchar',255,'上传附件',9,'fileName0',1,0,'附件','请上传附件','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 15:16:50','2020-11-04 15:16:50',NULL),(51,12,'varchar',255,'单行文本',0,'title0',1,0,'姓名','请输入姓名','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 17:11:32','2020-11-04 17:11:32',NULL),(52,12,'char',11,'手机号',2,'phone0',0,0,'手机号','请输入手机号','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 17:11:32','2020-11-04 17:11:32',NULL),(53,12,'varchar',255,'上传附件',9,'fileName0',1,0,'手机号','请上传手机号','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 17:11:32','2020-11-04 17:11:32',NULL),(54,13,'varchar',255,'单行文本',0,'title0',1,0,'单行文本','请输入单行文本','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 17:15:36','2020-11-04 17:15:36',NULL),(55,13,'char',11,'手机号',2,'phone0',1,0,'手机号','请输入手机号','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 17:15:36','2020-11-04 17:15:36',NULL),(56,13,'varchar',255,'上传附件',9,'fileName0',1,0,'上传附件','请上传上传附件','[{\"key\":\"\",\"value\":1}]',0,'2020-11-04 17:15:36','2020-11-04 17:15:36',NULL);

#
# Structure for table "process_log"
#

DROP TABLE IF EXISTS `process_log`;
CREATE TABLE `process_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `flow_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流程id',
  `program_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '待审批项目id',
  `approval_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审批人用户id',
  `node_id` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '节点id',
  `op_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作状态：0=申请，1=已审批',
  `content` varchar(1024) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '审批备注意见',
  `files_url` varchar(1024) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '附件URL',
  `result` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0=待审核,1通过,2=驳回,3=撤回,4=通过后撤回',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flow_id` (`flow_id`),
  KEY `program_id` (`program_id`),
  KEY `approval_user_id` (`approval_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='流程管理：审批记录表';

#
# Data for table "process_log"
#

INSERT INTO `process_log` VALUES (1,4,1,5,1,1,'2020年11月4日10:53:57，驳回','',2,'2020-11-04 10:48:20','2020-11-04 10:54:05',NULL),(2,4,1,130,2,0,'','',0,'2020-11-04 10:48:20','2020-11-04 10:48:20',NULL),(3,4,1,61,3,0,'','',0,'2020-11-04 10:48:20','2020-11-04 10:48:20',NULL),(4,10,2,5,1,1,'不能通过','',2,'2020-11-04 14:58:13','2020-11-04 15:21:53',NULL),(5,10,2,6,2,1,'反对','',1,'2020-11-04 14:58:13','2020-11-04 15:38:43',NULL),(6,11,3,127,1,0,'','',0,'2020-11-04 15:17:39','2020-11-04 15:17:39',NULL),(7,11,3,3,2,0,'','',0,'2020-11-04 15:17:39','2020-11-04 15:17:39',NULL);

#
# Structure for table "process_program"
#

DROP TABLE IF EXISTS `process_program`;
CREATE TABLE `process_program` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `flow_code` varchar(64) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '流程项目编号',
  `flow_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '流程id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '申请人用户id',
  `node_now` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '当前流程节点',
  `node_total` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '节点总个数',
  `flow_node` varchar(4096) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '用户自定义的审批流程节点：json',
  `is_edit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '申请人修改中：1',
  `is_fast` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否催办1',
  `content` text COLLATE utf8mb4_unicode_ci COMMENT '填写表单的内容',
  `files_url` text COLLATE utf8mb4_unicode_ci COMMENT '附件URL',
  `check_user_id` varchar(512) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '当前审批人id',
  `check_role_id` varchar(512) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '审批角色id',
  `copy_user_id` varchar(512) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '抄送用户id：逗号分隔',
  `check_department_id` varchar(512) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '审批部门id',
  `result` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0审核中,1=通过,2=驳回,3=撤回,4=通过后撤回',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0=正常,1=删除,2=草稿',
  `is_client` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0=正常,1=已委托/移交',
  `node_tag` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '自定义节点类型:0=平台定义,1=用户自定义',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '流程等级：0正常,1一般,2紧急',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `flow_id` (`flow_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='流程管理：审批项目表';

#
# Data for table "process_program"
#

INSERT INTO `process_program` VALUES (1,'HCSQ20201104104820',4,1,2,3,'[{\"node_id\":1,\"type\":2,\"role_id\":0,\"user_id\":5,\"need\":1,\"user_name\":\"张维维12\"},{\"node_id\":2,\"type\":2,\"role_id\":0,\"user_id\":130,\"need\":1,\"user_name\":\"李白\"},{\"node_id\":3,\"type\":2,\"role_id\":0,\"user_id\":61,\"need\":1,\"user_name\":\"汪微君\"}]',0,1,'[{\"field_name\":\"title0\",\"input_id\":0,\"input_title\":\"标题\",\"must\":1,\"placeholder\":\"请输入标题\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":\"大货车一两\"},{\"field_name\":\"content0\",\"input_id\":1,\"input_title\":\"内容\",\"must\":0,\"placeholder\":\"请输入内容\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":\"大货车一两，点击开始大富科技和\\n大货车一两，22323232\\n大货车一两\"},{\"field_name\":\"timeBetween0\",\"input_id\":8,\"input_title\":\"时间\",\"must\":1,\"placeholder\":\"请选择时间\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":[\"2020-11-04\",\"2020-11-05\"]},{\"field_name\":\"checkbox0\",\"input_id\":5,\"input_title\":\"复选框\",\"must\":0,\"placeholder\":\"请选择复选框\",\"key_value\":[{\"key\":\"订单\",\"value\":1},{\"key\":\"哈哈\",\"value\":2},{\"key\":\"刚刚\",\"value\":3}],\"value\":[1,2]}]','[]','','',',126,127,','',3,0,0,0,1,'2020-11-04 10:48:20','2020-11-04 14:40:18',NULL),(2,'WPLY20201104145813',10,6,2,2,'[{\"node_id\":1,\"type\":2,\"role_id\":0,\"user_id\":5,\"need\":1,\"user_name\":\"张维维12\"},{\"node_id\":2,\"type\":2,\"role_id\":0,\"user_id\":6,\"need\":1,\"user_name\":\"马化腾\"}]',0,0,'[{\"field_name\":\"content0\",\"input_id\":1,\"input_title\":\"用途1\",\"must\":1,\"placeholder\":\"请输入用途1\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":\"更换鼠标1\"},{\"field_name\":\"title0\",\"input_id\":0,\"input_title\":\"物品名称\",\"must\":1,\"placeholder\":\"请输入物品名称\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":\"鼠标\"},{\"field_name\":\"title1\",\"input_id\":0,\"input_title\":\"物品数量\",\"must\":1,\"placeholder\":\"请输入物品数量\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":\"5\"}]','[{\"field_name\":\"fileName0\",\"input_id\":9,\"input_title\":\"附件\",\"must\":0,\"placeholder\":\"请上传附件\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":[{\"name\":\"5.jpg\",\"type\":\"image/jpeg\",\"url\":\"http://xunmumei-1302444702.cos.ap-guangzhou.myqcloud.com/img/16044731975085.jpg\"}]}]','','',',7,1,','',1,0,0,0,0,'2020-11-04 14:58:13','2020-11-04 15:38:43',NULL),(3,'CWSP20201104151739',11,5,1,2,'[{\"node_id\":1,\"type\":2,\"role_id\":0,\"user_id\":127,\"need\":1,\"user_name\":\"杨天战\"},{\"node_id\":2,\"type\":2,\"role_id\":0,\"user_id\":3,\"need\":1,\"user_name\":\"砍价靠\"}]',0,0,'[{\"field_name\":\"title0\",\"input_id\":0,\"input_title\":\"姓名\",\"must\":1,\"placeholder\":\"请输入姓名\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":\"测试A\"},{\"field_name\":\"phone0\",\"input_id\":2,\"input_title\":\"手机号\",\"must\":1,\"placeholder\":\"请输入手机号\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":\"15541254125\"},{\"field_name\":\"num0\",\"input_id\":3,\"input_title\":\"金额\",\"must\":1,\"placeholder\":\"请输入金额\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":\"600\"}]','[{\"field_name\":\"fileName0\",\"input_id\":9,\"input_title\":\"附件\",\"must\":1,\"placeholder\":\"请上传附件\",\"key_value\":[{\"key\":\"\",\"value\":1}],\"value\":[{\"name\":\"u=2456468987,3284231714&fm=26&gp=0.jpg\",\"type\":\"image/jpeg\",\"url\":\"http://xunmumei-1302444702.cos.ap-guangzhou.myqcloud.com/img/1604474257522u%3D2456468987%2C3284231714%26fm%3D26%26gp%3D0.jpg\"}]}]','','',',127,3,','',3,0,0,0,2,'2020-11-04 15:17:39','2020-11-04 17:46:55',NULL);

#
# Structure for table "process_type"
#

DROP TABLE IF EXISTS `process_type`;
CREATE TABLE `process_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `flow_name` varchar(64) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '流程类型名称',
  `remark` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '备注说明',
  `system` varchar(32) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '归属系统',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1=关闭,0=启用',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='流程管理：流程类型表';

#
# Data for table "process_type"
#

INSERT INTO `process_type` VALUES (1,'财务审批','金额超过10万需要董事长审批1','财务系统',0,'2020-10-16 16:46:54','2020-10-30 11:44:25',NULL),(2,'合同审批','','业务系统',0,'2020-10-16 17:11:21','2020-10-16 17:11:21',NULL),(4,'用车申请','用车是由必填','管理系统',0,'2020-10-16 17:12:02','2020-10-19 14:30:44',NULL),(5,'人事审批','事假超过3天需要总经理审批','人力资源管理系统',0,'2020-10-16 17:12:02','2020-10-16 17:12:02',NULL),(6,'行政管理','','管理系统',0,'2020-10-19 14:30:09','2020-10-19 14:30:09',NULL);
