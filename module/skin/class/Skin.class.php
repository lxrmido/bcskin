<?php

define(SKIN_UPLOAD_ERR_EMPTY,  -20001);
define(SKIN_UPLOAD_SIZE_LIMIT, -20002);
define(SKIN_UPLOAD_ERR_SIZE,   -20003);
define(SKIN_UPLOAD_ERR_FORMAT, -20004);

class Skin{
	public static function upload($key, $name){
		if(empty($_FILES[$key])){
			return SKIN_UPLOAD_ERR_EMPTY;
		}
		$img_upload = $_FILES[$key];
		if($img_upload['size'] > SKIN_UPLOAD_SIZE_LIMIT){
			return SKIN_UPLOAD_ERR_SIZE;
		}
		$sizeInfo = getimagesize($img_upload['tmp_name']);
		if(empty($sizeInfo[1])){
			return SKIN_UPLOAD_ERR_FORMAT;
		}
		$time = time();
		$uid  = User::$last['id'];
		$data = [
			'uid'  => $uid,
			'time' => $time,
			'name' => $name
		];
		DB::insert($data, 'res_skin');
	}
}