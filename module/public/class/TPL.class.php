<?php

class TPL{

    public static function show($tpl_name, $config = array()){

        global $TPL_DEFAULT_JS;
        global $TPL_DEFAULT_CSS;

        $default_config = array(
            'url_root'    => WEBSITE_URL_ROOT,
            'url_data'    => WEBSITE_URL_DATA,
            'url_static'  => WEBSITE_URL_ROOT . '/' . RUNTIME_DIR_STATIC,
            'title'       => TPL_DEFAULT_TITLE,
            'js'          => array(),
            'css'         => array(),
            'less'        => array(),
            'default_js'  => $TPL_DEFAULT_JS,
            'default_css' => $TPL_DEFAULT_CSS,
            'ext_js'      => array(),
            'ext_css'     => array(),
            'plugin'      => array(),
            'frame'       => 'public/common',
            'static_version' => STATIC_VERSION,
            'powered_by'  => POWERED_BY
        );

                
        $tpl_config = self::load_config($tpl_name, $config);
        
        if($tpl_config != false){
            foreach($tpl_config as $key => $value){
                $default_config[$key] = $value;
            }
        }
                
        foreach($default_config as $key => $value) {
            if(!isset($config[$key])){
                $config[$key] = $default_config[$key];
            }
        }
        
        # JS
        foreach ($config['default_js'] as $jsf) {
            $config['js'][] = $jsf;
        }
        $config['js'] = ($config['js']);

        # CSS
        foreach ($config['default_css'] as $csf) {
            $config['css'][] = $csf;
        }
        $config['css'] = ($config['css']);
        
        $s = new Smarty;
        
        global $_RG;

        if(!empty($_RG['user']['salt'])){
            $_RG['user'] = User::low_safe($_RG['user']);
        }

        $s->assign($config);
        $s->assign('_RG', $_RG);
        $s->assign('_RG_JSON', json_encode($_RG, JSON_UNESCAPED_UNICODE));
        if(MARVIN_DEBUG){
            $s->assign('_CF_JSON', json_encode($config, JSON_UNESCAPED_UNICODE));
        }else{
            $s->assign('_CF_JSON', "null");
        }
        $s->assign('COMPILE_LESS', COMPILE_LESS);
        $s->assign('tpl_name', $tpl_name . '.html');
        $s->display($config['frame'] . '.html');
        die();
    }
    
    public static function extend_config($origin, $added){

        if(is_string($origin)){
            $origin = self::load_config($origin);
        }

        if(is_string($added)){
            $added = self::load_config($added);
        }

        foreach($added as $key => $value){
            if(!isset($origin[$key])){
                $origin[$key] = $value;
            }else{
                if(is_array($value)){
                    foreach($value as $v){
                        $origin[$key][] = $v;
                    }
                }else{
                    $origin[$key] = $value;
                }
            }
        }
        return $origin;
    }
    
    public static function load_config($tpl_name, $config = null){
        $file = RUNTIME_DIR_TPL. $tpl_name . '.conf.php';
        if(!file_exists($file)){
            return false;
        }
        include_once $file;
        $class_name = 'config_tpl_'.str_replace('/', '_', $tpl_name);
        $config_class = new $class_name;
        if($config === null){
            return $config_class->get_config();
        }else{
            return $config_class->get_config($config);
        }
    }
}