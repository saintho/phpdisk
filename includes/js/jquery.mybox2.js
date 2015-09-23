/**
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: jquery.mybox2.js 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
*/
var lang_btn_txt='&#19978;&#20256;&#25991;&#20214;';
var lang_upload_tips='<span style="color:#FF0000">&#65288;&#21333;&#20987;&#25991;&#20214;&#21517;&#32;&#21363;&#21487;&#33719;&#24471;&#25991;&#20214;&#19979;&#36733;&#22320;&#22336;&#65289;</span>';
var lang_pw_code_alert= '请将帖子编辑模式切换为【代码模式】，再点击添加。';

(function(jq){
    //class为.myBox_close为关闭
    jq.fn.myBox = function(options){
        var defaults = {
            opacity: 0.5,//背景透明度
            callBack: null,
            noTitle: false,
			show:false,
			timeout:0,
			target:null,
			boxType:null,//iframe,ajax,img
            title: "Title",
			drag:true,
			iframe: {//iframe 设置高宽
                width: 400,
                height: 300
            },
            html: ''//myBox内容
        },_this=this;
		this.EXT = jq.extend(defaults, options);
        var myBoxHtml = '<div id="myBox"><div class="myBox_popup"><table><tbody><tr><td class="myBox_tl"/><td class="myBox_b"/><td class="myBox_tr"/></tr><tr><td class="myBox_b"><div style="width:10px;">&nbsp;</div></td><td><div class="myBox_body">' + (_this.EXT.noTitle ? '' : '<table class="myBox_title"><tr><td class="myBox_dragTitle"><div class="myBox_itemTitle">' + _this.EXT.title + '</div></td><td width="20px" title="关闭"><div class="myBox_close" onclick="get_my_last()"></div></td></tr></table> ') +
        '<div class="myBox_content" id="myBoxContent"></div></div></td><td class="myBox_b"><div style="width:10px;">&nbsp;</div></td></tr><tr><td class="myBox_bl"/><td class="myBox_b"/><td class="myBox_br"/></tr></tbody></table></div></div>', B = null, C = null, win = jq(window);//B背景，C内容jquery div   
        this.showBox=function (){
            jq("#myBox_overlay").remove();
			jq("#myBox").remove();
            
            B = jq("<div id='myBox_overlay' class='myBox_hide'></div>").hide().addClass('myBox_overlayBG').css('opacity', _this.EXT.opacity).dblclick(function(){
                _this.close();
            }).appendTo('body').fadeIn(10);
            C = jq(myBoxHtml).appendTo('body');
            handleClick();
        }
        /*
         * 处理点击
         * @param {string} what
         */
        function handleClick(){
            var con = C.find("#myBoxContent");
			if (_this.EXT.boxType && jq.inArray(_this.EXT.boxType, ['iframe', 'ajax','img'])!=-1) {
				con.html("<div class='myBox_load'><div id='myBox_loading'><img src='images/ajax_loading.gif' /></div></div>");				
				if (_this.EXT.boxType === "img") {
					var img = jq("<img />");
					img.attr("src",_this.EXT.target);
					img.load(function(){
						img.appendTo(con.empty());
						setPosition();
					});
				}
				else 
					if (_this.EXT.boxType === "ajax") {
						jq.get(_this.EXT.target, function(data){
							con.html(data);
							C.find('.myBox_close').click(_this.close);
							setPosition();
						})
						
					}
					else {
					
						ifr = jq("<iframe name='myBoxIframe' style='width:" + _this.EXT.iframe.width + "px;height:" + _this.EXT.iframe.height + "px;' scrolling='auto' frameborder='0' src='" + _this.EXT.target + '#t='+ Math.random() + "'></iframe>");
						ifr.appendTo(con.empty());
						ifr.load(function(){
							try {
								it = jq(this).contents();
								it.find('.myBox_close').click(_this.close);
								fH = it.height();//iframe height
								fW = it.width();
								w = win;
								newW = Math.min(w.width() - 40, fW);
								newH = w.height() - 25 - (_this.EXT.noTitle ? 0 : 30);
								newH = Math.min(newH, fH);
								if (!newH) 
									return;
								var lt = calPosition(newW);
								C.css({
									left: lt[0],
									top: lt[1]
								});
								
								jq(this).css({
									height: newH,
									width: newW
								});
							} 
							catch (e) {
							}
						});
					}
				
			}
			else 
				if (_this.EXT.target) {
					jq(_this.EXT.target).clone(true).show().appendTo(con.empty());
					
				}
				else 
					if (_this.EXT.html) {
						con.html(_this.EXT.html);
					}
					else {
						jq(this).clone(true).show().appendTo(con.empty());
					}         
            afterHandleClick();
        }
        /*
         * 处理点击之后的处理
         */
        function afterHandleClick(){     
            setPosition();
            C.show().find('.myBox_close').click(_this.close).hover(function(){
                jq(this).addClass("on");
            }, function(){
                jq(this).removeClass("on");
            });
            jq(document).unbind('keydown.myBox').bind('keydown.myBox', function(e){
                if (e.keyCode === 27) 
                    _this.close();
                return true
            });
            typeof _this.EXT.callBack === 'function' ? _this.EXT.callBack() : null;
            !_this.EXT.noTitle&&_this.EXT.drag?drag():null;
			if(_this.EXT.timeout){
                setTimeout(_this.close,_this.EXT.timeout);
            }
				
        }
        /*
         * 设置myBox的位置
         */
        function setPosition(){
            if (!C) {
                return false;
            }
			
            var width = C.width(),  lt = calPosition(width);
            C.css({
                left: lt[0],
                top: lt[1]
            });
            var h = jq("body").height(), wh = win.height(),hh=jq("html").height();
            h = Math.max(h, wh);
            B.height(h).width(win.width())            
        }
        /*
         * 计算myBox的位置
         * @param {number} w 宽度
         */
        function calPosition(w){
            l = (win.width() - w) / 2;
            t = win.scrollTop() + win.height() /9;
            return [l, t];
        }
        /*
         * 拖拽函数drag
         */
        function drag(){
            var dx, dy, moveout;
            var T = C.find('.myBox_dragTitle').css('cursor', 'move');
            T.bind("selectstart", function(){
                return false;
            });
            
            T.mousedown(function(e){
                dx = e.clientX - parseInt(C.css("left"));
                dy = e.clientY - parseInt(C.css("top"));
                C.mousemove(move).mouseout(out).css('opacity',1);
                T.mouseup(up);
            });
            /*
             * 移动改变生活
             * @param {Object} e 事件
             */
            function move(e){
                moveout = false;
                if (e.clientX - dx < 0) {
                    l = 0;
                }
                else 
                    if (e.clientX - dx > win.width() - C.width()) {
                        l = win.width() - C.width();
                    }
                    else {
                        l = e.clientX - dx
                    }
                C.css({
                    left: l,
                    top: e.clientY - dy
                });
                
            }
            /*
             * 你已经out啦！
             * @param {Object} e 事件
             */
            function out(e){
                moveout = true;
                setTimeout(function(){
                    moveout && up(e);
                }, 10);
            }
            /*
             * 放弃
             * @param {Object} e事件
             */
            function up(e){
                C.unbind("mousemove", move).unbind("mouseout", out).css('opacity', 1);
                T.unbind("mouseup", up);
            }
        }
        
        /*
         * 关闭弹出框就是移除还原
         */
        this.close=function (){
            if (C) {
                B.remove();
                C.stop().fadeOut(10, function(){
                    C.remove();
                })
            }
        }
        /*
         * 触发click事件
         */		
        win.resize(function(){
            setPosition();
        });
		_this.EXT.show?_this.showBox():jq(this).click(function(){
            _this.showBox();
            return false;
        });
		return this;
    };
})(jQuery);

function show_box(id,tit,url,w,h){
	jq('#'+id).myBox({boxType:"iframe",title:tit,iframe:{width:w,height:h},target:url});
}
 function addCodeToEditor(txt,txt2,plugin_type){
 	switch(plugin_type){
		case 'dx2':
			if(wysiwyg){
				insertText(txt,false);
			}else{
				insertText(txt2, strlen(txt2), 0);
			}
		break;
		case 'pw87':
			if(editor.codeModeBtn.className == 'B_onCodeMode'){ 
				insertContentToTextArea(getObj('textarea'),txt2);
				editor.focus();
			}else{
				alert(lang_pw_code_alert);
			}

		break;
	}
 }
