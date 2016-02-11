<?php

$id   = IO::I('id', null, 'uint');
$name = IO::I('name');

IO::O([
	'result' => Cape::rename_mine($name, $id)
]);