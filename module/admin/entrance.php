<?php 

class module_admin{

	public function __construct(){
		User::admin_check();
	}

	public function main(){
		TPL::show('admin/main');
	}

	public function user_list(){
		$groups = DB::map("SELECT * FROM `user_group`", 'id');
		TPL::show('admin/user_list', [
			'groups_json' => json_encode($groups, JSON_UNESCAPED_UNICODE)
		]);
	}

	public function user_group(){
		$priv_list_method = DB::all("SELECT * FROM `priv_method` ORDER BY `module`,`method`");
		$priv_list_action = DB::all("SELECT * FROM `priv_action` ORDER BY `module`,`action`");

		TPL::show('admin/user_group', array(
			'priv_list_method' => $priv_list_method,
			'priv_list_action' => $priv_list_action
		));

	}

	public function user_priv(){
		TPL::show('admin/user_priv');
	}



	public function mp_classify(){

		TPL::show('admin/mp_classify');		
	}

	public function syslog(){
		$log_root = RUNTIME_DIR_DATA . 'log';
		$log_dir  = opendir($log_root);
		$log_files = [];
		while(($d = readdir($log_dir)) !== false){
			$f = $log_root . '/' . $d;
			if(!is_dir($f)){
				$log_files[] = $d;
			}
		}
		TPL::show('admin/syslog', [
			'log_files'      => $log_files,
			'log_files_json' => json_encode($log_files)
		]);
	}

}