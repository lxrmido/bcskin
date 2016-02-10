<?php
/**
 * 管理平台用户组工具类
 * @package  member
 */

class UserGroup{

	/**
	 * 获取用户组
	 * @param  int $group 组ID
	 * @return array
	 */
	public static function get_group($group){
		$g = DB::assoc("SELECT * FROM `user_group` WHERE `id`='$group'");
		if(empty($g)){
			return false;
		}
		return $g;
	}

	/**
	 * 获取某个用户组的用户列表
	 * @param  int $group  组ID
	 * @param  int $offset 
	 * @param  int $count  
	 * @return array       
	 */
	public static function user_list($group, $offset, $count){
		$count = DB::one("SELECT COUNT(`id`) FROM `user_basic` WHERE `group`='$group'");
		$list  = DB::all("SELECT `id`,`username`,`email`,`group`,`regdate`,`lastlogin`,`logintimes`,`lastip`,`ban` FROM `user_basic` WHERE `group`='$group'");
		return array($count, $list);
	}

	/**
	 * 插入新用户组
	 * @param  array $data 
	 * @return array
	 */
	public static function insert($data){
		User::log('gp_add', $data);
		DB::insert($data, 'user_group');
		$data['id'] = DB::id();
		return $data;
	}

	/**
	 * 获取所有用户组
	 * @return array
	 */
	public static function group_list(){
		return DB::all("SELECT * FROM `user_group`");
	}

	/**
	 * 修改用户组的组名
	 * @param  int $id   
	 * @param  string $name 
	 * @return bool
	 */
	public static function update_name($id, $name){
		User::log('gp_name', array('id'=>$id, 'name'=>$name));
		return DB::update([
			'name' => $name
		], 'user_group', '`id`=:id', ['id' => $id]);
	}

	/**
	 * 更新用户组的父节点
	 * @param  int $id     
	 * @param  int $parent 
	 * @return bool
	 */
	public static function update_parent($id, $parent){
		User::log('gp_parent');
		return DB::update([
			'parent' => $parent
		], 'user_group', '`id`=:id', ['id' => $id]);
	}

	/**
	 * 删除用户组
	 * @param  int $id          
	 * @param  int $sub_move_to 删除后子节点移动到的分组
	 * @return bool
	 */
	public static function remove($id, $sub_move_to){
		User::log('gp_remove', array('id'=>$id, 'name'=>$sub_move_to));
		if(DB::query("DELETE FROM `user_group` WHERE `id`='$id'")){
			return DB::query("UPDATE `user_group` SET `parent`='$sub_move_to' WHERE `parent`='$id'");
		}
		return false;
	}

	/**
	 * [add_priv_method description]
	 * @param int $id     [description]
	 * @param string $module [description]
	 * @param string $method [description]
	 * @return  bool
	 */
	public static function add_priv_method($id, $module, $method){
		if(DB::one("SELECT `gid` FROM `user_group_priv_method` WHERE `gid`='$id' AND `module`='$module' AND `method`='$method'")){
			return TRUE;
		}else{
			return !!DB::insert(array(
				'gid'    => $id,
				'module' => $module,
				'method' => $method
			), 'user_group_priv_method');
		}
	}

	/**
	 * [remove_priv_method description]
	 * @param  int $id     [description]
	 * @param  string $module [description]
	 * @param  string $method [description]
	 * @return bool
	 */
	public static function remove_priv_method($id, $module, $method){
		return !!DB::query("DELETE FROM `user_group_priv_method` WHERE `gid`='$id' AND `module`='$module' AND `method`='$method'");
	}

	/**
	 * [list_priv_method description]
	 * @param  int $id [description]
	 * @return array
	 */
	public static function list_priv_method($id){
		$self_priv_list   = DB::all("SELECT `module`,`method` FROM `user_group_priv_method` WHERE `gid`='$id' ORDER BY `module`");
		$parent_priv_list = array();
		$parent = DB::one("SELECT `parent` FROM `user_group` WHERE `id`='$id'");
		while($parent){
			$parent_priv_list[] = array(
				'parent'    => $parent,
				'priv_list' => DB::all("SELECT `module`,`method` FROM `user_group_priv_method` WHERE `gid`='$parent' ORDER BY `module`")
			);
			$parent = DB::one("SELECT `parent` FROM `user_group` WHERE `id`='$parent'");
		}
		return array(
			'priv_list' => $self_priv_list,
			'parent'    => $parent_priv_list
		);
	}

