<?php

$method_name = json_decode(IO::I('method_name', null, 'raw'), true);
$method_mpp  = json_decode(IO::I('method_mpp' , null, 'raw'), true);
$action_name = json_decode(IO::I('action_name', null, 'raw'), true);
$action_mpp  = json_decode(IO::I('action_mpp' , null, 'raw'), true);

foreach ($method_name as $x) {
	if(preg_match('/^[a-z_]+$/', $x['module']) !== 1){
		AdminUtil::log('er_priv_e', array(
			'raw' => $method_name
		));
		IO::E(-1, '非法参数:'.$x['module']);
	}
	if(preg_match('/^[a-z_]+$/', $x['method']) !== 1){
		AdminUtil::log('er_priv_e', array(
			'raw' => $method_name
		));
		IO::E(-1, '非法参数:'.$x['method']);
	}
	Priv::update_method_name($x['module'], $x['method'], $x['value']);
}

foreach ($action_name as $x) {
	if(preg_match('/^[a-z_]+$/', $x['module']) !== 1){
		AdminUtil::log('er_priv_e', array(
			'raw' => $action_name
		));
		IO::E(-1, '非法参数:'.$x['module']);
	}
	if(preg_match('/^[a-z_]+$/', $x['action']) !== 1){
		AdminUtil::log('er_priv_e', array(
			'raw' => $action_name
		));
		IO::E(-1, '非法参数:'.$x['action']);
	}
	Priv::update_action_name($x['module'], $x['action'], $x['value']);
}

foreach ($action_mpp as $x) {
	if(preg_match('/^[a-z_]+$/', $x['module']) !== 1){
		AdminUtil::log('er_priv_e', array(
			'raw' => $action_mpp
		));
		IO::E(-1, '非法参数:'.$x['module']);
	}
	if(preg_match('/^[a-z_]+$/', $x['action']) !== 1){
		AdminUtil::log('er_priv_e', array(
			'raw' => $action_mpp
		));
		IO::E(-1, '非法参数:'.$x['action']);
	}
	Priv::update_action_mpp($x['module'], $x['action'], $x['value']);
}

foreach ($method_mpp as $x) {
	if(preg_match('/^[a-z_]+$/', $x['module']) !== 1){
		AdminUtil::log('er_priv_e', array(
			'raw' => $method_mpp
		));
		IO::E(-1, '非法参数:'.$x['module']);
	}
	if(preg_match('/^[a-z_]+$/', $x['method']) !== 1){
		AdminUtil::log('er_priv_e', array(
			'raw' => $method_mpp
		));
		IO::E(-1, '非法参数:'.$x['method']);
	}
	Priv::update_method_mpp($x['module'], $x['method'], $x['value']);
}

IO::O();