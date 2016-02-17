<?php

$me=new Memcache();

$me->connect('localhost','11211');

$a=$me->get('name');

// echo $a;
var_dump($a);