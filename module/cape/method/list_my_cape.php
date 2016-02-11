<?php

$offset = IO::I('offset', 0, 'uint');
$limit  = IO::I('limit', 20, 'uint');

IO::O([
	'list'  => Cape::list_mine($offset, $limit),
	'total' => Cape::count_mine()
]);