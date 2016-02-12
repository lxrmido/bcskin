<?php

$dz_uid  = IO::I('uid', null, 'uint');
$auth = IO::I('auth', null, 'uint');

$r = DZLogin::get($dz_uid);

if(!$r){
	IO::E('登陆失败，请重试');
}

if($r['auth'] != $auth){
	IO::E('验证信息已过期，请重试');
}

if(empty($r['uid'])){
	IO::O([
		'uid' => 0
	]);
}else{
	$u = User::get_user_by_id($r['uid']);
	User::set_login($u, true);
	User::update_basic([
		'lastlogin' => time(),
		'lastip' => empty($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["REMOTE_ADDR"] : $_SERVER["HTTP_X_FORWARDED_FOR"]
	], $u['id']);
	IO::O([
		'uid' => $u['id']
	]);
}