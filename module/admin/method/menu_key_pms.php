<?php

import('mp_menu', false);

IO::O([
	'list' => MPMenuKey::all_pms()
]);