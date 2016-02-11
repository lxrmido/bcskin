$(function(){

	var tpl = ui('#tpl');

	var menuList = ui('#menu-list');
	menuList.$.on('mousedown', '.ctrl-item', function(){
		var $p, $n;
		$p = $(this).parents('.tr');
		switch(this.dataset.action){
			case 'up':
				$n = $p.prev('.tr');
				if($n && $n.length){
					$p.after($n);
				}
				break;
			case 'down':
				$n = $p.next('.tr');
				if($n && $n.length){
					$n.after($p);
				}
				break;
			case 'rm':
				$p.remove();
				break;
		}
	});

	var formAdd = ui('#form-add');
	formAdd.$.on('keydown', function(e){
		if(e.keyCode == KEYBOARD.ENTER){
			addListItem();
			return false;
		}
	});
	var btnAdd = ui('#btn-add', {
		click : function(){
			addListItem();
		}
	});

	var btnSave = ui('#btn-save', {
		click : function(){
			var data = [];
			menuList.$.find('.tr').each(function(){
				var $is = $(this).find('input');
				data.push({
					type : $is[0].value,
					icon : $is[1].value,
					content : $is[2].value,
					args : $is[3].value
				});
			});
			menuList.loading(true);
			G.method('admin.left_menu_build', {
				data : JSON.stringify(data)
			}, function(c, d){
				menuList.loading(false);
			}, function(c, m){
				menuList.loading(false);
				G.error(m);				
			})
		}
	});

	refreshList();


	function addListItem(){
		var inputs  = formAdd.$.find('input');
		var type    = inputs[0].value;
		var icon    = inputs[1].value;
		var content = inputs[2].value;
		var args    = inputs[3].value;
		var data    = {
			type : type,
			icon : icon,
			content : content,
			args : args
		};
		menuList.loading(true);
		G.method('admin.left_menu_add', data, 
			function(c, d){
				menuList.loading(false);
				inputs.val('');
				appendListItem(data);
			}, 
			function(c, m){
				menuList.loading(false);
				G.error(m);
			}
		);
	}

	function appendListItem(data){
		var e = tpl.dwListItem.clone();
		menuList.$.append(e);
		var inputs = $(e).find('input');
		if(data){
			inputs[0].value = (data.type);
			inputs[1].value = (data.icon);
			inputs[2].value = (data.content);
			inputs[3].value = (data.args);
		}
	}

	function refreshList(){
		menuList.loading(true);
		G.method('admin.left_menu_list', 
			function(c, d){
				menuList.loading(false);
				menuList.$.html('');
				var i;
				for(i = 0; i < d.list.length; i ++){
					appendListItem(d.list[i]);
				}
			},
			function(c, m){
				menuList.loading(false);
				G.error(m);
			}
		);
	}

});