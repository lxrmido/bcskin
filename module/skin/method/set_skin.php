<?php

$id = IO::I('id', null, 'uint');

$skin = Skin::get($id);

if($skin['uid'] != User::$last['id']){
	IO::E('目标皮肤不可用！');
}

IO::O([
	'result' => Skin::set_current($skin)
]);