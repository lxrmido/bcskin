$(function(){

	var tpl = ui('#tpl');

	var privRefresh = ui('#priv-refresh', {
		click : function(){
			refreshList();
		}
	});

	var privEdit = ui('#priv-edit', {
		click : function(){
			privEdit.$.hide();
			privSave.$.show();

			$('.name-show').hide();
			$('.name-edit').show();

			$('.mpp-show').hide();
			$('.mpp-edit').show();
		}
	});

	var privSave = ui('#priv-save', {
		click : function(){

			var methodNameChanged = [],
				methodMppChanged  = [],
				actionNameChanged = [],
				actionMppChanged  = [];

			$('.priv-item').each(function(){
				if(!this.tData){
					return;
				}
				if(this.tData.nameChanged){
					if(this.tData.type == 'method'){
						methodNameChanged.push({
							module : this.tData.module,
							method : this.tData.method,
							value  : this.dwNameInput.value
						});
					}else{
						actionNameChanged.push({
							module : this.tData.module,
							action : this.tData.action,
							value  : this.dwNameInput.value
						});
					}
					this.dwName.innerHTML = this.dwNameInput.value;
				}else if(this.tData.mppChanged){
					if(this.tData.type == 'method'){
						methodMppChanged.push({
							module : this.tData.module,
							method : this.tData.method,
							value  : this.dwMppInput.value
						});
					}else{
						actionMppChanged.push({
							module : this.tData.module,
							action : this.tData.action,
							value  : this.dwMppInput.value
						});
					}
					this.dwMpp.innerHTML = this.dwMppInput.value;
				}
			});

			privSave.loading(true);
			G.method('admin.priv_edit', {
				method_name : JSON.stringify(methodNameChanged),
				method_mpp  : JSON.stringify(methodMppChanged ),
				action_name : JSON.stringify(actionNameChanged),
				action_mpp  : JSON.stringify(actionMppChanged)
			}, function(c, d){

				privSave.loading(false);
				privEdit.$.show();
				privSave.$.hide();

				$('.name-show').show();
				$('.name-edit').hide();
				$('.mpp-show').show();
				$('.mpp-edit').hide();

				refreshList();

			}, function(e, d){
				privSave.loading(false);
				G.error(d);
			});

			
		}
	});


	var privRefresh = ui('#priv-list', {
		click : function(){
			refreshList();
		}
	});

	var methodList = ui('#method-list');
	methodList.$.on('change', 'input.name-edit', function(){
		this.parentNode.tData.nameChanged = true;
	}).on('change', 'input.mpp-edit', function(){
		this.parentNode.tData.mppChanged = true;
	});

	var actionList = ui('#action-list');
	actionList.$.on('change', 'input.name-edit', function(){
		this.parentNode.tData.nameChanged = true;
	}).on('change', 'input.mpp-edit', function(){
		this.parentNode.tData.mppChanged = true;
	});

	refreshList();

	function refreshList(){
		methodList.loading(true);
		actionList.loading(true);
		G.method('admin.priv_all', function(c, d){
			refreshMethodList(d.method);
			refreshActionList(d.action);
		}, function(c, m){
			G.error(m);
		});
	}

	function refreshMethodList(d){
		var i;
		methodList.$.html('');
		for(i = 0; i < d.length; i ++){
			genMethodListItem(d[i]);
		}
		methodList.loading(false);
	}

	function genMethodListItem(d){
		var e, i;
		e = tpl.dwPrivItem.clone();
		e.dwModule.innerHTML = d.module;
		e.dwKey.innerHTML = d.method;
		e.dwName.innerHTML = d.name;
		e.dwNameInput.value = d.name;
		e.dwNameInput.style.display = "none";
		e.dwMpp.innerHTML = d.mpp;
		e.dwMppInput.value = d.mpp;
		e.dwMppInput.style.display = "none";
		e.tData = {
			type   : 'method',
			module : d.module,
			method : d.method,
			name   : d.name,
			mpp    : d.mpp
		}
		methodList.element.appendChild(e);
	}

	function refreshActionList(d){
		var i;
		actionList.$.html('');
		for(i = 0; i < d.length; i ++){
			genActionListItem(d[i]);
		}
		actionList.loading(false);
	}

	function genActionListItem(d){
		var e, i;
		e = tpl.dwPrivItem.clone();
		e.dwModule.innerHTML = d.module;
		e.dwKey.innerHTML = d.action;
		e.dwName.innerHTML = d.name;
		e.dwNameInput.value = d.name;
		e.dwNameInput.style.display = "none";
		e.dwMpp.innerHTML = d.mpp;
		e.dwMppInput.value = d.mpp;
		e.dwMppInput.style.display = "none";
		e.tData = {
			type   : 'action',
			module : d.module,
			action : d.action,
			name   : d.name,
			mpp    : d.mpp
		}
		actionList.element.appendChild(e);

	}



});