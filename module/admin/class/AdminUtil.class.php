<?php
/**
 * admin模块的工具库
 * 
 * @package admin
 */

class AdminUtil{
    /**
     * 写日志
     * @param  string $type 日志类型
     * @param  string $data 日志数据
     * @return bool       是否成功
     */
	public static function log($type, $data = null){
        if($data == null){
            $data = '';
        }else{
            $data = addslashes(json_encode($data, JSON_UNESCAPED_UNICODE));
        }
        return DB::insert(array(
            'type' => $type,
            'uid'  => User::$last['id'],
            'data' => $data,
            'time' => time()
        ), 'log_admin');
    }

    /**
     * 搜索用户名为某关键字开头的用户
     * @param  string $kw 关键字
     * @return array     [['id'=>1,'username'=>'username'],...]
     */
    public static function search_user_start_with($kw){
        return DB::all("SELECT `id`,`username` FROM `user_basic` WHERE `username` LIKE :kw", ['kw' => '%'.$kw.'%']);
    }

    /**
     * 查找用户ID
     * @param  string $kw 关键字
     * @return array     [1,2,3,...]
     */
    public static function search_user_id($kw){
        return DB::all_one("SELECT `id` FROM `user_basic` WHERE `username` LIKE :kw", ['kw' => '%'.$kw.'%']);
    }
}