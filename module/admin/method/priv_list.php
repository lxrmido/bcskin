<?php

Priv::scan_privileges();

IO::O(array(
	'method' => Priv::$method,
	'action' => Priv::$action
));

