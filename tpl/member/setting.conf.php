<?php

class config_tpl_member_setting{
    
    
    
    function get_config(){
        // 继承配置
        $cfg = TPL::load_config('public/common');
        User::$last = User::get_full_info(User::$last);
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'public/less/ui.vericode',
                'member/less/setting'
            ),
            'js'  => array(
                'public/js/md5',
                'public/js/ui.vericode',
                'member/js/setting'
            ),
            'user_info' => User::$last
        ));

    }
}