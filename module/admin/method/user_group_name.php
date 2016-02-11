<?php

$gid  = IO::I('gid', null, 'uint');
$name = IO::I('name');

$rs = UserGroup::update_name($gid, $name);

IO::O(array(
	'result' => $rs
));