	/**
	 * [add_priv_action description]
	 * @param int $id     [description]
	 * @param string $module [description]
	 * @param string $action [description]
	 * @return  bool
	 */
	public static function add_priv_action($id, $module, $action){
		if(DB::one("SELECT `gid` FROM `user_group_priv_action` WHERE `gid`='$id' AND `module`='$module' AND `action`='$action'")){
			return TRUE;
		}else{
			return !!DB::insert(array(
				'gid'    => $id,
				'module' => $module,
				'action' => $action
			), 'user_group_priv_action');
		}
	}

	/**
	 * [remove_priv_action description]
	 * @param  int $id     [description]
	 * @param  string $module [description]
	 * @param  string $action [description]
	 * @return bool
	 */
	public static function remove_priv_action($id, $module, $action){
		return !!DB::query("DELETE FROM `user_group_priv_action` WHERE `gid`='$id' AND `module`='$module' AND `action`='$action'");
	}

	/**
	 * [list_priv_action description]
	 * @param  int $id [description]
	 * @return array
	 */
	public static function list_priv_action($id){
		$self_priv_list   = DB::all("SELECT `module`,`action` FROM `user_group_priv_action` WHERE `gid`='$id' ORDER BY `module`");
		$parent_priv_list = array();
		$parent = DB::one("SELECT `parent` FROM `user_group` WHERE `id`='$id'");
		while($parent){
			$parent_priv_list[] = array(
				'parent'    => $parent,
				'priv_list' => DB::all("SELECT `module`,`action` FROM `user_group_priv_action` WHERE `gid`='$parent' ORDER BY `module`")
			);
			$parent = DB::one("SELECT `parent` FROM `user_group` WHERE `id`='$parent'");
		}
		return array(
			'priv_list' => $self_priv_list,
			'parent'    => $parent_priv_list
		);
	}

	/**
	 * [check_priv_method description]
	 * @param  string  $module [description]
	 * @param  string  $method [description]
	 * @param  bool|int $gid    [description]
	 * @return bool
	 */
	public static function check_priv_method($module, $method, $gid = false){
		if($gid === false){
			$gid = User::$last['group'];
		}
		if(empty($gid)){
			return false;
		}
		if(!empty(DB::one("SELECT `gid` FROM `user_group_priv_method` WHERE `gid`='$gid' AND `module`='$module' AND `method`='$method'"))){
			return true;
		}		
		while(($gid = DB::one("SELECT `parent` FROM `user_group` WHERE `id`='$gid'")) != null){
			if(!empty(DB::one("SELECT `gid` FROM `user_group_priv_method` WHERE `gid`='$gid' AND `module`='$module' AND `method`='$method'"))){
				return true;
			}		
		}
		return false;
	}

	/**
	 * [check_priv_action description]
	 * @param  string  $module [description]
	 * @param  string  $action [description]
	 * @param  bool|int $gid    [description]
	 * @return bool
	 */
	public static function check_priv_action($module, $action, $gid = false){
		if($gid === false){
			$gid = User::$last['group'];
		}
		if(empty($gid)){
			return false;
		}
		if(!empty(DB::one("SELECT `gid` FROM `user_group_priv_action` WHERE `gid`='$gid' AND `module`='$module' AND `action`='$action'"))){
			return true;
		}		
		while(($gid = DB::one("SELECT `parent` FROM `user_group` WHERE `id`='$gid'")) != null){
			if(!empty(DB::one("SELECT `gid` FROM `user_group_priv_action` WHERE `gid`='$gid' AND `module`='$module' AND `action`='$action'"))){
				return true;
			}		
		}
		return false;
	}

}