$(function(){

	var tpl = ui('#tpl');

	var mallList = ui('#mall-list');
	mallList.add = function(d){
		var e = tpl.dwMallListItem.clone();
		e.dwName.dwText.innerHTML = d.username;
		$(e.dwPlayer).renderSkin2d({
			scale : 5,
			imageUrl : d.url
		});
		mallList.$.append(e);
	};
	_mall_list.sort(function(){
		return 0.5 - Math.random();
	});
	_mall_list.forEach(function(x){
		mallList.add(x);
	});

});