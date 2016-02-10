<?php

class SimpleCode{
    
    public static $SESSION_ID = 'simple_code';
    
    # 产生新验证码并显示
    public static function new_code($w = 80, $h = 30, $r = 255, $g = 255, $b = 255){
        $code = self::flush_code();
        self::gen_image($code, $w, $h, $r, $g, $b);
    }

    public static function new_login_code(){
        $code = self::flush_code();
        self::login_image($code);
    }
    
    # 检查验证码是否正确
    public static function check_code($code){
        // IO::add_to_debug('vrc', $code);
        // IO::add_to_debug('vrd', $_SESSION[self::$SESSION_ID]);
        $code = strtoupper($code);
        return (!empty($_SESSION[self::$SESSION_ID])) && $_SESSION[self::$SESSION_ID] == $code;
    }
    
    # 刷新验证码
    public static function flush_code(){
        $code = self::gen_code();
        $_SESSION[self::$SESSION_ID] = $code;
        return $code;
    }
    
    # 生成随机数
    public static function gen_code($len = 4){
        $s = '';
        for($i = 0; $i < $len; $i ++){
            $s .= self::gen_char();
        }
        return $s;
    }

    public static function gen_char(){
        $cs = ['1','2','3','4','5','6','7','8','9','Q','W','E','R','T','Y','U','I','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M'];
        return $cs[rand(0, 33)];
    }
    
    # 生成图片并显示
    public static function gen_image($str, $w = 80, $h = 30, $r = 255, $g = 255, $b = 255){
        $img = imagecreatetruecolor($w, $h);
        imagefill($img, 0, 0, imageColorAllocate($img, $r, $g, $b));
        $s = ''.$str;
        for($i = 0; $i < 4; $i ++){
            $fc = imageColorAllocate($img, rand(0, 150), rand(0, 150), rand(0, 150));
            imageline($img, 0, rand(0, $h), $w, rand(0, $h), $fc); 
            imageString($img, 5, $i * $w/4 + rand(0, $w/8), rand(1, $h/2), $s[$i], $fc);
        }
        header("Content-type: image/JPEG");
        imagejpeg($img);
        imagedestroy($img);
    }

    public static function login_image($str){
        $w = 45;
        $h = 23;
        $img = imagecreatetruecolor($w, $h);
        imagefill($img, 0, 0, imageColorAllocate($img, 189, 229, 255));
        $s = ''.$str;
        for($i = 0; $i < 4; $i ++){
            $fc = imageColorAllocate($img, 38, 75, 101);
            imageString($img, 11, $i * $w/4 + rand(0, $w/8), rand(1, $h/2), $s[$i], $fc);
        }
        header("Content-type: image/JPEG");
        imagejpeg($img);
        imagedestroy($img);
    }
}