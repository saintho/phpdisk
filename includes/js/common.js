/**
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: common.js 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
*/
String.prototype.strtrim = function(){
	return this.replace(/(^\s*)|(\s*$)/g, "");
}
String.prototype.toInt = function() {
	var s = parseInt(this);
	return isNaN(s) ? 0 : s;
}
function getId(id){
	return document.getElementById(id);	
}
function go(url){
	document.location.href = url;
}

function resize_textarea(obj,type) {
	if(type=='expand'){
		var newheight = parseInt(getId(obj).style.height, 10) + 50;
		getId(obj).style.height = newheight + 'px';
		getId(obj).style.width = '98%';
	}else if(type == 'plus'){
		var newheight = parseInt(getId(obj).style.height, 10) + 50;
		getId(obj).style.height = newheight + 'px';
	}else{
		var newheight = parseInt(getId(obj).style.height, 10) - 50;
		if(newheight > 0) {
			getId(obj).style.height = newheight + 'px';
		}
	}
}

function getCookie( name ) {
	var start = document.cookie.indexOf( name + "=" );
	var len = start + name.length + 1;
	if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) ) {
		return null;
	}
	if ( start == -1 ) return null;
	var end = document.cookie.indexOf( ";", len );
	if ( end == -1 ) end = document.cookie.length;
	return unescape( document.cookie.substring( len, end ) );
}

function setCookie( name, value, expires, path, domain, secure ) {
	var today = new Date();
	today.setTime( today.getTime() );
	if ( expires ) {
		expires = expires * 60 * 60 * 24;
	}
	var expires_date = new Date( today.getTime() + (expires) );
	document.cookie = name+"="+escape( value ) +
		( ( expires ) ? ";expires="+expires_date.toGMTString() : "" ) + 
		( ( path ) ? ";path=" + path : "" ) +
		( ( domain ) ? ";domain=" + domain : "" ) +
		( ( secure ) ? ";secure" : "" );
}

