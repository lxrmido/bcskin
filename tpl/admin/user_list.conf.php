<?php

class config_tpl_admin_user_list{
    function get_config(){
        $cfg = TPL::load_config('admin/common');
        
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'admin/less/user_list'
            ),
            'js'  => array(
                'public/js/md5',
                'admin/js/user_list'
                
            ),
            'navi'  => array(
                array(
                    '用户列表',
                    '?c=admin&a=user_list'
                )
            )
        ));
        
    }
}