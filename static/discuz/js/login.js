$(function(){



	var viewError = ui('#view-error').hide();
	var viewLogined = ui('#view-logined').hide();
	var viewNoLogin = ui('#view-no-login').hide();
	var viewNoRegister = ui('#view-no-register').hide();

	var errorSignTips = ui('#error-sign-tips');
	var iptAccount  = ui('#ipt-account');
	var iptPassword = ui('#ipt-password');

	var btnRegister = ui('#btn-register', {
		click : function(){
			var username = iptAccount.val();
			var password = iptPassword.val();
			if(!username.length){
				error('请输入游戏ID');
				return;
			}
			if(!password.length){
				error('请输入密码');
				return;
			}
			G.method('discuz.register', {
				dz_uid : window.discuz_auth.uid,
				auth   : window.discuz_auth.autj,
				username : username,
				password : MD5(password)
			}, function(c, d){
				document.location.href = './?c=member&a=logined&k=1';
			}, function(c, m){
				error(m);				
			});
		}
	});


	window.discuz_login = function(r){
		if(r.uid && r.uid > 0){
			viewLogined.show();
			G.method('discuz.trylogin', {
				uid  : r.uid,
				auth : r.auth
			}, function(c, d){
				if(d.uid && d.uid > 0){
					document.location.href = './?c=member&a=logined&k=1';
				}else{
					window.discuz_auth = d;
					viewNoRegister.show();
				}
			}, function(c, m){
				error(m);
			});
		}else{
			viewNoLogin.show();
		}
	};

	var sn  = document.createElement('script');
	sn.type = 'text/javascript';
	sn.src  = bcs_url;
	$('head').append(sn);

	function error(m){
		viewError.show();
		errorSignTips.$.html(m);
	}

});
