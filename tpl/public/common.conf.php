<?php
class config_tpl_public_common{
    function get_config(){
        return array(
            'css' => array(
                'public/css/font-awesome',
                'public/css/font-entypo'
            ),
            'less' => array(
                'public/less/ui',
                'public/less/ui.bc',
            ),
            'js'  => array(
                'public/js/less',
                'public/js/moment',
                'public/js/jquery',
                'public/js/config',
                'public/js/ui',
                'public/js/ui.bc',
                'public/js/config',
                'public/js/global',
                'public/js/common'
            ),
            'navi' => array(),
            'header_tpl' => 'tpl/public/header.html',
            'static_tpl' => 'tpl/public/static.html',
            'tpl_basic'  => 'tpl/',
            'tpl'        => array(
                'public/ui'
            )
        );
    }
}