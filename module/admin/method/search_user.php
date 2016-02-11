<?php

$kw = IO::I('kw');

IO::O([
	'result' => AdminUtil::search_user_start_with($kw)
]);