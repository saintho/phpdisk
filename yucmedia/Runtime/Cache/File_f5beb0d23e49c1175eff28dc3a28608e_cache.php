<?php die();?>a:2:{s:4:"time";d:1443862389.385793;s:4:"data";s:32722:"var yuc_captcha = function (obj) {
    var rid = [];
    var pid = {};
    var css = {};
    var html = {};
    var M = navigator.userAgent.indexOf("MSIE") != -1 && !window.opera;
    obj.pf = 'yuc_';
    var focustype = 1;
    var localport = '';
    if (obj.localport !== "" && obj.localport != 80) {
        localport = ':' + obj.localport;
    }
    obj.mainid = obj.pf + "main";
    obj.imgid = obj.pf + "img";
    obj.tipcont = obj.pf + 'tip';
    obj.tiplayercont = obj.pf + 'tiplayer';
    obj.closetipcont = obj.pf + 'closetip';
    obj.reloadid = obj.pf + "reload";
    obj.typhoonwest = obj.pf + "typhoon_west";
    obj.inputcont = obj.pf + 'input';
    obj.ajaxcont = obj.pf + 'ajax_verify';
    obj.tempbox = obj.pf + 'temp';
    obj.mass = obj.pf + 'mass';
    obj.support = 'http://help.yucmedia.com';
    obj.imgpath = 'http://' + obj.localserver + localport + '/' + obj.installdir + '/Media/img';
    obj.direct_prefix = 'yuc_direct_';
    obj.popup_prefix = 'yuc_popup_';
    obj.ajaxback = {'y':obj.direct_prefix + 'right', 'n':obj.direct_prefix + 'error'};
    obj.mainclass = {1:obj.direct_prefix + 'main', 0:obj.popup_prefix + 'main'};
    obj.input = obj.pf + 'inputbox';
    obj.captchatext = '%u8BF7%u8F93%u5165%u9A8C%u8BC1%u7801';
    obj.reloadtip = '%u770B%u4E0D%u6E05%3F%u6362%u4E00%u5F20';
    obj.logotip = '%u70B9%u51FB%u4E86%u89E3%u5B87%u521D%u7F51%u7EDC%u9A8C%u8BC1%u7801';
    obj.aderrortip = '%u56FE%u7247%u52A0%u8F7D%u5931%u8D25%u8BF7%u5237%u65B0%u91CD%u8BD5';
    obj.adtip = '%u70B9%u51FB%u67E5%u770B%u8BE6%u60C5';
    obj.helptip = '%u5982%u9700%u5E2E%u52A9%u8BF7%u70B9%u51FB';
    obj.closetip = '%u5173%u95ED';
    var $ = function (id) {
        return document.getElementById(id);
    }
    var T = function (g) {
        var path = obj.imgpath;
        g = g.replace(/YUC_LOCAL/g, path);
        if (M) {
            var x = document.createStyleSheet();
            x.cssText = g
        } else {
            var x = document.createElement("style");
            x.type = "text/css";
            x.appendChild(document.createTextNode(g));
            document.getElementsByTagName('head')[0].appendChild(x);
        }
    }
    var A = function (x, g, c) {
        if (M) {
            x.attachEvent("on" + g, (function (Y) {
                return function () {
                    c.call(Y)
                }
            })(x))
        } else {
            x.addEventListener(g, c, false)
        }
    }
    var D = function (id) {
        var e = $(id);
        if (e) {
            var p = e.parentNode;
        }
        if (p) {
            p.removeChild($(id));
        }
    };
    var L = function (id, src, func) {
        if (id) {
            if (!!$(id)) {
                D(id);
            }
        }
        var isIE = /msie/i.test(navigator.userAgent);
        var s = document.createElement('script');
        if (id) {
            s.id = id;
        }
        s.type = "text/javascript";
        s.onload = s.onreadystatechange = function () {
            if (!this.readyState || this.readyState == 'loaded'
                || this.readyState == 'complete') {
                if (typeof func == 'function') {
                    func();
                } else {
                    //alert('argument is not a function');
                    return;
                }
            }
        }
        s.src = src;
        s.charset = 'utf-8';
        document.getElementsByTagName('head')[0].appendChild(s);
    };
    var G = function (key, inconvert) {
        if (!inconvert) {
            return unescape(obj[key]);
        } else {
            return obj[key];
        }
    }
    var B = (function (ua) {
        var b = {
            msie:/msie/.test(ua) && !/opera/.test(ua),
            opera:/opera/.test(ua),
            safari:/webkit/.test(ua) && !/chrome/.test(ua),
            firefox:/firefox/.test(ua),
            chrome:/chrome/.test(ua)
        };
        var vMark = "";
        for (var i in b) {
            if (b[i]) {
                vMark = i;
            }
        }
        if (b.safari) {
            vMark = "version";
        }
        b.version = RegExp("(?:" + vMark + ")[\\/: ]([\\d.]+)")
            .test(ua) ? RegExp.$1 : "0";
        b.ie = b.msie;
        b.ie6 = b.msie && parseInt(b.version) == 6;
        b.ie7 = b.msie && parseInt(b.version) == 7;
        b.ie8 = b.msie && parseInt(b.version) == 8;
        return b;
    })(window.navigator.userAgent.toLowerCase());
    var I = function (n, t) {
        if (t) {
            var parentEl = t.parentNode;
            if (parentEl.lastChild == t) {
                parentEl.appendChild(n);
            } else {
                parentEl.insertBefore(n, t.nextSibling);
            }
        }
    }
    var P = function (r) {

        function __getIEVersion() {
            var rv = -1;
            if (navigator.appName == 'Microsoft Internet Explorer') {
                var ua = navigator.userAgent;
                var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
                if (re.exec(ua) != null)
                    rv = parseFloat(RegExp.$1);
            }
            return rv;
        }

        function __getOperaVersion() {
            var rv = 0;
            if (window.opera) {
                var sver = window.opera.version();
                rv = parseFloat(sver);
            }
            return rv;
        }

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
                    res = parseInt(width.substring(0, p));
                }
                else {
                    res = 1;
                }
            }
            return res;
        }

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
                res.bottom = parseInt(elStyle.borderBottomWidth.slice(0, -2));
            }
            else {
                res.left = __parseBorderWidth(element.style.borderLeftWidth);
                res.top = __parseBorderWidth(element.style.borderTopWidth);
                res.right = __parseBorderWidth(element.style.borderRightWidth);
                res.bottom = __parseBorderWidth(element.style.borderBottomWidth);
            }

            return res;
        }

        function getElementAbsolutePos(elemID) {
            var element;
            if (typeof(elemID) == "string") {
                element = document.getElementById(elemID);
            }
            else {
                element = elemID;
            }
            var res = new Object();
            res.left = 0;
            res.top = 0;
            if (element !== null) {
                res.left = element.offsetLeft;
                var offsetParent = element.offsetParent;
                var offsetParentTagName = offsetParent != null ? offsetParent.tagName.toLowerCase() : "";
                if (__isIENew && offsetParentTagName == 'td') {
                    res.top = element.scrollTop;
                }
                else {
                    res.top = element.offsetTop;
                }
                var parentNode = element.parentNode;
                var borderWidth = null;
                while (offsetParent != null) {
                    res.left += offsetParent.offsetLeft;
                    res.top += offsetParent.offsetTop;
                    var parentTagName = offsetParent.tagName.toLowerCase();
                    if ((__isIEOld && parentTagName != "table") || (__isFireFoxNew && parentTagName == "td") || __isChrome) {
                        borderWidth = __getBorderWidth(offsetParent);
                        res.left += borderWidth.left;
                        res.top += borderWidth.top;
                    }
                    if (offsetParent != document.body && offsetParent != document.documentElement) {
                        res.left -= offsetParent.scrollLeft;
                        res.top -= offsetParent.scrollTop;
                    }
                    if (!__isIE && !__isOperaOld || __isIENew) {
                        while (offsetParent != parentNode && parentNode !== null) {
                            res.left -= parentNode.scrollLeft;
                            res.top -= parentNode.scrollTop;
                            if (__isFireFoxOld || __isWebKit) {
                                borderWidth = __getBorderWidth(parentNode);
                                res.left += borderWidth.left;
                                res.top += borderWidth.top;
                            }
                            parentNode = parentNode.parentNode;
                        }
                    }
                    parentNode = offsetParent.parentNode;
                    offsetParent = offsetParent.offsetParent;
                }
            }
            return res;
        }

        var posi = getElementAbsolutePos(r);
        return posi;
    }
    var S = function () {
        for (var i = 0; i < rid.length; i++) {
            if (!$(pid[rid[i]].typhoonwest)) {
                var t = document.createElement('input');
                t.type = 'hidden';
                t.name = obj.typhoonwest;
                t.id = pid[rid[i]].typhoonwest;
                var n = $(rid[i]).name;
                t.value = obj.ssid[rid[i]] + ',' + n + ','
                    + obj.request_type;
                I(t, $(rid[i]));
            }
        }
    }
    var initparams = function () {
        if (typeof obj != 'object') {
            alert('yuc_site_config not found');
            return;
        }
        var renderid = '';
        var showtype = obj.show_type;
        var ssid = obj.ssid;
        if (obj.posiid) {
            for (var o in obj.posiid) {
                if ($(obj.posiid[o])) {
                    if ($(obj.posiid[o])) {
                        renderid += obj.posiid[o] + ',';
                        obj.show_type[obj.posiid[o]] = showtype[o];
                        obj.ssid[obj.posiid[o]] = ssid[o];
                    }
                }
            }
        }
        obj.renderid = renderid.substr(0, renderid.length - 1);
        if (obj.renderid.indexOf(',') != -1) {
            rid = obj.renderid.split(',');
        } else {
            rid = [ obj.renderid ];
        }
        for (var i = 0; i < rid.length; i++) {
            if (!$(rid[i])) {
                rid.splice(i, 1);
            }
        }
        for (i = 0; i < rid.length; i++) {
            var id = [ 'mainid', 'imgid', 'reloadid', 'typhoonwest',
                'inputcont', 'ajaxcont', 'tipcont', 'closetipcont', 'tiplayercont', 'tempbox', 'mass' ];
            for (var j = 0; j < id.length; j++) {
                pid[rid[i]] = function (x, o) {
                    var idobj = {};
                    for (var i = 0; i < id.length; i++) {
                        idobj[id[i]] = o[id[i]] + '_' + x;
                    }
                    return idobj;
                }(rid[i], obj);
            }
            html[rid[i]] = (function (r, obj, p) {
                p = p[r];
                if (obj.show_type[rid[i]]
                    && obj.show_type[rid[i]] == 1) {
                    var html = '<div class="yuc_direct_ad"><a href="http://www.yucmedia.com/welcom.php?from=local" target="_blank"><img id="' + p.imgid + '" style="border:0;display:none;" alt="' + G('aderrortip') + '" title="' + G('adtip') + '"></a></div>' +
                        '<div class="yuc_direct_loading_layer"><div class="yuc_direct_loading_inner"><div class="yuc_direct_loading_top"></div><div class="yuc_direct_loading"></div></div></div> ' +
                        '<div  id="' + p.tiplayercont + '"  class="yuc_direct_tip"><div class="yuc_direct_warning"><span class="yuc_direct_warning_icon"></span> <span id="' + p.tipcont + '" class="yuc_direct_warning_text"></span>' +
                        '<a id="' + p.closetipcont + '" href="javascript:;" class="yuc_direct_close" title="' + G('closetip') + '"></a> ' +
                        '</div></div> </div> ' +
                        '<div class="yuc_direct_tools">' +
                        '<div  class="yuc_direct_input"><div id="' + p.inputcont + '" class="yuc_direct_input_inner"></div><div id="' + p.ajaxcont + '" class="yuc_direct_ajax"></div></div><div class="yuc_ctrl"> ' +
                        '<div id="' + p.reloadid + '" class="yuc_direct_refresh" title="' + G('reloadtip') + '"></div>' +
                        '<a href="http://help.yucmedia.com/?from=help" target="_blank" class="yuc_direct_help" title="' + G('helptip') + '"></a><a href="http://www.yucmedia.com/?from=logo" target="_blank"  class="yuc_direct_logo" title="' + G('logotip') + '"></a> ' +
                        '</div></div> ';
                    return html;
                } else {
                    var html = '<div class="yuc_popup_ad"><a href="http://www.yucmedia.com/welcom.php?from=local" target="_blank"><img id="' + p.imgid + '" style="border: 0;display:none;" alt="' + G('aderrortip') + '" title="' + G('adtip') + '"></a></div>' +
                        '<div class="yuc_popup_loading_layer"><div class="yuc_popup_loading_inner"><div class="yuc_popup_loading_top"></div> <div class="yuc_popup_loading"></div></div></div> ' +
                        '<div  id="' + p.tiplayercont + '"  class="yuc_popup_tip"><div class="yuc_popup_warning"><span class="yuc_popup_warning_icon"></span> <span id="' + p.tipcont + '" class="yuc_popup_warning_text"></span>' +
                        '<a id="' + p.closetipcont + '" href="javascript:;" class="yuc_popup_close" title="' + G('closetip') + '"></a> ' +
                        '</div></div> </div> ' +
                        '<div class="yuc_popup_tools">' +
                        '<div class="yuc_ctrl"> ' +
                        '<div id="' + p.reloadid + '" class="yuc_popup_refresh"  title="' + G('reloadtip') + '"></div>' +
                        '<a href="http://help.yucmedia.com/?from=help" target="_blank" class="yuc_popup_help" title="' + G('helptip') + '"></a><a href="http://www.yucmedia.com/?from=logo" target="_blank"  class="yuc_popup_logo" title="' + G('logotip') + '"></a> ' +
                        '</div></div> ';
                    return html;
                }
            })(rid[i], obj, pid);
            if (obj.show_type[rid[i]]
                && obj.show_type[rid[i]] == 1) {
                css[rid[i]] = ".yuc_direct_main{position:relative;border:0;margin:0;padding:0;width:320px;height:250px;background:url('YUC_LOCAL/direct/frame.gif') no-repeat;}" +
                    ".yuc_direct_main .yuc_direct_ad,.yuc_direct_main .yuc_direct_loading_layer,.yuc_direct_main .yuc_direct_tip,.yuc_direct_main .yuc_direct_tools{left:10px;position:absolute;top:10px;width:300px;height:195px;z-index:2;}" +
                    ".yuc_direct_main .yuc_direct_ad{width:300px;height:195px;border:0;}" +
                    ".yuc_direct_main .yuc_direct_ad img{width:300px;height:195px;border:0;display:none;}" +
                    ".yuc_direct_main .yuc_direct_loading_layer{z-index:1;background:#4E4C4C;}" +
                    ".yuc_direct_main .yuc_direct_loading_layer .yuc_direct_loading_inner{margin:0;padding:0;border:0;}" +
                    ".yuc_direct_main .yuc_direct_loading_layer .yuc_direct_loading_inner .yuc_direct_loading_top{margin:0;height:78px;display:block;}" +
                    ".yuc_direct_main .yuc_direct_loading_layer .yuc_direct_loading{width:30px;height:30px;background:white url('YUC_LOCAL/direct/loading.gif') no-repeat;margin:0 auto;text-align:center;}" +
                    ".yuc_direct_main .yuc_direct_tip{top:180px;width:294px;height:18px;padding:2px;border:1px solid #F9F2A7;background:#FEFFE5;z-index:999;display:none;}" +
                    ".yuc_direct_main .yuc_direct_tip .yuc_direct_warning{margin:0;padding:0;height:18px;font-size:12px;line-height:17px;}" +
                    ".yuc_direct_main .yuc_direct_tip .yuc_direct_warning .yuc_direct_warning_icon{background:white url('YUC_LOCAL/direct/warning.gif');width:16px;height:16px;float:left;margin:0 5px 0 0;}" +
                    ".yuc_direct_main .yuc_direct_tip .yuc_direct_warning .yuc_direct_warning_text{font-family:arial,verdana,serif;font-size:12px;}" +
                    ".yuc_direct_main .yuc_direct_tip .yuc_direct_warning .yuc_direct_close{position:absolute;top:3px;right:2px;background:#ffffff url('YUC_LOCAL/direct/del.gif');width:16px;height:16px;color:#0082CB;cursor:pointer;}" +
                    ".yuc_direct_main .yuc_direct_tools{position:absolute;top:206px;width:300px;height:34px;padding:0px;margin:0;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_input{position:absolute;top:10px;left:6px;padding:2px;width:120px;height:18px;background:url('YUC_LOCAL/direct/input.gif') no-repeat;font-size:12px;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_input .yuc_direct_input_inner{margin:0;padding:0;width:80%;height:100%;font-size:12px;float:left;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_input .yuc_direct_input_inner .yuc_inputbox{position:static;height:100% !important;width:100% !important;margin:0  !important;padding:0  !important;border-color:#000000  !important;border-style:none  !important;border-width:0  !important;font-size:12px  !important;font-family:'arial'  !important;line-height:17px  !important;outline:none  !important;color:#A9A9A9;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_input .yuc_direct_right{margin:0;padding:0;width:18px;height:18px;float:right;background:white url('YUC_LOCAL/direct/check_right.gif') no-repeat;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_input .yuc_direct_error{margin:0;padding:0;width:18px;height:18px;float:right;background:white url('YUC_LOCAL/direct/check_error.gif') no-repeat;}" +
                    ".yuc_direct_main .yuc_direct_tools .ctrl{width:100%;height:100%;padding:0;margin:0;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_refresh{position:absolute;left:132px;top:8px;width:27px;height:27px;background:url('YUC_LOCAL/direct/reload.gif') no-repeat;border:0;cursor:pointer;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_refresh:hover{background:url('YUC_LOCAL/direct/reload_hover.gif') no-repeat;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_help{position:absolute;left:166px;top:3px;width:27px;height:27px;background:url('YUC_LOCAL/direct/help.gif') no-repeat;border:0;cursor:pointer;outline:none;display:none;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_help:hover{background:url('YUC_LOCAL/direct/help_hover.gif') no-repeat;}" +
                    ".yuc_direct_main .yuc_direct_tools .yuc_direct_logo{position:absolute;right:6px;top:13px;width:91px;height:21px;background:url('YUC_LOCAL/direct/logo.gif') no-repeat;outline:none;cursor:pointer;}";
            } else {
                css[rid[i]] = ".yuc_popup_main{position:absolute;border:0;margin:0;padding:0;width:320px;height:250px;background:url('YUC_LOCAL/popup/frame.gif') no-repeat;display:none;}" +
                    ".yuc_popup_main .yuc_popup_ad,.yuc_popup_main .yuc_popup_loading_layer,.yuc_popup_main .yuc_popup_tip,.yuc_popup_main .yuc_popup_tools{left:10px;position:absolute;top:10px;width:300px;height:195px;z-index:2;}" +
                    ".yuc_popup_main .yuc_popup_ad img{width:300px;height:195px;;border:0;display:none;}" +
                    ".yuc_popup_main .yuc_popup_loading_layer .yuc_popup_loading_inner{margin:0;padding:0}" +
                    ".yuc_popup_main .yuc_popup_loading_layer .yuc_popup_loading_inner .yuc_popup_loading_top{margin:0;height:78px;display:block;}" +
                    ".yuc_popup_main .yuc_popup_loading_layer{z-index:1;background:#4E4C4C;display:block;}" +
                    ".yuc_popup_main .yuc_popup_loading_layer .yuc_popup_loading{width:30px;height:30px;padding:0;background:white url('YUC_LOCAL/popup/loading.gif') no-repeat;margin:0 auto;text-align:center;}" +
                    ".yuc_popup_main .yuc_popup_tip{top:180px;width:294px;height:18px;padding:2px;border:1px solid #F9F2A7;background:#FEFFE5;z-index:999;display:none;}" +
                    ".yuc_popup_main .yuc_popup_tip .yuc_popup_warning{margin:0;padding:0;height:18px;font-size:12px;line-height:17px;}" +
                    ".yuc_popup_main .yuc_popup_tip .yuc_popup_warning .yuc_popup_warning_icon{background:white url('YUC_LOCAL/popup/warning.gif');width:16px;height:16px;float:left;margin:0 5px 0 0;}" +
                    ".yuc_popup_main .yuc_popup_tip .yuc_popup_warning .yuc_popup_warning_text{font-family:arial,verdana,serif;font-size:12px;}" +
                    ".yuc_popup_main .yuc_popup_tip .yuc_popup_warning .yuc_popup_close{position:absolute;top:3px;right:2px;background:#ffffff url('YUC_LOCAL/popup/del.gif');width:16px;height:16px;color:#0082CB;cursor:pointer;}" +
                    ".yuc_popup_main .yuc_popup_tools{position:absolute;top:206px;width:300px;height:34px;padding:0px;margin:0;}" +
                    ".yuc_popup_main .yuc_popup_tools .ctrl{width:100%;height:100%;padding:0;margin:0;}" +
                    ".yuc_popup_main .yuc_popup_tools .yuc_popup_refresh{position:absolute;left:17px;top:9px;width:27px;height:27px;background:url('YUC_LOCAL/popup/reload1.gif') no-repeat;border:0;cursor:pointer;}" +
                    ".yuc_popup_main .yuc_popup_tools .yuc_popup_refresh:hover{background:url('YUC_LOCAL/popup/reload2.gif') no-repeat;}" +
                    ".yuc_popup_main .yuc_popup_tools .yuc_popup_help{position:absolute;left:50px;top:3px;width:27px;height:27px;background:url('YUC_LOCAL/popup/help.gif') no-repeat;border:0;cursor:pointer;outline:none;display:none;}" +
                    ".yuc_popup_main .yuc_popup_tools .yuc_popup_help:hover{background:url('YUC_LOCAL/popup/help_hover.gif') no-repeat;}" +
                    ".yuc_popup_main .yuc_popup_tools .yuc_popup_logo{position:absolute;right:15px;top:16px;width:91px;height:21px;background:url('YUC_LOCAL/popup/logo.gif') no-repeat;outline:none;cursor:pointer;}";
            }
        }
    }
    this.customajax = function (r, func) {
        ajaxproc(r, func);
    }
    var ajaxproc = function (r, func) {
        var t = obj.show_type[r];
        var src = 'http://' + obj.localserver
            + obj.installdir
            + '/Action/ajax.php?' + obj.typhoonwest + '='
            + $(pid[r].typhoonwest).value
            + '&' + $(r).name + '=' + $(r).value
            + '&' + obj.mass + '=' + obj[r].mass
            + '&rnd=' + Math.random();
        var result = '';
        var isvalid = false;
        var code = '';
        var details = '';
        L(obj.pf + 'ajax', src, function () {
            result = obj.ajaxresult;
            if (result) {
                code = result.code;
                isvalid = result.result;
                details = result.details;
                if (!func) {
                    var code = result.code;
                    var isvalid = result.result;
                    var details = result.details;
                    if ($(pid[r].ajaxcont)) {
                        if (isvalid) {
                            $(pid[r].ajaxcont).className = obj.ajaxback['y'];
                        } else {
                            $(pid[r].ajaxcont).className = obj.ajaxback['n'];
                        }
                        if ($(pid[r].ajaxcont)) {
                            $(pid[r].ajaxcont).style.display = 'inline';
                        }
                    }
                } else if (typeof func == 'function') {
                    if (isvalid) {
                        func(1);
                    } else {
                        func(0);
                    }
                    if ($(pid[r].ajaxcont)) {
                        if (isvalid) {
                            $(pid[r].ajaxcont).className = obj.ajaxback['y'];
                        } else {
                            $(pid[r].ajaxcont).className = obj.ajaxback['n'];
                        }
                        $(pid[r].ajaxcont).style.display = 'inline';
                    }
                } else if (typeof func == 'string') {
                    if (isvalid) {
                        eval(func + '(1)');
                    } else {
                        eval(func + '(0)');
                    }
                }
            }
        });
    }
    var reload = function (r, o, p) {
        focustype = 0;
        if ($(pid[r].ajaxcont)) {
            $(pid[r].ajaxcont).style.display = 'none';
        }
        var src = 'http://' + obj.localserver + '/' + obj.installdir + '/Action/index.php?renderid=' + r;
        if (typeof obj[r] == 'object') {
            obj[r] = '';
        }
        L('yuc_code', src, function () {
            if (typeof obj[r] == 'object') {
                var codeobj = obj[r];
                if ($(p[r].imgid)) {
                    $(p[r].imgid).src = obj[r].imgsrc + '&rnd=' + Math.random();
                }
                S();
                if ($(pid[r].mass)) {
                    $(pid[r].mass).value = obj[r].mass;
                }
            }
        });
        $(r).value = '';
        $(r).focus();
    }

    var inithtml = function () {
        for (var i = 0; i < rid.length; i++) {
            T(css[rid[i]]);
            var d = document.createElement('div');
            d.id = pid[rid[i]].mainid;
            d.innerHTML = html[rid[i]];
            var src = 'http://' + obj.localserver + '/' + obj.installdir + '/Action/index.php?renderid=' + rid[i];
            L('yuc_code', src, function (i) {
                return function () {
                    if (typeof obj[rid[i]] == 'object') {
                        var codeobj = obj[rid[i]];
                        if ($(pid[rid[i]].imgid)) {
                            $(pid[rid[i]].imgid).src = obj[rid[i]].imgsrc + '&rnd=' + Math.random();
                            A($(pid[rid[i]].imgid), 'load', function () {
                                $(pid[rid[i]].imgid).style.display = 'inline';
                            })
                        }
                    }
                    if (!$(pid[rid[i]].mass)) {
                        var t = document.createElement('input');
                        t.type = 'hidden';
                        t.name = obj.mass;
                        t.id = pid[rid[i]].mass;
                        t.value = obj[rid[i]].mass;
                        I(t, $(rid[i]));
                    } else {
                        $(pid[rid[i]].mass).value = obj[rid[i]].mass;
                    }
                    S();
                }
            }(i));
            if (obj.show_type[rid[i]] == 1) {
                d.className = obj.mainclass[1];
                I(d, $(rid[i]));
                $(pid[rid[i]].inputcont).appendChild($(rid[i]));
                $(rid[i]).value = G('captchatext');
                $(rid[i]).className = obj.input;
                A($(rid[i]), 'click', function (i) {
                    return function () {
                        if ($(rid[i]).value == G('captchatext')) {
                            $(rid[i]).value = '';
                        }
                    }
                }(i));
                A($(rid[i]), 'blur', function (i) {
                    return function () {
                        if ($(rid[i]).value == "") {
                            $(rid[i]).value = G('captchatext');
                        }
                    }
                }(i));
                A($(rid[i]), 'keyup', function (i) {
                    return function () {
                        ajaxproc(rid[i]);
                    }
                }(i));
            } else {
                d.className = obj.mainclass[0];
                I(d, $(rid[i]));
                var posi = P(rid[i]);
                var top = posi.top;
                var left = posi.left;
                if (top < 230) {
                    d.style.top = top + 25 + 'px';
                } else {
                    d.style.top = top - 255 + 'px';
                }
                d.style.left = left + 'px';
                if (obj.show_type[rid[i]] == 2) {
                    if ($('yucmedia_Captcha')) {
                        $('yucmedia_Captcha').appendChild(d);
                    } else {
                        var parent = $(rid[i]).parentNode;
                        parent.insertBefore(d, $(rid[i]));
                    }
                    d.style.position = 'relative';
                    d.style.top = '0px';
                    d.style.left = '0px';
                    d.style.display = 'block';
                } else {
                    A($(rid[i]), 'click', function () {
                        d.style.display = 'inline';
                    });
                    A($(rid[i]), 'focus', function () {
                        if (top < 230) {
                            d.style.top = top + 25 + 'px';
                        } else {
                            d.style.top = top - 255 + 'px';
                        }
                        d.style.left = left + 'px';
                        d.style.display = 'inline';
                    });
                    var on = 0;
                    A(d, 'mouseover', function () {
                        on = 1;
                    });
                    A(d, 'mouseout', function () {
                        on = 0
                    });
                    A($(rid[i]), 'blur', function () {
                        if (on == 0) {
                            d.style.display = 'none';
                        }
                    });
                }
            }
            if (typeof CustomDefinedAjaxOnkeyup == 'function') {
                A($(rid[i]), 'keyup', function (i) {
                    return function () {
                        ajaxproc(rid[i], CustomDefinedAjaxOnkeyup);
                    }
                }(i));
            }
            if (obj.result) {
                if (obj.result.code) {
                    var a = '<a href="' + obj.support + '?code=' + obj.result.code + '"  target="_blank">详情</a>';
                    $(pid[rid[i]].tipcont).innerHTML = obj.result.details + a;
                    $(pid[rid[i]].tiplayercont).style.display = 'inline';
                    A($(pid[rid[i]].closetipcont), 'click', function (i) {
                        return function () {
                            $(pid[rid[i]].tiplayercont).style.display = 'none';
                        }
                    }(i));
                }
            }
            A($(pid[rid[i]].reloadid), 'click', function (i) {
                return function () {
                    reload(rid[i], obj, pid);
                }
            }(i));
        }
    }
    this.load = function () {
        YucServer.ready(
            function () {
                if (typeof(yucmedia_after_load) != 'undefined') {
                    yucmedia_after_load();
                }
                initparams();
                inithtml();
            }
        );
    }
}
var obj = yuc_site_config;
var yuc_captcha_obj = new yuc_captcha(obj);
yuc_captcha_obj.load();
// ol(yuc_captcha.html)";}