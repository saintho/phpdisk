/**
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: ann_js.js 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
*/
$(function(){
var _wrap=$('ul.scroll');//定义滚动区域
var _interval=2000;//定义滚动间隙时间
var _moving;//需要清除的动画
_wrap.hover(function(){
clearInterval(_moving);//当鼠标在滚动区域中时,停止滚动
},function(){
_moving=setInterval(function(){
var _field=_wrap.find('li:first');//此变量不可放置于函数起始处,li:first取值是变化的
var _h=_field.height();//取得每次滚动高度(多行滚动情况下,此变量不可置于开始处,否则会有间隔时长延时)
_field.animate({marginTop:-_h+'px'},600,function(){//通过取负margin值,隐藏第一行
_field.css('marginTop',0).appendTo(_wrap);//隐藏后,将该行的margin值置零,并插入到最后,实现无缝滚动
})
},_interval)//滚动间隔时间取决于_interval
}).trigger('mouseleave');//函数载入时,模拟执行mouseleave,即自动滚动
});
