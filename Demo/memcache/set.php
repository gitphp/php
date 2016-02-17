<?php
// 实例化对象
$me=new Memcache();

$me->connect('localhost','11211');
// object(Memcache)#1 (1) 
// { ["connection"]=> resource(3) of type (memcache connection) }
// var_dump($me);

$me->add('name','yangsong',0,100);
