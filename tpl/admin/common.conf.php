<?php

class config_tpl_admin_common{
    function get_config(){
        $cfg = TPL::load_config('public/common');
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                
            ),
            'js'  => array(
                'admin/js/common'
            ),
            'title' => TPL_DEFAULT_TITLE,
            'navi'  => array(
                array(
                    '管理',
                    './?c=admin'
                )
            ),
            'frame' => 'admin/common'
        ));
        
    }
}