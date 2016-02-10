<?php

$account  = IO::I('account');
$password = IO::I('password');
$code     = IO::I('code');
$keep     = (IO::I('keep', null, 'uint') == 1);

import('vericode');
if(!SimpleCode::check_code($code)){
    IO::E(-1, '验证码不正确！');
}

$u = User::check_login($account, $password);
if($u == false){
    IO::E(-2, '用户名或密码输入有误');
}
User::set_login($u, $keep);
User::update_basic([
	'lastlogin' => time(),
	'lastip' => empty($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["REMOTE_ADDR"] : $_SERVER["HTTP_X_FORWARDED_FOR"]
], $u['id']);
IO::O();