$(function(){



	var viewError = ui('#view-error').hide();
	var viewLogined = ui('#view-logined').hide();
	var viewNoLogin = ui('#view-no-login').hide();
	var viewNoRegister = ui('#view-no-register').hide();

	var errorSignTips = ui('#error-sign-tips');


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
