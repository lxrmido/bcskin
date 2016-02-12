<?php

class module_discuz{
	function __construct(){
		
	}

	function login(){
		TPL::show('discuz/login', [
			'bcs_url' => DISCUZ_BCS_URL
		]);
	}
}