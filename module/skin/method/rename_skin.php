<?php

$id   = IO::I('id', null, 'uint');
$name = IO::I('name');

IO::O([
	'result' => Skin::rename_mine($name, $id)
]);