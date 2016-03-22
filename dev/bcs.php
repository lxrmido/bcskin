<?php
define('BCS_WEBSITE_ROOT', 'http://bbs.bilicraft.io/s/');
define('BCS_LOGIN_KEY', 'bcskin-233');
define('BCS_LOGIN_API', BCS_WEBSITE_ROOT . 'method.php?m=discuz.login');

include './source/class/class_core.php';
$dz = & discuz_core::instance();
$dz->init_cron    = false;
$dz->init_session = false;
$dz->init();

header('Content-Type: application/x-javascript; charset=UTF-8');

if(empty($_G['uid'])){
	echo 'discuz_login(' . json_encode([
		'uid' => 0,
	]) . ');';
}else{
	$salt = rand(1111, 9999);
	$r = file_get_contents(BCS_LOGIN_API . '&uid=' . $_G['uid'] . '&username=' . $_G['username'] . '&salt=' . $salt . '&hash=' . md5($salt . $_G['uid'] . BCS_LOGIN_KEY));
	echo 'discuz_login(' . $r . ');';
}