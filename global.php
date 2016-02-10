<?php

/**
 * 最小化框架
 */


# 运行目录
define('RUNTIME_DIR_ROOT',   dirname(__FILE__));


require_once 'module/public/conf/config.php';

$JSON_IO      = false;
$JSONP        = false;
$DIE_ON_ERROR = true;
$INNER_CALL   = false;
$ARGS         = array();
$METHOD       = array(
    'is_method' => false,
    'debug'    => array()
);

$_RG = array();

$_REQUIRE_MODULE = array();
$_RUNNING_MODULE = array();

date_default_timezone_set(TIME_ZONE);

spl_autoload_register('lx_autoload');

chdir(RUNTIME_DIR_ROOT);
session_start();

foreach($MODULES_NEED_INIT as $m){
    lx_module_construct($m);
}


function lx_method($name){
    $path = explode('.', $name);
    $n    = count($path) - 1;
    if($n < 1){
        return RUNTIME_METHOD_NOTFOUND;
    }
    $i = 1;
    $dir  = RUNTIME_DIR_MODULE . '/' . $path[0] . '/method';
    while($i < $n && file_exists($dir)){
        $dir .= "/" . $path[++$i];
    }
    $file = "$dir/{$path[$n]}.php";
    if(file_exists($file)){
        lx_module($path[0]);
        return $file;
    } 
    return RUNTIME_METHOD_NOTFOUND;
}

function lx_autoload($class_name){
    if((!lx_include_class($class_name)) && FORCE_AUTOLOAD){
        if(!in_array($class_name, array('IO', 'DB'))){
            IO::e(-1, "Class '$class_name' not exist!");
        }
        // header(IO_HEAD);
        if(defined('IO_JSON')){
            die(
                json_encode(
                    array(
                        'code'    =>0, 
                        'message' => "Core class '$class_name' not exist!"
                    ),
                    JSON_UNESCAPED_UNICODE
                )
            );
        }else{
            die("Core class '$class_name' not exist!");
        }
    }
}

function lx_include_class($class_name){
    return include_file("class/$class_name.class.php");
}

function lx_module($module, $func = false, $exec = true){
    if($obj = lx_module_construct($module)){
        if(!method_exists($obj, $func)){
            return false;
        }
        $exec and $func and $obj->$func();
        return $obj;
    }
    return false;
}

function lx_module_construct($module){
    if(isset($_RUNNING_MODULE[$module])){
        return $_RUNNING_MODULE[$module];
    }
    $file = RUNTIME_DIR_MODULE . "$module/entrance.php";
    global $_REQUIRE_MODULE;
    if(!in_array($module, $_REQUIRE_MODULE)){
        $_REQUIRE_MODULE[] = $module;
    }
    if(!file_exists($file)){
        return false;
    }
    include_once($file);
    $module_class_name = 'module_'.$module;
    $_RUNNING_MODULE[$module] = new $module_class_name;
    return $_RUNNING_MODULE[$module];
}

function lx_stack_trace(){
    $stack = debug_backtrace();
    foreach($stack as $r){
        echo '----', $r['file'], ', <b>line</b>', $r['line'], ', <b>function</b>:', $r['function']."<br />";
    }
}

function import($module, $init = true){
    global $_REQUIRE_MODULE;
    if(in_array($module, $_REQUIRE_MODULE)){
        return;
    }
    $_REQUIRE_MODULE[] = $module;
    if($init){
        lx_module_construct($module);
    }
}

function include_file($file_name, $module = null){
    if($module != null){
        $file = RUNTIME_DIR_MODULE . "$module/$file_name";
        if(file_exists($file)){
            include_once($file);
            return true;
        }else{
            return false;
        }
    }
    global $_REQUIRE_MODULE;
    foreach($_REQUIRE_MODULE as $module){
        $file = RUNTIME_DIR_MODULE . "$module/$file_name";
        if(file_exists($file)){
            include_once($file);
            return true;
        }
    }
    return false;
}
