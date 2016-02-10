var util = {
    strCode : "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",
    randKey : function(length){
        var s = '';
        var i;
        for(i = 0; i < length; i ++){
            s += this.randChar();
        }
        return s;
    },
    randChar : function(){
        return this.strCode[parseInt(Math.random() * this.strCode.length)];
    },
    fromUnicode : function(s){
        s = s.replace(/u([\w]{4})/g, '\\u$1');
        try{
            eval("s='"+s+"'");
        }catch(e){
            console.log(s)
        }
        return s;
    }
};



// USER
$(function(){

    var headerUser = ui('#header-user');
    if(_RG.user){
        headerUser.$.show();
        headerUser.element.dwUsername.innerHTML = _RG.user.username;
        if(_RG.user.is_admin){
            headerUser.$.find('.admin').show();
        }else{
            headerUser.$.find('.admin').hide();
        }
    }else{
        headerUser.$.hide();
    }
    ui.loadTpl('#ui-tpl');
    ui.initNotify('#notify-area');

    
});
