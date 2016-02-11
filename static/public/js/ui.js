/**
 * UI工具库
 * Ver.20160211.for.bilicraft
 * lxrmido@lxrmido.com
 * License:Apache 2.0
 */
$(function(){
        
    
    var ui = window.ui = function(element_selector, option){
        var $e = $(element_selector);
        if($e.length == 1){
            return initWidget($e[0], option);
        }else if($e.length == 0){
            return undefined;
        }
        var i;
        return $e.map(function(){
            return initWidget(this, option);
        });
    };
    

    var defaultClass = {
        'tpl'          : 'Tpl',
        'view'         : 'View',
        'tab-bar'      : 'TabBar',
        'textbox'      : 'Textbox',
        'input'        : 'Input',
        'toggle'       : 'Toggle',
        'button'       : 'Button',
        'tip'          : 'Tip',
        'pages'        : 'Pages',
        'search'       : 'Search',
        'select'       : 'Select',
        'simple-pages' : 'SimplePages'
    };

    var $body   = $(document.body), 
        $window = $(window);

    var _tpl = null;

    // 遍历读取data-node，附加到元素下
    function initNode(obj){
        var i, nd;
        if(!obj.childNodes || obj.childNodes.length == 0){
            return obj;
        }
        var namedNodes = {};
        for(i = 0; i < obj.childNodes.length; i ++){
            if(obj.childNodes[i].dataset && obj.childNodes[i].dataset.node){
                nd = obj.childNodes[i].dataset.node;
                namedNodes[nd] = obj[nd] = initNode(obj.childNodes[i]);
            }else if(obj.childNodes[i].getAttribute){
                nd = obj.childNodes[i].getAttribute('data-node');
                if(nd){
                    namedNodes[nd] = obj[nd] = initNode(obj.childNodes[i]);
                }
            }
        }
        if(obj.nodeset == undefined){
            obj.nodeset = namedNodes;
        }
        return obj;
    }
    
    function initWidget(e, option){
        var i;
        var cl = e.className.split(' ');
        option = option || {};
        option.element = e;
        for(i = 0; i < cl.length; i ++){
            if(defaultClass[cl[i]]){
                return new ui['Widget' + defaultClass[cl[i]]](option);
            }
        }
        return new ui.Widget(option);
    }

    
    function initOption(default_option, option){
        option = option || {};
        var i;
        for(i in default_option){
            if(!(i in option)){
                option[i] = default_option[i];
            }
        }
        return option;
    }
    
    // Make Element
    function mk(what, option){
        var d  = document.createElement(what);
        var $d = $(d);
        var i;
        if(option){
            for(i in option){
                switch(i){
                    case 'style':
                        $d = $d.css(option[i]);
                        break;
                    default:
                        d[i] = option[i];
                }
            }
        }
        return d;
    }
    
    // Make Div
    function mkdiv(option, content){
        if(typeof option == "string"){
            option = {
                className : option
            };
            if(content){
                option.innerHTML = content;
            }
        }else if(typeof option == "object"){
            
        }
        return mk('div', option);
    }
    
    ui.extendClass = function(className, type){
        defaultClass[className] = type;
    }
    ui.initOption = initOption;
    ui.mk         = mk;
    ui.mkdiv      = mkdiv;
    ui.initNode   = initNode;
    
    // Mon's offset of year
    ui.mon_offset = function (year, month) {
        var i, offset;
        for (i = 1, offset = 0; i < month; i ++) {
            offset += ui.mon_days(year, i);
        }
        return offset;
    }
    // Days in month
    ui.mon_days = function(year, month){
        return (month == 2 && ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0)) ? 29 : [31, 28, 31, 30,31, 30, 31, 31, 30, 31, 30, 31][month - 1];
    }
    // Day in week
    ui.week_day = function(year, month, day){
        function i(n){ return parseInt((year - 1) / n); }
        return (i(1) + i(4) - i(100) + i(400) + ui.mon_offset(year, month) + day) % 7;
    }
    // From timestamp to "xxxx-xx-xx xx:xx:xx"
    ui.time_to_str = function(timestamp){
        var date = new Date(timestamp * 1000);
        function fm(raw){ return raw < 10 ? ("0" + raw) : raw; }
        return date.getFullYear() + "-" + fm(date.getMonth() + 1) + "-" + fm(date.getDate()) + " " + fm(date.getHours()) + ":" + fm(date.getMinutes()) + ":" + fm(date.getSeconds());
    }
    // From "xxxx-xx-xx xx:xx:xx" to timestamp
    ui.str_to_time = function(s){
        s = s.split(/[\s-:]/);
        return parseInt((new Date(s[0] || 0, (s[1] - 1) || 0, s[2] || 0, s[3] || 0, s[4] || 0, s[5] || 0)).getTime() / 1000);
    }
    // create a mask to cover element or window
    ui.mask = function(element, no_append){
        var x, y, w, h;
        var rect = element ? element.getBoundingClientRect() : {left : 0, top : 0, width : '100%', height : '100%'};
        var mask = $(mkdiv('mask')).css({
            left   : rect.left,
            top    : rect.top,
            width  : rect.width,
            height : rect.height
        }).hide();
        if(!no_append){
            $body.append(mask);
        }
        return mask;
    }
    // create masks surround the element
    ui.maskWith = function(element){
        var rect = element.getBoundingClientRect();
        var mask = {};
        mask.top = mkMask({ top : 0, left : 0, right : 0, height : rect.top });
        mask.right = mkMask({ top : rect.top, right : 0, height : rect.height, left : rect.left + rect.width });
        mask.bottom = mkMask({ top : rect.top + rect.height, bottom : 0, left : 0, right : 0 });
        mask.left = mkMask({ top : rect.top, left : 0, height : rect.height, width : rect.left });
        mask.hide = function(t){
            mask.top.fadeOut(t);mask.right.fadeOut(t);mask.bottom.fadeOut(t);mask.left.fadeOut(t);
        };
        mask.show = function(t){
            mask.top.fadeIn(t);mask.right.fadeIn(t);mask.bottom.fadeIn(t);mask.left.fadeIn(t);
        }
        mask.remove = function(){
            mask.top.remove();mask.right.remove();mask.bottom.remove();mask.left.remove();
        }
        function mkMask(css){
            return mkdiv('mask').css(css);
        }
        $body.append(mask.top, mask.right, mask.bottom, mask.left);
        return mask;
    }
    // load a node as tpl node
    ui.loadTpl = function(element){
        _tpl = ui(element).element;
    }
    // create element from tpl
    ui.fromTpl = function(from){
        if(typeof from == "string"){
            from = _tpl[from];
        }
        return ui.initNode(from.cloneNode(true));
    }

    // position lib
    ui.position = {
        screenCenter : function(element){
            var $e = $(element);
            var w1 = $window.width(), h1 = $window.height();
            var w2 = $e.outerWidth(),   h2 = $e.outerHeight();
            $e.css({
                left : (w1 - w2) / 2,
                top  : (h1 - h2) / 2
            });
        }
    }

    // flex tips
    $body.on('mouseenter', '.ft', function(){
        var offset = $(this).offset();
        var x = offset.left + $(this).width() / 2;
        if(!this.flexTips){
            this.flexTips = ui.fromTpl('dwFlexTips');
            this.flexTips.dwText.innerHTML = this.dataset.flex;
            $body.append(this.flexTips);
        }else{
            $(this.flexTips).show();
        }
        var ft = $(this.flexTips);
        setTimeout(function(){
            ft.css({
                left : x - ft.width() / 2,
                top  : offset.top - ft.outerHeight() - 4,
                opacity : 1
            });
        }, 10);
        var that = this;
        this.rmto = setTimeout(function(){
            if(that.flexTips){
                $(that.flexTips).remove();
                that.flexTips = undefined;
            }
        }, 3000);
    }).on('mouseleave', '.ft', function(){
        if(this.flexTips){
            $(this.flexTips).remove();
            this.flexTips = undefined;
            clearTimeout(this.rmto);
        }
    }).on('mousedown', '.ft', function(){
        if(this.flexTips){
            $(this.flexTips).remove();
            this.flexTips = undefined;
            clearTimeout(this.rmto);
        }
    });

    var frameMask  = null;
    var frameCount = 0;
    var notifyArea = null;
    ui.initNotify = function(element){
        notifyArea = ui(element);
    }
    ui.notify = function(option, warn){
        if(typeof option == 'string'){
            option = {
                text : option,
                warn : !!warn,
                click : null
            };
        }
        option = initOption({
            warn : false,
            text : '!',
            className : 'nt',
            time : 6000,
            freq : 30
        }, option);
        var dom = mkdiv(option.className);
        if(notifyArea){
            notifyArea.$.prepend(dom);
        }else{
            return false;
        }
        if(option.warn){
            dom.className += ' warn';
        }
        dom.innerHTML = option.text;
        var durationDom = mkdiv('duration');
        dom.appendChild(durationDom);
        var duration = 0;
        var durationClock;
        $(dom).mouseenter(function(){
            if(durationClock){
                clearTimeout(durationClock);
            }
        }).mouseleave(function(){
            durtime();
        }).click(function(){
            hide();
        });
        setTimeout(function(){
            dom.className += ' show';
            durtime();
        }, 100);
        return dom;
        function hide(){
            dom.className += ' hide';
            setTimeout(function(){
                $(dom).remove();
            }, 500);
        }
        function durtime(){
            if(duration >= option.time){
                hide();
            }else{
                durationDom.style.width = (1 - duration / option.time) * 100 + '%';
                duration += option.freq;
                durationClock = setTimeout(durtime, option.freq);
            }
        }
    }
    ui.showFrameMask = function(){
        frameCount ++;
        if(frameMask){
            return;
        }
        frameMask = ui.mask().fadeIn(200);
    }
    ui.hideFrameMask = function(){
        frameCount --;
        if(!frameMask){
            return;
        }
        if(frameCount > 0){
            return;
        }
        frameMask.fadeOut(200, function(){
            frameMask && frameMask.remove();
            frameMask = null;
        })
    }
    ui.inputTips = function(option){
        option = ui.initOption({
            element : null,
            tpl : _tpl,
            tplNameFrame : 'dwInputTips',
            tplNameItem  : 'dwInputTipsItem',
            itemSelector : '.item',
            onselect : null
        }, option);
        var tf = option.tpl[option.tplNameFrame].clone();
        tf.setPos = function(){
            var offset = $(option.element).offset();
            var eleH   = $(option.element).outerHeight();
            var eleW   = $(option.element).outerWidth();
            $(tf).css({
                left  : offset.left,
                top   : offset.top + eleH,
                width : eleW 
            });
        };
        tf.show = function(){
            tf.style.display = 'block';
            tf.setPos();
            return tf;
        };
        tf.hide = function(){
            tf.style.display = 'none';
            return tf;
        };
        tf.refresh = function(string_array){
            tf.innerHTML = '';
            var i, d;
            for(i = 0; i < string_array.length; i ++){
                d = option.tpl[option.tplNameItem].clone();
                d.innerHTML = string_array[i];
                tf.appendChild(d);
            }
            return tf;
        }
        $(tf).on('mousedown', option.itemSelector, function(){
            if(tf.onselect){
                tf.onselect(this.innerHTML);
            }
        });
        if(option.onselect){
            tf.onselect = option.onselect;
        }
        $body.append(tf);
        return tf;
    }
    ui.alert = function(option){
        ui.showFrameMask();
        var win = ui.fromTpl('dwAlert');
        if(typeof option == "string"){
            option = {
                text : option
            };
        }else{
            option = option || {};
        }
        if(option.text){
            win.dwContent.dwText.innerHTML = option.text;
        }
        if(option.title){
            win.dwTitle.innerHTML = option.title;
        }
        function close(){
            ui.hideFrameMask();
            $window.off('keydown', kb);
            $(win).remove();
        }
        function kb(e){
            if(e.keyCode == KEYBOARD.ENTER){
                close();
                return false;
            }
        }
        $(win.dwCtrl.dwBtnFrame.dwBtnOk).click(close);
        $(win.dwClose).click(close);
        $window.on('keydown', kb);
        $body.append(win);
        ui.position.screenCenter(win);
        return win;
    }
    ui.confirm = function(option){
        ui.showFrameMask();
        var win = ui.fromTpl('dwConfirm');
        if(typeof option == "string"){
            option = {
                text : option
            };
        }else{
            option = option || {};
        }
        if(option.text){
            win.dwContent.dwText.innerHTML = option.text;
        }
        if(option.title){
            win.dwTitle.innerHTML = option.title;
        }
        function cancel(){
            option.cancelCallback && option.cancelCallback(option);
            ui.hideFrameMask();
            $(win).remove();
        }
        function ok(){
            option.okCallback && option.okCallback(option);
            ui.hideFrameMask();
            $(win).remove();
        }
        $(win.dwCtrl.dwBtnFrame.dwBtnOk).click(ok);
        $(win.dwCtrl.dwBtnFrame.dwBtnCancel).click(cancel);
        $(win.dwClose).click(cancel);
        $body.append(win);
        ui.position.screenCenter(win);
        return win;
    }
    ui.prompt = function(option){
        ui.showFrameMask();
        var win = ui.fromTpl('dwPrompt');
        if(typeof option == "string"){
            option = {
                text : option
            };
        }else{
            option = option || {};
        }
        if(option.text){
            win.dwContent.dwText.innerHTML = option.text;
        }
        if(option.title){
            win.dwTitle.innerHTML = option.title;
        }
        if(option.value){
            win.dwContent.dwInput.value = option.value;
        }
        function cancel(){
            option.cancelCallback && option.cancelCallback(option);
            ui.hideFrameMask();
            $(win).remove();
        }
        function ok(){
            var checkRet;
            if(option.check && ((checkRet = option.check(win.dwContent.dwInput.value)) !== true)){
                wgTip.warn(checkRet);
                return;
            }
            if(!option.okCallback){
                ui.hideFrameMask();
                $(win).remove();
            }else{
                if(option.okCallback(win.dwContent.dwInput.value, option) === false){

                }else{
                    ui.hideFrameMask();
                    $(win).remove();
                }
            }            
        }
        var wgTip = ui(win.dwContent.dwTip);
        $(win.dwCtrl.dwBtnFrame.dwBtnOk).click(ok);
        $(win.dwCtrl.dwBtnFrame.dwBtnCancel).click(cancel);
        $(win.dwContent.dwInput).focus(function(){
            wgTip.hide();
        });
        $(win.dwClose).click(cancel);
        $body.append(win);
        ui.position.screenCenter(win);
        $(win.dwContent.dwInput).focus().on('keydown', function(e){
            if(e.keyCode == KEYBOARD.ENTER){
                ok();
                return false;
            }
        });
        return win;
    }
    ui.select = function(option){
        ui.showFrameMask();
        var win = ui.fromTpl('dwSelect');
        if(typeof option == "string"){
            option = {
                text : option
            };
        }else{
            option = option || {};
        }
        if(option.text){
            win.dwContent.dwText.innerHTML = option.text;
        }
        if(option.title){
            win.dwTitle.innerHTML = option.title;
        }
        function cancel(){
            option.cancelCallback && option.cancelCallback(option);
            ui.hideFrameMask();
            $(win).remove();
        }
        function ok(){
            option.okCallback && option.okCallback(win.wgSelect.val(), option);
            ui.hideFrameMask();
            $(win).remove();
        }
        win.wgSelect = ui(win.dwContent.dwSelect);
        if(option.options){
            win.wgSelect.resetOptions(option.options);
        }
        if(option.value){
            win.wgSelect.val(option.value);
        }
        $(win.dwCtrl.dwBtnFrame.dwBtnOk).click(ok);
        $(win.dwCtrl.dwBtnFrame.dwBtnCancel).click(cancel);
        $(win.dwClose).click(cancel);
        $body.append(win);
        ui.position.screenCenter(win);
        return win;
    }
    ui.chooseDate = function(option){
        ui.showFrameMask();
        var win = ui.fromTpl('dwDate');
        var cal = win.dwContent.dwRowMain.dwColLeft.dwCalendar;
        var rco = win.dwContent.dwRowMain.dwColRight;
        var date;
        option = option || {};
        if(option.title){
            win.dwTitle.innerHTML = option.title;
        }
        if(option.timestamp !== undefined){
            date = new Date(option.timestamp * 1000);
        }else{
            date = new Date();
        }
        function cancel(){
            option.cancelCallback && option.cancelCallback(option);
            ui.hideFrameMask();
            $(win).remove();
        }
        function ok(){
            option.okCallback && option.okCallback(date.getTime() / 1000);
            ui.hideFrameMask();
            $(win).remove();
        }
        function makeDay(day){
            var dom = ui.fromTpl('dwDateDay');
            dom.innerHTML = day || '';
            return dom;
        }
        function refreshDate(){
            var year  = year  || date.getFullYear();
            var month = month || (date.getMonth() + 1);
            var day   = day   || date.getDate();
            cal.dwHd.dwYear.innerHTML  = year;
            cal.dwHd.dwMonth.innerHTML = month;
            rco.dwRow2.dwYear.value = year;
            rco.dwRow2.dwMon.value = month;
            rco.dwRow2.dwDay.value = day;
            var day_offset = ui.week_day(year, month, 1);
            var mon_days   = ui.mon_days(year, month);
            var i, d;
            cal.dwTable.innerHTML = '';
            for(i = 0; i < day_offset; i ++){
                d = makeDay();
                cal.dwTable.appendChild(d);
            }
            for(i = 1; i <= mon_days; i ++){
                d = makeDay(i);
                d.className += ' ac';
                if(i == day){
                    d.className += ' cur';
                }
                cal.dwTable.appendChild(d);
            }
        }
        function refreshTime(){
            rco.dwRow3.dwHour.value = date.getHours();
            rco.dwRow3.dwMin.value  = date.getMinutes();
            rco.dwRow3.dwSec.value  = date.getSeconds();
        }
        function getFromInput(){
            var h = parseInt(rco.dwRow3.dwHour.value) || 0,
                i = parseInt(rco.dwRow3.dwMin.value ) || 0,
                s = parseInt(rco.dwRow3.dwSec.value ) || 0, 
                y = parseInt(rco.dwRow2.dwYear.value) || 0,
                m = parseInt(rco.dwRow2.dwMon.value ) || 0,
                d = parseInt(rco.dwRow2.dwDay.value ) || 0;
            if(y < 1970){
                y = 1970;
            } 
            date.setYear(y);
            date.setMonth(m - 1);
            date.setDate(d);
            date.setHours(h);
            date.setMinutes(i);
            date.setSeconds(s);
            refreshDate();
            refreshTime();
        }
        $(rco).on('blur', 'input', function(){
            getFromInput();
        });
        $(rco.dwRow1.dwNow).click(function(){
            date = new Date();
            refreshDate();
            refreshTime();
        });
        $(cal.dwTable).on('mousedown', '.day', function(){
            var day = parseInt($(this).html());
            $(this).addClass('cur').siblings().removeClass('cur');
            date.setDate(day);
            rco.dwRow2.dwDay.value = day;
            return false;
        });
        $(cal.dwHd.dwLeft).mousedown(function(){
            if(date.getFullYear() <= 1970 && date.getMonth() == 0){
                return false;
            }
            var newMonth = date.getMonth() - 1;
            if(newMonth < 0){
                newMonth = 11;
                date.setYear(date.getFullYear() - 1);
            }
            date.setMonth(newMonth);
            refreshDate();
            return false;
        });
        $(cal.dwHd.dwVer.dwDown).mousedown(function(){
            if(date.getFullYear() <= 1970){
                return false;
            }
            date.setYear(date.getFullYear() - 1);
            refreshDate();
            return false;
        });
        $(cal.dwHd.dwVer.dwUp).mousedown(function(){
            date.setYear(date.getFullYear() - 1);
            refreshDate();
            return false;
        });
        $(cal.dwHd.dwRight).mousedown(function(){
            var newMonth = date.getMonth() + 1;
            if(newMonth > 11){
                newMonth = 0;
                date.setYear(date.getFullYear() + 1);
            }
            date.setMonth(newMonth);
            refreshDate();
            return false;
        });
        refreshDate();
        refreshTime();
        $(win.dwCtrl.dwBtnFrame.dwBtnOk).click(ok);
        $(win.dwCtrl.dwBtnFrame.dwBtnCancel).click(cancel);
        $(win.dwClose).click(cancel);
        $body.append(win);
        ui.position.screenCenter(win);
        return win;
    }
    
    ui.CHECK_RULE = {
        NOT_EMPTY : function(text, prefix){
            if(text.length <= 0){
                return LANG.CONTENT_NOT_EMPTY(prefix);
            }
            return true;
        },
        LENGTH : function(from, to){
            return function(text, prefix){
                if(text.length >= from && text.length <= to){
                    return true;
                }
                return LANG.CONTENT_LENGTH(prefix, from, to)
            }
        },
        LENGTH_FIXED : function(length){
            return function(text, prefix){
                if(text.length == length){
                    return true;
                }
                return LANG.CONTENT_LENGTH_FIXED(prefix, length)
            }
        },
        LENGTH_LEAST : function(length){
            return function(text, prefix){
                if(text.length >= length){
                    return true;
                }
                return LANG.CONTENT_LENGTH_LEAST(prefix, length)
            }
        },
        EMAIL : function(text, prefix){
            if(text.match(/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/)){
                return true;
            }
            return LANG.NEED_CORRECT_EMAIL;
        }
    };
    
    ui.check = function(widgets){
        var i;
        for(i = 0; i < widgets.length; i ++){
            if(!widgets[i].check()){
                return false;
            }
        }
        return true;
    }
    
    ui.Widget = function(option){
        if(!option){
            return;
        }
        
        option = initOption({
            initNode : true,
            initNodeWithCallback : false
        }, option);
        
        this.option = option;
        this.element = option.element || mkdiv(option.className);
        this.$ = $(this.element);
                
        if(typeof this.element == 'string'){
            this.element = $(this.element)[0];
        }

        this.element.linkedUIWidget = this;
        
        if(option.initNode){
            initNode(this.element);
        }
        
        if(option.tip){
            this.tip = new ui.WidgetTip({
                element : option.tip
            });
        }
        
        if(option.check){
            this.checkRule = option.check;
        }
        
        if(option.prefix){
            this.prefix = option.prefix;
        }
    }
    ui.Widget.prototype = {
        loading : function(isl){
            if(isl){
                this.$.addClass('spin-loading');
            }else{
                this.$.removeClass('spin-loading');
            }
            return this;
        },
        val : function(v){
            if(v == undefined){
                return this.$.val();
            }else{
                this.$.val(v);
            }
        },
        check : function(){
            if(!this.checkRule){
                this.checkPass = true;
                return true;
            }
            var i;
            var value = this.val();
            var ret;
            for(i = 0; i < this.checkRule.length; i ++){
                ret = this.checkRule[i](value, this.prefix);
                if(ret !== true){
                    this.warn(ret);
                    return false;
                }
            }
            this.cancelWarn();
            this.checkPass = true;
            return true;
        },
        warn : function(text){
            this.$.removeClass('correct').addClass('warning');
            if(this.tip){
                return this.tip.warn(text);
            }
        },
        cancelWarn : function(){
            this.$.removeClass('warning').addClass('correct');
            if(this.tip){
                return this.tip.hide();
            }
        },
        show : function(){
            this.$.show.apply(this.$, arguments);
        },
        hide : function(){
            this.$.hide.apply(this.$, arguments);
        },
        initAsList : function(tpl, dataList, callback){
            var i, e;
            var $l = this.$;
            $l.html('');
            for(i = 0; i < dataList.length; i ++){
                e = ui.initNode(tpl.cloneNode(true));
                callback(e, dataList[i]);
                $l.append(e);
            }
        }
    };

    ui.WidgetTpl = function(option){
        if(!option){
            return;
        }

        var that = this;

        option = initOption({
            
        }, option);

        ui.Widget.call(this, option);

        var i;

        if(this.element.nodeset){
            for(i in this.element.nodeset){
                (function(){
                    var o = that.element.nodeset[i];
                    that[o.dataset.node] = o;
                    o.clone = function(){
                        return initNode(o.cloneNode(true));
                    }
                })();
            }
        }
    }
    
    ui.WidgetTabBar = function(option){
        if(!option){
            return;
        }
        option = initOption({
            className : 'tab-bar',
            tabClassName : 'tab',
            view : {},
            selected : null,
            onswitch : null
        }, option);
        
        ui.Widget.call(this, option);
        
        
        var $e = $(this.element);
        var that = this;
        var sel;
        
        $e.on('click', '.' + option.tabClassName, function(e){
            var k = $(this).attr('key');
            that.switchTo(k);
        });
        
        var i;
        this.view = {};
        for(i in option.view){
            this.linkView(i, option.view[i]);
        }   
        if(option.onswitch){
            this.onswitch = option.onswitch;
        }
        if(!option.selected){
            sel = $e.find('.selected').attr('key');
            if(sel){
                this.switchTo(sel);
            }
        }else{
            this.selected = option.selected;
        }
    }
    ui.WidgetTabBar.prototype = new ui.Widget();
    ui.WidgetTabBar.prototype.addTab = function(key, html){
        var d = mkdiv(this.option.tabClassName, html);
        d.setAttribute('key', key);
        this.element.appendChild(d);
        return this;
    }
    ui.WidgetTabBar.prototype.switchTo = function(key){
        var that = this;
        $(this.element).
            find('.' + this.option.tabClassName).
            each(function(){
                var k = this.getAttribute('key');
                if(k == key){
                    $(this).addClass('selected');
                    that.view[k].show();
                }else{
                    $(this).removeClass('selected');
                    that.view[k].hide();
                }
            });
        this.selected = key;
        this.onswitch && this.onswitch(key);
        return this;
    }
    ui.WidgetTabBar.prototype.linkView = function(key, view, option){
        option = option || {};
        if(typeof view == 'string'){
            option.element = view;
            view = new ui.WidgetView(option);
        }
        this.view[key] = view;
    }
    ui.WidgetTabBar.prototype.val = function(v){
        if(v === undefined){
            return this.selected;
        }else{
            return this.switchTo(v);
        }
    }
    
    ui.WidgetView = function(option){
        if(!option){
            return;
        }
        option = initOption({
            className : 'view'
        }, option);
        
        ui.Widget.call(this, option);
        
    }
    ui.WidgetView.prototype = new ui.Widget();
    ui.WidgetView.prototype.hide = function(){
        this.element.style.display = 'none';
        return this;
    }
    ui.WidgetView.prototype.show = function(){
        this.element.style.display = 'block';
        return this;
    }

    ui.WidgetInput = function(option){
        if(!option){
            return;
        }
        option = initOption({
            className : 'input',
            type : 'text',
            onchange : null,
            onblur : null,
            inputTips : null,
            value : null,
            onenter : null
        }, option);

        ui.Widget.call(this, option);
        
        var $e = $(this.element);

        if(option.inputTips){
            this.setInputTips(option.inputTips);
        }

        if(option.value){
            this.element.value = option.value;
        }

        var that = this;

        var lastValue = this.element.value;

        function checkChange(){
            if(that.element.value == lastValue){
                return;
            }
            that.change(that.element.value, lastValue);
            lastValue = that.element.value;
        }

        $e.mousedown(checkChange).
            mouseup(checkChange).
            keyup(checkChange).
            keydown(function(e){
                checkChange();
                if(e.keyCode == KEYBOARD.ENTER){
                    if(that.onenter){
                        that.onenter();
                    }
                }
            }).
            blur(checkChange);

        if(option.onchange){
            this.onchange = option.onchange;
        }
        if(option.onenter){
            this.onenter = option.onenter;
        }

    }
    ui.WidgetInput.prototype.setInputTips = function(callback){
        var that = this;
        that.inputTips = ui.inputTips({
            element : that.element,
            onselect : function(v){
                that.val(v);
            }
        });
        that.inputTipsCallback = callback;
        that.$.focus(function(){
            that.inputTips.refresh([]).show();
        }).blur(function(){
            that.inputTips.hide();
        });
    }
    ui.WidgetInput.prototype.change = function(newValue, oldValue){
        var that = this;
        if(this.onchange){
            this.onchange(newValue, oldValue);
        }
        if(this.inputTipsCallback){
            this.inputTipsCallback(function(string_array){
                that.inputTips.refresh(string_array);
            });
        }
    }
    ui.WidgetInput.prototype.val = function(value){
        if(value == undefined){
            return this.element.value;
        }else{
            this.element.value = value;
            return this;
        }
    }
    
    ui.WidgetTextbox = function(option){
        if(!option){
            return;
        }
        option = initOption({
            className : 'textbox',
            labelClassName : 'label',
            type : 'text',
            onchange : null,
            onblur : null
        }, option);
        
        ui.Widget.call(this, option);
        
        var $e = $(this.element);
        var $label = $e.find('.' + option.labelClassName);
        var $input = $e.find('input');
        var that   = this;

        if($label.length == 0){
            if(option.label){
                this.label = mkdiv(option.labelClassName, option.label);
                $label = $(this.label);
            }
        }else{
            this.label = $label[0];
        }
        
        if($input.length == 0){
            this.input = mk('input', option);
            $input = $(this.input);
        }else{
            this.input = $input[0];
        }

        this.lastValue = this.input.value;
        if(this.lastValue.length){
            this.refreshWordCount();
        }
        this.onchange = option.onchange;
        this.onblur = option.onblur;
        
        if((!this.prefix) && this.label){
            this.prefix = this.label.innerHTML;
        }
        
        $input.focus(function(){
            $e.addClass('focus');
        }).blur(function(){
            $e.removeClass('focus');
            that.check && that.check();
            that.onblur && that.onblur();
        }).keydown(function(e){
            if(e.keyCode == KEYBOARD.ENTER){
                if(option.enter){
                    option.call(that, e);
                }
            }
        }).mouseup(function(){
            that.valueChanged(true);
        }).keyup(function(){
            that.valueChanged(true);
        }).change(function(){
            that.valueChanged(true);
        });
        
        if(option.limit){
            this.setLimit(option.limit);
        }

    }
    ui.WidgetTextbox.prototype = new ui.Widget();
    ui.WidgetTextbox.prototype.val = function(v){
        var ds;
        if(v == undefined){
            return $(this.input).val();
        }else{
            $(this.input).val(v);
            this.valueChanged();
            return this;
        }
    }
    ui.WidgetTextbox.prototype.disabled = function(v){
        if(v == undefined){
            return this.input.disabled;
        }
        this.input.disabled = v;
    }
    ui.WidgetTextbox.prototype.setLimit = function(limit){
        var $input = $(this.input);
        if(!this.wc){
            this.wc = mkdiv('wc');
            this.element.appendChild(this.wc);
            $(this.input).addClass('with-wc');
        }
        this.limit = limit;
        this.refreshWordCount();
        return this;
    }
    ui.WidgetTextbox.prototype.valueChanged = function(by_ui){
        var fm;
        if(this.input.value == this.lastValue){
            return;
        }
        if(this.onchange){
            this.onchange(this.input.value, this.lastValue, by_ui);
        }
        this.lastValue = this.input.value;
        this.refreshWordCount();
    }
    ui.WidgetTextbox.prototype.refreshWordCount = function(){
        if(!this.wc){
            return this;
        }
        this.wc.innerHTML = this.input.value.length + '/' + this.limit;
        if(this.input.value.length > this.limit){
            $(this.wc).addClass('beyond');
        }else{
            $(this.wc).removeClass('beyond');
        }
        return this;
    }
    
    
    ui.WidgetToggle = function(option){
        if(!option){
            return;
        }
        option = initOption({
            className : 'toggle',
            checked : false,
            toggle : null,
            disabled : false
        }, option);
        
        ui.Widget.call(this, option);
        
        var $e = $(this.element);
        this.checked = option.checked;
        if($e.hasClass('checked')){
            this.checked = true;
        }else if(this.checked){
            $e.addClass('checked');
        }
        var that = this;
        this.ontoggle = option.toggle;
        $e.click(function(){
            if(!that.disabled){
                that.toggle();
            }
        })
    }
    ui.WidgetToggle.prototype = new ui.Widget();
    ui.WidgetToggle.prototype.toggle = function(){
        this.val(!this.checked);
        this.ontoggle && this.ontoggle.call(this, this.checked);
        return this;
    }
    ui.WidgetToggle.prototype.val = function(val){
        if(val == undefined){
            return this.checked;
        }
        this.checked = val;
        if(val){
            $(this.element).addClass('checked');
        }else{
            $(this.element).removeClass('checked');
        }
        return this;
    }
    
    ui.WidgetButton = function(option){
        if(!option){
            return;
        }
        option = initOption({
            click    : null,
            disabled : false
        }, option);
        
        ui.Widget.call(this, option);
        
        var $e = $(this.element);
        
        var that = this;

        this.onclick = option.click;

        $e.click(function(e){
            if(that._disabled){
                return;
            }
            if(that.onclick){
                that.onclick.call(that, e);
            }
        });

        this._disabled = $e.hasClass('disabled');

        if(option.disabled){
            this.disabled(true);
        }
        
    }
    ui.WidgetButton.prototype = new ui.Widget();
    ui.WidgetButton.prototype.loading = function(v){
        this.disabled = v;
        return ui.Widget.prototype.loading.call(this, v);
    }
    ui.WidgetButton.prototype.disabled = function(v){
        if(v === undefined){
            return this._disabled;
        }
        if(v === true){
            this._disabled = true;
            this.$.addClass('disabled');
        }else{
            this._disabled = false;
            this.$.removeClass('disabled');
        }
    }
    
    ui.WidgetTip = function(option){
        if(!option){
            return;
        }
        option = initOption({
            click : null
        }, option);
        
        ui.Widget.call(this, option);
        
        var $e = this.$.hide();
    }
    ui.WidgetTip.prototype = new ui.Widget();
    ui.WidgetTip.prototype.show = function(){
        this.$.slideDown();
        return this;
    }
    ui.WidgetTip.prototype.hide = function(){
        this.$.slideUp();
        return this;
    }
    ui.WidgetTip.prototype.warn = function(text){
        this.$.
            removeClass('green').
            removeClass('blue').
            addClass('red').
            html(
                '<i class="icon-warning-sign"></i>&nbsp;' + text
            );
        return this.show();
    }
    ui.WidgetTip.prototype.ok = function(text){
        this.$.
            removeClass('red').
            removeClass('blue').
            addClass('green').
            html(
                '<i class="icon-ok"></i>&nbsp;' + text
            );
        return this.show();
    }
    ui.WidgetTip.prototype.info = function(text){
        this.$.
            removeClass('red').
            removeClass('green').
            addClass('blue').
            html(
                '<i class="icon-info-sign"></i>&nbsp;' + text
            );
        return this.show();
    }
    ui.WidgetPages = function(option){
        if(!option){
            return;
        }
        option = initOption({
            page_amount  : 99,
            page_current : 10,
            prev_icon : '<i class="icon-angle-left"></i>',
            next_icon : '<i class="icon-angle-right"></i>',
            gotoPage : null
        }, option);
        
        ui.Widget.call(this, option);
        
        var $e = this.$.on('click', '.item', function(){
            if(option.gotoPage){
                option.gotoPage(this.pageIndex);
            }
        });
        this.prev_icon = option.prev_icon;
        this.next_icon = option.next_icon;
        this.refresh(option.page_current, option.page_amount);
    }
    ui.WidgetPages.prototype = new ui.Widget();
    ui.WidgetPages.prototype.refresh = function(cur, all){
        var start, end;
        start = cur - 2;
        if(start < 1){
            start = 1;
        }
        end = cur + 2;
        if(end > all){
            end = all;
        }
        this.$.html('');
        
        function mkpg(n, c){
            var d = mkdiv((i == cur ? 'item cur' : 'item'), c || n);
            d.pageIndex = n;
            return d;
        }
        
        if(start != 1){
            this.$.append(mkpg(cur - 1, this.prev_icon));
            this.$.append(mkpg(1));
            this.$.append(mkdiv('dot'));
        }
        var i;
        for(i = start; i <= end; i ++){
            this.$.append(mkpg(i));
        }
        if(end != all){
            this.$.append(mkdiv('dot'));
            this.$.append(mkpg(all));
            this.$.append(mkpg(cur + 1, this.next_icon));
        }
    }
    
    ui.WidgetSearch = function(option){
        if(!option){
            return;
        }
        option = initOption({
            buttonClassName : 'search-button',
            onsearch : null
        }, option);
        
        ui.Widget.call(this, option);
        
        var $e = this.$;
        var that = this;
        
        var $input = $e.find('input');
        var $btn   = $e.find('.' + option.buttonClassName);
        
        this.input  = $input[0];
        this.button = $btn[0];
        
        this.onsearch = option.onsearch;
        
        $input.keydown(function(e){
            if(e.keyCode == 13){
                that.search();
                return;
            }
        })
        $btn.click(function(){
            that.search();
        });
    }
    ui.WidgetSearch.prototype = new ui.Widget();
    ui.WidgetSearch.prototype.val = function(v){
        return ui.WidgetTextbox.prototype.val.call(this, v);
    }
    ui.WidgetSearch.prototype.search = function(kw){
        kw = kw || this.val();
        console.log(this.onsearch);
        if(this.onsearch){
            this.onsearch(kw);
        }
        return this;
    }

    ui.WidgetSearch.prototype.valueChanged = function(){
        
    }

    ui.WidgetSelect = function(option){
        if(!option){
            return;
        }
        option = initOption({
            className : 'select',
            selectedClassName : 'selected',
            optionListClassName : 'option-list',
            optionFrameClassName : 'option-frame',
            optionClassName : 'option',
            value : null,
            onselect : null,
            options : {},
            slim : false
        }, option);
        
        ui.Widget.call(this, option);
        
        var $e = $(this.element);

        if($e.hasClass('slim')){
            option.slim = true;
        }else if(option.slim){
            $e.addClass('slim');
        }

        if(option.slim){
            this.slim = true;
            option.optionListClassName += ' slim';
        }

        var options = {};
        this.options = options;

        var optionList = mkdiv(option.optionListClassName);
        this.optionList = optionList;

        var selected = mkdiv(option.selectedClassName);
        this.selected = selected;

        this.optionClassName = option.optionClassName;
        this.optionFrameClassName = option.optionFrameClassName;

        $e.find('.' + option.optionClassName).each(function(){
            var $t = $(this);
            var v, n;
            if($t.attr('value')){
                v = $t.attr('value');
            }else{
                v = $t.html();
                $t.attr('value', v);
            }
            n = $t.html();
            this.value = v;
            options[v] = {
                name    : n,
                element : this
            };
        });
        var i, d, on;
        for(i in option.options){
            d = mkdiv(option.optionClassName);
            d.innerHTML = option.options[i];
            d.value = i;
            d.setAttribute('value', i);
            options[i] = {
                name    : option.options[i],
                element : d
            };
        }
        for(i in options){
            d = mkdiv(option.optionFrameClassName);
            d.appendChild(options[i].element);
            optionList.appendChild(d);
            if(!on){
                on = i;
            }
        }
        $e.append(selected);
        $body.append(optionList);
        this.value = undefined;
        if(option.view){
            for(i in option.view){
                this.linkView(i, option.view[i]);
            }
        }
        if(option.value){
            this.select(option.value);
        }else if(on){
            this.select(on);
        }
        this.onselect = option.onselect;
        var that = this;
        $e.click(function(){
            that.showOptions();
        })
        $(optionList).on('mousedown', '.' + option.optionClassName, function(){
            that.select(this.value);
            that.hideOptions();
            return false;
        });
        this.hideOptions = function(){
            $(window).off('mousedown', that.hideOptions);
            that.$.css('min-width', '1px');
            $(that.optionList).hide();
        };
    }

    ui.WidgetSelect.prototype = new ui.Widget();
    ui.WidgetSelect.prototype.select = function(k){
        if(this.value == k){
            return this;
        }else{
            this.value = k;
            if(this.onselect){
                this.onselect(k);
            }
        }
        if(this.options[k]){
            this.selected.innerHTML = this.options[k].name;
        }
        var that = this;
        if(this.view){
            var i;
            for(i in this.view){
                if(i == k){
                    this.view[i].show();
                }else{
                    this.view[i].hide();
                }
            }
        }
        return this;
    }
    ui.WidgetSelect.prototype.val = function(k){
        if(k !== undefined){            
            return this.select(k);
        }else{
            return this.value;
        }
    }
    ui.WidgetSelect.prototype.showOptions = function(){
        var that = this;
        var rect = this.element.getBoundingClientRect();
        $(this.optionList).slideDown(200).css({
            left : rect.left,
            top  : rect.top + that.$.outerHeight() - 1
        });
        var w = 0;

        this.$.css('min-width', ($(this.optionList).width()));
        rect = this.element.getBoundingClientRect();
        $(this.optionList).css({
            left : rect.left,
            top  : rect.top + that.$.outerHeight() - 1
        });
        $(window).on('mousedown', that.hideOptions);
    }
    ui.WidgetSelect.prototype.linkView = function(key, view, option){
        option = option || {};
        if(typeof view == 'string'){
            option.element = view;
            view = new ui.WidgetView(option);
        }
        this.view = this.view || {};
        this.view[key] = view;
    }
    ui.WidgetSelect.prototype.resetOptions = function(options){
        var i;
        this.optionList.innerHTML = '';
        this.options = {};
        for(i in options){
            this.addOption(options[i], i)
        }
        this.select(this.val());
        return this;
    }
    ui.WidgetSelect.prototype.addOption = function(title, value){
        var ef, e;
        ef = mkdiv(this.optionFrameClassName);
        e = mkdiv(this.optionClassName);
        e.innerHTML = title;
        e.value = value;
        e.setAttribute('value', value);
        this.options[value] = {
            name    : title,
            element : e
        };            
        ef.appendChild(e);
        this.optionList.appendChild(ef);
        return this;
    }

    ui.WidgetSimplePages = function(option){
        if(!option){
            return;
        }
        option = initOption({
            tpl : 'dwSimplePage',
            page_amount  : 0,
            page_current : 1,
            gotoPage : null
        }, option);
        
        ui.Widget.call(this, option);
        
        var $e = $(this.element);

        this.pageElement = ui.fromTpl(option.tpl);

        $e.append(this.pageElement);

        var that = this;

        this.ongotopage   = option.gotoPage;
        this.page_current = option.page_current;
        this.page_amount  = option.page_amount;

        $(this.pageElement.dwInput).keydown(function(e){
            if(e.keyCode == KEYBOARD.ENTER){
                that.go();
            }
        });
        $(this.pageElement.dwJump).click(function(){
            that.go();
        });
        $(this.pageElement.dwNext).click(function(){
            that.go(that.page_current + 1);
        });
        $(this.pageElement.dwPrev).click(function(){
            that.go(that.page_current - 1);
        });
        this.refresh(option.page_current, option.page_amount);
    }
    ui.WidgetSimplePages.prototype = new ui.Widget();
    ui.WidgetSimplePages.prototype.refresh = function(cur, all){
        this.pageElement.dwLabel.innerHTML = cur + ' / ' + all;
        if(cur <= 1){
            this.pageElement.dwPrev.style.display = 'none'
        }else{
            this.pageElement.dwPrev.style.display = 'block'
        }
        if(cur >= all){
            this.pageElement.dwNext.style.display = 'none'
        }else{
            this.pageElement.dwNext.style.display = 'block'
        }
        this.page_current = parseInt(cur) || 1;
        this.page_amount  = parseInt(all) || 1;
    }
    ui.WidgetSimplePages.prototype.go = function(n){
        var pg = parseInt(n || this.pageElement.dwInput.value);
        if(isNaN(pg)){
            pg = 1;
        }
        this.pageElement.dwInput.value = pg;
        if(this.ongotopage){
            this.ongotopage(pg);
        }
        return this;
    }
    
});