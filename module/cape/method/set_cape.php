<?php

$id = IO::I('id', null, 'uint');

$cape = Cape::get($id);

if($cape['uid'] != User::$last['id']){
	IO::E('目标披风不可用！');
}

IO::O([
	'result' => Cape::set_current($cape)
]);