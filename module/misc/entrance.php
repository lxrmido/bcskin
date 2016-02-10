<?php

class module_misc{
	public function __construct(){

	}

	public function browser_problem(){
		// IO::E('抱歉！本系统暂时不支持您所使用的浏览器或者浏览模式，请使用Chrome、FireFox、Safari、IE11+等现代浏览器或者360浏览器、搜狗浏览器、QQ浏览器、猎豹等浏览器的极速模式（webkit内核模式）。');
		TPL::show('public/browser_problem');
	}
}