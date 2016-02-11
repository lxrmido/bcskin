<?php

class config_tpl_admin_user_priv{
    function get_config(){
        $cfg = TPL::load_config('admin/common');
        
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'admin/less/user_priv'
            ),
            'js'  => array(
                'admin/js/user_priv'
            ),
            'navi'  => array(
                array(
                    '权限',
                    '?c=admin&a=user_priv'
                )
            )
        ));
        
    }
}