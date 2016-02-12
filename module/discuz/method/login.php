<?php

$dz_uid      = IO::I('uid', null, 'uint');
$dz_username = IO::I('username');
$salt        = IO::I('salt');
$hash        = IO::I('hash');

if(DZLogin::check($dz_uid, $salt, $hash)){
	$auth = DZLogin::auth($dz_uid, $dz_username);
	echo json_encode([
		'uid'  => $dz_uid,
		'auth' => $auth 
	], JSON_UNESCAPED_UNICODE);
}else{
	echo '{uid:0, message:"check failed."}';
}