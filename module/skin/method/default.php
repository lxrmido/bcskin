<?php
$url = 'http://skins.minecraft.net/MinecraftSkins/' . User::$last['username'] . '.png';

$r = Net::get_with_header($url);

if($r['content'] == '404 Not Found'){
	header('Location:' . WEBSITE_URL_ROOT . '/static/skin/img/char.png');
}else{
	header('Contype-Type: image/png');
	echo $r['content'];
}