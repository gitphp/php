-- �������ݿ�
create database shop_ci charset utf8;

-- ѡ�����ݿ�
use cishop;

/*------------------------------------��Ʒģ��---------------------------------------*/
-- ������Ʒ����
create table jd_category(
	c_id smallint unsigned not null auto_increment primary key comment '��Ʒ���ID',
	c_name varchar(30) not null default '' comment '��Ʒ�������',
	c_pid smallint unsigned not null default 0 comment '��Ʒ���ID',
	c_desc varchar(255) not null default '' comment '��Ʒ�������',
	c_sort tinyint not null default 50 comment '��������',
	c_unit varchar(15) not null default '' comment '��λ',
	c_show tinyint not null default 1 comment '�Ƿ���ʾ��Ĭ����ʾ',
	index c_pid(c_pid)
)charset=utf8 comment '��Ʒ�����';


-- ������ƷƷ�Ʊ�
create table jd_brand(
	b_id smallint unsigned not null auto_increment primary key comment '��ƷƷ��ID',
	b_name varchar(30) not null default '' comment '��ƷƷ������',
	b_desc varchar(255) not null default '' comment '��ƷƷ������',
	b_url varchar(100) not null default '' comment '��ƷƷ����ַ',
	b_logo varchar(64) not null default '' comment 'Ʒ��logo',
	b_sort tinyint unsigned not null default 50 comment '��ƷƷ����������',
	b_show tinyint not null default 1 comment '�Ƿ���ʾ��Ĭ����ʾ'	
)charset=utf8 comment '��ƷƷ�Ʊ�';

-- ������Ʒ���ͱ�
create table jd_goods_type(
	type_id tinyint unsigned not null auto_increment primary key comment '��Ʒ����ID',
	type_name varchar(16) not null default '' comment '��Ʒ��������'
)charset=utf8 comment '��Ʒ�����ͱ�';


-- ������Ʒ���Ա�
create table jd_attribute(
	a_id smallint unsigned not null auto_increment primary key comment '��Ʒ����ID',
	a_name varchar(50) not null default '' comment '��Ʒ��������',
	type_id smallint not null default 0 comment '��Ʒ������������ID',
	a_type tinyint not null default 1 comment '�����Ƿ��ѡ 0 ΪΨһ��1Ϊ��ѡ��2Ϊ��ѡ',
	a_input_type tinyint not null default 1 comment '����¼�뷽ʽ 0Ϊ�ֹ�¼�룬1Ϊ���б���ѡ��2Ϊ�ı���',
	a_value text comment '���Ե�ֵ',
	a_sort tinyint not null default 50 comment '������������',
	index type_id(type_id)
)charset=utf8 comment '��Ʒ�����б�';

-- ������Ʒ��
create table ci_goods(
	g_id int unsigned not null auto_increment primary key comment '��ƷID',
	g_sn varchar(30) not null default '' comment '��Ʒ����',
	g_name varchar(100) not null default '' comment '��Ʒ����',
	g_brief varchar(255) not null default '' comment '��Ʒ������',
	g_desc text comment '��Ʒ����',
	cat_id smallint unsigned not null default 0 comment '��Ʒ�������ID',
	brand_id smallint unsigned not null default 0 comment '��Ʒ����Ʒ��ID',
	market_price decimal(10,2) not null default 0 comment '�г���',
	shop_price decimal(10,2) not null default 0 comment '����۸�',
	promote_price decimal(10,2) not null default 0 comment '�����۸�',
	promote_start_time int unsigned not null default 0 comment '������ʼʱ��',
	promote_end_time int unsigned not null default 0 comment '������ֹʱ��',
	g_img varchar(50) not null default '' comment '��ƷͼƬ',
	g_thumb varchar(50) not null default '' comment '��Ʒ����ͼ',
	g_number smallint unsigned not null default 0 comment '��Ʒ���',
	g_click int unsigned not null default 0 comment '�������',
	type_id smallint unsigned not null default 0 comment '��Ʒ����ID',
	is_promote tinyint unsigned not null default 0 comment '�Ƿ������Ĭ��Ϊ0������',
	is_best tinyint unsigned not null default 0 comment '�Ƿ�Ʒ,Ĭ��Ϊ0',
	is_new tinyint unsigned not null default 0 comment '�Ƿ���Ʒ��Ĭ��Ϊ0',
	is_hot tinyint unsigned not null default 0 comment '�Ƿ�����,Ĭ��Ϊ0',
	is_onsale tinyint unsigned not null default 1 comment '�Ƿ��ϼ�,Ĭ��Ϊ1',
	g_addtime int unsigned not null default 0 comment '���ʱ��',
	index cat_id(cat_id),
	index brand_id(brand_id),
	index type_id(type_id)
)charset=utf8 comment '��Ʒgoods��';

