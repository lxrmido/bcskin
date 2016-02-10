<?php

class config_tpl_skin_main{
    
    
    
    function get_config(){
        // 继承配置
        $cfg = TPL::load_config('public/common');
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'skin/less/main'
            ),
            'js'  => array(
                'skin/js/three.min',
                'skin/js/viewer',
                'skin/js/sv2d',
                'skin/js/main'
            )
        ));
    }
}