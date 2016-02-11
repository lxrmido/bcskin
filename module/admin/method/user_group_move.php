<?php

$id = IO::I('id', null, 'uint');
$target = IO::I('target', null, 'uint');

if(UserGroup::update_parent($id, $target)){
	IO::O();
}else{
	IO::E('操作失败，请稍后重试');
}