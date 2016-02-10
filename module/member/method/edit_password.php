<?php

import('vericode');

$u = User::get_login();

if(!$u){
	IO::E('请先登录');
}

$old_pass = User::make_pass(IO::I('old_pass'), $u['salt']);

$new_pass = User::make_pass(IO::I('new_pass'), $u['salt']);

if(empty($new_pass)){
	IO::E('请输入新密码');
}

if(!SimpleCode::check_code(IO::I('vericode'))){
	IO::E('验证码错误');
}

SimpleCode::flush_code();

if($old_pass != $u['password']){
	IO::E('旧密码有误，请检查');
}


if(User::update_basic([
	'password' => $new_pass
], $u['id'])){
	IO::O();
}else{
	IO::E('修改失败，请稍后重试');
}