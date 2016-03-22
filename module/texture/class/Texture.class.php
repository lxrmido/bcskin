<?php

class Texture{

	public static function update_uni($player){
		$data = [
			'player_name' => $player,
			'last_update' => time(),
			'model_preference' => [],
			'skins'       => []
		];
		import('skin', false);
		import('cape', false);
		$skin = Skin::file_current($player);
		if(file_exists($skin)){
			$data['model_preference'][] = 'skin';
			$data['skins']['default']   = hash('SHA256', file_get_contents($skin));
			copy($skin, self::texture_file($data['skins']['default']));
		}
		$cape = Cape::file_current($player);
		if(file_exists($cape)){
			$data['model_preference'][] = 'cape';
			$data['skins']['cape']   = hash('SHA256', file_get_contents($cape));
			copy($cape, self::texture_file($data['skins']['cape']));
		}
		return file_put_contents(self::uni_file($player), json_encode($data));
	}

	public static function uni_file($player){
		$dir = RUNTIME_DIR_DATA;
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$dir .= 'uniskin/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		return $dir . urlencode($player) . '.json';
	}

	public static function texture_file($tuuid){
		$dir = RUNTIME_DIR_DATA;
		if(!file_exists($dir)){
			mkdir($dir);
		}
		$dir .= 'texture/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		return $dir . $tuuid;
	}

}