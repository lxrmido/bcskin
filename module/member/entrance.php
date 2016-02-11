<?php

class module_member{
    
    public function __construct(){
        global $_RG;
        $_RG['user'] = User::get_login();
    }
    
    public function debug(){
        echo 'debug:<br>';
    }

    public function main(){
        if(User::get_login()){
            if(User::is_super()){
                header('Location:./?c=skin');
            }else{
                header('Location:./?c=skin');
            }
        }else{
            $this->login();
        }
    }
    
    public function login(){

        TPL::show('member/login');
    }

    public function logout(){
        User::logout();
        header('Location:./?c=member');
    }

    public function setting(){
        if(User::get_login()){
            TPL::show('member/setting');
        }else{
            IO::E('请先登录');
        }
    }

    public function logined(){
        if($u = User::get_login()){
            $k = IO::I('k', 0, 'uint') == 1;
            User::set_login($u, $k);
            header('Location:./?c=member');
        }else{
            IO::E('请先登录');
        }
    }
}