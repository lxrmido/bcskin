<?php

$gid    = IO::I('gid', null, 'uint');
$module = IO::I('module');
$key    = IO::I('key');

IO::O(array(
	'result' => UserGroup::remove_priv_method($gid, $module, $key)
));