-- ������Ʒ���Զ�Ӧ��
create table ci_goods_attr(
	ga_id int unsigned not null auto_increment primary key comment '���ID',
	goods_id int unsigned not null default 0 comment '��Ʒ��ID',
	attr_id smallint unsigned not null default 0 comment '���Ե�ID',
	attr_value varchar(255) not null default '' comment '���Ե�ֵ',
	attr_price decimal(10,2) not null default 0 comment '���Եļ۸�',
	index goods_id(goods_id),
	index attr_id(attr_id)
)charset=utf8 comment '��Ʒ�����Ե��м��';

-- ������Ʒ����
create table ci_galary(
	img_id int unsigned not null auto_increment primary key comment 'ͼƬ���',
	goods_id int unsigned not null default 0 comment '��ƷID',
	img_url varchar(50) not null default '' comment 'ͼƬURL',
	thumb_url varchar(50) not null default '' comment '����ͼURL',
	img_desc varchar(50) not null default '' comment 'ͼƬ����',
	index goods_id(goods_id)
)engine=MyISAM charset=utf8;

/*------------------------------------��Ʒģ�� end-----------------------------------*/


/*------------------------------------�û�ģ��---------------------------------------*/
-- �����û���
create table ci_user(
	user_id int unsigned not null auto_increment primary key comment '�û����',
	user_name varchar(50) not null default '' comment '�û���',
	email varchar(50) not null default '' comment '��������',
	password char(32) not null default '' comment '�û�����,md5����',
	reg_time int unsigned not null default 0 comment '�û�ע��ʱ��'
)engine=MyISAM charset=utf8;

-- �����û��ջ���ַ��
create table ci_address(
	address_id int unsigned not null auto_increment primary key comment '��ַ���',
	user_id int unsigned not null default 0 comment '��ַ�����û�ID',
	consignee varchar(60) not null default '' comment '�ջ�������',
	province smallint unsigned not null default 0 comment 'ʡ�ݣ�������ID',
	city smallint unsigned not null default 0 comment '��',
	district smallint unsigned not null default 0 comment '��',
	street varchar(100) not null default '' comment '�ֵ���ַ',
	zipcode varchar(10) not null default '' comment '��������',
	telephone varchar(20) not null default '' comment '�绰',
	mobile varchar(20) not null default '' comment '�ƶ��绰',
	index user_id(user_id)
)engine=MyISAM charset=utf8;

-- ��������������ʡ��������
create table ci_region(
	region_id smallint unsigned not null auto_increment primary key comment '����ID',
	parent_id smallint unsigned not null default 0 comment '��ID',
	region_name varchar(30) not null default '' comment '��������',
	region_type tinyint unsigned not null default 1 comment '�������� 1 ʡ�� 2 �� 3 ��(��)'
)engine=MyISAM charset=utf8;

-- �������ﳵ��
create table ci_cart(
	cart_id int unsigned not null auto_increment primary key comment '���ﳵID',
	user_id int unsigned not null default 0 comment '�û�ID',
	goods_id int unsigned not null default 0 comment '��ƷID',
	goods_name varchar(100) not null default '' comment '��Ʒ����',
	goods_img varchar(50) not null default '' comment '��ƷͼƬ',
	goods_attr varchar(255) not null default '' comment '��Ʒ����',
	goods_number smallint unsigned not null default 1 comment '��Ʒ����',
	market_price decimal(10,2) not null default 0 comment '�г��۸�',
	goods_price decimal(10,2) not null default 0 comment '�ɽ��۸�',
	subtotal decimal(10,2) not null default 0 comment 'С��'
)engine=MyISAM charset=utf8;
/*------------------------------------�û�ģ�� end-----------------------------------*/




/*------------------------------------����ģ��---------------------------------------*/
-- �����ͻ���ʽ��
create table ci_shipping(
	shipping_id tinyint unsigned not null auto_increment primary key comment '���',
	shipping_name varchar(30) not null default '' comment '�ͻ���ʽ����',
	shipping_desc varchar(255) not null default '' comment '�ͻ���ʽ����',
	shipping_fee decimal(10,2) not null default 0 comment '�ͻ�����',
	enabled tinyint unsigned not null default 1 comment '�Ƿ����ã�Ĭ������'
)engine=MyISAM charset=utf8;


-- ����֧����ʽ��
create table ci_payment(
	pay_id tinyint unsigned not null auto_increment primary key comment '֧����ʽID',
	pay_name varchar(30) not null default '' comment '֧����ʽ����',
	pay_desc varchar(255) not null default '' comment '֧����ʽ����',
	enabled tinyint unsigned not null default 1 comment '�Ƿ����ã�Ĭ������'
)engine=MyISAM charset=utf8;


