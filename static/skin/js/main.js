$(function(){

	var tpl = ui('#tpl');

	var sv = ui('#skin-viewer');
	sv.viewer = SkinViewer(window, sv.element);
	sv.viewer.changeSkin(C.defaultSkin());

	var tabMain = ui('#skin-tab-main', {
		view : {
			current : '#view-current',
			myskin  : '#view-myskin',
			mycape  : '#view-mycape',
			uploadskin  : '#view-upload-skin',
			uploadcape  : '#view-upload-cape'
		}
	});

	var currentSkinName   = ui('#current-skin-name');
	var currentSkinOrigin = ui('#current-skin-origin');
	var currentCapeName   = ui('#current-cape-name');
	var currentCapeOrigin = ui('#current-cape-origin');

	var btnResetSkin = ui('#btn-reset-skin');
	var btnResetCape = ui('#btn-reset-cape');

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
	var btnUploadSkin = ui('#btn-upload-skin');
	var btnClearSkin = ui('#btn-clear-skin', {
		click : function(){
			ui.prompt({
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

});