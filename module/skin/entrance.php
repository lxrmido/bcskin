<?php

class module_skin{
	public function __construct(){
		User::admin_check();
	}

	public function char(){
		$url = 'http://skins.minecraft.net/MinecraftSkins/' . User::$last['username'] . '.png';

		$r = Net::get_with_header($url);

		if(empty($r['header']['Location'])){
			header('Location:' . WEBSITE_URL_ROOT . '/static/skin/img/char.png');
		}else{
			header('Content-Type: image/png');
			echo Net::get($r['header']['Location']);
		}
	}

	public function main(){
		import('cape', false);
		TPL::show('skin/main', [
			'current_skin_json' => json_encode(Skin::get_current(), JSON_UNESCAPED_UNICODE),
			'current_cape_json' => json_encode(Cape::get_current(), JSON_UNESCAPED_UNICODE)
		]);
	}

	public function mall(){
		TPL::show('skin/mall', [
			'mall_list_json' => json_encode(Skin::mall_list())
		]);
	}

}