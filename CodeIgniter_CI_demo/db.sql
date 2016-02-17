-- 创建数据库
create database shop_ci charset utf8;

-- 选择数据库
use cishop;

/*------------------------------------商品模块---------------------------------------*/
-- 创建商品类别表
create table jd_category(
	c_id smallint unsigned not null auto_increment primary key comment '商品类别ID',
	c_name varchar(30) not null default '' comment '商品类别名称',
	c_pid smallint unsigned not null default 0 comment '商品类别父ID',
	c_desc varchar(255) not null default '' comment '商品类别描述',
	c_sort tinyint not null default 50 comment '排序依据',
	c_unit varchar(15) not null default '' comment '单位',
	c_show tinyint not null default 1 comment '是否显示，默认显示',
	index c_pid(c_pid)
)charset=utf8 comment '商品分类表';


-- 创建商品品牌表
create table jd_brand(
	b_id smallint unsigned not null auto_increment primary key comment '商品品牌ID',
	b_name varchar(30) not null default '' comment '商品品牌名称',
	b_desc varchar(255) not null default '' comment '商品品牌描述',
	b_url varchar(100) not null default '' comment '商品品牌网址',
	b_logo varchar(64) not null default '' comment '品牌logo',
	b_sort tinyint unsigned not null default 50 comment '商品品牌排序依据',
	b_show tinyint not null default 1 comment '是否显示，默认显示'	
)charset=utf8 comment '商品品牌表';

-- 创建商品类型表
create table jd_goods_type(
	type_id tinyint unsigned not null auto_increment primary key comment '商品类型ID',
	type_name varchar(16) not null default '' comment '商品类型名称'
)charset=utf8 comment '商品的类型表';


-- 创建商品属性表
create table jd_attribute(
	a_id smallint unsigned not null auto_increment primary key comment '商品属性ID',
	a_name varchar(50) not null default '' comment '商品属性名称',
	type_id smallint not null default 0 comment '商品属性所属类型ID',
	a_type tinyint not null default 1 comment '属性是否可选 0 为唯一，1为单选，2为多选',
	a_input_type tinyint not null default 1 comment '属性录入方式 0为手工录入，1为从列表中选择，2为文本域',
	a_value text comment '属性的值',
	a_sort tinyint not null default 50 comment '属性排序依据',
	index type_id(type_id)
)charset=utf8 comment '商品属性列表';

-- 创建商品表
create table ci_goods(
	g_id int unsigned not null auto_increment primary key comment '商品ID',
	g_sn varchar(30) not null default '' comment '商品货号',
	g_name varchar(100) not null default '' comment '商品名称',
	g_brief varchar(255) not null default '' comment '商品简单描述',
	g_desc text comment '商品详情',
	cat_id smallint unsigned not null default 0 comment '商品所属类别ID',
	brand_id smallint unsigned not null default 0 comment '商品所属品牌ID',
	market_price decimal(10,2) not null default 0 comment '市场价',
	shop_price decimal(10,2) not null default 0 comment '本店价格',
	promote_price decimal(10,2) not null default 0 comment '促销价格',
	promote_start_time int unsigned not null default 0 comment '促销起始时间',
	promote_end_time int unsigned not null default 0 comment '促销截止时间',
	g_img varchar(50) not null default '' comment '商品图片',
	g_thumb varchar(50) not null default '' comment '商品缩略图',
	g_number smallint unsigned not null default 0 comment '商品库存',
	g_click int unsigned not null default 0 comment '点击次数',
	type_id smallint unsigned not null default 0 comment '商品类型ID',
	is_promote tinyint unsigned not null default 0 comment '是否促销，默认为0不促销',
	is_best tinyint unsigned not null default 0 comment '是否精品,默认为0',
	is_new tinyint unsigned not null default 0 comment '是否新品，默认为0',
	is_hot tinyint unsigned not null default 0 comment '是否热卖,默认为0',
	is_onsale tinyint unsigned not null default 1 comment '是否上架,默认为1',
	g_addtime int unsigned not null default 0 comment '添加时间',
	index cat_id(cat_id),
	index brand_id(brand_id),
	index type_id(type_id)
)charset=utf8 comment '商品goods表';

-- 创建商品属性对应表
create table ci_goods_attr(
	ga_id int unsigned not null auto_increment primary key comment '编号ID',
	goods_id int unsigned not null default 0 comment '商品的ID',
	attr_id smallint unsigned not null default 0 comment '属性的ID',
	attr_value varchar(255) not null default '' comment '属性的值',
	attr_price decimal(10,2) not null default 0 comment '属性的价格',
	index goods_id(goods_id),
	index attr_id(attr_id)
)charset=utf8 comment '商品和属性的中间表';

