<?php
/**
 * 全局配置
 */
#############################################
define('TIME_ZONE', 'Asia/Shanghai');
# MySQL服务器、用户名、密码
define('SQL_SVR', 'localhost');    
define('SQL_USR', '');        
define('SQL_PWD', '');    
define('SQL_DB', '');    
define('DB_DEBUG', true);

define('MD5_SALT', 'gnc_dev');

define('COOKIES_PREFIX', 'gnc_');
define('SESSION_PREFIX', 'gnc_');

# 是否强制所有PHP类都只位于class目录下
define('FORCE_AUTOLOAD', false);
# 模板路径
define('RUNTIME_DIR_TPL',  'tpl/');
# 类文件路径
define('RUNTIME_DIR_CLASS',  'class/');
# 模块路径
define('RUNTIME_DIR_MODULE', 'module/');
# 静态文件
define('RUNTIME_DIR_STATIC', 'static/');
# DATA路径
define('RUNTIME_DIR_DATA', 'data/');
# 找不到方法时指定默认处理方法
define('RUNTIME_METHOD_NOTFOUND', RUNTIME_DIR_MODULE . 'public/method/notfound.php');

define('WEBSITE_URL_ROOT',  'http://l/fw');
define('WEBSITE_URL_DATA', WEBSITE_URL_ROOT . '/' . RUNTIME_DIR_DATA);

define('COMPILE_LESS', false);
define('MARVIN_DEBUG', false);
define('STATIC_VERSION', '0826');
#############################################

# TPL
define('TPL_DEFAULT_TITLE', '供稿中心');
$TPL_DEFAULT_JS = array(
    
);
$TPL_DEFAULT_CSS = array(
    
);

$LANGS = array(
    'method'   => '方法',
    'username' => '用户名',
    'password' => '密码'
);

$MODULES_NEED_INIT = array(
    'public',
    'member'
);
