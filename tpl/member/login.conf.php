<?php

class config_tpl_member_login{
    
    
    
    function get_config(){
        // 继承配置
        $cfg = TPL::load_config('public/common');
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'public/less/ui.vericode',
                'member/less/login'
            ),
            'js'  => array(
                'skin/js/three.min',
                'skin/js/viewer',
                'public/js/md5',
                'public/js/ui.vericode',
                'member/js/login'
            )
        ));
    }
}