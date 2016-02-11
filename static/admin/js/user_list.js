$(function(){

	var tpl = ui('#tpl');

	var currentGroupId  = 0;
	var currentListPage = 1; 

	var listTab = ui('#list-tab', {
		view : {
			group : '#view-group',
			find  : '#view-find'
		}
	});

	var groupList = ui('#group-list');
	groupList.$.on('click', '.item', function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		refreshUserList(this.tData.id, 1);
	});

	var userList = ui('#user-list');
	userList.$.on('click', '.ctrl-item', listCtrl);

	var userPages = ui('#user-pages', {
		gotoPage : function(page){
			refreshUserList(currentGroupId, page);
		}
	});

	var userAddFrame = ui('#user-add-frame');
	var btnAddUser = ui('#btn-add-user', {
		click : function(){
			userAddFrame.$.slideDown(300);
		}
	});
	var inputAddUserName = ui('#input-add-user-name', {
		limit : 16
	});
	var inputAddUserEmail = ui('#input-add-user-email', {
		limit : 128
	});
	var inputAddUserPassword = ui('#input-add-user-password', {
		
	});
	var tipAddUser = ui('#tip-add-user');
	var btnAddUserFold = ui('#btn-add-user-fold', {
		click : function(){
			userAddFrame.$.slideUp(200);
		}
	});
	var btnAddUserAdd = ui('#btn-add-user-add', {
		click : function(){
			tipAddUser.hide();
			var username = inputAddUserName.val();
			var email    = inputAddUserEmail.val();
			var password = inputAddUserPassword.val();

			if(username.length < 1){
				tipAddUser.warn('请输入用户名');
				return;
			}
			if(email.length < 1){
				tipAddUser.warn('请输入邮箱');
				return;
			}
			if(password.length < 1){
				tipAddUser.warn('请输入密码');
				return;
			}

			G.method('admin.user_add', {
				username : username,
				email    : email,
				password : MD5(password)
			}, function(c, d){
				tipAddUser.ok('已添加');
				inputAddUserName.val('');
				inputAddUserEmail.val('');
				inputAddUserPassword.val('');
			}, function(c, m){
				tipAddUser.warn(m);
			});
		}
	});

	var userEditFrame = ui('#user-edit-frame');
	var inputEditUserName = ui('#input-edit-user-name', {
		limit : 16
	});
	var inputEditUserEmail = ui('#input-edit-user-email', {
		limit : 128
	});
	var inputEditUserPassword = ui('#input-edit-user-password', {
		
	});
	var labelEditUserRegdate = ui('#label-edit-user-regdate');
	var labelEditUserLastlogin = ui('#label-edit-user-lastlogin');
	var tipEditUser = ui('#tip-edit-user');
	var btnEditUserFold = ui('#btn-edit-user-fold', {
		click : function(){
			userEditFrame.$.slideUp(200);
		}
	});
	var btnEditUserSave = ui('#btn-edit-user-save', {
		click : function(){
			userEditFrame.loading(true);
			G.method('admin.edit_user', {
				uid : userEditFrame.tData.id,
				username : inputEditUserName.val(),
				email : inputEditUserEmail.val(),
				password : MD5(inputEditUserPassword.val())
			}, function(c, d){
				userEditFrame.loading(false);
				userEditFrame.item.dwName.innerHTML = inputEditUserName.val();
			}, function(c, m){
				userEditFrame.loading(false);
				G.error(m);
			});
		}
	});

	var findKw = '';
	var findPg = 0;

	var userFindKw = ui('#user-find-kw');

	var userPagesFind = ui('#user-pages-find', {
		gotoPage : function(page){
			findPg = page > 0 ? page - 1 : 0;
			refreshFindList();
		}
	});

	var btnUserSearch = ui('#btn-user-search', {
		click : function(){
			findKw = userFindKw.val();
			findPg = 0;
			refreshFindList();
		}
	});

	var userListFind = ui('#user-list-find');
	userListFind.$.on('click', '.ctrl-item', listCtrl);

	refreshGroupList();
	refreshUserList(currentGroupId, 1);

	function refreshFindList(){
		var pageSize = 20;
		userListFind.loading(true);
		G.method('admin.user_search', {
			kw : findKw,
			offset : findPg * pageSize,
			count  : pageSize
		}, function(c, d){
			userListFind.loading(false);
			userListFind.$.html('');
			userPagesFind.refresh(findPg + 1, Math.ceil(d.count / pageSize));
			var i;
			for(i = 0; i < d.list.length; i ++){
				genFindListItem(d.list[i]);
			}
		}, function(c, m){
			userListFind.loading(false);
			G.error(m);
		});
	}

	function genFindListItem(d){
		var e = tpl.dwUserItem.clone();
		d.ban = parseInt(d.ban);
		d.group = parseInt(d.group);
		userListFind.$.append(e);
		e.dwId.innerHTML = d.id;
		e.dwName.innerHTML = d.username;
		e.dwGroup.innerHTML = _groups[d.group].name;
		if(d.ban == 1){
			e.dwCtrl.dwBan.className += ' baned';
			e.dwCtrl.dwBan.dataset.flex = '解除封禁';
		}
		e.tData = d;
		return e;
	}

	function refreshGroupList(){
		groupList.loading(true);
		member.userGroup(function(d){
			groupList.$.html('');
			$(genGroupListItem(
				{
					name : '所有用户',
					id   : 0
				}, 1)).addClass('selected');
			var i;
			for(i in d){
				genGroupListItem(d[i], 1);
			}
			groupList.loading(false);
		});
	}

	function genGroupListItem(d, layer){
		var e = tpl.dwGroupItem.clone();
		groupList.element.appendChild(e);
		e.dwName.innerHTML = d.name;
		if(layer > 1){
			e.dwHolder.style.display = 'block';
			e.dwHolder.style.marginLeft = 12 * layer - 12 + 'px';
		}
		e.tData = d;
		var i, s = false;
		if(d.sub){
			for(i in d.sub){
				genGroupListItem(d.sub[i], layer + 1);
				s = true;
			}
		}
		if(s){
			e.dwIcon.className += ' expand';
		}
		return e;
	}

	function refreshUserList(gid, page){
		userList.loading(true);
		var pageSize = 20;
		G.method('admin.user_list', {
			gid    : gid,
			offset : pageSize * (page - 1),
			count  : pageSize
		}, function(c, d){
			userList.loading(false);
			userList.$.html('');
			var i;
			for(i = 0; i < d.list.length; i ++){
				genUserListItem(d.list[i]);
			}
			currentGroupId  = gid;
			currentListPage = page;
			userPages.refresh(page, Math.ceil(d.count / pageSize));
		}, function(c, m){
			userList.loading(false);
			G.error(m)
		});
	}

	function genUserListItem(d){
		var e = tpl.dwUserItem.clone();
		d.ban = parseInt(d.ban);
		d.group = parseInt(d.group);
		userList.$.append(e);
		e.dwId.innerHTML = d.id;
		e.dwName.innerHTML = d.username;
		e.dwGroup.innerHTML = _groups[d.group].name;
		if(d.ban == 1){
			e.dwCtrl.dwBan.className += ' baned';
			e.dwCtrl.dwBan.dataset.flex = '解除封禁';
		}
		e.tData = d;
		return e;
	}

	function listCtrl(){
		var $p = $(this).parents('.item');
		switch(this.dataset.action){
			case 'edit':
				$p.after(userEditFrame.$);
				userEditFrame.tData = $p[0].tData;
				userEditFrame.item = $p[0];
				userEditFrame.$.slideDown(300);
				inputEditUserName.val($p[0].tData.username);
				inputEditUserEmail.val($p[0].tData.email);
				inputEditUserPassword.val('');
				labelEditUserRegdate.element.innerHTML = C.timeStr($p[0].tData.regdate);
				labelEditUserLastlogin.element.innerHTML = C.timeStr($p[0].tData.lastlogin);
				break;
			case 'group':
				ui.select({
					options : (function(){
						var a = {};
						for(var i in _groups){
							a[i] = _groups[i].name;
						}
						return a;
					})(),
					value : $p[0].tData.group,
					okCallback : function(v){
						G.method('admin.change_user_group', {
							uid : $p[0].tData.id,
							gid : v
						}, function(c, d){
							if(listTab.val() == 'group' || currentGroupId == 0){
								$p[0].tData.group = v;
								$p[0].dwGroup.innerHTML = _groups[v].name;
							}else{
								$p.fadeOut(200, function(){
									$p.remove();
								});
							}
						}, function(c, m){
							G.error(m);
						});
					}
				})
				break;
			case 'remove':
				ui.confirm({
						text : '要删除用户' + $p[0].tData.username + '吗？',
						okCallback : function(){
							G.method('admin.remove_user', {
								uid : $p[0].tData.id
							}, function(c, d){
								$p.fadeOut(200, function(){
									$p.remove();
								});
							}, function(c, m){
								G.error(m);
							})
						}
					});
				break;
			case 'ban':
				if($p[0].tData.ban == 0){
					ui.confirm({
						text : '要封禁用户' + $p[0].tData.username + '吗？',
						okCallback : function(){
							G.method('admin.ban_user', {
								uid : $p[0].tData.id,
								ban : 1
							}, function(c, d){
								$p[0].tData.ban = 1;
								$p[0].dwCtrl.dwBan.className += ' baned';
								$p[0].dwCtrl.dwBan.dataset.flex = '解除封禁';
							}, function(c, m){
								G.error(m);
							})
						}
					});
				}else{
					G.method('admin.ban_user', {
						uid : $p[0].tData.id,
						ban : 0
					}, function(c, d){
						$p[0].tData.ban = 0;
						$p[0].dwCtrl.dwBan.className = $p[0].dwCtrl.dwBan.className.replace(' baned', '');
						$p[0].dwCtrl.dwBan.dataset.flex = '封禁用户';
					}, function(c, m){
						G.error(m);
					})
				}
				break;
		}
	}


});