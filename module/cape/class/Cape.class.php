<?php

define('CAPE_UPLOAD_SIZE_LIMIT', 1000000);
define('CAPE_UPLOAD_ERR_EMPTY',  -20001);
define('CAPE_UPLOAD_ERR_SIZE',   -20002);
define('CAPE_UPLOAD_ERR_FORMAT', -20003);
define('CAPE_UPLOAD_ERR_INSERT', -20004);
define('CAPE_UPLOAD_ERR_MVFILE', -20005);

class Cape{

	public static function errmsg($code){
		switch($code){
			case CAPE_UPLOAD_ERR_EMPTY:
				return '找不到上传的文件';
			case CAPE_UPLOAD_ERR_SIZE:
				return '文件太大，请保持在'.CAPE_UPLOAD_SIZE_LIMIT.'字节内';
			case CAPE_UPLOAD_ERR_FORMAT:
				return '文件格式识别失败';
			case CAPE_UPLOAD_ERR_INSERT:
				return '服务器繁忙，请稍后重试(1)';
			case CAPE_UPLOAD_ERR_MVFILE:
				return '服务器繁忙，请稍后重试(2)';
			default:
				return '操作失败，请稍后重试';
		}
	}

	public static function list_mine($offset, $limit){
		$uid = User::$last['id'];
		return DB::all("SELECT * FROM `res_cape` WHERE `uid`='$uid' ORDER BY `id` DESC LIMIT $offset, $limit");
	}

	public static function count_mine(){
		$uid = User::$last['id'];
		$r   = DB::one("SELECT COUNT(`id`) FROM `res_cape` WHERE `uid`='$uid'");
		if(empty($r)){
			return 0;
		}
		return intval($r);
	}

	public static function remove_mine($ids){
		$uid = User::$last['id'];
		return DB::query("DELETE FROM `res_cape` WHERE `id` IN ($ids) AND `uid`='$uid'");
	}

	public static function rename_mine($name, $id){
		$uid = User::$last['id'];
		return DB::update([
			'name' => $name
		], 'res_cape', "`id`='$id' AND `uid`='$uid'");
	}

	/**
	 * upload cape image file
	 * @param  string $key  form-key
	 * @param  string $name cape name
	 * @return integer|array  
	 */
	public static function upload($key, $name){
		if(empty($_FILES[$key])){
			return CAPE_UPLOAD_ERR_EMPTY;
		}
		$img_upload = $_FILES[$key];
		if($img_upload['size'] > CAPE_UPLOAD_SIZE_LIMIT){
			return CAPE_UPLOAD_ERR_SIZE;
		}
		$sizeInfo = getimagesize($img_upload['tmp_name']);
		if(empty($sizeInfo[1])){
			return CAPE_UPLOAD_ERR_FORMAT;
		}
		$time = time();
		$uid  = User::$last['id'];
		$data = [
			'uid'      => $uid,
			'username' => User::$last['username'],
			'time'   => $time,
			'name'   => $name,
			'size'   => $img_upload['size'],
			'width'  => $sizeInfo[0],
			'height' => $sizeInfo[1],
			'share'  => 0,
			'url'    => '',
			'star_count'    => 0,
			'comment_count' => 0,
			'view_count'    => 0,
			'origin_id'  => 0,
			'origin_uid' => $uid,
			'origin_username' => User::$last['username']
		];
		DB::insert($data, 'res_cape');
		$data['id'] = DB::id();
		if(empty($data['id'])){
			return CAPE_UPLOAD_ERR_INSERT;
		}
		$file = self::get_file_from_data($data);
		if(!move_uploaded_file($img_upload['tmp_name'], $file)){
			return CAPE_UPLOAD_ERR_MVFILE;
		}
		$data['url'] = self::get_url_from_data($data);
		$data['origin_id'] = $data['id'];
		DB::update([
			'url'       => $data['url'],
			'origin_id' => $data['id'],
		], 'res_cape', "`id`='{$data['id']}'");
		return $data;
	}

	public static function get_file_from_data($data){
		$dir = RUNTIME_DIR_DATA;
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$dir .= 'cape_upload/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$dir .= date('Ymd', $data['time']) . '/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		return $dir . $data['id'] . '.png';
	}

	public static function file_current($player = false){
		if(!$player){
			$player = User::$last['username'];
		}
		$dir = RUNTIME_DIR_DATA;
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$dir .= 'cape/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		return $dir . urlencode($player) . '.png';
	}

	public static function get_url_from_data($data){
		return WEBSITE_URL_DATA . 'cape_upload/' . date('Ymd', $data['time']) . '/' . $data['id'] . '.png';
	}

	public static function get($id){
		$r = DB::assoc("SELECT * FROM `res_cape` WHERE `id`='$id'");
		if(empty($r['id'])){
			return false;
		}
		return $r;
	}

	public static function set_current($data){
		$dst = self::file_current();
		$src = self::get_file_from_data($data);
		copy($src, $dst);
		import('texture', false);
		Texture::update_uni(User::$last['username']);
		return DB::replace([
			'uid'       => User::$last['id'],
			'cape_id'   => $data['id'],
			'time'      => time(),
			'origin_id' => $data['origin_id']
		], 'cape_current');
	}

	public static function get_current(){
		$uid = User::$last['id'];
		$r = DB::assoc("SELECT * FROM `cape_current` WHERE `uid`='$uid'");
		if(empty($r['uid'])){
			return false;
		}
		return self::get($r['cape_id']);
	}

	public static function reset_current(){
		$uid = User::$last['id'];
		$f = self::file_current();
		if(file_exists($f)){
			unlink($f);
		}
		return DB::query("DELETE FROM `cape_current` WHERE `uid`='$uid'");
	}
}