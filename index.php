<?php

/**
 * F3框架入口
 * 与F2合并时注意ORM兼容性
 */

include_once 'global.php';

$c = IO::I('c', 'member');
$a = IO::I('a', 'main');

$_RG['PG_C'] = $c;
$_RG['PG_A'] = $a;

$_RG['PG_GET'] = $_GET;


if(lx_module($c, $a) === false){
	IO::E('找不到此页面');
}