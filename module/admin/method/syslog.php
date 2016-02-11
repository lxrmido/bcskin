<?php

$type = IO::I('type');
$date = IO::I('date');

if(!in_array($type, ['err', 'dbg', 'dgr', 'tml'])){
	IO::E('不合法的日志类型');
}

if(preg_match('/\d{4}\-\d{2}\-\d{2}/', $date) <= 0){
	IO::E('不合法的日志日期');
}

$file = RUNTIME_DIR_DATA . 'log/' . $type . '_' . $date . '.txt';

if(!file_exists($file)){
	IO::E('日志不存在');
}

$content = file_get_contents($file);

IO::O([
	'content' => $content
]);