<?php

$uid = IO::I('uid', null, 'uint');
$ban = IO::I('ban', null, 'bool');

if($uid == User::$last['id']){
	IO::E('您不能封禁自己！');
}

$u = User::get_user_by_id($uid);

if(empty($u['id'])){
	IO::E('所选择的用户不可用！');
}
if($ban){
	AdminUtil::log("ban_user", $u);
	$r = User::update([
		'ban' => 1
	], $uid);
}else{
	AdminUtil::log("unban_user", $u);
	$r = User::update([
		'ban' => 0
	], $uid);
}
if($r){
	IO::O();
}else{
	IO::E('操作失败，请稍后重试');
}
