<?php

$username = IO::I('username');
$email    = IO::I('email');
$password = IO::I('password');
$group    = IO::I('group', 3, 'uint');

if(User::get_user_by_name($username)){
	IO::E('用户名已被使用');
}

if(User::get_user_by_email($email)){
	IO::E('邮箱已被使用');
}

$r = User::add_user(array(
	'username' => $username,
	'email'    => $email,
	'password' => $password,
	'group'    => $group
));

if(!$r){
	IO::E('添加失败，请稍后重试');
}else{
	IO::O();
}