function deleteCookie( name, path, domain ) {
	if ( getCookie( name ) ) document.cookie = name + "=" +
			( ( path ) ? ";path=" + path : "") +
			( ( domain ) ? ";domain=" + domain : "" ) +
			";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

function resize_img(id,w,h){
	if(getId(id).width>w){
		getId(id).width = w;
	}
	if(getId(id).height>h){
		getId(id).height = h;
	}
}

function get_icon(ext)
{
    var icons =
	{
		'default':'file',
		'7z' : '7z',
		'asp' : 'asp',
		'aspx' : 'aspx',
		'bat' : 'bat',
		'bmp' : 'bmp',
		'chm' : 'chm',
		'css' : 'css',
		'db' : 'db',
		'dll' : 'dll',
		'doc' : 'doc',
		'exe' : 'exe',
		'file' : 'file',
		'fla' : 'fla',
		'gif' : 'gif',
		'htm' : 'htm',
		'html' : 'html',
		'images' : 'images',
		'ini' : 'ini',
		'jpeg' : 'jpeg',
		'jpg' : 'jpg',
		'js' : 'js',
		'jsp' : 'jsp',
		'lnk' : 'lnk',
		'mdb' : 'mdb',
		'mov' : 'mov',
		'mp3' : 'mp3',
		'pdf' : 'pdf',
		'php' : 'php',
		'png' : 'png',
		'ppt' : 'ppt',
		'psd' : 'psd',
		'qt' : 'qt',
		'quicktime' : 'quicktime',
		'rar' : 'rar',
		'reg' : 'reg',
		'rm' : 'rm',
		'rmvb' : 'rmvb',
		'shtml' : 'shtml',
		'swf' : 'swf',
		'tif' : 'tif',
		'torrent' : 'torrent',
		'txt' : 'txt',
		'vbs' : 'vbs',
		'video' : 'video',
		'video2' : 'video2',
		'video3' : 'video3',
		'vsd' : 'vsd',
		'wmv' : 'wmv',
		'xls' : 'xls',
		'xml' : 'xml',
		'xsl' : 'xsl',
		'zip' : 'zip'
	}
    return icons[ext] ? icons[ext] : icons['default'];
}
function get_extension(n){
	n = n.substr(n.lastIndexOf('.')+1);
	return n.toLowerCase();
}
function rtn_display_status(id){
	return getId(id).style.display = getId(id).style.display=='' ? 'none' : '';
}
function reverse_ids(id){
	for (var i=0;i<id.length;i++) {
		var ids = id[i];
		ids.checked = !ids.checked;
	}
}
function cancel_ids(id){
	for (var i=0;i<id.length;i++) {
		var ids = id[i];
		ids.checked = false;
	}
}
function checkbox_ids(ids){
	var n = document.getElementsByName(ids);
	var j = 0;
	for(i = 0; i < n.length; i++){
		if(n[i].checked){
			j++;
		}
	}
	if(j ==0){
		return false;
	}else{
		return true;
	}
}
function on_menu(parent, child, position, showtype){
	var p = getId(parent);
	var c = getId(child);
	
	p["_parent"]     = p.id;
	c["_parent"]     = p.id;
	p["_child"]      = c.id;
	c["_child"]      = c.id;
	p["_position"]   = position;
	c["_position"]   = position;
	
	c.style.position   = "absolute";
	c.style.visibility = "hidden";
	p.style.cursor = 'pointer';
	
	if(showtype == 'click'){
		p.onclick     = _on_click;
		p.onmouseout  = _on_hide;
		c.onmouseover = _on_show;
		c.onmouseout  = _on_hide;
	}else{
		p.onmouseover = _on_show;
		p.onmouseout  = _on_hide;
		c.onmouseover = _on_show;
		c.onmouseout  = _on_hide;
	}
}

function _on_show_event(parent, child){
	var p = getId(parent);
	var c = getId(child);
	
	var ph = p.offsetHeight;
	var pw = p.offsetWidth;
	var pl = p.offsetLeft;
	var pt = p.offsetTop;
	
	var ch = c.offsetHeight;
	var cw = c.offsetWidth;
	var cl = c.offsetLeft;
	var ct = c.offsetTop;
	
	var top,left;
	
	if(c["_position"]=="-x"){top=0;left=-cw-2;}
	if(c["_position"]=="-y"){top=-ch+2;left=0;}
	if(c["_position"]=="x"){top=0;left=pw+2;}
	if(c["_position"]=="y"){top=ph+2;left=0;}
	
	for (; p; p = p.offsetParent){
		top  += p.offsetTop;
		left += p.offsetLeft;
	}
	
	c.style.position   = "absolute";
	c.style.top        = top +'px';
	c.style.left       = left+'px';
	c.style.visibility = "visible";
}
function _on_show(){
	var p = getId(this["_parent"]);
	var c = getId(this["_child" ]);
	
	_on_show_event(p.id, c.id);
	clearTimeout(c["at_timeout"]);
}
function _on_hide(){
	var p = getId(this["_parent"]);
	var c = getId(this["_child" ]);
	
	c["at_timeout"] = setTimeout("getId('"+c.id+"').style.visibility = 'hidden'", 100);
}
function _on_click(){
	var p = getId(this["_parent"]);
	var c = getId(this["_child" ]);
	
	if (c.style.visibility != "visible") _on_show_event(p.id, c.id); else c.style.visibility = "hidden";
	return false;
}
function copy_text(id,msg){
	var field = getId(id);
	if (field){
		if(document.all){
			field.createTextRange().execCommand('copy');
			alert(msg);
		}else{
			alert('请复制选定的内容');
		}
	}
}
function copy_mytxt(txt,msg) {
	if (window.clipboardData) {
		window.clipboardData.clearData();
		window.clipboardData.setData("Text", txt);
	} else if (navigator.userAgent.indexOf("Opera") != -1) {
		window.location = txt;
	} else if (window.netscape) {
		try {
			netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
		} catch (e) {
			alert("复制操作被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将'signed.applets.codebase_principal_support'设置为'true'");
			return false;
		}
		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if (!clip)
			return;
		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if (!trans)
			return;
		trans.addDataFlavor('text/unicode');
		var str = new Object();
		var len = new Object();
		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		var copytext = txt;
		str.data = copytext;
		trans.setTransferData("text/unicode", str, copytext.length * 2);
		var clipid = Components.interfaces.nsIClipboard;
		if (!clip)
			return false;
		clip.setData(trans, null, clipid.kGlobalClipboard);
	}
	alert(msg);
}
function open_box(url,width,height){
	if(url!=''){
		window.showModalDialog(url,'','dialogWidth='+width+'px;dialogHeight='+height+'px');
	}
}
function abox(url,title,width,height){
	$.jBox.open("iframe:"+url, title, width, height,{top:'10%',buttons: {}});
}
function atips(msg){
	$.jBox.tip(msg);
}
