<?php

$u = User::get_login();

if(!$u){
	IO::E('请先登录');
}

$email = IO::I('email');

if(!IO::match_email($email)){
	IO::E('请输入合法的邮箱地址');
}

if(User::get_user_by_email($email)){
	IO::E('该邮箱已被使用');
}

if(User::update_basic([
	'email' => $email
], $u['id'])){
	IO::O();
}else{
	IO::E('修改失败，请稍后重试');
}