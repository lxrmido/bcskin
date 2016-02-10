<?php

class Net{
    
    public static function get($url){
        $t1 = microtime(true);
        $c = curl_init();
        curl_setopt($c, CURLOPT_TIMEOUT, 30);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HEADER, 0);
        $o = curl_exec($c);
        curl_close($c);
        $t2 = microtime(true);
        // Log::timeline("GET:$url", $t1, $t2);
        return $o;
    }

    public static function get_spider($url){
        $c = curl_init();
        curl_setopt($c, CURLOPT_TIMEOUT, 30);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
        $p0 = explode('#', $url);
        $p1 = explode('?', $p0[0]);
        $p2 = explode('//', $p1[0]);
        $p3 = explode('/', $p2[1]);
        $header = [
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding:gzip, deflate, sdch',
            'Accept-Language:en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4,zh-TW;q=0.2,ja;q=0.2',
            'Cache-Control:max-age=0',
            'Connection:keep-alive',
            'Host:'.$p3[0],
            'DNT:1',
            'Referer:http://'.$p3[0],
            'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.132 Safari/537.36'
        ];
        curl_setopt($c, CURLOPT_HTTPHEADER, $header);
        $o = curl_exec($c);
        return self::decode_http($o);
    }

    public static function get_mp_news($url){
        $c = curl_init();
        curl_setopt($c, CURLOPT_TIMEOUT, 30);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
        $p0 = explode('#', $url);
        $p1 = explode('?', $p0[0]);
        $p2 = explode('//', $p1[0]);
        $p3 = explode('/', $p2[1]);
        $header = [
            'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding:gzip, deflate, sdch',
            'Accept-Language:en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4,zh-TW;q=0.2,ja;q=0.2',
            'Cache-Control:max-age=0',
            'Connection:keep-alive',
            'Host:'.$p3[0],
            'DNT:1',
            'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.132 Safari/537.36'
        ];
        curl_setopt($c, CURLOPT_HTTPHEADER, $header);
        $o = curl_exec($c);
        return $o;
    }


    public static function get_json($url){
        return json_decode(self::get($url), true);
    }
    
    public static function post($url, $data){
        $t1 = microtime(true);
        $c = curl_init();
        curl_setopt($c, CURLOPT_TIMEOUT, 30);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        $o = curl_exec($c);
        curl_close($c);
        $t2 = microtime(true);
        // Log::timeline("POST:$url", $t1, $t2);
        return $o;
    }    

    public static function post_h($url, $data){
        $t1 = microtime(true);
        $c = curl_init();
        curl_setopt($c, CURLOPT_TIMEOUT, 30);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        curl_setopt($c, CURLOPT_HTTPHEADER, [
            'Content-Type:plain/text',
            'Content-Length:'.strlen($data)
        ]);
        $o = curl_exec($c);
        curl_close($c);
        $t2 = microtime(true);
        return $o;
    }

    public static function get_with_header($url){
        $t1 = microtime(true);
        $c = curl_init();
        curl_setopt($c, CURLOPT_TIMEOUT, 30);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HEADER, true);
        // curl_setopt($c, CURLOPT_HEADER, 0);
        // curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
        // $p0 = explode('#', $url);
        // $p1 = explode('?', $p0[0]);
        // $p2 = explode('//', $p1[0]);
        // $p3 = explode('/', $p2[1]);
        // $header = [
        //     'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        //     'Accept-Encoding:gzip, deflate, sdch',
        //     'Accept-Language:en-US,en;q=0.8,zh-CN;q=0.6,zh;q=0.4,zh-TW;q=0.2,ja;q=0.2',
        //     'Cache-Control:max-age=0',
        //     'Connection:keep-alive',
        //     'Host:'.$p3[0],
        //     'DNT:1',
        //     'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.132 Safari/537.36'
        // ];
        // curl_setopt($c, CURLOPT_HTTPHEADER, $header);
        $o = curl_exec($c);
        curl_close($c);
        $t2 = microtime(true);
        // Log::timeline("GETH:$url", $t1, $t2);
        return self::decode_http($o);
        return $o;
    }

    public static function post_with_header($url, $data){
        $t1 = microtime(true);
        $c = curl_init();
        curl_setopt($c, CURLOPT_TIMEOUT, 30);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_HEADER, true);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        $o = curl_exec($c);
        curl_close($c);
        $t2 = microtime(true);
        // Log::timeline("POSTH:$url", $t1, $t2);
        return self::decode_http($o);
    }

    public static function decode_http($raw){
        $header = array();
        $dat_sp = explode("\r\n\r\n", $raw);
        $hdr_sp = explode("\r\n", $dat_sp[0]);
        preg_match('/^(\S+) (\S+) (\S+)$/', $hdr_sp[0], $pms);
        $hdr_length = count($hdr_sp);
        if(count($pms) > 3){
            $http_version      = $pms[1];
            $http_status_code  = $pms[2];
            $http_status_msg   = $pms[3];
        }else{
            $http_version      = '';
            $http_status_code  = '';
            $http_status_msg   = '';
        }
        for($i = 1; $i < $hdr_length; $i ++){
            $s = explode(": ", $hdr_sp[$i]);
            if(empty($header[$s[0]])){
                $header[$s[0]] = isset($s[1]) ? $s[1] : '';
            }else{
                if(is_array($header[$s[0]])){
                    $header[$s[0]][] = $s[1];
                }else{
                    $header[$s[0]] = array(
                        $header[$s[0]], $s[1]
                    );
                }
            }
        }
        $content = '';
        $dat_sp_length = count($dat_sp);
        for($i = 1; $i < $dat_sp_length; $i ++){
            $content .= $dat_sp[$i];
        }
        $ret = array(
            'http_version'     => $http_version,
            'http_status_code' => $http_status_code,
            'http_status_msg'  => $http_status_msg,
            'header'           => $header,
            'content'          => $content
        );
        return $ret;
    }
}