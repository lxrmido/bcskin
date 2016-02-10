<?php
include 'global.php';

# 设定以JSONP形式返回
$JSONP = true;
$METHOD['jsonp_handle'] = IO::r('jsonp_handle');
$METHOD['jsonp_key'] = IO::r('jsonp_key');
#是否以JSON形式输出
$METHOD['json'] = $JSON_IO = IO::r('json', 1, 'uint') > 0;
# 方法名
$METHOD['name'] = IO::r('m');
# 获取实际文件路径
$METHOD['file'] = lx_method($METHOD['name']);
# 包含
include($METHOD['file']);