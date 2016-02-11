<?php

$gid = IO::I('gid', null, 'uint');

IO::O(array(
	'method' => UserGroup::list_priv_method($gid),
	'action' => UserGroup::list_priv_action($gid)
));