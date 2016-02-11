<?php

class config_tpl_admin_syslog{
    function get_config(){
        $cfg = TPL::load_config('admin/common');
        
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'admin/less/syslog'
            ),
            'js'  => array(
                'admin/js/syslog'
            ),
            'navi'  => array(
                array(
                    '调试及报错',
                    '?c=admin&a=syslog'
                )
            )
        ));
        
    }
}