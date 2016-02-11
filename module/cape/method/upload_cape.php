<?php

$r = Cape::upload('cape_file', IO::I('name'));

if(is_integer($r)){
	IO::E($r, Cape::errmsg($r));
}

IO::O([
	'data' => $r
]);