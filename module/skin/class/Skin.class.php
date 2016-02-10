<?php

define('SKIN_UPLOAD_SIZE_LIMIT', 1000000);
define('SKIN_UPLOAD_ERR_EMPTY',  -20001);
define('SKIN_UPLOAD_ERR_SIZE',   -20002);
define('SKIN_UPLOAD_ERR_FORMAT', -20003);
define('SKIN_UPLOAD_ERR_INSERT', -20004);
define('SKIN_UPLOAD_ERR_MVFILE', -20005);

class Skin{

	public static function errmsg($code){
		switch($code){
			case SKIN_UPLOAD_ERR_EMPTY:
				return '找不到上传的文件';
			case SKIN_UPLOAD_ERR_SIZE:
				return '文件太大，请保持在'.SKIN_UPLOAD_SIZE_LIMIT.'字节内';
			case SKIN_UPLOAD_ERR_FORMAT:
				return '文件格式识别失败';
			case SKIN_UPLOAD_ERR_INSERT:
				return '服务器繁忙，请稍后重试(1)';
			case SKIN_UPLOAD_ERR_MVFILE:
				return '服务器繁忙，请稍后重试(2)';
			default:
				return '操作失败，请稍后重试';
		}
	}

	/**
	 * upload skin image file
	 * @param  string $key  form-key
	 * @param  string $name skin name
	 * @return integer|array  
	 */
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
			'uid'    => $uid,
			'time'   => $time,
			'name'   => $name,
			'size'   => $img_upload['size'],
			'width'  => $sizeInfo[0],
			'height' => $sizeInfo[1],
			'share'  => 0,
			'url'    => '',
			'star_count'    => 0,
			'comment_count' => 0,
			'view_count'    => 0
		];
		DB::insert($data, 'res_skin');
		$data['id'] = DB::id();
		if(empty($data['id'])){
			return SKIN_UPLOAD_ERR_INSERT;
		}
		$file = self::get_file_from_data($data);
		if(!move_uploaded_file($img_upload['tmp_name'], $file)){
			return SKIN_UPLOAD_ERR_MVFILE;
		}
		$data['url']  = self::get_url_from_data($data);
		DB::update([
			'url' => $data['url']
		], 'res_skin', "`id`='{$data['id']}'");
		return $data;
	}

	public static function get_file_from_data($data){
		$dir = RUNTIME_DIR_DATA;
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$dir .= 'skin_upload/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$dir .= date('Ymd', $data['time']) . '/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		return $dir . $data['id'] . '.png';
	}

	public static function get_url_from_data($data){
		return WEBSITE_URL_DATA . 'skin_upload/' . date('Ymd', $data['time']) . '/' . $data['id'] . '.png';
	}
}