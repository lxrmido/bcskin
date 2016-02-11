<?php

class Priv{

	public static $method; 
	public static $action;

	public static $method_mpp;
	public static $action_mpp;

	public static function scan_privileges(){
		self::flush_privileges();
		$md_root = opendir(RUNTIME_DIR_MODULE);
		while(($md_dir = readdir($md_root)) !== false){
			$md = RUNTIME_DIR_MODULE . '/' . $md_dir;
			$mt = $md . '/method';
			if(is_dir($md) && file_exists($mt)){
				$mt_dir = opendir($mt);
				while(($mt_file = readdir($mt_dir)) !== false){
					if(is_file($mt . '/' . $mt_file)){
						$mt_name = substr($mt_file, 0, -4);
						if(!self::method_exists($md_dir, $mt_name)){
							DB::query("INSERT INTO `priv_method` (`module`,`method`,`name`,`mpp`) VALUES ('$md_dir','$mt_name','','')");
						}
					}
				}
			}
			$ae = $md . '/entrance.php';
			if(file_exists($ae)){
				include_once($ae);			
				$class = new ReflectionClass('module_'.$md_dir);
				foreach ($class->getMethods() as $class_method) {
					$action_name = $class_method->getName();
					if(chr(ord($action_name)) != '_'){
						if(!self::action_exists($md_dir, $action_name)){
							DB::query("INSERT INTO `priv_action` (`module`,`action`,`name`,`mpp`) VALUES ('$md_dir','$action_name','','')");
						}					
					}
				}
			}
		}
		self::check_deprecated();
		self::flush_privileges();
	}

	public static function flat_method(){
		return DB::all("SELECT * FROM `priv_method` ORDER BY `module`,`method`");
	}

	public static function flat_action(){
		return DB::all("SELECT * FROM `priv_action` ORDER BY `module`,`action`");
	} 

	public static function check_deprecated(){
		$method = self::flat_method();
		$action = self::flat_action();
		foreach ($method as $m) {
			if(!file_exists(RUNTIME_DIR_MODULE . '/' . $m['module']) || !file_exists(RUNTIME_DIR_MODULE . '/' . $m['module'] . '/method/' . $m['method'] . '.php')){
				DB::query("DELETE FROM `priv_method` WHERE `module`='{$m['module']}' AND `method`='{$m['method']}'");
			}
		}
		foreach ($action as $a) {
			if(!lx_module($a['module'], $a['action'], false)){
				DB::query("DELETE FROM `priv_action` WHERE `module`='{$a['module']}' AND `action`='{$a['action']}'");
			}
		}
	}

	public static function current_method_mpp(){
		global $METHOD;
		if(empty($METHOD['name'])){
			return false;
		}
		self::start();
		if(isset(self::$method_mpp[$METHOD['module']]) && isset(self::$method_mpp[$METHOD['module']][$METHOD['method']])){
			return self::$method_mpp[$METHOD['module']][$METHOD['method']];
		}else{
			return false;
		}
	}

	public static function current_action_mpp(){
		global $_RG;
		$c = $_RG['PG_C'];
		$a = $_RG['PG_A'];
		self::start();
		if(isset(self::$action_mpp[$c]) && isset(self::$action_mpp[$c][$a])){
			return self::$action_mpp[$c][$a];
		}else{
			return false;
		}
	}

	public static function start(){
		if(empty(self::$method)){
			self::flush_privileges();
		}
	}

	public static function flush_privileges(){
		self::$method = array();
		self::$method_mpp = array();
		$ps = self::flat_method();
		foreach ($ps as $p) {
			if(empty(self::$method[$p['module']])){
				self::$method[$p['module']] = array();
				self::$method_mpp[$p['module']] = array();
			}
			self::$method[$p['module']][$p['method']] = $p['name'];
			self::$method_mpp[$p['module']][$p['method']] = $p['mpp'];
		}
		self::$action = array();
		self::$action_mpp = array();
		$ps = self::flat_action();
		foreach ($ps as $p) {
			if(empty(self::$action[$p['module']])){
				self::$action[$p['module']] = array();
				self::$action_mpp[$p['module']] = array();
			}
			self::$action[$p['module']][$p['action']] = $p['name'];
			self::$action_mpp[$p['module']][$p['action']] = $p['mpp'];
		}
	}

	public static function method_exists($module, $method){
		return isset(self::$method[$module]) && isset(self::$method[$module][$method]);
	}

	public static function action_exists($module, $action){
		return isset(self::$action[$module]) && isset(self::$action[$module][$action]);
	}

	public static function update_method_name($module, $method, $name){
		return DB::query("UPDATE `priv_method` SET `name`='$name' WHERE `module`='$module' AND `method`='$method'");
	}

	public static function update_action_name($module, $action, $name){
		return DB::query("UPDATE `priv_action` SET `name`='$name' WHERE `module`='$module' AND `action`='$action'");
	}

	public static function update_method_mpp($module, $method, $mpp){
		return DB::query("UPDATE `priv_method` SET `mpp`='$mpp' WHERE `module`='$module' AND `method`='$method'");
	}

	public static function update_action_mpp($module, $action, $mpp){
		return DB::query("UPDATE `priv_action` SET `mpp`='$mpp' WHERE `module`='$module' AND `action`='$action'");
	}
}