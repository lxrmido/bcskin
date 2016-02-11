<?php

$uid      = IO::I('uid', null, 'uint');
$username = IO::I('username');
$email    = IO::I('email');
$password = IO::I('password');

$u = User::get_user_by_id($uid);
if(empty($u['id'])){
	IO::E('所选择的用户不可用！');
}
if(empty($username)){
	IO::E('请输入用户名');
}
if(empty($email)){
	IO::E('请输入邮箱地址');
}
if(($uo = User::get_user_by_name($username)) !== false){
	if($uo['id'] == $u['id']){

	}else{
		IO::E('用户名已被使用！');
	}
}

if(($uo = User::get_user_by_email($email)) !== false){
	if($uo['id'] == $u['id']){

	}else{
		IO::E('邮箱已被使用！');
	}
}
$data = [
	'username' => $username,
	'email'    => $email
];

if(!empty($password)){
	$data['password'] = User::make_pass($password, $u['salt']);
}

AdminUtil::log('edit_user', [
	'old' => $u,
	'mod' => $data
]);

if(User::update($data, $uid)){
	IO::O();
}else{
	IO::E('操作失败，请稍后重试');
}