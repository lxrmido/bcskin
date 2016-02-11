<?php

class config_tpl_admin_user_group{
    function get_config(){
        $cfg = TPL::load_config('admin/common');
        
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'admin/less/user_group'
            ),
            'js'  => array(
                'admin/js/user_group'
            ),
            'navi'  => array(
                array(
                    '用户组',
                    '?c=admin&a=user_group'
                )
            )
        ));
        
    }
}