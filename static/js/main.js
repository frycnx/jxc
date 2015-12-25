// ------------------------------
// Sidebar Accordion Menu
// ------------------------------
$(function () {
    var reg = new RegExp('='+$("#sidebar").attr('app')+'($|&)','i');
    $('#sidebar').find('a').each(function(){
        //设置选择
        if( reg.test($(this).attr('href')) ) {
            $(this).closest('li').addClass('active')
                .closest('ul.acc-menu').attr('cur','true').show()
                .closest('li').addClass('open').addClass('active');
        }
        //跳过子
        if($(this).siblings('ul.acc-menu').length<1){            
            return true;
        }
        //增加hasChild
        $(this).closest('li').addClass('hasChild');
        //点击事件
        $(this).click(function(){
            if($(this).siblings('ul.acc-menu:visible').length>0){
                $(this).closest('li').removeClass('open');
            }else{
                $(this).closest('li').addClass('open');
            }
            $(this).siblings('ul.acc-menu').slideToggle({
                duration: 200,
                progress: function(){
                    checkpageheight();
                    if ($(this).closest('li').is(":last-child")) { //only scroll down if last-child
                        $("#sidebar").animate({ scrollTop: $("#sidebar").height()},0);
                    }

                },
                complete: function(){
                    $("#sidebar").resize();
                }
            });
        });
    });

    //On click of left menu
    $("a#leftmenu-trigger").click(function () {
        if ((window.innerWidth)<768) {
            $("body").removeClass("collapse-leftbar");
            $("body").toggleClass("show-leftbar");
        } else {
            if($("body").hasClass("collapse-leftbar")) {
                $("body").removeClass("collapse-leftbar");
                $('.acc-menu[cur=true]').css('display', 'block');
            }else{
                $("body").addClass("collapse-leftbar");
                $('.acc-menu').css('display', '');
            }
        }
        checkpageheight();
        //leftbarScrollShow();
    });
	//.pulsate({repeat:false})
	$("#leftmenu-trigger").click();

    //set minimum height of page
    $("#page-content").css("min-height",($(window).height()-$("header[role=banner]").height())+"px");
});
$(window).resize(function(){
    if ((window.innerWidth)<768) {
        $("body").removeClass("collapse-leftbar");
        $("body").removeClass("show-leftbar");
    }
    $("#page-content").css("height",($(window).height()-$("header[role=banner]").height())+"px");
});


// -------------------------------
// Back to Top button
// -------------------------------
$('#back-to-top').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 500);
    return false;
});

//Presentational: set all panel-body with br0 if it has panel-footer
$(".panel-footer").prev().css("border-radius","0");

// Match page height with Sidebar Height
function checkpageheight() {
    sh=$("#page-leftbar").height();
    ch=$("#page-content").height();
    if (sh>ch) $("#page-content").css("min-height",sh+"px");
}

//Fixing the show of scroll rails even when sidebar is hidden
function leftbarScrollShow () {
    if ($("body").hasClass("show-leftbar")) {
        $("#sidebar").show();
    } else {
        $("#sidebar").hide();
    }
    $("#sidebar").resize();
}

function add(x,y){
    var wx,wy,m;
    try{wx=x.toString().split(".")[1].length}catch(e){wx=0}
    try{wy=y.toString().split(".")[1].length}catch(e){wy=0}
    m=Math.pow(10,Math.max(wx,wy))
    return (x*m+y*m)/m;
}
function subtract(x,y){
    var wx,wy,m;
    try{wx=x.toString().split(".")[1].length}catch(e){wx=0}
    try{wy=y.toString().split(".")[1].length}catch(e){wy=0}
    m=Math.pow(10,Math.max(wx,wy))
    return (x*m-y*m)/m;
}
function multiply(x,y){
    var wx,wy,m;
    try{wx=x.toString().split(".")[1].length}catch(e){wx=0}
    try{wy=y.toString().split(".")[1].length}catch(e){wy=0}
    m=Math.pow(10,Math.max(wx,wy))
    return (x*m*y*m)/m;
}
function divide(x,y){
    var wx,wy,m;
    try{wx=x.toString().split(".")[1].length}catch(e){wx=0}
    try{wy=y.toString().split(".")[1].length}catch(e){wy=0}
    m=Math.pow(10,Math.max(wx,wy))
    return (x*m/y*m)*m;
}