-- ����������
create table ci_order(
	order_id int unsigned not null auto_increment primary key comment '����ID',
	order_sn varchar(30) not null default '' comment '������',
	user_id int unsigned not null default 0 comment '�û�ID',
	address_id int unsigned not null default 0 comment '�ջ���ַid',
	order_status tinyint unsigned not null default 0 comment '����״̬ 1 ������ 2 ������ 3 �ѷ��� 4 �����',
	postscripts varchar(255) not null default '' comment '��������',
	shipping_id tinyint not null default 0 comment '�ͻ���ʽID',
	pay_id tinyint not null default 0 comment '֧����ʽID',
	goods_amount decimal(10,2) not null default 0 comment '��Ʒ�ܽ��',
	order_amount decimal(10,2) not null default 0 comment '�����ܽ��',
	order_time int unsigned not null default 0 comment '�µ�ʱ��',
	index user_id(user_id),
	index address_id(address_id),
	index pay_id(pay_id),
	index shipping_id(shipping_id)
)engine=MyISAM charset=utf8;


-- ����������ϸ��,����Ʒ������ϵ����Զࣩ
create table ci_order_goods(
	rec_id int unsigned not null auto_increment primary key comment '���',
	order_id int unsigned not null default 0 comment '����ID',
	goods_id int unsigned not null default 0 comment '��ƷID',
	goods_name varchar(100) not null default '' comment '��Ʒ����',
	goods_img varchar(50) not null default '' comment '��ƷͼƬ',
	shop_price decimal(10,2) not null default 0 comment '��Ʒ�۸�',
	goods_price decimal(10,2) not null default 0 comment '�ɽ��۸�',
	goods_number smallint unsigned not null default 1 comment '��������',
	goods_attr varchar(255) not null default '' comment '��Ʒ����',
	subtotal decimal(10,2) not null default 0 comment '��ƷС��'
)engine=MyISAM charset=utf8;

/*------------------------------------����ģ�� end-----------------------------------*/



-- ������̨����Ա��
create table ci_admin(
	a_id smallint unsigned not null auto_increment primary key comment '����Ա���',
	a_username varchar(30) not null default '' comment '����Ա����',
	a_password char(32) not null default '' comment '����Ա����',
	a_email varchar(50) not null default '' comment '����Ա����',
	a_addtime int unsigned not null default 0 comment '���ʱ��'
)charset=utf8 comment '��̨����Ա��';

-- ����һ����¼��Ϊ����Ա
insert into ci_admin(a_username,a_password,a_email) values('admin','21232f297a57a5a743894a0e4a801fc3','admin@itcast.cn');
insert into ci_admin(a_username,a_password,a_email) values('admin','admin','admin@itcast.cn');



-- ��𲿷֣��Ȳ��벿�����ݣ�������
insert into ci_category(c_name,c_pid) values('�ֻ�����',0);
insert into ci_category(c_name,c_pid) values('��ֵ��',0);
insert into ci_category(c_name,c_pid) values('�ֻ����',0);
insert into ci_category(c_name,c_pid) values('CDMA�ֻ�',1);
insert into ci_category(c_name,c_pid) values('3G�ֻ�',1);
insert into ci_category(c_name,c_pid) values('iphone 4s',5);
insert into ci_category(c_name,c_pid) values('��ͨ�ֻ���ֵ��',2);
insert into ci_category(c_name,c_pid) values('�ƶ��ֻ���ֵ��',2);
insert into ci_category(c_name,c_pid) values('����',3);
insert into ci_category(c_name,c_pid) values('���',3);




-- cms--------------------

create table cms_fields(
      id smallint primary key auto_increment,
      model_id tinyint not null comment 'ģ�͵�id',
      f_ename varchar(32) not null comment 'Ӣ������',
      f_cname varchar(32) not null comment '��������',
      f_type varchar(32) not null comment '�ֶε�����',
      f_value varchar(32) not null comment '�ֶε�Ĭ��ֵ'
)charset utf8 comment '�ֶα�';


-- �齱��
create table jd_huodong(
id smallint unsigned primary key auto_increment,
username varchar(32) not null comment'�û�����',
sex char(3) not null default '��' comment '�Ա�',
tel char(11) not null default '' comment'�绰��Ϣ',
email varchar(32) not null default '' comment '����',
address varchar(64) not null default '' comment '��ַ��Ϣ',
status tinyint not null default 0 comment '0=δ�齱��1,2,3=�н�',
user_id smallint not null comment '��Աid'
)charset utf8 comment 'ǰ̨�齱��Ϣ��';

-- �������ͱ�
create table jd_arctype(
id tinyint unsigned primary key auto_increment,
type_name varchar(32) not null comment '��������',
parent_id tinyint unsigned comment '����id',
arcurl varchar(64) not null default '' comment '�������ӵ�ַ'
)charset utf8 comment '���·����';

insert into jd_arctype values(null,'��ɫ����',0,''); -- 1
insert into jd_arctype values(null,'�ᱦ��',27,''); -- 1
insert into jd_arctype values(null,'DIYװ��',27,''); -- 1
insert into jd_arctype values(null,'�ӱ�����',27,''); -- 1
insert into jd_arctype values(null,'�ҵ�����',27,''); -- 1
insert into jd_arctype values(null,'��¹��Ʒ��',27,''); -- 1
insert into jd_arctype values(null,'��Ч����',27,''); -- 7



















