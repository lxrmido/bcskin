$(function(){
	var settingTab = ui('#setting-tab', {
		view : {
			base   : '#view-base',
			safe   : '#view-safe',
		}
	});

	var settingFrame = ui('#setting-frame');

	var email = ui('#email', {
		limit : 200,
		tip : '#tip-email',
		check : [
			ui.CHECK_RULE.LENGTH(3, 200)
		]
	});

	var saveEmail = ui('#save-email', {
		click : function(){
			if(email.check()){
				G.method('member.edit_email', {
					email : email.val()
				}, function(c, d){
					email.tip.ok('已保存');
				}, function(c, m){
					email.tip.warn(m);
				});
			}
		}
	});

	var password = ui('#password', {
		check : [
			ui.CHECK_RULE.LENGTH_LEAST(6)
		],
		tip : '#tip-password'
	});
	var passwordConfirm = ui('#password-confirm', {
		check : [
			function(t, p){
				if(t == password.val()){
					return true;
				}
				return '两次输入密码不一致';
			}
		],
		tip : '#tip-password-confirm'
	});
	var oldPassword = ui('#old-password', {
		check : [
			ui.CHECK_RULE.NOT_EMPTY
		],
		tip : '#tip-password-save'
	});
	var passwordVericode = ui('#password-vericode');
	var savePassword = ui('#save-password', {
		click : function(){
			if(passwordVericode.check() && password.check() && passwordConfirm.check() && oldPassword.check()){
				G.method('member.edit_password', {
					new_pass : MD5(password.val()),
					old_pass : MD5(oldPassword.val()),
					vericode : passwordVericode.val()
				}, function(c, d){
					oldPassword.tip.ok('修改已保存');
				}, function(c, m){
					oldPassword.tip.warn(m);
				});
			}
		}
	});
});