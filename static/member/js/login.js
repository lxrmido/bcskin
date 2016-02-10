$(function(){
    
    var ui = window.ui;
    
    ui('#login-tab-bar-main', {
        view : {
            login    : '#view-login',
            register : '#view-register'
        },
        onswitch : function(key){
            
        }
    });
    
    var lgAccount  = ui('#login-account', {
        check : [
            ui.CHECK_RULE.NOT_EMPTY
        ],
        tip : '#tips-login-account'
    });
    lgAccount.$.keydown(function(e){
        if(e.keyCode == KEYBOARD.ENTER){
            login();
        }
    });
    var lgPassword = ui('#login-password', {
        check : [
            ui.CHECK_RULE.NOT_EMPTY
        ],
        tip : '#tips-login-password'
    });
    lgPassword.$.keydown(function(e){
        if(e.keyCode == KEYBOARD.ENTER){
            login();
        }
    });
    var lgVericode = ui('#login-vericode');
    lgVericode.$.keydown(function(e){
        if(e.keyCode == KEYBOARD.ENTER){
            login();
        }
    });
    var lgKeep = ui('#login-remember');
    var lgTips = ui('#tips-login');
    var lgSubmit = ui('#login-submit', {
        click : function(){
            login();
        }
    });
    
    
    var rgAccount = ui('#register-account', {
        check : [
            ui.CHECK_RULE.NOT_EMPTY
        ],
        tip : '#tips-register-account'
    });
    var rgEmail = ui('#register-email', {
        check : [
            ui.CHECK_RULE.NOT_EMPTY
        ],
        tip : '#tips-register-email'
    });
    var rgPassword = ui('#register-password', {
        check : [
            ui.CHECK_RULE.NOT_EMPTY
        ],
        tip : '#tips-register-password'
    });
    var rgPasswordConfirm = ui('#register-password-confirm', {
        check : [
            ui.CHECK_RULE.NOT_EMPTY,
            function(text, prefix){
                if(text != rgPassword.val()){
                    return '两次输入密码不一致';
                }
                return true;
            }
        ],
        tip : '#tips-register-password-confirm'
    });
    var rgVericode = ui('#register-vericode');
    var rgTips = ui('#tips-register');
    var rgSubmit = ui('#register-submit', {
        click : function(){
            register();
        }
    });

    
    function login(){
        if(
            lgAccount.check() && 
            lgPassword.check() 
        ){
            G.method('member.login', {
                account  : lgAccount.val(),
                password : lgPassword.val(),
                code     : lgVericode.val(),
                keep     : lgKeep.val() ? 1 : 0
            }, function(){
                lgTips.hide();
                document.location.href = './?c=member&a=logined&k=' + (lgKeep.val() ? 1 : 0);
            }, function(c, m){
                lgTips.warn(m);
            });
        }
    }
    
    function register(){
        if(
            rgAccount.check() && 
            rgEmail.check() && 
            rgPassword.check() && 
            rgPasswordConfirm.check() && 
            rgVericode.check()
        ){
            G.method('member.register', {
                username : rgAccount.val(),
                password : rgPassword.val(),
                email    : rgEmail.val(),
                code     : rgVericode.val()
            }, function(c, d){
                rgTips.hide();
                document.location.href = './?c=member&a=logined&k=' + (lgKeep.val() ? 1 : 0);
            }, function(c, m){
                rgTips.warn(m);
            });
        }
    }
    
});