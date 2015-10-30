/**
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: digg.js 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
*/

var etag=false;
function pdVote(file_id,dig_type){
	if(etag==true){
		alert(lang['vote_just']);
		return;
	}
	var p_url = 'ajax.php?action=digg&dig_type='+dig_type+'&file_id='+file_id;
	var html_doc=document.getElementsByTagName('head')[0];
    var js=document.createElement('script');
    js.setAttribute('type', 'text/javascript');
    js.setAttribute('src', p_url);
	js.onreadystatechange=function(){
        if(js.readyState=='loaded'||js.readyState=='complete'){
            pdVoteRes();
        }
    }
    js.onload=function(){
        pdVoteRes();
    }
	html_doc.appendChild(js);
	etag=true;
}

function pdVoteRes(){
	if(re[2]=='success'){
		var s = getId('s'+re[1]).innerHTML;
		getId('s'+re[1]).innerHTML=parseInt(s)+1;
		pdUpdate();
		alert(re[3]);
	}else if(re[2]=='fail'){
		alert(re[3]);
	}else{
		alert('unknown error.');
	}
}

function pdUpdate(){
	var sUp=parseInt(getId('s1').innerHTML);
	var sDown=parseInt(getId("s2").innerHTML);
	var sTotal=sUp+sDown;
	var spUp=(sUp/sTotal)*100;
	spUp=Math.round(spUp*10)/10;
	var spDown=100-spUp;
	spDown=Math.round(spDown*10)/10;
	getId('sp1').innerHTML=spUp+'%';
	getId('sp2').innerHTML=spDown+'%';
	getId('eimg1').style.width = parseInt((sUp/sTotal)*55)+'px';
	getId('eimg2').style.width = parseInt((sDown/sTotal)*55)+'px';
}