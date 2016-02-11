<?php

$data = json_decode(IO::I('data', null, 'raw'), true);

$list = [];

$i = 1;
foreach ($data as $d) {
	$list[] = [
		'id'   => $i ++,
		'type' => $d['type'],
		'icon' => $d['icon'],
		'content' => $d['content'],
		'args' => $d['args']
	];
}

LeftMenu::clear();
LeftMenu::build_list($list);

IO::O();