<?php die();?>a:2:{s:4:"time";d:1375434423.1702659130096435546875;s:4:"data";s:50976:" 

var yuc_captcha = function(obj) {
    obj.pf = 'yuc_';
    obj.mainid = obj.pf + "main";
    obj.imgid = obj.pf + "img";
    obj.reloadid = obj.pf + "reload";
    obj.typhoonwest = obj.pf + "typhoon_west";
    obj.inputcont = obj.pf + 'input';
    obj.focustype = 1;
    obj.imglink = obj.pf + 'imglink';
    obj.tipcont = obj.pf + 'tip';
    obj.tiplayercont = obj.pf + 'tiplayer';
    obj.closetipcont = obj.pf + 'closetip';
    obj.ajaxcont = obj.pf + 'ajax_verify';
    obj.ajaxdetails = obj.pf + 'ajaxdetails';
    obj.tempbox = obj.pf + 'temp';
    obj.imgpath = 'http://' + obj.server + '/Media/Frame/img';
    obj.errorimg = obj.imgpath + '/error.gif';
    obj.errorinfo = '%u5982%u95EE%u9898%u4F9D%u65E7%uFF0C%u8BF7%u8BBF%u95EE';
    obj.direct_prefix = 'direct_';
    obj.popup_prefix = 'popup_';
    obj.blockctrl = obj.pf + 'blockctrl';
    obj.input = 'inputbox';
    obj.isloaded = false;
    obj.ajaxback = {'y':obj.direct_prefix + 'right','n':obj.direct_prefix + 'error'};
    obj.adimg = obj.pf + 'adimg';
    obj.cssname = obj.pf + 'css';
    obj.captchatext1 = '%u8BF7%u8F93%u5165%u9A8C%u8BC1%u7801';
    obj.captchatext0 = '%u70B9%u51FB%u83B7%u53D6%u9A8C%u8BC1%u7801';
    obj.reloadtip = '%u770B%u4E0D%u6E05%3F%u6362%u4E00%u5F20';
    obj.logotip = '%u70B9%u51FB%u4E86%u89E3%u5B87%u521D%u7F51%u7EDC%u9A8C%u8BC1%u7801';
    obj.aderrortip = '%u56FE%u7247%u52A0%u8F7D%u5931%u8D25%u8BF7%u5237%u65B0%u91CD%u8BD5';
    obj.adtip = '%u70B9%u51FB%u67E5%u770B%u8BE6%u60C5';
    obj.helptip = '%u5982%u9700%u5E2E%u52A9%u8BF7%u70B9%u51FB';
    obj.closetip = '%u5173%u95ED';
    obj.rpttip = '%u8BF7%u4E0D%u8981%u91CD%u590D%u8F93%u5165%uFF0C%u8BF7%u5237%u65B0%u540E%u91CD%u65B0%u8F93%u5165';
    obj.helpname = '%u8BE6%u60C5';


    obj.cookiesetting = {
        'expires': 300,
        'path': '/'
    };
    obj.cookiename = {
        'uid':obj.pf + 'uid',
        'visit':obj.pf + 'visit',
        'reload':obj.pf + 'reload'
    }

    var $ = function(id) {
        return document.getElementById(id)};
    var rid = [];
    var posiid = {};
    var pid = {};
    var Html = [];
    var custom = {};
    var debugx = false;
    var isieload = false;
    var isrptreload = false;
    var M = navigator.userAgent.indexOf("MSIE") != -1 && !window.opera;
    var ismove = true;
    var isstop = false;
    var stopsec = 10;
    var diffsec = 0;
    var storagems = 100;
    var sendms = 5000;
    var xyt = {};
    var pushdata = Array();
    var data = "";
    var strogeprocess = null;
     
    var X = function(cid) {
        if (!cid) {
            cid = obj.cookieid}
        var arrStr = document.cookie.split(';');
        for (var i = 0; i < arrStr.length; i++) {
            var temp = arrStr[i].split("=");
            if (temp[0] == cid) {
                return J(temp[1])} else {
                return ''}
        }

    };

    var GS = function(name, value, options) {
        if (typeof value != 'undefined') {              options = options || {};
            if (value === null) {
                value = '';
                options.expires = -1}
            var expires = '';
            if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
                var date;
                if (typeof options.expires == 'number') {
                    date = new Date();
                    date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000))} else {
                    date = options.expires}
                expires = '; expires=' + date.toUTCString()}
            var path = options.path ? '; path=' + options.path : '';
            var domain = options.domain ? '; domain=' + options.domain : '';
            var secure = options.secure ? '; secure' : '';
            document.cookie = [name, '=', Z(value), expires, path, domain, secure].join('')} else {
            var cookieValue = null;
            if (document.cookie && document.cookie != '') {
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = cookies[i].replace(/^\s+|\s+$/g, "");
                    if (cookie.substring(0, name.length + 1) == (name + '=')) {
                        cookieValue = J(cookie.substring(name.length + 1));
                        break}
                }
            }
            return cookieValue}
    };

    var I = function(n, t) {
        if (t) {
            var p = t.parentNode;
            if (p.lastChild == t) {
                p.appendChild(n)} else {
                p.insertBefore(n, t.nextSibling)}
        }
    }
    var G = function(key, inconvert) {
        if (!inconvert) {
            return unescape(obj[key])} else {
            return obj[key]}
    }
    var S = function() {
        for (var i = 0; i < rid.length; i++) {
            if (!$(pid[rid[i]].typhoonwest)) {
                var actionid = '';
                var actssid = '';
                if (obj[rid[i]]['actionid']) {
                    actionid = obj[rid[i]]['actionid'];
                    actssid = actionid + '|' + obj.ssid[rid[i]]} else {
                    actssid = obj.ssid[rid[i]]}
                var value = actssid + ',' + $(rid[i]).name + ',' + obj.request_type;
                N(pid[rid[i]].typhoonwest, $(rid[i]), obj.typhoonwest, value);
                N(pid[rid[i]].tempbox, $(rid[i]), '', 0)}
        }
    };
    var L = function(id, src, func) {
        if (id) {
            if (!!$(id)) {
                D(id)}
        }
        var isIE =/msie/i.test(navigator.userAgent);
        var s = C('script');
        if (id) {
            s.id = id}
        s.type = "text/javascript";
        if (isIE) {
            s.onreadystatechange = function () {
                if (s.readyState.toLowerCase() == "loaded" || s.readyState.toLowerCase() == "complete") {
                    if (typeof func == 'function') {
                        func()}
                }
            }
        } else {
            s.onload = function () {
                if (typeof func == 'function') {
                    func()}
            }
        }
        s.src = src;
        s.charset = 'utf-8';
        H(s)};
    var isEmptyObj = function (obj) {
        for (var name in obj) {
            return false}
        return true}
    var T = function(r, g) {
        if (g) {
            if (M) {
                var x = document.createStyleSheet();
                x.cssText = g
            } else {
                var c = C("style");
                c.type = "text/css";
                c.appendChild(document.createTextNode(g));
                H(c)}
        }
        var savecss = $(pid[r].cssname);
        if (savecss && savecss.value && savecss.value.indexOf(obj[r].pattern) == -1) {
            $(pid[r].cssname).value += ',' + obj[r].pattern} else {
            if (!savecss) {
                N(pid[r].cssname, $(r), '', obj[r].pattern)}
        }
    };
    var H = function(o) {
        var head = document.getElementsByTagName('head');
        var node = (head.length < 1) ? document.body : head[0];
        node.appendChild(o)};
    var B = (function(ua) {
        var b = {
            msie :/msie/.test(ua) && !/opera/.test(ua),
            opera :/opera/.test(ua),
            safari :/webkit/.test(ua) && !/chrome/.test(ua),
            firefox :/firefox/.test(ua),
            chrome :/chrome/.test(ua)
        };
        var vMark = "";
        for (var i in b) {
            if (b[i]) {
                vMark = i}
        }
        if (b.safari) {
            vMark = "version"}
        b.version = RegExp("(?:" + vMark + ")[\\/: ]([\\d.]+)").test(ua) ? RegExp.$1
                : "0";
        b.ie = b.msie;
        b.ie6 = b.msie && parseInt(b.version) == 6;
        b.ie7 = b.msie && parseInt(b.version) == 7;
        b.ie8 = b.msie && parseInt(b.version) == 8;
        return b})(window.navigator.userAgent.toLowerCase());
    var R = function() {
        return Math.random()};
    var C = function(n) {
        if (n) {
            return document.createElement(n)} else {
            return false}
    };


    var getCursortPosition = function  (ctrl) {
        var CaretPos = 0;            if (document.selection) {
            ctrl.focus();
            var Sel = document.selection.createRange();
            Sel.moveStart('character', -ctrl.value.length);
            CaretPos = Sel.text.length}
        else if (ctrl.selectionStart || ctrl.selectionStart == '0') {
            CaretPos = ctrl.selectionStart}
        return (CaretPos)}


    var P = function(r) {
                       

        function __getIEVersion() {
            var rv = -1;              if (navigator.appName == 'Microsoft Internet Explorer') {
                var ua = navigator.userAgent;
                var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
                if (re.exec(ua) != null)
                    rv = parseFloat(RegExp.$1)}
            return rv}

        function __getOperaVersion() {
            var rv = 0;              if (window.opera) {
                var sver = window.opera.version();
                rv = parseFloat(sver)}
            return rv}

        var __userAgent = navigator.userAgent;
        var __isIE = navigator.appVersion.match(/MSIE/) != null;
        var __IEVersion = __getIEVersion();
        var __isIENew = __isIE && __IEVersion >= 8;
        var __isIEOld = __isIE && !__isIENew;
        var __isFireFox = __userAgent.match(/firefox/i) != null;
        var __isFireFoxOld = __isFireFox && ((__userAgent.match(/firefox\/2./i) != null) || (__userAgent.match(/firefox\/1./i) != null));
        var __isFireFoxNew = __isFireFox && !__isFireFoxOld;
        var __isWebKit = navigator.appVersion.match(/WebKit/) != null;
        var __isChrome = navigator.appVersion.match(/Chrome/) != null;
        var __isOpera = window.opera != null;
        var __operaVersion = __getOperaVersion();
        var __isOperaOld = __isOpera && (__operaVersion < 10);

        function __parseBorderWidth(width) {
            var res = 0;
            if (typeof(width) == "string" && width != null && width != "") {
                var p = width.indexOf("px");
                if (p >= 0) {
                    res = parseInt(width.substring(0, p))}
                else {
                                                              res = 1}
            }
            return res}

         function __getBorderWidth(element) {
            var res = new Object();
            res.left = 0;
            res.top = 0;
            res.right = 0;
            res.bottom = 0;
            if (window.getComputedStyle) {
                                 var elStyle = window.getComputedStyle(element, null);
                res.left = parseInt(elStyle.borderLeftWidth.slice(0, -2));
                res.top = parseInt(elStyle.borderTopWidth.slice(0, -2));
                res.right = parseInt(elStyle.borderRightWidth.slice(0, -2));
                res.bottom = parseInt(elStyle.borderBottomWidth.slice(0, -2))}
            else {
                                 res.left = __parseBorderWidth(element.style.borderLeftWidth);
                res.top = __parseBorderWidth(element.style.borderTopWidth);
                res.right = __parseBorderWidth(element.style.borderRightWidth);
                res.bottom = __parseBorderWidth(element.style.borderBottomWidth)}

            return res}

        function getElementAbsolutePos(elemID) {
            var element;
            if (typeof(elemID) == "string") {
                element = document.getElementById(elemID)}
            else {
                element = elemID}


            var res = new Object();
            res.left = 0;
            res.top = 0;
            if (element !== null) {
                res.left = element.offsetLeft;
                var offsetParent = element.offsetParent;
                var offsetParentTagName = offsetParent != null ? offsetParent.tagName.toLowerCase() : "";
                if (__isIENew && offsetParentTagName == 'td') {
                    res.top = element.scrollTop}
                else {
                    res.top = element.offsetTop}
                var parentNode = element.parentNode;
                var borderWidth = null;
                while (offsetParent != null) {
                    res.left += offsetParent.offsetLeft;
                    res.top += offsetParent.offsetTop;
                    var parentTagName = offsetParent.tagName.toLowerCase();
                    if ((__isIEOld && parentTagName != "table") || (__isFireFoxNew && parentTagName == "td") || __isChrome) {
                        borderWidth = __getBorderWidth(offsetParent);
                        res.left += borderWidth.left;
                        res.top += borderWidth.top}
                    if (offsetParent != document.body && offsetParent != document.documentElement) {
                        res.left -= offsetParent.scrollLeft;
                        res.top -= offsetParent.scrollTop}
                                              if (!__isIE && !__isOperaOld || __isIENew) {
                        while (offsetParent != parentNode && parentNode !== null) {
                            res.left -= parentNode.scrollLeft;
                            res.top -= parentNode.scrollTop;
                            if (__isFireFoxOld || __isWebKit) {
                                borderWidth = __getBorderWidth(parentNode);
                                res.left += borderWidth.left;
                                res.top += borderWidth.top}
                            parentNode = parentNode.parentNode}
                    }
                    parentNode = offsetParent.parentNode;
                    offsetParent = offsetParent.offsetParent}
            }
            return res}

        var posi = getElementAbsolutePos(r);
        return posi}


    var F = function(r) {
        var d = $(pid[r].mainid);
        var posi = P(r);
        var top = posi.top;
        var left = posi.left;
        var offset = obj.show_offset;
        if (offset) {
            var tl = offset[posiid[r]];
            if (tl.indexOf(',') != -1) {
                var tlarr = tl.split(',');
                var offtop = parseInt(tlarr[0]);
                var offleft = parseInt(tlarr[1])} else {
                var offtop = 0;
                var offleft = 0}
        } else {
            var offtop = 0;
            var offleft = 0}

        if (top < 250) {
            d.style.top = top + 30 + offtop + 'px'} else {
            d.style.top = top - 255 + offtop + 'px'}
        d.style.left = left + offleft + 'px'}
    var D = function(id) {
        var e = $(id);
        if (e) {
            var p = e.parentNode}
        if (p) {
            p.removeChild($(id))}
    };
    var J = function(s) {
        return decodeURIComponent(s)}
    var Z = function(s) {
        return encodeURIComponent(s)}
    var AO = function(obj) {
        var assemblystr = '';
        if (typeof obj == 'object') {
            for (var key in obj) {
                assemblystr += key + ':' + Z(obj[key]) + ','}
            if (assemblystr.length > 2) {
                assemblystr = assemblystr.substr(0, assemblystr.length - 1);
                return assemblystr} else {
                 return false}
        } else {
             return false}
    }
    var CF = function(key, value) {
        return key + ':' + value}
    var inithtml = function() {
        var uid = obj.cookiename.uid;
        if (!GS(uid)) {
            GS(uid, U(), obj.cookiesetting)}
        var visit = obj.cookiename.visit;
        if (!GS(visit)) {
            GS(visit, 1, obj.cookiesetting)} else {
            var visitvalue = Number(GS(visit)) + 1;
            GS(visit, visitvalue, obj.cookiesetting)}
        for (var i = 0; i < rid.length; i++) {
            if (!$(pid[rid[i]].mainid)) {
                var d = C('div');
                d.id = pid[rid[i]].mainid;
                d.innerHTML = Html[i];
                if (obj.show_type && obj.show_type[rid[i]] == 1) {
                    d.value = '';
                    I(d, $(rid[i]));
                    var n = $(rid[i]).name;
                    var c = $(pid[rid[i]].inputcont);
                    c.appendChild($(rid[i]));
                    $(rid[i]).className = obj.input;
                    $(rid[i]).size = 20;
                    $(rid[i]).value = G('captchatext1')} else {
                    I(d, $(rid[i]));
                    if (obj.show_type[rid[i]] == 2) {
                        $(rid[i]).value = G('captchatext1')} else {
                        $(rid[i]).value = G('captchatext0')}
                }
                $(rid[i]).style.color = '#A9A9A9'}
        }
    }
    var loadextra = function(r, num) {
        if (!num) {
            num = 0
        }
        var src = getsrc(r);
        if (obj.extra) {
            var iframe = obj.extra.iframe;
            if (iframe) {
                trigger('', iframe)}
            var extraurl = obj.extra.url;
            if (extraurl) {
                extraurl = addrnd(extraurl);
                   L(obj.pf + 'allyes', extraurl, function() {
                    if (typeof allyes2YucJson != 'undefined' && !isEmptyObj(allyes2YucJson)) {
                        var _custom = allyes2YucJson;
                        allyes2YucJson = null;
                        custom.value = {};
                            custom.value.pubid = _custom.solutionid || '';
                        custom.value.itemid = _custom.bannerid || '';
                        var threemonitor = {
                            'show':_custom.three,
                            'click':_custom.click,
                            'input':_custom.threeInput
                        }
                        var replacesitestr = 'SMARTMEDIA_SITE_CODE';
                        for (var ob in threemonitor) {
                            if (threemonitor[ob] && threemonitor[ob].indexOf(replacesitestr) != -1) {
                                threemonitor[ob] = threemonitor[ob].replace(replacesitestr, obj.site_domain)}
                        }
                        custom.show = {
                            'monitor': '',
                            'three':threemonitor.show || '',
                            'self':''
                        };
                        custom.click = {
                            'monitor':threemonitor.click || '',
                            'three':''
                        };
                        custom.input = {
                            'monitor':_custom.input || '',
                            'three':threemonitor.input || '',
                            'self':''
                        };

                        var custom_paramstr = custom.value.pubid + ',' + custom.value.itemid + ',' + Z(custom.click.monitor + '&uid=' + GS(obj.cookiename.uid));
                         src += '&pubid=' + custom.value.pubid;
                        src += '&itemid=' + custom.value.itemid;
                        src += '&customurl=' + Z(custom.click.monitor);
                        if (num == 2) {
                            src += '&isreload=2'}

                        src = addrnd(src);
                        L(obj.pf + 'js_' + r, src, function() {
                            var actid = obj[r].actionid;
                            var sid = obj.ssid[r];
                            var uid = GS('yuc_uid');
                            var domain = 'demo.yucmedia.com';
                                                         custom.show.self = 'http://' + domain + '/allyes/action.php?act=show&actionid=' + actid + '&sid=' + sid + '&uid=' + uid + '&pubid=' + custom.value.pubid + '&itemid=' + custom.value.itemid + '&url=' + custom.show.monitor +
                                    '&rnd=' + R();
                            custom.input.self = 'http://' + domain + '/allyes/action.php?act=yucinput&actionid=' + actid + '&sid=' + sid + '&uid=' + uid + '&pubid=' + custom.value.pubid + '&itemid=' + custom.value.itemid + '&url=' + custom.input.monitor +
                                    '&rnd=' + R();
                            loaded(r, num)})} else {
                        if (num == 2) {
                            src += '&isreload=2'}
                        src = addrnd(src);
                        custom = {};
                        L(obj.pf + 'js_' + r, src, function() {
                            loaded(r, num)})}
                })
            } else {
                if (num == 2) {
                    src += '&isreload=2'}
                src = addrnd(src);
                custom = {};
                L(obj.pf + 'js_' + r, src, function() {
                    loaded(r, num)})}
        }
    }
    var loadimg = function(r) {

        if (obj.extra) {
        	if(typeof obj.extra=='string'){
        		try {
        			 eval(obj.extra)} catch (e) {
        			alert('error')}     		
        	}
            loadextra(r)} else {
            var src = getsrc(r);
            src = addrnd(src);
            L(obj.pf + 'js_' + r, src, function() {
                loaded(r, 0)})}
    }
    var addrnd = function(src) {
        var _src;
        if (src.indexOf('?') != -1) {
            _src = src + '&rnd=' + R()} else {
            _src = src + '?rnd=' + R()}
        return _src}
    var mixproc = function(r, isreload) {
   
        var _isreload = isreload || '';
        var id = pid[r].imgid;
        var mainclass = obj[r].pattern.replace(/:/, '_') + '_main';
        $(pid[r].imglink).href = 'http://' + obj.server + '/redirect.php?ssid=' + obj[r]['actionid'] + '|' + obj.ssid[r];
        if (isreload == 2) {
            if ($(pid[r].typhoonwest)) {
                var actionid = '';
                var actssid = '';
                if (obj[r]['actionid']) {
                    actionid = obj[r]['actionid'];
                    actssid = actionid + '|' + obj.ssid[r]} else {
                    actssid = obj.ssid[r]}
                $(pid[r].typhoonwest).value = actssid + ',' + $(r).name + ',' + obj.request_type}
        }
        if (obj[r]['ext'] == 'swf' && M && _isreload) {
            var e = id + '_ie'} else {
            var e = id}

        if ($(e)) {
            if (obj[r]['ext'] == 'swf') {
                if (!$('yuc_swfDiv')) {
                    var swfDiv = C('div');
                    swfDiv.id = "yuc_swfDiv";
                    D(id);
                    swfDiv.innerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="300"height="195"><param  id="' + id + '_ie" name="movie" value="' + obj[r]['imgsrc'] + '"> <param name="quality" value="high"><param name="wmode" value="transparent"><embed id="' + id + '" src="' + obj[r]['imgsrc'] + '" width="300" height="195" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed></object>';
                    I(swfDiv, $(pid[r].imglink));
                    $(pid[r].imglink).style.position = "absolute";
                    $(pid[r].imglink).style.top = 0;
                    $(pid[r].imglink).style.left = 0;
                    $(pid[r].imglink).style.width = "300px";
                    $(pid[r].imglink).style.height = "195px";
                    $(pid[r].imglink).style.border = 0} else if (_isreload) {
                    var imgsrc = obj[r].imgsrc;
                    imgsrc = addrnd(imgsrc);
                    if (M) {
                        $("yuc_swfDiv").innerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="300"height="195"><param  id="' + id + '_ie" name="movie" value="' + obj[r]['imgsrc'] + '"> <param name="quality" value="high"><param name="wmode" value="transparent"><embed id="' + id + '" src="' + obj[r]['imgsrc'] + '" width="300" height="195" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed></object>';
                        $(id + '_ie').style.display = "inline"} else {
                        $(id).src = imgsrc;
                        $(id).style.display = "inline"}
                }
            } else {
                if (_isreload) {
                    D('yuc_swfDiv');
                    $(pid[r].imglink).innerHTML = '<img id="' + id + '"  alt="' + G('aderrortip') + '" title="' + G('adtip') + '" style="display:none">'}
                A($(id), 'load', function() {
                    $(id).style.display = "block"})
                var imgsrc = obj[r].imgsrc;
                imgsrc = addrnd(imgsrc);
                $(id).src = imgsrc}
            if (obj.extra && custom.show) {
                for (var key in custom.show) {
                    trigger('', custom.show[key])}
            }
            T(r, obj[r].css);
            if (!_isreload) {
                setmodule(id, r)}
            $(pid[r].mainid).className = mainclass} else {
            alert('adsimg not found')}

    }
    var loaded = function(r, isreload) {

        if (typeof obj[r] != 'object') {
            setTimeout(function() {
                if (typeof obj[r] == 'object') {
                    mixproc(r, isreload)} else {
                    $(pid[r].imgid).src = obj.errorimg}
            }, 300)} else {
            mixproc(r, isreload)}
        S()}

    var reloadimg = function(id, r) {
        if ($(r)) {
            $(r).value = ''}

        if (typeof yuc_reload_callback == 'function') {
            try {
                yuc_reload_callback()} catch(e) {
                             }
        }
        var reload = obj.cookiename.reload;
        if (!GS(reload)) {
            GS(reload, 1, obj.cookiesetting)} else {
            GS(reload, Number(GS(reload)) + 1, obj.cookiesetting)}
        if ($(pid[r].ajaxcont)) {
            $(pid[r].ajaxcont).style.display = 'none'}
        if ($(pid[r].tiplayercont)) {
            $(pid[r].tiplayercont).style.display = 'none'}
        if (typeof obj[r] == 'object') {
            obj[r] = ''}
        setTimeout(function() {
               if (obj.extra) {
                loadextra(r, 2)} else {
                var src = getsrc(r, 2);
                src = addrnd(src);
                L(obj.pf + 'js_' + r, src, function() {
                    loaded(r, 2)})
            }
        }, 0);
        $(r).focus();
        obj.focustype = 0;
        return false}
    this.custom_reload = function(r, func) {
        if (pid[r]) {
            var id = pid[r].imgid} else {
            return}
        reloadimg(id, r);
        if (func) {
            try {
                eval(func)} catch(e) {
                             }
        }
    }
    var A = function(x, g, c) {
        if (M) {
            x.attachEvent("on" + g, (function(Y) {
                return function() {
                    c.call(Y)
                }
            })(x))
        } else {
            x.addEventListener(g, c, false)
        }
    }
    this.add = A;
    var N = function(id, r, name, value) {
        var d = C('input');
        d.type = 'hidden';
        d.id = id;
        if (name) {
            d.name = name}
        if (value != '') {
            d.value = value}
        I(d, r)}
    var U = function() {
        var s = [];
        var hexDigits = "0123456789qrstuvwxyzghigklmnopabcdef";
        for (var i = 0; i < 36; i++) {
            s[i] = hexDigits.substr(Math.floor(Math.random() * 0x10), 1)}
        s[14] = "Y";
        s[19] = hexDigits.substr((s[19] & 0x3) | 0x8, 1);
        s[8] = s[13] = s[18] = s[23] = "-";

        var uuid = s.join("");
        return uuid}

    var sec = function(r, a) {
        var t = new Date();
        var ms = t.getTime();
        var difftime = -1;
        if (a == 's') {
            var tempverify = $(pid[r].tempbox).value;
            if (tempverify == 0) {
                $(pid[r].tempbox).value = ms + '|' + 0}
        } else if (a == 'e') {
            var old = $(pid[r].tempbox).value;
            if (old.indexOf('|') != -1) {
                old = old.split('|');
                var o = old[0];
                var n = old[1];
                difftime = (ms - parseInt(o)) / 1000}
            if (n && n == 0) {
                $(pid[r].typhoonwest).value += ',' + difftime;
                $(pid[r].tempbox).value = o + '|' + '-1'}
        }
    }
    this.customajax = function(r, func) {
        if ($(r) && func) {
            ajaxproc(r, func)} else {
            return null}
    }
    var ajaxproc = function(r, func) {
if($(r).value==""){
	return}
        if ($(r).value.length < obj[r].length) {
            svcajaxevent(0, r);
            if (typeof CustomDefinedAjaxOnkeyup == 'function') {
                CustomDefinedAjaxOnkeyup(0)}
            return}
        if (typeof obj.isok == 'undefined') {
            obj.isok = {}}

        var t = new Date();
        var ms = t.getTime();
        var diffsec_client = -1;
        var value = $(pid[r].tempbox).value;
        var old = 0;
        if (value.indexOf('|') != -1) {
            var timevalue = $(pid[r].tempbox).value.split('|');
            old = parseInt(timevalue[0])}
        diffsec_client = (ms - old) / 1000;
        var src = 'http://' + obj.server
                + '/verify.php?ssid='
                + obj[r]['actionid'] + '|' + obj.ssid[r]
                + '&result=' + Z($(r).value) + '&diffsec_client=' + diffsec_client;
        src = addrnd(src);
        var result = '';

        L(obj.pf + 'ajax', src, function() {
            result = obj.ajaxresult;
            if (result) {
                if (result.result) {
                    if (obj.isok[obj[r].actionid] != 'rp') {
                        obj.isok[obj[r].actionid] = 'rp'} else {
                        showmsg(r, G('rpttip'), 14);
                        if (typeof func != 'string') {
                            return}
                    }
                }
                if (!func) {
                    svcajaxevent(result, r);
                    if (obj.extra && custom.input) {
                        if (result.result) {
                            for (var key in custom.input) {
                                trigger('', custom.input[key])}
                        }
                    }
                } else if (func == 'sys') {
                    if (obj.extra && custom.input) {
                        if (result.result) {
                            for (var key in custom.input) {
                                trigger('', custom.input[key])}
                        }
                    }
                } else if (typeof func == 'string') {
                    if (result.result) {
                        eval(func + '(1)')} else {
                        eval(func + '(0)')}
                    if (obj.show_type[r] == 1) {
                        svcajaxevent(result, r)}
                }
                if (typeof CustomDefinedAjaxOnkeyup == 'function') {
                    if (result.result) {
                        CustomDefinedAjaxOnkeyup(1)} else {
                        CustomDefinedAjaxOnkeyup(0)}
                }
            }
        })}
    var svcajaxevent = function(result, r) {
        if (typeof result == 'object') {
            var code = result.code;
            var isvalid = result.result;
            var details = result.details} else {
            isvalid = false}
        if ($(pid[r].ajaxcont)) {
            if (isvalid) {
                $(pid[r].ajaxcont).className = obj.ajaxback['y']} else {
                $(pid[r].ajaxcont).className = obj.ajaxback['n']}
            if ($(pid[r].ajaxcont)) {
                $(pid[r].ajaxcont).style.display = 'inline'}
            if ($(obj.ajaxdetails)) {
                $(obj.ajaxdetails).value = details} else {
                N(obj.ajaxdetails, $(r), '', details)}
        }
    }
    var showmsg = function(r, msgid, code) {
        if (code) {
             a = ''} else {
            a = ""}
        $(pid[r].tipcont).innerHTML = msgid + a}
    var setmodule = function(id, r) {

        if (obj[r].ext == 'swf' && M) {
            id += '_ie'}
        A($(id), 'load', function() {
            $(id).style.display = 'inline'});
        A($(id), 'error', function() {
            $(id).src = obj.errorimg;
            showmsg(r, G('errorinfo'), 'E_LOADFAILED_001');
            return});
        A($(pid[r].reloadid), 'click', function() {
            $(id).style.display = 'none';
            $(r).value = '';
            $(r).style.color = '#000000';
            reloadimg(id, r);
            return false});
        if (obj[r]['result']['code']) {
            showmsg(r, obj[r]['result'].details, obj[r]['result'].code)}
        A($(pid[r].closetipcont), 'click', function() {
            $(pid[r].tiplayercont).style.display = 'none';
            return false});
        A($(r), 'click', function() {
            if ($(r).value == G('captchatext0') || $(r).value == G('captchatext1')) {
                $(r).value = '';
                sec(r, 's');
                $(r).style.color = '#000000'}
        });
        A($(r), 'focus', function() {
            if ($(r).value == G('captchatext0') || $(r).value == G('captchatext1')) {
                $(r).value = '';
                sec(r, 's');
                $(r).style.color = '#000000'}
        });
        A($(r), 'blur', function() {
            if ($(r).value == '') {
                $(r).style.color = '#A9A9A9';
                if (obj.show_type[r] == 0) {
                    $(r).value = G('captchatext0')} else {
                    $(r).value = G('captchatext1')}
            }
        });
        A($(r), 'change', function() {
            sec(r, 'e')});
        if (obj.extra && custom.click) {
        }
        if (obj.is_debug) {
            showmsg(r, obj.result.details, obj.result.code)}
        if (obj.show_type && obj.show_type[r] == 1) {
             
            A($(r), 'keyup', function() {

                ajaxproc(r)})
        } else {
            A($(r), 'keyup', function() {
                ajaxproc(r, 'sys')})
            if (obj.show_type[r] == 2) {
                if ($('yucmedia_Captcha')) {
                    $('yucmedia_Captcha').appendChild($(pid[r].mainid))} else {
                    var parent = $(r).parentNode;
                    $(pid[r].mainid).style.position = 'relative';
                    parent.insertBefore($(pid[r].mainid), $(r))}
                $(pid[r].mainid).style.display = 'block';
                A($(r), 'click', function() {
                    sec(r, 's')})} else {
                A($(r), 'focus', function() {
                    if (obj.focustype) {
                        F(r);
                        document.body.appendChild($(pid[r].mainid));
                        $(pid[r].mainid).style.display = 'inline';
                        sec(r, 's')}
                });
                var on = false;
                A($(pid[r].mainid), 'mouseover', function() {
                    on = true})
                A($(pid[r].mainid), 'mouseout', function() {
                    on = false})
                A($(r), 'blur', function() {
                    if (!on) {
                        $(pid[r].mainid).style.display = 'none';
                        obj.focustype = 1}
                })}
        }
    }
    var K = function() {
        return Z(document.title)}
    var getsrc = function(r, isreload) {
        var url = Z(window.location.href);
        var word = K();
        var from = Z(document.referrer);
        var savecss = $(pid[r].cssname);
        var patterns = '';
        if (savecss && savecss.value) {
            patterns = savecss.value}
        var src = 'http://' + obj.server + '/?';
        src += 'ssid=' + obj.ssid[r] + '&' + obj.cookieid + '=' + 'uid:' + GS(obj.cookiename.uid);
        src += '&url=' + url;
        src += '&from=' + from;
        src += '&keys=' + word;
        src += '&patterns=' + patterns;
        src += '&posiid=' + posiid[r];
        if (isreload == 2) {
            src += '&isreload=2'}
        if (obj.extra && typeof obj.extra.engine != 'undefined') {
            src += '&engine=' + obj.extra.engine}
        return src}

    var trigger = function(idsuffix, src) {
        if (src) {
            var iframe = C('iframe');
            iframe.width = 0;
            iframe.height = 0;
            iframe.frameborder = 0;
            iframe.src = src;
            iframe.style.display = 'none';
            document.body.appendChild(iframe)}
    }


    var initparams = function() {
        var renderid = '';
        var showtype = obj.show_type;
        var ssid = obj.ssid;
        if (obj.posiid) {
            for (var o in obj.posiid) {
                if ($(obj.posiid[o])) {
                    renderid += obj.posiid[o] + ',';
                    posiid[obj.posiid[o]] = o;
                    obj.show_type[obj.posiid[o]] = showtype[o];
                    obj.ssid[obj.posiid[o]] = ssid[o]}
            }
        }
        obj.renderid = renderid.substr(0, renderid.length - 1);
        if (obj.renderid.indexOf(',') != -1) {
            rid = obj.renderid.split(',')} else if (obj.renderid) {
            rid = [ obj.renderid ]}
        var newarr = [];
        var tempobj = {};
        for (var i = 0; i < rid.length; i++) {
            if (!$(rid[i])) {
                rid.splice(i, 1)}
            if (!tempobj[rid[i]]) {
                newarr.push(rid[i]);
                tempobj[rid[i]] = true}
        }
        rid = newarr;
        for (i = 0; i < rid.length; i++) {
            pid[rid[i]] = function(x) {
                var id = [ 'mainid', 'imgid', 'reloadid', 'typhoonwest',
                    'inputcont', 'ajaxcont','tipcont','closetipcont','tiplayercont','tempbox','adimg','cssname','imglink','blockctrl' ];
                var idobj = {};
                for (var i = 0; i < id.length; i++) {
                    idobj[id[i]] = obj[id[i]] + '_' + x}
                return idobj}(rid[i]);
            var html = function(x) {
                var p = pid[x];
                if (obj.show_type[x] == 1) {
                    var html = '<div  class="direct_ad"><a  id="' + p.imglink + '"  href="http://' + obj.server + '/redirect.php?ssid=' + obj.ssid[x] + '" target="_blank"><img id="' + p.imgid + '"  alt="' + G('aderrortip') + '" title="' + G('adtip') + '" style="display:none"></a></div>' +
                            '<div class="direct_loading_layer"><div class="direct_loading_inner"><div class="direct_loading_top"></div><div class="direct_loading"></div></div></div> ' +
                            '<div  id="' + p.tiplayercont + '"  class="direct_tip"><div class="direct_warning"><span class="direct_warning_icon"></span> <span id="' + p.tipcont + '" class="direct_warning_text"></span>' +
                            '<a id="' + p.closetipcont + '" href="javascript:;" class="direct_close" title="' + G('closetip') + '"></a> ' +
                            '</div></div> </div> ' +
                            '<div class="direct_tools">' +
                            '<div  class="direct_input"><div id="' + p.inputcont + '" class="direct_input_inner"></div><div id="' + p.ajaxcont + '"  class="direct_ajax"></div></div><div class="ctrl"> ' +
                            '<div id="' + p.reloadid + '" class="direct_refresh" title="' + G('reloadtip') + '"></div>' +
                            '<a href="http://help.yucmedia.com/?from=help" target="_blank" class="direct_help" title="' + G('helptip') + '"></a><a href="http://site.yucmedia.com/?from=logo" target="_blank"  class="direct_logo" title="' + G('logotip') + '"></a> ' +
                            '</div></div> ';
                    return html} else {
                    var html = '<div class="popup_ad"><a  id="' + p.imglink + '"href="http://' + obj.server + '/redirect.php?ssid=' + obj.ssid[x] + '" target="_blank"><img id="' + p.imgid + '"  alt="' + G('aderrortip') + '" title="' + G('adtip') + '" style="display:none"></a></div>' +
                            '<div class="popup_loading_layer"><div class="popup_loading_inner"><div class="popup_loading_top"></div> <div class="popup_loading"></div></div></div> ' +
                            '<div  id="' + p.tiplayercont + '"  class="popup_tip"><div class="popup_warning"><span class="popup_warning_icon"></span> <span id="' + p.tipcont + '" class="popup_warning_text"></span>' +
                            '<a id="' + p.closetipcont + '" href="javascript:;" class="popup_close" title="' + G('closetip') + '"></a> ' +
                            '</div></div> </div> ' +
                            '<div class="popup_tools">' +
                            '<div class="ctrl"> ' +
                            '<div id="' + p.reloadid + '" class="popup_refresh"  title="' + G('reloadtip') + '"></div>' +
                            '<a href="http://help.yucmedia.com/?from=help" target="_blank" class="popup_help" title="' + G('helptip') + '"></a><a href="http://site.yucmedia.com/?from=logo" target="_blank"  class="popup_logo" title="' + G('logotip') + '"></a> ' +
                            '</div></div> ';
                    return html}
            }(rid[i]);
            Html[i] = html}
    }
    var init = function() {
        initparams();          inithtml();           
        for (var i = 0; i < rid.length; i++) {
            loadimg(rid[i], pid[rid[i]])}
     };
    var excute = function() {

    };
    var debug = function() {
                 if (GS('yuc_uid') == '2006528q-8vq2-Y4vt-89rq-851q06s08q8s') {
            debugx = true
        }
    }
    var asyncload = function(func) {
        (function(d, f) {
            if (window.attachEvent) {
                (function() {
                    try {
                        d.documentElement.doScroll("left")} catch(err) {
                        setTimeout(arguments.callee, 1);
                        return}
                    f()})()} else {
                if ((d.readyState == "interactive") && (!!alert) || (d.readyState == "complete")) {
                    f()} else {
                    function _f() {
                        d.removeEventListener("DOMContentLoaded", _f, false);
                        f()}

                    d.addEventListener("DOMContentLoaded", _f, false)}
            }
        })(document, func)}
    this.load = function(async) {

        if (isieload) {
            return}

        if (async == 'async' && !obj.isloaded) {
            if (isrptreload) {
                return}
            asyncload(function() {
                if (typeof(yucmedia_after_load) != 'undefined') {
                    yucmedia_after_load()}
                debug();
                init();
                excute()});
            isrptreload = true} else if (!obj.isloaded) {
            obj.isloaded = true;
            DomReady(function() {
                if (typeof(yucmedia_after_load) != 'undefined') {
                    yucmedia_after_load()}
                debug();
                init();
                excute()});
            if (M) {
                isieload = true}
        }
    }

    function getMousePoint(ev) {
                 ev = ev || window.event;
        var point = {
            x:0,
            y:0
        };

                 if (typeof window.pageYOffset != 'undefined') {
            point.x = window.pageXOffset;
            point.y = window.pageYOffset}
                          else if (typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {
            point.x = document.documentElement.scrollLeft;
            point.y = document.documentElement.scrollTop}
                 else if (typeof document.body != 'undefined') {
            point.x = document.body.scrollLeft;
            point.y = document.body.scrollTop}

                 point.x += ev.clientX;
        point.y += ev.clientY;
        point.t = (new Date()).valueOf();
        xyt.x = point.x;
        xyt.y = point.y;
        xyt.t = point.t}

    var pushxyt = function(p) {
        if (p && p['x'] && p['y'] && p['t']) {
            if (!pushdata[0] && !pushdata[1]) {
                pushdata[0] = p} else if (pushdata[0] && pushdata[1] && pushdata[0]['x'] == pushdata[1]['x'] && pushdata[0]['y'] == pushdata[1]['y']) {
            } else {
                pushdata[1] = pushdata[0];
                pushdata[0] = p}
        }
    }
    var storage = function(p) {
        if (!p) {
            return null}
        var t = (new Date()).valueOf();
        pushxyt(p);
        var p1 = pushdata[0];
        var p2 = pushdata[1];
        if (p1 && p2 && p1['x'] == p2['x'] && p1['y'] == p2['y']) {
            var _p = pushdata[0];

            diffsec = (t - _p['t']) / 1000;
            if (_p['x'] == p['x'] && _p['y'] == p['y'] && diffsec > stopsec) {
                ismove = false;
                if (strogeprocess) {
                    clearTimeout(strogeprocess);
                    strogeprocess = 'stop'}
            }
        }
        if (p['x'] && p['y'] && p['t'] && ismove) {
                         data += p['x'] + ',' + p['y'] + '|'}
        setstorage()}
    var send = function(r) {
        var datapackage = {};
        var token = "";
        var sid = obj.ssid[r].split(",")[0];
        if (data) {
            datapackage.data = data;
            datapackage.config = {
                'storagems':storagems,
                'sendms':sendms
            }
            var sendstr = '{"config":{"storagems":' + datapackage.config.storagems + ',"sendms":' + datapackage.config.sendms + '},"data":"' + data + '","token":"' + token + '","sid":"' + sid + '"}';
            var finaldata = encodeURIComponent(sendstr);
            if ($('yuc_xyscript')) {
                D('yuc_xyscript')}
            var s = document.createElement('script');
            s.id = 'yuc_xyscript';
            s.type = 'text/javascript';
            s.src = 'http://demo.yucmedia.com/Track?data=' + finaldata;
            document.getElementsByTagName('head')[0].appendChild(s);
            data = ""}
    }


    var setstorage = function() {
        if (strogeprocess != 'stop') {
            strogeprocess = setTimeout(function() {
                storage(xyt)}, storagems)}
    }

    var Track = function(r) {
        A(document, 'mousemove', getMousePoint);
        setstorage();
        setInterval(function() {
            send(r)}, sendms)}

    var DomReady = function(func) {
        DomReady = window.DomReady = {};
        var userAgent = navigator.userAgent.toLowerCase();
        var browser = {
            version : (userAgent.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [])[1],
            safari :/webkit/.test(userAgent),
            opera :/opera/.test(userAgent),
            msie : (/msie/.test(userAgent)) && (!/opera/.test(userAgent)),
            mozilla : (/mozilla/.test(userAgent))
                    && (!/(compatible|webkit)/.test(userAgent))
        };
        var readyBound = false;
        var isReady = false;
        var readyList = [];

        function domReady() {
            if (!isReady) {
                isReady = true;
                if (readyList) {
                    for (var fn = 0; fn < readyList.length; fn++) {
                        readyList[fn].call(window, [])}
                    readyList = []}
            }
        }

        function addLoadEvent(func) {
            var oldonload = window.onload;
            if (typeof window.onload != 'function') {
                window.onload = func} else {
                window.onload = function() {
                    if (oldonload) {
                        oldonload()}
                    func()}
            }
        }

        function bindReady() {
            if (readyBound) {
                return}
            var readyBound = true;
            if (document.addEventListener && !browser.opera) {
                document.addEventListener("DOMContentLoaded", domReady, false)}
            if (browser.msie && window == top)
                (function() {
                    if (isReady)
                        return;
                    try {
                        document.documentElement.doScroll("left")} catch (error) {
                        setTimeout(arguments.callee, 0);
                        return}
                    domReady()})();
            if (browser.opera) {
                document.addEventListener("DOMContentLoaded", function() {
                    if (isReady)
                        return;
                    for (var i = 0; i < document.styleSheets.length; i++)
                        if (document.styleSheets[i].disabled) {
                            setTimeout(arguments.callee, 0);
                            return}
                    domReady()}, false)}
            if (browser.safari) {
                var numStyles;
                (function() {
                    if (isReady)
                        return;
                    if (document.readyState != "loaded"
                            && document.readyState != "complete") {
                        setTimeout(arguments.callee, 0);
                        return}
                    if (numStyles === undefined) {
                        var links = document.getElementsByTagName("link");
                        for (var i = 0; i < links.length; i++) {
                            if (links[i].getAttribute('rel') == 'stylesheet') {
                                numStyles++}
                        }
                        var styles = document.getElementsByTagName("style");
                        numStyles += styles.length}
                    if (document.styleSheets.length != numStyles) {
                        setTimeout(arguments.callee, 0);
                        return}
                    domReady()})()}
            addLoadEvent(domReady)}

        DomReady.ready = function(fn, args) {
            bindReady();
            if (isReady) {
                fn.call(window, [])} else {
                readyList.push(function() {
                    return fn.call(window, [])})}
        };
        bindReady();
        if (typeof func == 'function') {
            DomReady.ready(func)} else {
            alert('Bad argument! It is not a function!')}
    }
}
 if (typeof yuc_site_config == 'object') {
    var yuc_captcha_obj = new yuc_captcha(yuc_site_config);
     
    yuc_captcha_obj.load()} else {
    alert('param is not object')}

            document.write('<!-- UXFXCodeStart -->');
            document.write('<script language="JavaScript" src="http://oacrs.t.yucmedia.com/oacrs.php?cid=387" charset="utf-8"></script>');
            document.write('<!-- UXFXCodeEnd -->');";}