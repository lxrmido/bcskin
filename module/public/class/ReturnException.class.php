<?php
class ReturnException extends Exception{
    public $ret;
    public function __construct($ret){
        $this->code = 128;
        $this->ret  = $ret;
    }
}