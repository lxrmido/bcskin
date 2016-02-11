<?php

$gid = IO::I('gid', null, 'uint');

$to  = IO::I('to', null, 'uint');

IO::O(array(
	'result' => UserGroup::remove($gid, $to)
));