-- RBAC
create database cms_tp charset utf8;
use cms_tp;
set names gbk;

-- 用户表---------------------表1
create table cms_admin(
a_id tinyint unsigned primary key auto_increment,
a_username varchar(32) not null comment '用户名',
a_password char(32) not null comment '密码',
a_salt char(10) not null default 'yaso8848' comment '密码的秘钥'
)charset utf8 comment '后台用户表';
-- test data,super admin
insert into cms_admin values(null,'admin','4f1c83ac88e52d209264c273a7bc15cb','yaso8848');

-- 角色表--------------------表2
create table cms_role(
r_id tinyint unsigned primary key auto_increment,
r_name varchar(32) not null comment '角色名字'
)charset utf8 comment '用户角色表';

-- 权限表---------------------表3
create table cms_auth(
p_id tinyint unsigned primary key auto_increment,
p_name varchar(30) not null comment '权限名字',
p_pid tinyint unsigned not null default 0 comment '父id',
p_cname varchar(32) not null default '' comment '控制器名',
p_aname varchar(32) not null default '' comment '方法名字'
)charset utf8 comment '后台权限表';

-- 用户+角色 （中间表）---------表4
create table cms_user_role(
user_id tinyint unsigned not null comment '用户id',
role_id tinyint unsigned not null comment '角色id',
key (user_id),
key (role_id)
)charset utf8 comment '用户+角色(中间表)';
-- 角色+权限 （中间表）---------表5
create table cms_auth_role(
auth_id tinyint unsigned not null comment '权限id',
role_id tinyint unsigned not null comment '角色id',
index (auth_id),
index (role_id)
)charset utf8 comment '权限+角色(中间表)';

