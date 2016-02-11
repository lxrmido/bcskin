<?php

$uid = IO::I('uid', null, 'uint');

if($uid == User::$last['id']){
	IO::E('您不能删除自己！');
}

$u = User::get_user_by_id($uid);

if(empty($u['id'])){
	IO::E('所选择的用户不可用！');
}

AdminUtil::log("rm_user", $u);

if(User::remove($uid)){
	IO::O();
}else{
	IO::E('操作失败，请稍后重试');
}