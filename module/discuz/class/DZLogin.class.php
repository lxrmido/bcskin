<?php

class DZLogin{

	public static function check($dz_uid, $salt, $hash){
		return $hash == md5($salt . $dz_uid . DISCUZ_BCS_LOGIN_KEY);
	}

	public static function auth($dz_uid, $dz_username){
		$r = DB::assoc("SELECT * FROM `discuz_login` WHERE `dz_uid`='$dz_uid'");
		$auth = rand(11111111, 99999999);
		if(empty($r['dz_uid'])){
			DB::insert([
				'dz_uid'      => $dz_uid,
				'dz_username' => $dz_username,
				'uid'         => 0,
				'username'    => '',
				'auth'        => $auth,
				'time'        => time()
			], 'discuz_login');
		}else{
			DB::update([
				'auth'        => $auth,
				'time'        => time()
			], 'discuz_login');
		}
		return $auth;
	}

}