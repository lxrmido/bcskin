<?php

Priv::scan_privileges();

IO::O([
	'method' => Priv::flat_method(),
	'action' => Priv::flat_action()
]);