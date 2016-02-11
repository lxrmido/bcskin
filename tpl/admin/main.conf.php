<?php

class config_tpl_admin_main{
    function get_config(){
        $cfg = TPL::load_config('admin/common');
        
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'admin/less/main'
            ),
            'js'  => array(
                
            ),
            'navi'  => array(
                array(
                    '概述',
                    '?c=admin'
                )
            )
        ));
        
    }
}