-- 创建商品相册表
create table ci_galary(
	img_id int unsigned not null auto_increment primary key comment '图片编号',
	goods_id int unsigned not null default 0 comment '商品ID',
	img_url varchar(50) not null default '' comment '图片URL',
	thumb_url varchar(50) not null default '' comment '缩略图URL',
	img_desc varchar(50) not null default '' comment '图片描述',
	index goods_id(goods_id)
)engine=MyISAM charset=utf8;

/*------------------------------------商品模块 end-----------------------------------*/


/*------------------------------------用户模块---------------------------------------*/
-- 创建用户表
create table ci_user(
	user_id int unsigned not null auto_increment primary key comment '用户编号',
	user_name varchar(50) not null default '' comment '用户名',
	email varchar(50) not null default '' comment '电子邮箱',
	password char(32) not null default '' comment '用户密码,md5加密',
	reg_time int unsigned not null default 0 comment '用户注册时间'
)engine=MyISAM charset=utf8;

-- 创建用户收货地址表
create table ci_address(
	address_id int unsigned not null auto_increment primary key comment '地址编号',
	user_id int unsigned not null default 0 comment '地址所属用户ID',
	consignee varchar(60) not null default '' comment '收货人姓名',
	province smallint unsigned not null default 0 comment '省份，保存是ID',
	city smallint unsigned not null default 0 comment '市',
	district smallint unsigned not null default 0 comment '区',
	street varchar(100) not null default '' comment '街道地址',
	zipcode varchar(10) not null default '' comment '邮政编码',
	telephone varchar(20) not null default '' comment '电话',
	mobile varchar(20) not null default '' comment '移动电话',
	index user_id(user_id)
)engine=MyISAM charset=utf8;

-- 创建地区表，包括省市区三级
create table ci_region(
	region_id smallint unsigned not null auto_increment primary key comment '地区ID',
	parent_id smallint unsigned not null default 0 comment '父ID',
	region_name varchar(30) not null default '' comment '地区名称',
	region_type tinyint unsigned not null default 1 comment '地区类型 1 省份 2 市 3 区(县)'
)engine=MyISAM charset=utf8;

-- 创建购物车表
create table ci_cart(
	cart_id int unsigned not null auto_increment primary key comment '购物车ID',
	user_id int unsigned not null default 0 comment '用户ID',
	goods_id int unsigned not null default 0 comment '商品ID',
	goods_name varchar(100) not null default '' comment '商品名称',
	goods_img varchar(50) not null default '' comment '商品图片',
	goods_attr varchar(255) not null default '' comment '商品属性',
	goods_number smallint unsigned not null default 1 comment '商品数量',
	market_price decimal(10,2) not null default 0 comment '市场价格',
	goods_price decimal(10,2) not null default 0 comment '成交价格',
	subtotal decimal(10,2) not null default 0 comment '小计'
)engine=MyISAM charset=utf8;
/*------------------------------------用户模块 end-----------------------------------*/




/*------------------------------------订单模块---------------------------------------*/
-- 创建送货方式表
create table ci_shipping(
	shipping_id tinyint unsigned not null auto_increment primary key comment '编号',
	shipping_name varchar(30) not null default '' comment '送货方式名称',
	shipping_desc varchar(255) not null default '' comment '送货方式描述',
	shipping_fee decimal(10,2) not null default 0 comment '送货费用',
	enabled tinyint unsigned not null default 1 comment '是否启用，默认启用'
)engine=MyISAM charset=utf8;


-- 创建支付方式表
create table ci_payment(
	pay_id tinyint unsigned not null auto_increment primary key comment '支付方式ID',
	pay_name varchar(30) not null default '' comment '支付方式名称',
	pay_desc varchar(255) not null default '' comment '支付方式描述',
	enabled tinyint unsigned not null default 1 comment '是否启用，默认启用'
)engine=MyISAM charset=utf8;


-- 创建订单表
create table ci_order(
	order_id int unsigned not null auto_increment primary key comment '订单ID',
	order_sn varchar(30) not null default '' comment '订单号',
	user_id int unsigned not null default 0 comment '用户ID',
	address_id int unsigned not null default 0 comment '收货地址id',
	order_status tinyint unsigned not null default 0 comment '订单状态 1 待付款 2 待发货 3 已发货 4 已完成',
	postscripts varchar(255) not null default '' comment '订单附言',
	shipping_id tinyint not null default 0 comment '送货方式ID',
	pay_id tinyint not null default 0 comment '支付方式ID',
	goods_amount decimal(10,2) not null default 0 comment '商品总金额',
	order_amount decimal(10,2) not null default 0 comment '订单总金额',
	order_time int unsigned not null default 0 comment '下单时间',
	index user_id(user_id),
	index address_id(address_id),
	index pay_id(pay_id),
	index shipping_id(shipping_id)
)engine=MyISAM charset=utf8;


