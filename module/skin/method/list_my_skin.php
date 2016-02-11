<?php

$offset = IO::I('offset', 0, 'uint');
$limit  = IO::I('limit', 20, 'uint');

IO::O([
	'list'  => Skin::list_mine($offset, $limit),
	'total' => Skin::count_mine()
]);