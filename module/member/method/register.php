<?php
$code     = IO::I('code');
$username = IO::I('username');
$email    = IO::I('email');
$password = IO::I('password');

import('vericode');
if(!SimpleCode::check_code($code)){
    IO::E(-1, '验证码不正确！');
}

$time = time();
$data = array(
    'username'   => $username,
    'email'      => $email,
    'password'   => $password,
    'regdate'    => $time,
    'lastlogin'  => $time,
    'group'      => 2,
    'logintimes' => 3,
    'lastip'     => ''
);

switch(User::check_insert($data)){
    case CODE_USERNAME_USED:
        IO::E(CODE_USERNAME_USED, '此用户名已被使用');
        break;
    case CODE_EMAIL_USED:
        IO::E(CODE_EMAIL_USED, '此邮箱已被使用');
        break;
    default:
        $data['salt'] = User::make_salt();
        $data['password'] = User::make_pass($data['password'], $data['salt']);
        if(User::insert($data)){
            SimpleCode::flush_code();
            $u = User::check_login($username, $password);
            User::set_login($u, false);
            IO::O();
        }else{
            IO::E(-1, '注册出错，请稍后重试');
        }
        break;
}