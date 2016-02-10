<?php

class module_vericode{
    
    public function simple_code(){
    	$w = IO::I('w', 80,  'uint');
    	$h = IO::I('h', 30,  'uint');
    	$r = IO::I('r', 255, 'uint');
    	$g = IO::I('g', 255, 'uint');
    	$b = IO::I('b', 255, 'uint');
        SimpleCode::new_code($w, $h, $r, $g, $b);
    }

    public function login_code(){
    	SimpleCode::new_login_code();
    }
    
}