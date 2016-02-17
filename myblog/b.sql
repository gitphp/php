
create database yang_blog charset utf8;
use yang_blog
-- 1、文章数据表 前缀bk_
create table bk_article(
	id mediumint unsigned not null primary key auto_increment,
	title varchar(128) not null default '' comment '文章标题',
	author varchar(32) not null default '' comment '文章作者',
	content text not null comment '文章内容',
	keywords varchar(255) not null default '' comment '文章关键字seo',
	remark varchar(255) not null default '' comment '简单描述description',
	arc_pic varchar(128) NOT NULL default '' COMMENT '文章图片',
	type_id smallint unsigned not null default 0 comment '文章分类ID',
	add_ip char(15) NOT NULL default '' COMMENT '添加IP',
	addtime int unsigned not null default 0 comment '添加时间',
	edittime int unsigned not null default 0 comment '修改时间',
	sort smallint unsigned not null default 100 comment '文章排序',
	is_bold tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否加粗显示',
	is_tj tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否博主推荐',
	arc_click mediumint(8) unsigned NOT NULL DEFAULT '99' COMMENT '日志点击数',
	status tinyint(1) unsigned not null default 1 comment '是否展示0=不展示|1=展示',
	index (`type_id`),
	index (`addtime`),
	index (`is_bold`),
	index (`is_tj`)
)charset utf8 comment '文章数据表';


-- 2、文章分类表
create table bk_category(
	id smallint unsigned not null primary key auto_increment,
	catname varchar(64) not null default '' comment '文章分类名称',
	p_id smallint unsigned not null comment '父级ID',
	remark varchar(128) not null default '' comment '简单描述',
	index (`p_id`)
)charset utf8 comment '文章分类表';

-- 3、用户表
create table bk_user(
	id smallint unsigned not null primary key auto_increment,
	username varchar(64) not null default '' comment '用户登陆名',
	password char(32) not null comment '登陆密码',
	usernice varchar(64) not null comment '用户昵称',
	real_name varchar(32) not null comment '用户真实名字',
	user_email varchar(128) not null default '' comment '用户邮箱',
	user_tel char(11) not null default '' comment '用户手机',
	user_qq varchar(12) not null default '' comment '用户QQ',
	user_pic varchar(128) not null default '' comment '用户头像url',
	user_sex tinyint(1) unsigned not null default '0' comment '性别1=男|2=女',
	createtime int unsigned not null default 0 comment '注册时间',
	login_time int unsigned not null default 0 comment '最后登陆时间',
	login_ip char(15) not null default '' comment '最后登陆IP',
	role_id tinyint NOT NULL DEFAULT '0' COMMENT '角色0=前台用户|99=后台管理员',
	userstatus tinyint(1) not null default 0 comment '登陆状态0下线|1在线'
)charset utf8 comment '博客用户表';


insert into bk_user values 
(null,'youngsong',md5('yaso8848'),'Object、','杨松','4873473@qq.com','18811888504',4873473,'',1,1444444444,1444444444,'',99,1);

-- 4、留言表
create table bk_message(
	id mediumint unsigned primary key auto_increment,
	user_id smallint unsigned not null default 0 comment '留言用户Id',
	content varchar(2048) not null default '' comment '留言内容',
	createtime int unsigned not null default 0 comment '留言时间',
	mess_ip char(15) NOT NULL default '' COMMENT '留言IP地址',
	mess_status tinyint(1) unsigned not null default 1 comment '1=显示|0=不显示',
	reply_status tinyint(1) unsigned not null default 0 comment '0=未回复|1=已回复',
	count_zan smallint unsigned not null default 0 comment '赞的个数',
	index (`reply_status`)
)charset utf8 comment '用户留言表';


-- 5、评论表
create table bk_comment(
	id smallint unsigned not null primary key auto_increment,
	user_id mediumint unsigned not null default 0 comment '评论用户Id',
	content varchar(2048) not null default '' comment '评论内容',
	createtime int unsigned not null default 0 comment '评论时间',
	mess_status tinyint(1) unsigned not null default 1 comment '1=显示|0=不显示',
	reply_status tinyint(1) unsigned not null default 0 comment '0=未回复|1=已回复',
	index (`reply_status`)
)charset utf8 comment '文章评论表';


