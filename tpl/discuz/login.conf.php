<?php

class config_tpl_discuz_login{
    
    function get_config(){
        // 继承配置
        $cfg = TPL::load_config('public/common');
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'discuz/less/login'
            ),
            'js'  => array(
                'public/js/md5',
                'discuz/js/login'
            )
        ));
    }
}