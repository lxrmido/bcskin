<?php

$code = IO::I('code');

IO::O(array(
    'correct' => SimpleCode::check_code($code)
));