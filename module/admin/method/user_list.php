<?php

$gid    = IO::I('gid', null, 'uint');
$offset = IO::I('offset', null, 'uint');
$count  = IO::I('count', null, 'uint');

if($gid === 0){
	list($amount, $list) = User::user_list($offset, $count);
}else{
	list($amount, $list) = UserGroup::user_list($gid, $offset, $count);
}

IO::O(array(
	'count' => $amount,
	'list'  => $list
));