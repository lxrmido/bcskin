<?php

$type = IO::I('type');
$icon = IO::I('icon');
$content = IO::I('content');
$args = IO::I('args');

if(LeftMenu::add([
	'type' => $type,
	'icon' => $icon,
	'content' => $content,
	'args' => $args
])){
	IO::O();
}else{
	IO::E('添加失败，请稍后重试');
}