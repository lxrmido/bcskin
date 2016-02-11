$(function(){
   
    // 初始化左侧导航栏，高亮当前页
    var cur_navi = $('#header').find('.navi').each(function(){
    	cur_navi = this.innerHTML;
	    $('#left-menu').find('.list-item').each(function(){
	        if($(this).find('span').html() == cur_navi){
	            $(this).addClass('selected');
	            return false;
	        }
	    });
    });


    
});

var member = {
    userGroup : function(callback){
        G.method('member.group_list', function(c, d){
            var i, g;
            var m = {};
            for(i = 0; i < d.list.length; i ++){
                g = d.list[i];
                g.id = parseInt(g.id);
                g.parent = parseInt(g.parent);
                if(g.parent > 0){
                    if(!m[g.parent]){
                        m[g.parent] = {
                            sub : {}
                        };
                    }
                    m[g.parent].sub[g.id] = g;
                }
                if(m[g.id]){
                    g.sub = m[g.id].sub;
                    m[g.id] = g;
                }else{
                    m[g.id] = g;
                    g.sub = {};
                }
            }
            for(i in m){
                if(m[i].parent > 0){
                    delete m[i];
                }
            }
            callback(m);
        }, function(c, m){
            G.error(m);
        });
    }

};
