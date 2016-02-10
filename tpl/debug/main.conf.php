<?php

class config_tpl_debug_main{
    function get_config($config){
        $cfg = TPL::load_config('public/common');
        $cfg = TPL::extend_config($cfg, 'res/plugin_download');
        
        return TPL::extend_config($cfg, array(
            'css' => array(

            ),
            'less' => array(
            ),
            'js'  => array(
                'debug/js/main'
            ),
            'title' => 'debug'
        ));
        
    }
}