-- 6、广告表
create table bk_ad(
	id smallint unsigned primary key auto_increment,
	ad_name varchar(64) not null default '' comment '广告名字',
	img_url varchar(150) NOT NULL DEFAULT '' COMMENT '广告的图片地址',
	ad_link varchar(150) NOT NULL DEFAULT '' COMMENT '广告的链接地址'
)charset utf8 comment '广告表';


-- 7、相册图片表
create table bk_photo(
	id smallint unsigned primary key auto_increment,
	pic_name varchar(64) not null default '' comment '图片名字',
	pic_url varchar(128) not null default '' comment '图片url地址',
	xc_id tinyint unsigned not null default 0 comment '相册的id',
	addtime int unsigned not null default 0 comment '添加时间',
	index (`xc_id`)
)charset utf8 comment '相册图片表';

-- 10、相册表
create table bk_xiangce(
	id tinyint unsigned primary key auto_increment,
	xc_name varchar(64) not null default '' comment '相册名字',
	xc_desc varchar(255) not null default '' comment '相册描述',
	addtime int unsigned not null default 0 comment '添加时间'
)charset utf8 comment '相册表';

-- 8、分享链接表
create table bk_links(
	id tinyint unsigned primary key auto_increment,
	link_url varchar(128) not null default '' comment 'url地址',
	link_name varchar(64) not null default '' comment 'url名字',
	pic_url varchar(128) not null default '' comment '图片地址',
	link_target tinyint(1) unsigned not null default 0 comment '打开方式',
	link_desc varchar(255) not null default '' comment '链接描述',
	is_show tinyint(1) not null default 1 comment '是否显示',
	start_time int unsigned NOT NULL default 0 COMMENT '开通时间',
	end_time int unsigned NOT NULL default 0 COMMENT '到期时间',
	index (`is_show`)
)charset utf8 comment '友情链接表';

-- 9、回复表
create table bk_huifu(
	id smallint unsigned primary key auto_increment,
	content varchar(1024) not null default '' comment '回复内容',
	hui_time int unsigned not null default 0 comment '回复时间',
	user_id smallint unsigned not null default 0 comment '用户id',
	mess_id mediumint unsigned not null default 0 comment '留言id',
	index (`mess_id`)
)charset utf8 comment '主人回复表';

-- 11、个人说说表
create table bk_shuo(
	id mediumint unsigned primary key auto_increment,
	content varchar(1024) not null default '' comment '说说内容',
	img_url varchar(128) not null default '' comment '图片地址',
	addtime int unsigned not null default 0 comment '添加时间'
)charset utf8 comment '个人说说表';


-- 12、网站配置表
CREATE TABLE `bk_config` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `weblogo` varchar(128) NOT NULL default '' COMMENT '网站logo',
  `webname` varchar(64) NOT NULL default '' COMMENT '网站名称',
  `webtitle` varchar(128) NOT NULL default '' COMMENT '网站标题',
  `webkeys` varchar(255) NOT NULL default '' COMMENT '网站关键字',
  `webdesc` varchar(1024) NOT NULL default '' COMMENT '网站描述',
  `dredgetime` int unsigned NOT NULL default 0 COMMENT '开通时间',
  PRIMARY KEY (`id`)
)DEFAULT CHARSET=utf8 COMMENT='网站配置表';


-- 13、许愿墙表
create table bk_wish(
	id mediumint unsigned primary key auto_increment,
	username varchar(64) not null default '游客路人甲' comment '许愿人',
	content varchar(1024) not null default '' comment '许愿内容',
	addtime int unsigned not null default 0 comment '许愿时间',
	user_ip char(15) not null default '127.0.0.1' comment '留言者的ip'
)charset utf8 comment '愿望表';


-- 14、banner文字
CREATE TABLE bk_tou (
	id smallint unsigned primary key auto_increment,
	msg1 varchar(32) not null default '' comment '第一句不过超过11字',
	msg2 varchar(32) not null default '' comment '第二句',
	msg3 varchar(32) not null default '' comment '第三句',
	ctime int unsigned not null default 0 comment '添加时间',
	key `ctime`(`ctime`)
)CHARSET utf8 comment '首页banner三句话';

insert into bk_tou value(null,'我们不停的翻弄着回忆','却再也找不回那时的自己','努力向前，我还是我',1449999999);





















