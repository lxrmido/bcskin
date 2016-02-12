<?php

class config_tpl_skin_mall{
    
    function get_config(){
        // 继承配置
        $cfg = TPL::load_config('skin/common');
        return TPL::extend_config($cfg, array(
            'css' => [
                
            ],
            'less' => [
                'skin/less/mall'
            ],
            'js'  => [
                'skin/js/sv2d',
                'skin/js/mall'
            ],
            'navi' => [
                [
                    '陈列室',
                    './?c=skin&a=mall'
                ]
            ]
        ));
    }
}