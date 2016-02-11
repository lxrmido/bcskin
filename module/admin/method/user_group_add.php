<?php

$name   = IO::I('name');
$parent = IO::I('parent', null, 'uint');

$rs = UserGroup::insert(array(
	'name'   => $name,
	'parent' => $parent
));

IO::O(array(
	'result' => $rs
));