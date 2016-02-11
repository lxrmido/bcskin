$(function(){

	var tpl = ui('#tpl');

	var viewList = ui('#view-list').show();
	var viewView = ui('#view-view').hide();

	var tabMain = ui('#tab-main', {
		view : {
			'dbg' : '#view-dbg-list',
			'err' : '#view-err-list',
			'dgr' : '#view-dgr-list',
			'tml' : '#view-tml-list'
		}
	});
	viewList.$.on('click', '.list-item', function(){
		viewView.show();
		viewList.hide();
		viewView.loading(true);
		var that = this;
		var typeText = ({
			dbg : '调试', 
			err : '报错',
			dgr : '警报',
			tml : '时间'
		})[this.tData.type];
		G.method('admin.syslog', {
			type : this.tData.type,
			date : this.tData.date
		}, function(c, d){
			viewView.loading(false);
			textContent.load(d.content);
			lblFileName.element.dwText.innerHTML = typeText + '日志-' + that.tData.date; 
		}, function(c, m){
			viewView.loading(false);
			G.error(m);
		});
	});

	var lblFileName = ui('#lbl-file-name');
	var textContent = ui('#text-content');
	textContent.load = function(text){
		textContent.$.empty();
		var lines = text.split('\n');
		var out = '';
		lines.forEach(function(line){
			out += textContent.format(line);
		});
		textContent.$.html(out);
	};
	textContent.format = function(line){
		if(line.indexOf('[ErrorType]') == 0){
			return '<p class="error-type">错误类型：' + line.replace('[ErrorType]', '') + '</p>';
		}else if(line.indexOf('[Type]') == 0){
			return '<p class="type">调试类型：' + line.replace('[Type]', '') + '</p>';
		}else if(line.indexOf('[Time]') == 0){
			return '<p class="time">记录时间：' + line.replace('[Time]', '') + '</p>';
		}else if(line.indexOf('[Content]') == 0){
			return '<p class="content">记录内容：</p>' + 
				(line.replace(/\s/g, '').length > 9 ? ('<textarea>' + line.replace('[Content]', '') + '</textarea>') : '');
		}else if(line == '----------'){
			return '';
		}else{
			if(line.replace(/\s/g, '').length){
				return '<textarea>' + line + '</textarea>';
			}else{
				return '';
			}
		}
	};


	var btnViewBack = ui('#btn-view-back', {
		click : function(){
			viewView.hide();
			viewList.show();
		}
	});


	_log_files.sort(function(a, b){
		a = parseInt(a.replace('dbg_', '').replace('err_', '').replace('dgr_', '').replace('tml_', '').replace('.txt', '').replace(/\-/g, ''));
		b = parseInt(b.replace('dbg_', '').replace('err_', '').replace('dgr_', '').replace('tml_', '').replace('.txt', '').replace(/\-/g, ''));
		if(a > b){
			return -1;
		}else if(a < b){
			return 1;
		}else{
			return 0;
		}
	}).forEach(function(x){
		genListItem(x);
	});

	function genListItem(name){
		var disname = name.replace('dbg_', '').replace('err_', '').replace('dgr_', '').replace('tml_', '').replace('.txt', '');
		var e = tpl.dwListItem.clone();
		e.dwText.innerHTML = disname;
		if(name.indexOf('dbg_') === 0){
			tabMain.view.dbg.element.appendChild(e);
		}else if(name.indexOf('err_') === 0){
			tabMain.view.err.element.appendChild(e);
		}else if(name.indexOf('dgr_') === 0){
			tabMain.view.dgr.element.appendChild(e);
		}else{
			tabMain.view.tml.element.appendChild(e);
		}
		e.tData = {
			type : name.split('_')[0],
			date : name.split('_')[1].replace('.txt', '')
		};
		return e;
	}

});