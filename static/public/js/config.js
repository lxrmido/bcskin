var C = {
    basePath : function(){
        if(window.URL_ROOT){
            return window.URL_ROOT;
        }
        return document.location.href.replace(/\/[^\/]+$/, '');
    },
    staticPath : function(){
        return C.basePath() + '/static';
    },
    modURL : function(c, a){
        return C.basePath() + '/?c=' + c + '&a=' + a;
    },
    methodURL : function(url){
        return C.basePath() + '/method.php?m=' + url;
    },
    jsonpURL : function(url){
        return C.basePath() + '/jsonp.php?m=' + url;
    },
    timeStr : function(timestamp, withsec){
        var ec = new Date(),
            et = new Date(timestamp * 1000);
        var yc = ec.getFullYear(), yt = et.getFullYear(),
            mc = ec.getMonth() + 1, mt = et.getMonth() + 1,
            dc = ec.getDate(), dt = et.getDate();
        var s = '';
        function f(x){ return x < 10 ? '0' + x : x; }
        switch(true){
            case yc == yt && mc == mt && dc == dt:
                s = '今天';
                break;
            case yc == yt && mc == mt && dc - dt == 1:
                s = '昨天';
                break;
            case yc == yt && mc == mt && dc - dt == 2:
                s = '前天';
                break;
            case ec.getTime() / 1000 - timestamp <= 86400 * 7:
                s = LANG.WEEKDAY[et.getDay()];
                break;
            case yc == yt:
                s = f(mt) + '月' + f(dt) + '日';
                break;
            default:
                s = yt + '年' + f(mt) + '月' + f(dt) + '日';
                break;
        }
        return s + ' ' + f(et.getHours()) + ':' + f(et.getMinutes()) + (withsec ? (":" + f(et.getSeconds())) : "");
    },
    defaultSkin : function(){
        return C.staticPath() + '/skin/img/char.png';
    }
};

var LANG = {
    CONTENT_NOT_EMPTY : function(prefix){
        return prefix + '的内容不能为空';
    },
    CONTENT_LENGTH : function(prefix, from, to){
        return prefix + '的长度需为' + from + '~' + to + '位';
    },
    CONTENT_LENGTH_FIXED : function(prefix, length){
        return prefix + '的长度需为' + length + '位';
    },
    CONTENT_LENGTH_LEAST : function(prefix, length){
        return prefix + '的长度最少需为' + length + '位';
    },
    NEED_CORRECT_EMAIL : '请输入合法的email地址',
    WEEKDAY : ['周日', '周一', '周二', '周三', '周四', '周五', '周六', '周日']
}

var KEYBOARD = {
    ENTER : 13
}