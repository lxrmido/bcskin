$(function(){

	var tpl = ui('#tpl');
	var groupList = ui('#group-list');
	var privList  = ui('#priv-list');
	groupList.$.on('click', '.ctrl-item', function(){
		var $p = $(this).parent().parent();
		var td = $p[0].tData;
		switch(this.dataset.action){
			case 'remove':
				$(this).toggleClass('expanded');
				break;
			case 'config':
				if(privList.gid > 0 && privList.gid == td.id){
					privList.$.slideUp(100);
					privList.gid = 0;
					return;
				}else if(privList.gid > 0){
					privList.$.slideUp(100);
				}
				$p.after(privList.$);
				privList.$.slideDown(200);
				privList.loading(true);
				privList.gid = td.id;
				G.method('admin.user_group_priv_list', {
					gid : td.id
				}, function(c, d){
					privList.loading(false);
					refreshPrivList(d);
				}, function(c, m){
					privList.loading(false);
					G.error(m);
				});
				break;
			case 'edit':
				ui.prompt({
					text  : '请输入新名称',
					value : td.name,
					okCallback : function(v){
						if(v.length < 1){
							return false;
						}
						G.method('admin.user_group_name', {
							gid  : td.id,
							name : v
						}, function(c, d){
							td.name = v;
							$p[0].dwName.innerHTML = td.name = v;
						}, function(c, m){
							G.error(m);
						});
					}
				});
				break;
			case 'add':
				ui.prompt({
					text  : '请输入用户组名称',
					okCallback : function(v){
						if(v.length < 1){
							return false;
						}
						G.method('admin.user_group_add', {
							parent : td.id,
							name   : v
						}, function(c, d){
							refreshList();
						}, function(c, m){
							G.error(m);
						});
					}
				});
				break;
			case 'move':
				member.userGroup(function(d){
					var map = {
						'0' : '顶层'
					};
					var i;
					for(i in d){
						map[i] = d[i].name;
					}
					ui.select({
						text : '移动到哪个用户组下？',
						options : map,
						okCallback : function(v){
							G.method('admin.user_group_move', {
								id : td.id,
								target : v
							}, function(c, d){
								refreshList();
							}, function(c, m){
								G.error(m);
							});
						}
					})
				});
				break;
		}
	}).on('mousedown', '.confirm-del', function(){
		var $p = $(this).parents('.group-item');
		G.method('admin.user_group_rm', {
			'gid' : $p[0].tData.id,
			'to'  : 2
		}, function(c, d){
			$p.remove();
		}, function(c, m){
			G.error(m);
		});
	});

	var groupAdd = ui('#group-add', {
		click : function(){
			ui.prompt({
				text  : '请输入用户组名称',
				okCallback : function(v){
					if(v.length < 1){
						return false;
					}
					G.method('admin.user_group_add', {
						parent : 0,
						name   : v
					}, function(c, d){
						refreshList();
					}, function(c, m){
						G.error(m);
					});
				}
			});
		}
	});

	var groupRefresh = ui('#group-refresh', {
		click : function(){
			refreshList();
		}
	});

	refreshList();
	initPrivList();

	function initPrivList(){
		var i, n;
		privList.$items = privList.$.find('.priv-item');
		privList.$items.each(function(){
			var n = this;
			n.toggle = ui(n.dwT, {
				toggle : ontoggle
			});
			n.toggle.module = n.dwM.innerHTML;
			if(n.dwKm){
				n.toggle.method = n.dwKm.innerHTML;
			}else{
				n.toggle.action = n.dwKa.innerHTML;
			}
		});

		function ontoggle(v){
			var mn = 'admin.user_group_priv_' + (this.method ? 'm' : 'a') + '_' + (v ? 'a' : 'r');
			G.method(mn, {
				gid : privList.gid,
				module : this.module,
				key : this.method || this.action
			}, function(c, d){}, function(c, m){
				G.error(m);
			});
		}
	}

	function refreshPrivList(d){
		var i, j, m, n;
		var pm = {};
		var pa = {};
		for(i = 0; i < d.method.priv_list.length; i ++){
			n = d.method.priv_list[i];
			if(!pm[n.module]){
				pm[n.module] = {};
			}
			pm[n.module][n.method] = 0;
		}
		for(i = 0; i < d.method.parent.length; i ++){
			m = d.method.parent[i];
			for(j = 0; j < m.priv_list.length; j ++){
				n = m.priv_list[j];
				if(!pm[n.module]){
					pm[n.module] = {};
				}
				pm[n.module][n.method] = parseInt(m.parent);
			}
		}
		for(i = 0; i < d.action.priv_list.length; i ++){
			n = d.action.priv_list[i];
			if(!pa[n.module]){
				pa[n.module] = {};
			}
			pa[n.module][n.action] = 0;
		}
		for(i = 0; i < d.action.parent.length; i ++){
			m = d.action.parent[i];
			for(j = 0; j < m.priv_list.length; j ++){
				n = m.priv_list[j];
				if(!pa[n.module]){
					pa[n.module] = {};
				}
				pa[n.module][n.action] = parseInt(m.parent);
			}
		}
		privList.$items.each(function(){
			var n = this;
			if(n.dwKm){
				if(pm[n.dwM.innerHTML] == undefined || pm[n.dwM.innerHTML][n.dwKm.innerHTML] == undefined){
					n.toggle.val(false);
					n.dwE.style.display = 'none';
					n.toggle.disabled = false;
				}else if(pm[n.dwM.innerHTML][n.dwKm.innerHTML] == 0){
					n.toggle.val(true);
					n.dwE.style.display = 'none';
					n.toggle.disabled = false;
				}else if(pm[n.dwM.innerHTML][n.dwKm.innerHTML] > 0){
					n.toggle.val(true);
					n.dwE.style.display = 'block';
					n.toggle.disabled = true;
				}
			}else{
				if(pa[n.dwM.innerHTML] == undefined || pa[n.dwM.innerHTML][n.dwKa.innerHTML] == undefined){
					n.toggle.val(false);
					n.dwE.style.display = 'none';
					n.toggle.disabled = false;
				}else if(pa[n.dwM.innerHTML][n.dwKa.innerHTML] == 0){
					n.toggle.val(true);
					n.dwE.style.display = 'none';
					n.toggle.disabled = false;
				}else if(pa[n.dwM.innerHTML][n.dwKa.innerHTML] > 0){
					n.toggle.val(true);
					n.dwE.style.display = 'block';
					n.toggle.disabled = true;
				}else{
				}
			}
		});
	}

	function refreshList(){
		groupList.loading(true);
		member.userGroup(function(d){
			groupList.$.html('');
			var i;
			for(i in d){
				genListItem(d[i], 1);
			}
			groupList.loading(false);
		});
	}

	function genListItem(d, layer){
		var e = tpl.dwGroupItem.clone();
		groupList.element.appendChild(e);
		e.dwName.innerHTML = d.name;
		e.dwLayerHolder.className += layer;
		e.layer = layer;
		e.tData = d;
		var i, s = false;
		if(d.sub){
			for(i in d.sub){
				genListItem(d.sub[i], layer + 1);
				s = true;
			}
		}
		if(s){
			e.dwLayerIcon.className += ' expand';
		}
	}


});