var G = (function(window){
    
    var G = function(){
        
    }
    
    G.modURL = C.modURL;

    G.upload = function(url, arg, file, key_name, progress_callback, loaded_callback){
        var formData = new FormData(),
            oXHR     = new XMLHttpRequest();
        var i;

        oXHR.upload.addEventListener('progress', progress_callback, false);
        oXHR.addEventListener('load', loaded_callback, false);

        url = C.methodURL(url);

        for(i in arg){
            formData.append(i, arg[i]);
        }
        if(!('mid' in arg)){
            if(_RG && _RG.PG_GET && _RG.PG_GET.mid){
                formData.append('mid', _RG.PG_GET.mid);
            }
        }

        formData.append(key_name, file);
        
        oXHR.open('POST', url);
        oXHR.send(formData);
    };
    
    G.method = function(a, b, c, d){
        var url, arg, func_ok, func_er;
        if(arguments.length == 4){
            url = a;
            arg = b;
            func_ok = c;
            func_er = d;
        }else if(arguments.length == 3){
            url = a;
            if(typeof b == "function"){
                func_ok = b;
                func_er = c;
            }else{
                arg = b;
                func_ok = c;
            }
        }else if(arguments.length == 2){
            url = a;
            if(typeof b == "function"){
                func_ok = b;
            }else{
                arg = b;
            }
        }else{
            url = a;
        }
        arg = arg || {};

        if(!('mid' in arg)){
            if(_RG && _RG.PG_GET && _RG.PG_GET.mid){
                arg['mid'] = _RG.PG_GET.mid;
            }
        }

        var xhr = new XMLHttpRequest();
        xhr.handleerror = function(d){
            console.log(d)
            if(!d){
                console.error("Connetction error.");
            }else if(typeof d == "string"){
                console.error("XHRParseError");
                console.log([a, b, c, d]);
                console.log(d);
            }else if(d.code !== undefined){
                func_er && func_er(d.code, d.message);
            }else{
                console.error("XHRIllegal");
                console.log([a, b, c, d]);
                console.log(d);
            }
        }
        xhr.onreadystatechange = function(){
            var d;
            if(this.readyState == 4){
                if(this.status == 200){
                    d = this.responseText;
                    try{
                        d = JSON.parse(d);
                    }catch(e){
                        console.error("JSONParseError or CallbackError");
                        console.error(e);
                        this.handleerror(d);
                        return;
                    }
                    if(d.code && d.code > 0){
                        func_ok && func_ok(d.code, d.args)
                    }else{
                        this.handleerror(d);
                    }
                }else{
                    console.log(this.status);
                    this.handleerror();
                }
            }
        }
        xhr.open("POST", C.methodURL(url), true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(G.serialize(arg));
    };

    G.serialize = function(o){
        var a = [], i;
        for(i in o){
            a.push(i + '=' + encodeURIComponent(o[i]));
        }
        return a.join('&');
    };

    G.error = function(str){
        if(window.ui){
            ui.notify(str, true) || ui.alert(str);
        }else{
            alert(str);
        }
    };

    (function(){
        var d = document.createElement('div');
        var to_test = ['t', 'webkitT', 'mozT'];
        var i;
        for(i = 0; i < to_test.length; i ++){
            if((to_test[i] + 'ransform') in d.style){
                G.cssPrefix = to_test[i];
                return;
            }
        }
        if(!('dataset' in document.documentElement)){
            document.location.href = './?c=misc&a=browser_problem';
        }
    })();
    
    return G;
    
})(window);
