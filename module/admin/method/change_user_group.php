<?php

$uid = IO::I('uid', null, 'uint');
$gid = IO::I('gid', null, 'uint');

if(UserGroup::get_group($gid) === false){
	IO::E('所选择的用户组不可用！');
}

$u = User::get_user_by_id($uid);

if(empty($u['id'])){
	IO::E('所选择的用户不可用！');
}

if($u['group'] == $gid){
	IO::E('用户已经是此用户组！');
}

AdminUtil::log('c_u_g', [
	'uid' => $u['id'],
	'old' => $u['group'],
	'new' => $gid
]);
if(User::update([
	'group' => $gid
], $uid)){
	IO::O();
}else{
	IO::E('操作失败，请稍后重试');
}