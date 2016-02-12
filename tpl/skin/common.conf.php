<?php

class config_tpl_skin_common{
    function get_config(){
        $cfg = TPL::load_config('public/common');
        return TPL::extend_config($cfg, array(
            'css' => array(
                
            ),
            'less' => array(
                'skin/less/common'
            ),
            'js'  => array(

            ),
            'title' => TPL_DEFAULT_TITLE,
            'navi'  => array(
                [
                    '皮肤',
                    './?c=skin'
                ]
            ),
            'frame' => 'skin/common'
        ));
        
    }
}