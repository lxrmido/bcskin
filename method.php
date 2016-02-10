<?php
include 'global.php';

$METHOD['is_method'] = true;
#是否以JSON形式输出
$METHOD['json'] = $JSON_IO = IO::r('json', 1, 'uint') > 0;
# 方法名
$METHOD['name'] = IO::r('m', 'undefined');
$m = explode('.', $METHOD['name']);
if(count($m) !== 2){
	IO::E('所请求的方法不可用，请检查(A)。');
}
$METHOD['module'] = $m[0];
$METHOD['method'] = $m[1];
if((preg_match('/^[a-z0-9_]+$/', $METHOD['module']) !== 1) || (preg_match('/^[a-z0-9_]+$/', $METHOD['method']) !== 1)){
	$METHOD['module'] = '-Please-';
	$METHOD['method'] = '-Check-';
	IO::E('所请求的方法不可用，请检查(B)。');
}
# 获取实际文件路径
$METHOD['file'] = lx_method($METHOD['name']);
# 包含
include($METHOD['file']);