<?php

$kw = IO::I('kw');
$offset = IO::I('offset', null, 'uint');
$count  = IO::I('count', null, 'uint');

if(preg_match('/^[0-9]+$/', $kw) == 1){
	$uid = intval($kw);
	$ex = "`id`='$uid' OR `username` LIKE :kw OR `email` LIKE :kw";
	$pr = ['kw' => '%'.$kw.'%'];
}else{
	$ex = "`username` LIKE :kw OR `email` LIKE :kw";
	$pr = ['kw' => '%'.$kw.'%'];
}

$amount = DB::one("SELECT COUNT(`id`) FROM `user_basic` WHERE $ex LIMIT $offset,$count", $pr);
$list   = DB::all("SELECT `id`,`username`,`email`,`group`,`regdate`,`lastlogin`,`logintimes`,`lastip`,`ban` FROM `user_basic` WHERE $ex LIMIT $offset,$count", $pr);

IO::O(array(
	'count' => $amount,
	'list'  => $list
));