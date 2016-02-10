<?php

class Spider{

	public static function download($src){
		$r = Net::get_with_header($src);
		if(empty($r['http_status_code'])){
			Log::error('spider_download_empty_status', [
				'src' => $src
			]);
			return false;
		}
		$http_status_code = intval($r['http_status_code']);
		if($http_status_code >= 400){
			Log::error('spider_download_status_error', [
				'src'    => $src,
				'status' => $r['http_status_code']
			]);
			return false;
		}

		$ret = [
			'mime'    => '',
			'extname' => '',
			'name'    => self::getFileNameFromURL($src),
			'time'    => time(),
			'uid'     => 0
		];
		if(User::$last && isset(User::$last['id'])){
			$ret['uid'] = User::$last['id'];
		}
		if(!empty($r['header'])){
			$cts = explode(';', self::getHeaderContentType($r['header']));
			$ret['mime']    = $cts[0];
			$ret['extname'] = self::mime2ext($ret['mime']);
			$cdName = self::getHeaderContentDisposition($r['header']);
			if(!empty($cdName)){
				$ret['name'] = $cdName;
			}
			if(empty($ret['extname'])){
				preg_match("/\.([^\"]+)/", $ret['name'], $m);
				if(!empty($m[1])){
					$ret['extname'] = strtolower($m[1]);
					if(empty($ret['mime'])){
						$ret['mime'] = self::ext2mime($ret['mime']);
					}
				}
			}
		}

		if(DB::insert($ret, 'spider_download')){
			$ret['id'] = DB::id();
		}else{
			Log::error('spider_download_insert_db', [
				'src'  => $src,
				'data' => $ret  
			]);
			return false;
		}

		if(empty($ret['id'])){
			Log::error('spider_download_insert_db_id', [
				'src'  => $src,
				'data' => $ret  
			]);
			return false;
		}

		$dir = RUNTIME_DIR_DATA . 'spy_down';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$dir .= '/' . date('Ymd', $ret['time']);
		if(!file_exists($dir)){
			mkdir($dir);
		}
		file_put_contents($dir . '/' . $ret['id'], $r['content']);
		return $ret;
	}

	public static function get_file($data){
		return RUNTIME_DIR_DATA . 'spy_down/' . date('Ymd', $data['time']) . '/' . $data['id'];
	}

	public static function getHeaderContentType($header){
		if(isset($header['Content-Type'])){
			return $header['Content-Type'];
		}
		return '';
	}

	public static function getHeaderContentDisposition($header){
		$to_check = ['Content-Disposition', 'Content-disposition', 'content-disposition', 'content-Disposition'];
		foreach ($to_check as $tkey) {
			if(isset($header[$tkey])){
				return $header[$tkey];
			}
		}
		return '';
	}

	public static function getFileNameFromURL($url){
		$nm = explode('#', $url);
		$nm = explode('?', $nm[0]);
		$nm = explode('/', $nm[0]);
		return $nm[count($nm) - 1];
	}

	public static function mime2ext($mime){
		switch($mime){
			case 'image/gif':
				return 'gif';
			case 'image/jpeg':
				return 'jpg';
			case 'image/bmp':
				return 'bmp'; 
			case 'image/png':
				return 'png';
			default:
				return '';
		}
	}

	public static function ext2mime($ext){
		switch($ext){
			case 'jpg':
			case 'jpeg':
				return "image/jpeg";
			case 'png':
				return "image/png";
			case 'gif':
				return "image/gif";
			default:
				return '';
		}
	}

}