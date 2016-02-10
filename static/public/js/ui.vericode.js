$(function(){
    var ui = window.ui;
    
    ui.extendClass('vericode', 'Vericode');
    
    ui.WidgetVericode = function(option){
        if(!option){
            return;
        }
        option = ui.initOption({
            refresh : null,
            check : null
        }, option);
        
        ui.WidgetTextbox.call(this, option);
        
        var $e = $(this.element);
        
        var $img = $e.find('img');
        this.img  = $img[0];        
        var that = this;
        
        $img.on('click', function(){
            that.refresh();
        });
        
        $(this.input).focus(function(){
            if(!that._initialed){
                that.refresh();
            }
            $e.removeClass('warning').removeClass('correct');
        }).blur(function(){
            that.checkCode();
        });

        if(option.refresh){
            this.refresh = option.refresh;
        }
        if(option.checkCode){
            this.checkCode = option.checkCode;
        }
    }
    ui.WidgetVericode.prototype = new ui.WidgetTextbox();
    ui.WidgetVericode.prototype.checkCode = function(){
        var that = this;
        that.veriPass = false;
        if(that.val().length){
            G.method('vericode.check', {
                code : that.val()
            }, function(code, data){
                if(data.correct){
                    that.veriPass = true;
                    that.$.addClass('correct').removeClass('warning');
                }else{
                    that.$.addClass('warning').removeClass('correct');
                }
            });
        }else{
            that.$.addClass('warning').removeClass('correct');
        }
    }
    ui.WidgetVericode.prototype.refresh = function(){
        this._initialed = true;
        this.img.src = G.modURL('vericode', 'simple_code') + '&t=' + Math.random();
        this.$.removeClass('warning').removeClass('correct');
    }
    ui.WidgetVericode.prototype.check = function(){
        if(!this.veriPass){
            this.$.addClass('warning').removeClass('correct');
            return false;
        }
        return ui.Widget.prototype.check.call(this);
    }
});