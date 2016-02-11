$(function(){

	var tpl = ui('#tpl');

	var sv = ui('#skin-viewer');
	sv.viewer = SkinViewer(window, sv.element);
	sv.previewSkin = function(url){
		sv.viewer.changeSkin(url);
	};
	sv.previewCape = function(url){
		sv.viewer.changeCape(url);
	}
	sv.reloadSkin = function(data){
		data = data || {
			name : '未设置',
			origin_username : false,
			url : C.defaultSkin()
		};
		sv.viewer.changeSkin(data.url);
		currentSkinFront.$.empty().renderSkin2d({
			scale : 4,
			imageUrl : data.url
		});
		currentSkinBack.$.empty().renderSkin2d({
			scale : 4,
			imageUrl : data.url,
			drawBack : true
		});
		currentSkinName.$.html(data.name);
		if(data.origin_username == _RG.user.username){
			currentSkinOrigin.$.html('自行上传');
		}else if(!data.origin_username){
			currentSkinOrigin.$.html('并没有');
		}else{
			currentSkinOrigin.$.html(data.origin_username + '分享');
		}
	};
	sv.reloadCape = function(data){
		data = data || {
			name : '未设置',
			origin_username : false,
			url : false
		};
		sv.viewer.changeCape(data.url);
		currentCapeName.$.html(data.name);
		if(data.origin_username == _RG.user.username){
			currentCapeOrigin.$.html('自行上传');
		}else if(!data.origin_username){
			currentCapeOrigin.$.html('并没有');
		}else{
			currentCapeOrigin.$.html(data.origin_username + '分享');
		}
	};

	var currentSkinName   = ui('#current-skin-name');
	var currentSkinOrigin = ui('#current-skin-origin');
	var currentCapeName   = ui('#current-cape-name');
	var currentCapeOrigin = ui('#current-cape-origin');

	var currentSkinFront  = ui('#current-skin-front');
	var currentSkinBack   = ui('#current-skin-back');

	var btnResetSkin = ui('#btn-reset-skin', {
		click : function(){
			G.method('skin.reset_skin', function(c, d){
				_current_skin = false;
				sv.reloadSkin(_current_skin);
			}, function(c, m){
				G.error(m);
			});
		}
	});
	var btnResetCape = ui('#btn-reset-cape', {
		click : function(){
			G.method('cape.reset_cape', function(c, d){
				_current_cape = false;
				sv.reloadCape(_current_cape);
			}, function(c, m){
				G.error(m);
			});
		}
	});

	var btnAddSkin = ui('#btn-add-skin', {
		click : function(){
			var f = document.createElement('input');
			f.type = 'file';
			f.multiple = true;
			f.onchange = function(e){
				var i;
				for(i = 0; i < f.files.length; i ++){
					uploadSkinList.add(f.files[i]);
				}
			};
			$(f).click();
		}
	});
	var btnUploadSkin = ui('#btn-upload-skin', {
		click : function(){
			uploadSkinList.uploadNext();
		}
	});
	var btnClearSkin = ui('#btn-clear-skin', {
		click : function(){
			ui.confirm({
				text : '要清空上传队列吗？',
				okCallback : function(){
					uploadSkinList.empty();
				}
			})
		}
	});

	var uploadSkinList = ui('#upload-skin-list');
	uploadSkinList.add = function(x){
		var it = tpl.dwUploadSkinListItem.clone();
		var rd = new FileReader();
		var img = new Image();
		rd.onload = function(e){
			img.src = e.target.result;
			$(it.dwFront).renderSkin2d({
				scale : 2,
				imageUrl : e.target.result
			});
			$(it.dwBack).renderSkin2d({
				scale : 2,
				imageUrl : e.target.result,
				drawBack : true
			});
		};
		it.dwName.innerHTML = x.name.split('.')[0];
		it.file = x;
		rd.readAsDataURL(x);
		uploadSkinList.$.append(it);
	};
	uploadSkinList.empty = function(){
		uploadSkinList.$.empty();
	};
	uploadSkinList.uploadNext = function(){
		var $wi = uploadSkinList.$.find('.item.waiting');
		if($wi.length){
			G.upload('skin.upload_skin', {
					name : $wi[0].dwName.innerHTML
				}, $wi[0].file, 'skin_file',
				function(e){
					var pc = parseInt(e.loaded / e.total * 100);
					if(pc < 100){
						$wi[0].dwProc.innerHTML =  + '%';
					}
					$wi[0].dwProc.innerHTML = '处理中';
				},
				function(e){
					$($wi[0]).removeClass('waiting');
					$wi[0].dwProc.innerHTML = '上传完毕';
					try{
						var rs = JSON.parse(e.target.response);
						if(rs.code == undefined){
							$wi[0].dwProc.innerHTML = "上传出错";
							$($wi[0]).addClass('error');
						}else if(rs.code <= 0){
							$wi[0].dwProc.innerHTML = rs.message;
							$($wi[0]).addClass('error');
						}else{
							$($wi[0]).addClass('success');
							setTimeout(function(){
								uploadSkinList.uploadNext();
							}, 10);
						}
					}catch(e){
						$wi[0].dwProc.innerHTML = "上传出错";
						$($wi[0]).addClass('error');
					}
				});
		}else{
			mySkinList.refresh();
		}
	};
	uploadSkinList.$.on('click', '.ctrl-item', function(){
		var $p = $(this).parents('.item');
		switch(this.dataset.action){
			case 'remove':
				$p.slideUp(200, function(){
					$p.remove();
				})
				break;
			case 'edit':
				ui.prompt({
					text : '请输入皮肤名称：',
					value : $p[0].dwName.innerHTML,
					okCallback : function(v){
						$p[0].dwName.innerHTML = v;
					}
				})
				break;
		}
	});

	var mySkinList = ui('#myskin-list');
	mySkinList.sp = ui('#sp-myskin', {
		gotoPage : function(n){
			mySkinList.refresh(n - 1);
		}
	});
	mySkinList.checkAll = ui('#check-myskin');
	mySkinList.checkAll.$.click(function(){
		if(mySkinList.toggleCheckAll()){
			mySkinList.checkAll.$.addClass('checked');
		}else{
			mySkinList.checkAll.$.removeClass('checked');
		}
	});
	mySkinList.rmAll = ui('#rm-all-myskin', {
		click : function(){
			var ids = mySkinList.getCheckedIDs();
			ui.confirm({
				text : '确定要删除选中的'+ids.length+'项吗？',
				okCallback : function(){
					G.method('skin.rm_my_skins', {
						ids : ids.join(',')
					}, function(c, d){
						mySkinList.getChecked().slideUp(200, function(){
							$(this).remove();
						});
					}, function(c, m){
						G.error(m);
					});
				}
			})
		}
	});
	mySkinList.toggleCheckAll = function(){
		if(mySkinList.$.find('.item.checked').length == mySkinList.$.find('.item').length){
			mySkinList.$.find('.item.checked').removeClass('checked');
			return false;
		}else{
			mySkinList.$.find('.item').addClass('checked');
			return true;
		}
	};
	mySkinList.getChecked = function(){
		return mySkinList.$.find('.item.checked');
	};
	mySkinList.getCheckedIDs = function(){
		var ids = [];
		mySkinList.$.find('.item.checked').each(function(){
			ids.push(this.tData.id);
		});
		return ids;
	};
	mySkinList.add = function(x){
		var it = tpl.dwMySkinListItem.clone();
		$(it.dwFront).renderSkin2d({
			scale : 2,
			imageUrl : x.url
		});
		$(it.dwBack).renderSkin2d({
			scale : 2,
			imageUrl : x.url,
			drawBack : true
		});
		it.dwName.innerHTML = x.name.split('.')[0];
		it.tData = x;
		mySkinList.$.append(it);
	};
	mySkinList.refresh = function(page){
		page = page || 0;
		var pageSize = 10;
		mySkinList.loading(true);
		G.method('skin.list_my_skin', {
			offset : page * pageSize,
			limit  : pageSize
		}, function(c, d){
			mySkinList.loading(false);
			mySkinList.$.empty();
			if(d.list.length){
				d.list.forEach(function(x){
					mySkinList.add(x);
				});
			}
			mySkinList.sp.refresh(page + 1, Math.ceil(d.total / pageSize));
		}, function(c, m){
			mySkinList.loading(false);
			G.error(m);
		});
	};
	mySkinList.$.on('click', '.ctrl-item', function(){
		var $p = $(this).parents('.item');
		var td = $p[0].tData;
		switch(this.dataset.action){
			case 'preview':
				sv.previewSkin(td.url);
				break;
			case 'edit':
				ui.prompt({
					text : '请输入新名字：',
					value : td.name,
					okCallback : function(v){
						G.method('skin.rename_skin', {
							name : v,
							id : td.id
						}, function(c, d){
							td.name = v;
							$p[0].dwName.innerHTML = v;
						}, function(c, m){
							G.error(m);
						});
					}
				});
				break;
			case 'remove':
				ui.confirm({
					text : '确定要删除皮肤"' + td.name + '"吗？',
					okCallback : function(){
						G.method('skin.rm_my_skins', {
							ids : td.id
						}, function(c, d){
							$p.slideUp(200, function(){
								$(this).remove();
							});
						}, function(c, m){
							G.error(m);
						});
					} 
				})
				break;
		}
	}).on('click', '.check', function(){
		$(this).parent().toggleClass('checked');
		if(mySkinList.$.find('.item.checked').length == mySkinList.$.find('.item').length){
			mySkinList.checkAll.$.addClass('checked');
		}else{
			mySkinList.checkAll.$.removeClass('checked');
		}
	}).on('click', '.use', function(){
		var td = $(this).parent()[0].tData;
		G.method('skin.set_skin', {
			id : td.id
		}, function(c, d){
			_current_skin = td;
			sv.reloadSkin(td);
		}, function(c, m){
			G.error(m);
		});
	});

	var tabMain = ui('#skin-tab-main', {
		view : {
			current : '#view-current',
			myskin  : '#view-myskin',
			mycape  : '#view-mycape',
			uploadskin  : '#view-upload-skin',
			uploadcape  : '#view-upload-cape'
		},
		onswitch : function(v){
			switch(v){
				case 'current':
					sv.reloadSkin(_current_skin);
					sv.reloadCape(_current_cape);
					break;
				default:
					break;
			}
		}
	});

	mySkinList.refresh();



	/**
	 * CAPE
	 */
	
	var btnAddCape = ui('#btn-add-cape', {
		click : function(){
			var f = document.createElement('input');
			f.type = 'file';
			f.multiple = true;
			f.onchange = function(e){
				var i;
				for(i = 0; i < f.files.length; i ++){
					uploadCapeList.add(f.files[i]);
				}
			};
			$(f).click();
		}
	});
	var btnUploadCape = ui('#btn-upload-cape', {
		click : function(){
			uploadCapeList.uploadNext();
		}
	});
	var btnClearCape = ui('#btn-clear-cape', {
		click : function(){
			ui.confirm({
				text : '要清空上传队列吗？',
				okCallback : function(){
					uploadCapeList.empty();
				}
			})
		}
	});

	var uploadCapeList = ui('#upload-cape-list');
	uploadCapeList.add = function(x){
		var it = tpl.dwUploadCapeListItem.clone();
		var rd = new FileReader();
		rd.onload = function(e){
			it.dwPreview.src = e.target.result;
		};
		it.dwName.innerHTML = x.name.split('.')[0];
		it.file = x;
		rd.readAsDataURL(x);
		uploadCapeList.$.append(it);
	};
	uploadCapeList.empty = function(){
		uploadCapeList.$.empty();
	};
	uploadCapeList.uploadNext = function(){
		var $wi = uploadCapeList.$.find('.item.waiting');
		if($wi.length){
			G.upload('cape.upload_cape', {
					name : $wi[0].dwName.innerHTML
				}, $wi[0].file, 'cape_file',
				function(e){
					var pc = parseInt(e.loaded / e.total * 100);
					if(pc < 100){
						$wi[0].dwProc.innerHTML =  + '%';
					}
					$wi[0].dwProc.innerHTML = '处理中';
				},
				function(e){
					$($wi[0]).removeClass('waiting');
					$wi[0].dwProc.innerHTML = '上传完毕';
					try{
						var rs = JSON.parse(e.target.response);
						if(rs.code == undefined){
							$wi[0].dwProc.innerHTML = "上传出错";
							$($wi[0]).addClass('error');
						}else if(rs.code <= 0){
							$wi[0].dwProc.innerHTML = rs.message;
							$($wi[0]).addClass('error');
						}else{
							$($wi[0]).addClass('success');
							setTimeout(function(){
								uploadCapeList.uploadNext();
							}, 10);
						}
					}catch(e){
						$wi[0].dwProc.innerHTML = "上传出错";
						$($wi[0]).addClass('error');
					}
				});
		}else{
			myCapeList.refresh();
		}
	};
	uploadCapeList.$.on('click', '.ctrl-item', function(){
		var $p = $(this).parents('.item');
		switch(this.dataset.action){
			case 'remove':
				$p.slideUp(200, function(){
					$p.remove();
				})
				break;
			case 'edit':
				ui.prompt({
					text : '请输入披风名称：',
					value : $p[0].dwName.innerHTML,
					okCallback : function(v){
						$p[0].dwName.innerHTML = v;
					}
				})
				break;
		}
	});

	var myCapeList = ui('#mycape-list');
	myCapeList.sp = ui('#sp-mycape', {
		gotoPage : function(n){
			myCapeList.refresh(n - 1);
		}
	});
	myCapeList.checkAll = ui('#check-mycape');
	myCapeList.checkAll.$.click(function(){
		if(myCapeList.toggleCheckAll()){
			myCapeList.checkAll.$.addClass('checked');
		}else{
			myCapeList.checkAll.$.removeClass('checked');
		}
	});
	myCapeList.rmAll = ui('#rm-all-mycape', {
		click : function(){
			var ids = myCapeList.getCheckedIDs();
			ui.confirm({
				text : '确定要删除选中的'+ids.length+'项吗？',
				okCallback : function(){
					G.method('cape.rm_my_capes', {
						ids : ids.join(',')
					}, function(c, d){
						myCapeList.getChecked().slideUp(200, function(){
							$(this).remove();
						});
					}, function(c, m){
						G.error(m);
					});
				}
			})
		}
	});
	myCapeList.toggleCheckAll = function(){
		if(myCapeList.$.find('.item.checked').length == myCapeList.$.find('.item').length){
			myCapeList.$.find('.item.checked').removeClass('checked');
			return false;
		}else{
			myCapeList.$.find('.item').addClass('checked');
			return true;
		}
	};
	myCapeList.getChecked = function(){
		return myCapeList.$.find('.item.checked');
	};
	myCapeList.getCheckedIDs = function(){
		var ids = [];
		myCapeList.$.find('.item.checked').each(function(){
			ids.push(this.tData.id);
		});
		return ids;
	};
	myCapeList.add = function(x){
		var it = tpl.dwMyCapeListItem.clone();
		it.dwPreview.src = x.url;
		it.dwName.innerHTML = x.name.split('.')[0];
		it.tData = x;
		myCapeList.$.append(it);
	};
	myCapeList.refresh = function(page){
		page = page || 0;
		var pageSize = 10;
		myCapeList.loading(true);
		G.method('cape.list_my_cape', {
			offset : page * pageSize,
			limit  : pageSize
		}, function(c, d){
			myCapeList.loading(false);
			myCapeList.$.empty();
			if(d.list.length){
				d.list.forEach(function(x){
					myCapeList.add(x);
				});
			}
			myCapeList.sp.refresh(page + 1, Math.ceil(d.total / pageSize));
		}, function(c, m){
			myCapeList.loading(false);
			G.error(m);
		});
	};
	myCapeList.$.on('click', '.ctrl-item', function(){
		var $p = $(this).parents('.item');
		var td = $p[0].tData;
		switch(this.dataset.action){
			case 'preview':
				sv.previewCape(td.url);
				break;
			case 'edit':
				ui.prompt({
					text : '请输入新名字：',
					value : td.name,
					okCallback : function(v){
						G.method('cape.rename_cape', {
							name : v,
							id : td.id
						}, function(c, d){
							td.name = v;
							$p[0].dwName.innerHTML = v;
						}, function(c, m){
							G.error(m);
						});
					}
				});
				break;
			case 'remove':
				ui.confirm({
					text : '确定要删除披风"' + td.name + '"吗？',
					okCallback : function(){
						G.method('cape.rm_my_capes', {
							ids : td.id
						}, function(c, d){
							$p.slideUp(200, function(){
								$(this).remove();
							});
						}, function(c, m){
							G.error(m);
						});
					} 
				})
				break;
		}
	}).on('click', '.check', function(){
		$(this).parent().toggleClass('checked');
		if(myCapeList.$.find('.item.checked').length == myCapeList.$.find('.item').length){
			myCapeList.checkAll.$.addClass('checked');
		}else{
			myCapeList.checkAll.$.removeClass('checked');
		}
	}).on('click', '.use', function(){
		var td = $(this).parent()[0].tData;
		G.method('cape.set_cape', {
			id : td.id
		}, function(c, d){
			_current_cape = td;
			sv.reloadCape(td);
		}, function(c, m){
			G.error(m);
		});
	});

	myCapeList.refresh();


});