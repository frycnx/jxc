/**
 * 
 */
(function($){$.fn.ajaxTable=function(options){	
	var settings =
	{		
			"url": null,
            "data": {},
            "perpage": 30,
			"ajaxMethod": "GET",
			"pageContainer": null,
			"pageInfoContainer": null,
			"pageNumSelect": null,
			"searchForm": null,
			"columns": [],
			"complete": null,
			"showMsg": null,
			"closeMsg": null,
			"loading": "载入中...",
			"error":"加载数据错误,请刷新重试！"
	};
	
	if (options)
	{
		jQuery.extend(settings, options);
	} 
	var sort = {};
	var params = {};
	var table = $(this).unbind('ajaxLoad').bind('ajaxLoad',function(){load()})
        .unbind('getParams').bind('getParams',function(e,d){if(typeof d === 'function')d.call(this,getParams());});

	/**
	 * 生成随机码
	 */
	function get_rand_name(len){
		var len = len || 5;
		var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		var name = '_';
		for(var i=0;i<len;i++){
			name += chars.charAt(Math.floor(Math.random()*chars.length));
		}
		return name+'_'+new Date().getTime();
	}

    function msgId()
    {
        return '_' + table.attr('id') + '_loading_div';
    }
	
	/**
	 * 信息显示框
	 */
	function showMsg (str)
	{
		if(typeof settings['showMsg'] === 'function') {
			settings['showMsg'].call( this, str);
			return;
	    }
		var load_id = msgId();
		var load = '';
		load += '<div id="'+load_id +'" style="padding:5px;font-size:20px;position:absolute;background-color:#fff;color:#000;border:1px solid #000">';
		load += str||settings['loading'];
		load += '</div>';
		table.before(load);
		$('#'+load_id)
		.css('left',(table.parent().width()-$('#'+load_id).width())/2)
		.css('top',(table.parent().height()-$('#'+load_id).height())/2);        
	}

	function closeMsg() {
		if(typeof settings['closeMsg'] === 'function') {
			settings['closeMsg'].call( this );
			return;
	    }
		$('#'+msgId()).remove();
	}

	/**
	 * 增加头部排序按钮
	 */
	function headSort()
	{
		var ths = table.children('thead').children('tr:eq(0)').children('th');
		ths.each(function (i){
            if(!settings['columns']||!settings['columns'][i]) {
                return true;
            }
			var sort = settings['columns'][i]['sortable'];
			if(sort==undefined || sort) {
				if ($(this).children('i.fa').length > 0) {
					return true;
				}
				$(this)
				.append('<i class="fa fa-sort"></i>')
				.children('i:eq(0)')
				.css('cursor', 'pointer')
				.css('color', '#ccc')
				.addClass("pull-right")
				.attr('sort', 'no')
				.attr('name', settings['columns'][i]['name'])
				.click(function (){
					resetSort(ths);
					changSort($(this));
				});
			}
		});
	}
	
	/**
	 * 重置排序
	 * @param  ths 所有排序单元格
	 * @return void
	 */
	function resetSort(ths)
	{
		ths.each(function (i){
			$(this)
			.children('i:eq(0)')
			.css('color', '#ccc')
			.removeClass("fa-sort-asc")
			.removeClass("fa-sort-desc")
			.addClass("fa-sort");
		});
	}	
	
	/**
	 * 排序改变事件
	 */
	function changSort(th)
	{
		sort = {};
		if(th.attr('sort')=='no') {
			th
			.removeClass("fa-sort")
			.addClass("fa-sort-asc")
			.css('color', '#4d4d4d')
			.attr('sort', 'asc');
			sort[th.attr('name')] = 'asc';
		} else if (th.attr('sort')=='asc') {
			th
			.removeClass("fa-sort-asc")
			.addClass("fa-sort-desc")
			.css('color', '#4d4d4d')
			.attr('sort', 'desc');
			sort[th.attr('name')] = 'desc';
		} else if (th.attr('sort')=='desc') {
			th
			.removeClass("fa-sort-desc")
			.addClass("fa-sort")
			.attr('sort', 'no');
		}
		getData();
	}

    function getParams(){
        if(settings['searchForm']) {
            var obj=$('#' + settings['searchForm']);
            obj.find('input').each(function (){
                if(!$(this).attr('name')){
                    return true;
                }
                if(!$(this).val()) {
                    delete params[$(this).attr('name')];
                    return true;
                }
                if($(this).attr('type')=='radio'){
                    if($(this).attr('checked')) {
                        params[$(this).attr('name')] = $(this).val();
                    }
                } else if ($(this).attr('type')=='checkbox'){
                    if($(this).attr('checked')) {
                        params[$(this).attr('name')] = $(this).val();
                    }
                } else {
                    params[$(this).attr('name')] = $(this).val();
                }
                
            });
            obj.find('select').each(function (){
                if(!$(this).attr('name')){
                    return true;
                }
                if(!$(this).val()) {
                    delete params[$(this).attr('name')];
                    return true;
                }
                params[$(this).attr('name')] = $(this).val();
            });
        }
		var p = [];
		for (var key in params) {
			p.push(key + '=' + encodeURIComponent(params[key]));
		};
		for (var key in sort) {
			p.push('sort[' + key + ']=' + sort[key]);
		};
        return p.join('&');
    }

	function getUrl(){
		if(settings['url'].indexOf('?') >= 0) {
			return settings['url'] + '&' + getParams();
		} else {
			return settings['url'] + '?' + getParams();
		}
	}
	
	/**
	 * ajax获取数据
	 */
	function getData()
	{
		$.ajax({
		  type: settings.ajaxMethod,
		  url: getUrl(),
          data: settings.data,
		  dataType: "json",
		  headers: {"Access-With":"Ajax-Table"},
		  beforeSend: function (){
			  showMsg(settings.loading, 1);
		  },
		  error: function (){
		  	  closeMsg();
			  showMsg(settings.error, 0);
		  },
		  success : function (d){
			  addRow(d);
			  if(d['sum']) {
			  	addFoot(d['sum']);
			  }
              setPage(d['count'], params['page']);
    		  closeMsg();
			  if(typeof settings['complete'] === 'function') {
			    settings['complete'].call( this, d, settings);
		      }
		  }
		});
	}

	/**
	 * 增加行
	 */
	function addRow(json) {
        if(!settings['columns']) {
            return;
        }
        var tr = '';
		for(var i=0; i<json['data'].length; i++) {
			tr += '<tr>';
			for(var j=0; j<settings['columns'].length; j++) {
                if(!settings['columns'][j]) {
                    continue;
                }
				var data = settings['columns'][j]['data'];
                var attr = "";
                if(settings['columns'][j]['attr']) {
                    attr = " " + settings['columns'][j]['attr'];
                }
				if(typeof data === 'string') {					
					tr += '<td' + attr + '>'+(json['data'][i][data]||"")+'</td>';
				} else if (typeof data === 'function') {
					tr += '<td' + attr + '>'+data.call( this, json['data'][i] )+'</td>';
				} else {
					tr += '<td' + attr + '></td>';
				}
			}
			tr += '</tr>';
		}
        table.children('tbody').html(tr);
	}

	/**
	 * 增加行
	 */
	function addFoot(json) {
        if(!settings['columns']) {
            return;
        }
        var tr = '<tfoot><tr><td>总计</td>';
        var len = settings['columns'].length;
		for(var j=1; j<len; j++) {
            if(!settings['columns'][j]) {
                continue;
            }
            var attr = "";
            if(settings['columns'][j]['attr']) {
                attr = " " + settings['columns'][j]['attr'];
            }
            if(!settings['columns'][j]['sum']) {
            	tr += '<td' + attr + '></td>';
                continue;
            }
			var data = settings['columns'][j]['sum'];
			if(typeof data === 'string') {					
				tr += '<td' + attr + '>'+(json[data]||"")+'</td>';
			} else if (typeof data === 'function') {
				tr += '<td' + attr + '>'+data.call( this, json )+'</td>';
			} else {
				tr += '<td' + attr + '></td>';
			}
		}
		tr += '</tr></tfoot>';
		table.children("tfoot").remove();
        table.children('tbody').after(tr);
	}

	function getPageNum(count) {
		return Math.ceil(count/getPerPage());
	}

	function getPerPage() {
		return $('#'+settings['pageNumSelect']).val() || settings['perpage'];
	}

	function changePerPage() {
        if(!settings['pageNumSelect']) {
            return;
        }
		$('#'+settings['pageNumSelect']).change(function (){
			params['perpage'] = $(this).val();
			params['page'] = 1;
			getData();
		});
	}


	function setPage(allNum, curpageNum) {
		params['page'] = 1;
		curpageNum = parseInt(curpageNum||1);
		var allPageNum = getPageNum(allNum);
        if(settings['pageInfoContainer']) {
		$('#'+settings['pageInfoContainer']).html(curpageNum + '/' + allPageNum + '页，共' + allNum + '条数据');
        }
        if(settings['pageContainer']) {
		$('#' + settings['pageContainer']).html(getPage(allPageNum, curpageNum)).find('a').click(function (){
			params['page'] = $(this).attr('page');
			getData();
			return false;
		});	
        }
	}

	function getPageUrl(){
		var page = params['page'];
		delete params['page'];
		var url = getUrl();
		params['page'] = page;
		if(url.indexOf('?') >= 0) {
			return url + '&page=';
		} else {
			return url + '?page=';
		}
	}

	function getPage(pages,curpage) {
	    var multi = '';
	    var mpurl = getPageUrl();
	    var page = 5;
	    var offset = 2;
	    if(page > pages) {
	        from = 1;
	        to = pages;
	    } else {
	        from = curpage - offset;
	        to = from + page - 1;
	        if(from < 1) {
	            to = curpage + 1 - from;
	            from = 1;
	            if(to - from < page) {
	                to = page;
	            }
	        } else if(to > pages) {
	            from = pages - page + 1;
	            to = pages;
	        }
	    }
	    multi += '<ul class="pagination">';
	    multi += curpage - offset > 1 && pages > page ? '<li><a href="' + mpurl + '1" page="1">1...</a><li>' : '';
	    //multi += curpage > 1 ? '<li><a href="' + mpurl + 'page=' + (curpage - 1) + '" class="prev">&lsaquo;&lsaquo;</a></li>' : '';
	    for(i = from; i <= to; i++){
	        multi += i == curpage ? '<li class="active">' : '<li>';
	        multi += '<a href="' + mpurl + i + '" page="' + i + '">' + i + '</a></li>';
	    }
	    //multi += curpage < pages ? '<li><a href="' + mpurl + 'page=' + (curpage + 1) + '" class="next">&rsaquo;&rsaquo;</a></li>' : '';
	    multi += to < pages ? '<li><a href="' + mpurl + pages + '" page="' + pages + '">...' + pages + '</a></li>' : '';
	    multi += '</ul>';
	    return multi;
	}

	function doSearch () {
        if(!settings['searchForm']) {
            return;
        }
		$('#' + settings['searchForm']).submit(function (){
			params['page'] = 1;
			getData();
			return false;
		});
	}

	function load() {
		params['perpage'] = getPerPage();
		headSort();
		getData();
		changePerPage();
		doSearch();
	}

    if(settings['url'] && settings['url']!='') {
        load();
    }
	return this;
	}
})(jQuery);
