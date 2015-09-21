<?php die();?>a:2:{s:4:"time";d:1442830769.6913559;s:4:"data";s:2585:"(function () {
    var isReady = false; //是否已经加载完毕
    var readBound = false; //判断是否已经调用过循环事件
    var readylist = []; //把需要执行的方法先暂存在这个数组里
    //判断浏览器，该方法来自Cloudgamer JavaScript Library v0.1
    var Browser = (function (ua) {
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
        b.version = RegExp("(?:" + vMark + ")[\\/: ]([\\d.]+)").test(ua) ? RegExp.$1 : "0";
        b.ie = b.msie;
        b.ie6 = b.msie && parseInt(b.version) == 6;
        b.ie7 = b.msie && parseInt(b.version) == 7;
        b.ie8 = b.msie && parseInt(b.version) == 8;
        return b;
    })(window.navigator.userAgent.toLowerCase());

    function bindReady() {
        if (readBound) { //保证bindReady方法只执行一遍
            return;
        }
        readBound = true;
        //For IE并且不是嵌套在frame中
        if (Browser.msie && window == top) {
            (function () {
                if (isReady) {
                    return;
                }
                try {
                    document.documentElement.doScroll("left"); //如果没加载dom完毕这个会报错
                } catch (error) {
                    setTimeout(arguments.callee, 0); //循环调用父函数,也就是ready方法
                    return;
                }
                Test.Done();
            })();
        } else {
            document.addEventListener("DOMContentLoaded", Test.Done, false);
        }
    }

    var Test = {
        ready:function (fn) {
            bindReady();//判断是否加载完毕
            if (isReady) {
                fn.call(document); //加载完毕，直接调用
            } else {
                readylist.push(fn);//如果还没加载完成则将该方法暂存到readylist数组中，以便以后调用
            }
            return this;
        }
    };

    //静态方法：加载完毕执行
    Test.Done = function () {
        if (!isReady) {
            isReady = true;
        }
        readylist[0].call(document);
    }
    YucServer = Test;
})();";}