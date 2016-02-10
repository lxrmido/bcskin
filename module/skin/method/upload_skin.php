<?php

$r = Skin::upload('skin_file', IO::I('name'));

if(is_integer($r)){
	IO::E($r, Skin::errmsg($r));
}

IO::O([
	'data' => $r
]);