-- 创建订单明细表,即商品订单关系表（多对多）
create table ci_order_goods(
	rec_id int unsigned not null auto_increment primary key comment '编号',
	order_id int unsigned not null default 0 comment '订单ID',
	goods_id int unsigned not null default 0 comment '商品ID',
	goods_name varchar(100) not null default '' comment '商品名称',
	goods_img varchar(50) not null default '' comment '商品图片',
	shop_price decimal(10,2) not null default 0 comment '商品价格',
	goods_price decimal(10,2) not null default 0 comment '成交价格',
	goods_number smallint unsigned not null default 1 comment '购买数量',
	goods_attr varchar(255) not null default '' comment '商品属性',
	subtotal decimal(10,2) not null default 0 comment '商品小计'
)engine=MyISAM charset=utf8;

/*------------------------------------订单模块 end-----------------------------------*/



-- 创建后台管理员表
create table ci_admin(
	a_id smallint unsigned not null auto_increment primary key comment '管理员编号',
	a_username varchar(30) not null default '' comment '管理员名称',
	a_password char(32) not null default '' comment '管理员密码',
	a_email varchar(50) not null default '' comment '管理员邮箱',
	a_addtime int unsigned not null default 0 comment '添加时间'
)charset=utf8 comment '后台管理员表';

-- 插入一条记录作为管理员
insert into ci_admin(a_username,a_password,a_email) values('admin','21232f297a57a5a743894a0e4a801fc3','admin@itcast.cn');
insert into ci_admin(a_username,a_password,a_email) values('admin','admin','admin@itcast.cn');



-- 类别部分，先插入部分数据，做测试
insert into ci_category(c_name,c_pid) values('手机类型',0);
insert into ci_category(c_name,c_pid) values('充值卡',0);
insert into ci_category(c_name,c_pid) values('手机配件',0);
insert into ci_category(c_name,c_pid) values('CDMA手机',1);
insert into ci_category(c_name,c_pid) values('3G手机',1);
insert into ci_category(c_name,c_pid) values('iphone 4s',5);
insert into ci_category(c_name,c_pid) values('联通手机充值卡',2);
insert into ci_category(c_name,c_pid) values('移动手机充值卡',2);
insert into ci_category(c_name,c_pid) values('耳机',3);
insert into ci_category(c_name,c_pid) values('电池',3);




-- cms--------------------

create table cms_fields(
      id smallint primary key auto_increment,
      model_id tinyint not null comment '模型的id',
      f_ename varchar(32) not null comment '英文名称',
      f_cname varchar(32) not null comment '中文名称',
      f_type varchar(32) not null comment '字段的类型',
      f_value varchar(32) not null comment '字段的默认值'
)charset utf8 comment '字段表';


-- 抽奖表
create table jd_huodong(
id smallint unsigned primary key auto_increment,
username varchar(32) not null comment'用户名字',
sex char(3) not null default '男' comment '性别',
tel char(11) not null default '' comment'电话信息',
email varchar(32) not null default '' comment '邮箱',
address varchar(64) not null default '' comment '地址信息',
status tinyint not null default 0 comment '0=未抽奖，1,2,3=中奖',
user_id smallint not null comment '会员id'
)charset utf8 comment '前台抽奖信息表';

-- 文章类型表
create table jd_arctype(
id tinyint unsigned primary key auto_increment,
type_name varchar(32) not null comment '分类名字',
parent_id tinyint unsigned comment '父类id',
arcurl varchar(64) not null default '' comment '文章链接地址'
)charset utf8 comment '文章分类表';

insert into jd_arctype values(null,'特色服务',0,''); -- 1
insert into jd_arctype values(null,'夺宝岛',27,''); -- 1
insert into jd_arctype values(null,'DIY装机',27,''); -- 1
insert into jd_arctype values(null,'延保服务',27,''); -- 1
insert into jd_arctype values(null,'家电下乡',27,''); -- 1
insert into jd_arctype values(null,'聚鹿礼品卡',27,''); -- 1
insert into jd_arctype values(null,'能效补贴',27,''); -- 7



