function date ( format, timestamp ) {
    var a, jsdate=((timestamp) ? new Date(timestamp*1000) : new Date());
    var pad = function(n, c){
        if( (n = n + "").length < c ) {
            return new Array(++c - n.length).join("0") + n;
        } else {
            return n;
        }
    };
    var txt_weekdays = ["Sunday","Monday","Tuesday","Wednesday", "Thursday","Friday","Saturday"];        
    var txt_ordin = {1:"st",2:"nd",3:"rd",21:"st",22:"nd",23:"rd",31:"st"};
    var txt_months = ["", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var f = {
        // Day
            d: function(){
                return pad(f.j(), 2);
            },
            D: function(){
                t = f.l(); return t.substr(0,3);
            },
            j: function(){
                return jsdate.getDate();
            },
            l: function(){
                return txt_weekdays[f.w()];
            },
            N: function(){
                return f.w() + 1;
            },
            S: function(){
                return txt_ordin[f.j()] ? txt_ordin[f.j()] : 'th';
            },
            w: function(){
                return jsdate.getDay();
            },
            z: function(){
                return (jsdate - new Date(jsdate.getFullYear() + "/1/1")) / 864e5 >> 0;
            },

        // Week
            W: function(){
                var a = f.z(), b = 364 + f.L() - a;
                var nd2, nd = (new Date(jsdate.getFullYear() + "/1/1").getDay() || 7) - 1;

                if(b <= 2 && ((jsdate.getDay() || 7) - 1) <= 2 - b){
                    return 1;
                } else{

                    if(a <= 2 && nd >= 4 && a >= (6 - nd)){
                        nd2 = new Date(jsdate.getFullYear() - 1 + "/12/31");
                        return date("W", Math.round(nd2.getTime()/1000));
                    } else{
                        return (1 + (nd <= 3 ? ((a + nd) / 7) : (a - (7 - nd)) / 7) >> 0);
                    }
                }
            },

        // Month
            F: function(){
                return txt_months[f.n()];
            },
            m: function(){
                return pad(f.n(), 2);
            },
            M: function(){
                t = f.F(); return t.substr(0,3);
            },
            n: function(){
                return jsdate.getMonth() + 1;
            },
            t: function(){
                var n;
                if( (n = jsdate.getMonth() + 1) == 2 ){
                    return 28 + f.L();
                } else{
                    if( n & 1 && n < 8 || !(n & 1) && n > 7 ){
                        return 31;
                    } else{
                        return 30;
                    }
                }
            },

        // Year
            L: function(){
                var y = f.Y();
                return (!(y & 3) && (y % 1e2 || !(y % 4e2))) ? 1 : 0;
            },
            //o not supported yet
            Y: function(){
                return jsdate.getFullYear();
            },
            y: function(){
                return (jsdate.getFullYear() + "").slice(2);
            },

        // Time
            a: function(){
                return jsdate.getHours() > 11 ? "pm" : "am";
            },
            A: function(){
                return f.a().toUpperCase();
            },
            B: function(){
                // peter paul koch:
                var off = (jsdate.getTimezoneOffset() + 60)*60;
                var theSeconds = (jsdate.getHours() * 3600) +
                                 (jsdate.getMinutes() * 60) +
                                  jsdate.getSeconds() + off;
                var beat = Math.floor(theSeconds/86.4);
                if (beat > 1000) beat -= 1000;
                if (beat < 0) beat += 1000;
                if ((String(beat)).length == 1) beat = "00"+beat;
                if ((String(beat)).length == 2) beat = "0"+beat;
                return beat;
            },
            g: function(){
                return jsdate.getHours() % 12 || 12;
            },
            G: function(){
                return jsdate.getHours();
            },
            h: function(){
                return pad(f.g(), 2);
            },
            H: function(){
                return pad(jsdate.getHours(), 2);
            },
            i: function(){
                return pad(jsdate.getMinutes(), 2);
            },
            s: function(){
                return pad(jsdate.getSeconds(), 2);
            },
            //u not supported yet

        // Timezone
            //e not supported yet
            //I not supported yet
            O: function(){
               var t = pad(Math.abs(jsdate.getTimezoneOffset()/60*100), 4);
               if (jsdate.getTimezoneOffset() > 0) t = "-" + t; else t = "+" + t;
               return t;
            },
            P: function(){
                var O = f.O();
                return (O.substr(0, 3) + ":" + O.substr(3, 2));
            },
            //T not supported yet
            //Z not supported yet

        // Full Date/Time
            c: function(){
                return f.Y() + "-" + f.m() + "-" + f.d() + "T" + f.h() + ":" + f.i() + ":" + f.s() + f.P();
            },
            //r not supported yet
            U: function(){
                return Math.round(jsdate.getTime()/1000);
            }
    };

    return format.replace(/[\\]?([a-zA-Z])/g, function(t, s){
        if( t!=s ){
            // escaped
            ret = s;
        } else if( f[s] ){
            // a date function exists
            ret = f[s]();
        } else{
            // nothing special
            ret = s;
        }

        return ret;
    });
}

(function ( $ ) {
	var attachEvent = document.attachEvent,
		stylesCreated = false;
	
	var jQuery_resize = $.fn.resize;
	
	$.fn.resize = function(callback) {
		return this.each(function() {
			if(this == window)
				jQuery_resize.call(jQuery(this), callback);
			else
				addResizeListener(this, callback);
		});
	}

	$.fn.removeResize = function(callback) {
		return this.each(function() {
			removeResizeListener(this, callback);
		});
	}
	
	if (!attachEvent) {
		var requestFrame = (function(){
			var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame ||
								function(fn){ return window.setTimeout(fn, 20); };
			return function(fn){ return raf(fn); };
		})();
		
		var cancelFrame = (function(){
			var cancel = window.cancelAnimationFrame || window.mozCancelAnimationFrame || window.webkitCancelAnimationFrame ||
								   window.clearTimeout;
		  return function(id){ return cancel(id); };
		})();

		function resetTriggers(element){
			var triggers = element.__resizeTriggers__,
				expand = triggers.firstElementChild,
				contract = triggers.lastElementChild,
				expandChild = expand.firstElementChild;
			contract.scrollLeft = contract.scrollWidth;
			contract.scrollTop = contract.scrollHeight;
			expandChild.style.width = expand.offsetWidth + 1 + 'px';
			expandChild.style.height = expand.offsetHeight + 1 + 'px';
			expand.scrollLeft = expand.scrollWidth;
			expand.scrollTop = expand.scrollHeight;
		};

		function checkTriggers(element){
			return element.offsetWidth != element.__resizeLast__.width ||
						 element.offsetHeight != element.__resizeLast__.height;
		}
		
		function scrollListener(e){
			var element = this;
			resetTriggers(this);
			if (this.__resizeRAF__) cancelFrame(this.__resizeRAF__);
			this.__resizeRAF__ = requestFrame(function(){
				if (checkTriggers(element)) {
					element.__resizeLast__.width = element.offsetWidth;
					element.__resizeLast__.height = element.offsetHeight;
					element.__resizeListeners__.forEach(function(fn){
						fn.call(element, e);
					});
				}
			});
		};
		
		/* Detect CSS Animations support to detect element display/re-attach */
		var animation = false,
			animationstring = 'animation',
			keyframeprefix = '',
			animationstartevent = 'animationstart',
			domPrefixes = 'Webkit Moz O ms'.split(' '),
			startEvents = 'webkitAnimationStart animationstart oAnimationStart MSAnimationStart'.split(' '),
			pfx  = '';
		{
			var elm = document.createElement('fakeelement');
			if( elm.style.animationName !== undefined ) { animation = true; }    
			
			if( animation === false ) {
				for( var i = 0; i < domPrefixes.length; i++ ) {
					if( elm.style[ domPrefixes[i] + 'AnimationName' ] !== undefined ) {
						pfx = domPrefixes[ i ];
						animationstring = pfx + 'Animation';
						keyframeprefix = '-' + pfx.toLowerCase() + '-';
						animationstartevent = startEvents[ i ];
						animation = true;
						break;
					}
				}
			}
		}
		
		var animationName = 'resizeanim';
		var animationKeyframes = '@' + keyframeprefix + 'keyframes ' + animationName + ' { from { opacity: 0; } to { opacity: 0; } } ';
		var animationStyle = keyframeprefix + 'animation: 1ms ' + animationName + '; ';
	}
	
	function createStyles() {
		if (!stylesCreated) {
			//opacity:0 works around a chrome bug https://code.google.com/p/chromium/issues/detail?id=286360
			var css = (animationKeyframes ? animationKeyframes : '') +
					'.resize-triggers { ' + (animationStyle ? animationStyle : '') + 'visibility: hidden; opacity: 0; } ' +
					'.resize-triggers, .resize-triggers > div, .contract-trigger:before { content: \" \"; display: block; position: absolute; top: 0; left: 0; height: 100%; width: 100%; overflow: hidden; } .resize-triggers > div { background: #eee; overflow: auto; } .contract-trigger:before { width: 200%; height: 200%; }',
				head = document.head || document.getElementsByTagName('head')[0],
				style = document.createElement('style');
			
			style.type = 'text/css';
			if (style.styleSheet) {
				style.styleSheet.cssText = css;
			} else {
				style.appendChild(document.createTextNode(css));
			}

			head.appendChild(style);
			stylesCreated = true;
		}
	}
	
	window.addResizeListener = function(element, fn){
		if (attachEvent) element.attachEvent('onresize', fn);
		else {
			if (!element.__resizeTriggers__) {
				if (getComputedStyle(element).position == 'static') element.style.position = 'relative';
				createStyles();
				element.__resizeLast__ = {};
				element.__resizeListeners__ = [];
				(element.__resizeTriggers__ = document.createElement('div')).className = 'resize-triggers';
				element.__resizeTriggers__.innerHTML = '<div class="expand-trigger"><div></div></div>' +
																						'<div class="contract-trigger"></div>';
				element.appendChild(element.__resizeTriggers__);
				resetTriggers(element);
				element.addEventListener('scroll', scrollListener, true);
				
				/* Listen for a css animation to detect element display/re-attach */
				animationstartevent && element.__resizeTriggers__.addEventListener(animationstartevent, function(e) {
					if(e.animationName == animationName)
						resetTriggers(element);
				});
			}
			element.__resizeListeners__.push(fn);
		}
	};
	
	window.removeResizeListener = function(element, fn){
		if (attachEvent) element.detachEvent('onresize', fn);
		else {
			element.__resizeListeners__.splice(element.__resizeListeners__.indexOf(fn), 1);
			if (!element.__resizeListeners__.length) {
					element.removeEventListener('scroll', scrollListener);
					element.__resizeTriggers__ = !element.removeChild(element.__resizeTriggers__);
			}
		}
	}
}( jQuery ));

(function ($) {

    function setWidth(obj) {
        var tid = obj.attr("id");
        if(obj.children("thead").length) {
            //重新计算表头的宽高
            var table_thead_th = $('#'+tid+'_table_thead')
                                .width(obj.width())
                                .children("thead")
                                .height(obj.children("thead").height())
                                .find("th");
            //计算表头背景宽高
            $('#'+tid+'_table_thead_bg')
                    .width(obj.width())
                    .height(parseFloat(obj.children("thead").height())+parseFloat(obj.css("margin-top").replace("px","")));
            //重新计算表头的列宽高
            obj.children("thead").find('th').each(function (index) {
                table_thead_th
                    .eq(index)
                    .width($(this).width())
            });
        }

        if(obj.children("tfoot").length) {
            //重新计算表尾
            var table_tfoot_th = $('#'+tid+'_table_tfoot')
                                .width(obj.width())
                                .children("tfoot")
                                .height(obj.children("tfoot").height())
                                .find("th");
            //计算表尾背景宽高
            $('#'+tid+'_table_tfoot_bg')
                    .width(obj.width())
                    .height(parseFloat(obj.children("tfoot").height())+parseFloat(obj.css("margin-bottom").replace("px","")));
            //重新计算表尾的列宽高
            obj.children("tfoot").find('th').each(function (index) {
                table_tfoot_th.eq(index).width($(this).width());
            });
        }
    }

    $.fn.fixTable = function (params) {
        function getBackgroundColor(obj) {
            var bg = obj.css("background-color");
            if(bg=="transparent"||bg=="rgba(0, 0, 0, 0)") {
                return getBackgroundColor(obj.parent());
            }
            return bg;
        }

		function fixTable(obj){
            obj.parent().css("overflow-y","auto");
            var tid = obj.attr("id"),
                z = obj.css("z-index"),
                bg = getBackgroundColor(obj);
            z = parseInt(z=='auto'? 0: z);
            if(obj.children("thead").length) {
                createThead(obj, tid, bg, z);
            }

            if(obj.children("tfoot").length) {
                createTfoot(obj, tid, bg, z);
            }            

            setWidth(obj);
			//obj.resize(function(){setWidth(obj);});
            return this;
		}

        function createThead(obj, tid, bg, z) {
            //生成表头
            var table_thead = $('<table id="'+tid+'_table_thead"></table>')
                            .css("z-index", z+2)
							.css("position", "absolute")
							.css("background-color", bg)
                            .css("top", "0")
                            .append(obj.children("thead").clone());
            $.each(obj.prop("attributes"), function () {
                if (this.name != "id") {
                    table_thead.attr(this.name, this.value);
                }
            });
            obj.before(table_thead)
                .children("thead")
                .css("visibility", "hidden");
            //处理表头背景
            var tblh = $('#'+tid+'_table_thead_bg');
            tblh.before($("<div></div>")
                .css("z-index", z+1)
                .css("position", "absolute")
                .css("background-color", bg)
                .css("top", "0")
                .width(tblh.width())
                .height(parseFloat(tblh.height())+parseFloat(obj.css("margin-top").replace("px",""))));
        }

        function createTfoot(obj, tid, bg, z) {
            //生成表尾
            var h = parseFloat(obj.children("tfoot").height());
            var b = parseFloat(obj.css("margin-bottom").replace("px",""));
            var top = parseFloat(obj.parent().height())-h-b;
            var table_tfoot = $('<table id="'+tid+'_table_tfoot"></table>')
					.css("z-index", z+2)
                    .css("position", "absolute")
					.css("background-color", bg)
                    .css("top", top)
                    .append(obj.children("tfoot").clone());
            $.each(obj.prop("attributes"), function () {
                if (this.name != "id") {
                    table_tfoot.attr(this.name, this.value);
                }
            });
            obj.after(table_tfoot)
                .children("tfoot")
                .css("visibility", "hidden");
            //表尾背景
            var tblf = $('#'+tid+'_table_tfoot');
            tblf.after($('<div id="'+tid+'_table_tfoot_bg"></div>')
                    .css("z-index", z+1)
                    .css("position", "absolute")
                    .css("background-color", bg)
                    .css("top", top)
                    .width(obj.children("tfoot").width())
                    .height(h + b));
        }
	
        return this.each(function (i, e) {
            fixTable($(e));
        });

    };
    $.fn.fixTableWidth = function (params) {

        return this.each(function (i, e) {
            setWidth($(e));
        });

    };
})(jQuery);

(function(){
  var cache = {}; 
  this.tmpl = function tmpl(str, data){
    var fn = !/\W/.test(str) ?
      cache[str] = cache[str] ||
        tmpl(document.getElementById(str).innerHTML) :
      new Function("obj",
        "var p=[],print=function(){p.push.apply(p,arguments);};" +
        "with(obj){p.push('" +
        str
          .replace(/[\r\t\n]/g, " ")
          .split("<%").join("\t")
          .replace(/((^|%>)[^\t]*)'/g, "$1\r")
          .replace(/\t=(.*?)%>/g, "',$1,'")
          .split("\t").join("');")
          .split("%>").join("p.push('")
          .split("\r").join("\\'")
      + "');}return p.join('');");
    return data ? fn( data ) : fn;
  };
})();


function randStr(len){
    var len = len||5,chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',l=chars.length,name='';
    for(var i=0;i<len;i++){
        name += chars.charAt(Math.floor(Math.random()*l));
    }
    return name;
}