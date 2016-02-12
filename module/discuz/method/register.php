<?php

$dz_uid  = IO::I('dz_uid', null, 'uint');
$auth = IO::I('auth', null, 'uint');

$username = IO::I('username');
$password = IO::I('password');

$r = DZLogin::get($dz_uid);

if(!$r){
	IO::E('注册失败，请重试');
}

if($r['auth'] != $auth){
	IO::E('验证信息已过期，请重试');
}

$time = time();
$data = array(
    'username'   => $username,
    'email'      => $username . '@fa.ke',
    'password'   => $password,
    'regdate'    => $time,
    'lastlogin'  => $time,
    'group'      => 2,
    'logintimes' => 3,
    'lastip'     => ''
);

switch(User::check_insert($data)){
    case CODE_USERNAME_USED:
        IO::E('此用户名已被使用');
        break;
    case CODE_EMAIL_USED:
        IO::E('此邮箱已被使用');
        break;
    default:
        $data['salt'] = User::make_salt();
        $data['password'] = User::make_pass($data['password'], $data['salt']);
        if(User::insert($data)){
            $u = User::check_login($username, $password);
            User::set_login($u, true);
            IO::O();
        }else{
            IO::E('注册出错，请稍后重试');
        }
        break;
}