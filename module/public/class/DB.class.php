<?php

class DB{

	public static $dbo = false;

	public static function connect(){
		self::$dbo = new DBO(SQL_SVR, SQL_DB, SQL_USR, SQL_PWD);
	}

	public static function insert($map, $table){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->insert($map, $table);
	}

	public static function replace($map, $table){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->replace($map, $table);
	}

	public static function insert_more($datas, $table){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->insert_more($datas, $table);
	}

	public static function update($map, $table, $condition = 1, $condition_map = false){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->update($map, $table, $condition, $condition_map);
	}

	public static function assoc($sql, $data = false){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->assoc($sql, $data);
	}

	public static function one($sql, $data = false){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->one($sql, $data);
	}

	public static function all($sql, $data = false){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->all($sql, $data);
	}

	public static function all_one($sql, $data = false){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->all_one($sql, $data);
	}

	public static function map($sql, $key = 'id', $data = false){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->map($sql, $key, $data);
	}

	public static function id($name = false){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->id($name);
	}

	public static function query($sql = false, $data = false){
		if(!self::$dbo){
			self::connect();
		}
		return self::$dbo->query($sql, $data);
	}
}