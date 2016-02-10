<?php

class DBO{

	public static $pdo = false;
	public static $lastprepare;

	public function error($msg){
		Log::error('db_error', [
			'stack' => debug_backtrace(),
			'msg'   => $msg
		]);
		if(is_array($msg)){
			$msg = $msg[2];
			if(empty($msg)){
				$msg = 'Unknown';
			}
		}
		if(DB_DEBUG){
			IO::E(-3306, $msg);
		}else{
			IO::E(-3306, '查询出错');
		}
	}

	public function __construct($svr, $db, $usr, $pwd){
		$dsn = 'mysql:host=' . $svr . ';dbname=' . $db . ';charset=utf8';
		try{
			$this->pdo = new PDO($dsn, $usr, $pwd);
			$this->pdo->exec('set names utf8');
		}catch(PDOException $e){
			return $this->error($e->getMessage());
		}
	}

	/**
     * 插入数据条目
     * $map = array(
     *     'key1' => 'value1',
     *     'key2' => 'value2',
     *     ......
     * )
     * $table为表名
     */
	public function insert($map, $table){
		$key_ary = array();
        $val_ary = array();
        $qto_ary = array();
        foreach($map as $k => $v){
            $key_ary[] = "`$k`";
            $qto_ary[] = ":$k";
        }
        $key_str = implode(',', $key_ary);
        $prp_str = implode(',', $qto_ary);

        try{
        	$sth = $this->pdo->prepare("INSERT INTO `$table` ($key_str) VALUES ($prp_str)", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        	if(!$sth){
        		return $this->error($this->pdo->errorInfo());
        	}
        	$r = $sth->execute($map);
   //      	Log::debug('db_edebug', [
			// 	'result' => $r,
			// 	'stack'  => debug_backtrace()
			// ]);
		}catch(Exception $e){
			return $this->error($e->getMessage());
		}

		if($r === false){
			Log::error('db_insert', [
				'map'   => $map,
				'table' => $table,
				'error' => $sth->errorInfo()
			]);
		}

		return $r;
	}

	public function replace($map, $table){
		$key_ary = array();
        $val_ary = array();
        $qto_ary = array();
        foreach($map as $k => $v){
            $key_ary[] = "`$k`";
            $qto_ary[] = ":$k";
        }
        $key_str = implode(',', $key_ary);
        $prp_str = implode(',', $qto_ary);

        try{
        	$sth = $this->pdo->prepare("REPLACE INTO `$table` ($key_str) VALUES ($prp_str)", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        	if(!$sth){
        		return $this->error($this->pdo->errorInfo());
        	}
        	$r = $sth->execute($map);
		}catch(PDOException $e){
			return $this->error($e->getMessage());
		}
		
		return $r;
	}

	/**
     * 插入数据条目
     * $data = [
	 * 		[
	 *  		'key1' => 'value1a',
	 *  		'key2' => 'value2a'.
	 *  		...
	 *  	],
	 *  	[
	 *  		'key1' => 'value1b',
	 *  		'key2' => 'value2b'.
	 *  		...
	 *  	],
	 *  	...
     ]
     * $table为表名
     */

	public function insert_more($datas, $table){
		$key_ary = array();
        $val_ary = array();
        $qto_ary = array();

        $map = $datas[0];

        foreach($map as $k => $v){
            $key_ary[] = "`$k`";
            $qto_ary[] = ":$k";
        }
        $key_str = implode(',', $key_ary);
        $prp_str = implode(',', $qto_ary);

        $r = [];

        try{
        	$sth = $this->pdo->prepare("INSERT INTO `$table` ($key_str) VALUES ($prp_str)", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        	if(!$sth){
        		return $this->error($this->pdo->errorInfo());
        	}
        	foreach ($datas as $d) {
        		$rs = $sth->execute($d);
	        	$r[] = $rs;
        	}
		}catch(PDOException $e){
			return $this->error($e->getMessage());
		}

		return $r;
	}

	/**
     * 更新数据条目
     * $map = array(
     *     'key1' => 'value1',
     *     'key2' => 'value2',
     *     ......
     * )
     * $table为表名
     * $condition为WHERE后接的SQL条件语句，如"`number` > 100 AND `age` < 20"
     * $condition为'`number` > :number AND `age` > :age'形式时，
     * $condition_map为array('number' => 100, 'age' => 20)
     * $condition_map与$map不能有相同的key名
     */
	public function update($map, $table, $condition = 1, $condition_map = false){
		$kv_ary  = '';
		$val_ary = array();
		foreach ($map as $k => $v) {
			$kv_ary[]  = "`$k`=:$k"; 
		}

		if($condition_map !== false){
			$map = array_merge($map, $condition_map);
		}

		try{
        	$sth = $this->pdo->prepare("UPDATE `$table` SET " . implode(',', $kv_ary) . " WHERE $condition", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        	if(!$sth){
        		return $this->error($this->pdo->errorInfo());
        	}
        	$r = $sth->execute($map);
		}catch(PDOException $e){
			return $this->error($e->getMessage());
		}
		return $r;
	}

	public function assoc($sql, $data = false){
		return $this->fetch(PDO::FETCH_ASSOC, $sql, $data);
	}

	public function one($sql, $data = false){
		$rs = $this->fetch(PDO::FETCH_NUM, $sql, $data);
		if(empty($rs)){
			return NULL;
		}
		if(count($rs) > 0){
			return $rs[0];
		}
		return NULL;
	}

	public function fetch($mode, $sql, $data){
		try{
			if($data === false){
				$sth = $this->pdo->prepare($sql);
				if(!$sth){
	        		return $this->error($this->pdo->errorInfo());
	        	}
				$sth->execute();
			}else{
				$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
				if(!$sth){
	        		return $this->error($this->pdo->errorInfo());
	        	}
				$sth->execute($data);
			}
			$sth->setFetchMode($mode);
			$r = $sth->fetch();
		}catch(PDOException $e){
			return $this->error($e->getMessage());
		}
		return $r;
	}

	/**
	 * 查询结果，得到所有结果组成的数组，如
	 * all("SELECT * FROM `user`");将获得诸如：
	 * [
	 * 		{
	 * 			name : 'Bill',
	 * 			age  : 30
	 * 		},
	 * 		{
	 * 			name : 'Hilt',
	 * 			age  : 29
	 * 		}
	 * ]
	 * @param  String $sql  SQL语句
	 * @param  array  $data SQL语句中绑定的数据值
	 * @return array()
	 */
	public function all($sql, $data = false){
		return $this->fetch_all(PDO::FETCH_ASSOC, $sql, $data);
	}

	public function all_row($sql, $data = false){
		return $this->fetch_all(PDO::FETCH_NUM, $sql, $data);
	}

	public function fetch_all($mode, $sql, $data = false){
		try{
			if($data === false){
				$sth = $this->pdo->prepare($sql);
				if(!$sth){
	        		return $this->error($this->pdo->errorInfo());
	        	}
				$r = $sth->execute();
			}else{
				$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
				if(!$sth){
	        		return $this->error($this->pdo->errorInfo());
	        	}
				$r = $sth->execute($data);
			}
			$sth->setFetchMode($mode);
			$r = $sth->fetchAll();
		}catch(PDOException $e){
			return $this->error($e->getMessage());
		}
		return $r;
	}

	/**
	 * 查询所有行的单个值，如
	 * all_one("SELECT `name` FROM `user`");将获得诸如：
	 * ['Bill', 'Hilt']
	 * @param  String $sql SQL语句
	 * @param  array  $data SQL语句中绑定的数据值
	 * @return array()
	 */
	public function all_one($sql, $data = false){
		$rs = $this->fetch_all(PDO::FETCH_NUM, $sql, $data);
		$rt = [];
		foreach ($rs as $r) {
			$rt[] = $r[0];
		}
		return $rt;
	}

	/**
	 * 查询并以指定关键字作为数组的key返回
	 * @param  String $sql SQL语句
	 * @param  String $key 键
	 * @param  array  $data SQL语句中绑定的数据值
	 * @return array()
	 */
	public function map($sql, $key = 'id', $data = false){
		$rs = $this->fetch_all(PDO::FETCH_ASSOC, $sql, $data);
		$rt = [];
		foreach ($rs as $r) {
			$rt[$r[$key]] = $r;
		}
		return $rt;
	}

	/**
	 * 查询最后插入的ID
	 * @param  String $sql SQL语句
	 * @return int ID
	 */
	public function id($name = false){
		if($name === false){
			return $this->pdo->lastInsertId();
		}else{
			return $this->pdo->lastInsertId($name);
		}
	}

	public function query($sql = false, $data = false){
		if($sql === false){
			$r = $this->pdo->exec();
			return $r;
		}else if($data === false){
			$r = $this->pdo->exec($sql);
			return $r;
		}else{
			$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
			if(!$sth){
        		return $this->error($this->pdo->errorInfo());
        	}
			$r = $sth->execute($data);
			return $r;
		}
	}

	/**
     * 插入数据条目
     * $data = [
	 * 		[
	 *  		'key1' => 'value1a',
	 *  		'key2' => 'value2a'.
	 *  		...
	 *  	],
	 *  	[
	 *  		'key1' => 'value1b',
	 *  		'key2' => 'value2b'.
	 *  		...
	 *  	],
	 *  	...
     ]
     * $table为表名
     */

	public function insert_ignore_more($datas, $table){
		$key_ary = array();
        $val_ary = array();
        $qto_ary = array();

        $map = $datas[0];

        foreach($map as $k => $v){
            $key_ary[] = "`$k`";
            $qto_ary[] = ":$k";
        }
        $key_str = implode(',', $key_ary);
        $prp_str = implode(',', $qto_ary);

        $r = [];

        try{
        	$sth = $this->pdo->prepare("INSERT IGNORE INTO `$table` ($key_str) VALUES ($prp_str)", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        	if(!$sth){
        		return $this->error($this->pdo->errorInfo());
        	}
        	foreach ($datas as $d) {
        		$rs = $sth->execute($d);
	        	$r[] = $rs;
        	}
		}catch(PDOException $e){
			return $this->error($e->getMessage());
		}

		return $r;
	}
}