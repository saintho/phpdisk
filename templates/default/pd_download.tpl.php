<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_download.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="index_box">
<!--#include sub/block_adv_middle#-->
<div>

<div id="dl_box">
	<div class="tit">{#file_icon($file['file_extension'],'filetype_32')#} {#$file['file_name']#}&nbsp;&nbsp;<a href="{$file[file_url]}"><span class="f12 txtgray" style="font-size:12px;"><?=__('back_viewfile')?></span></a></div>
	<div>{$adv_top}</div>
	<div id="b1">
	{$adv_inner}
	</div>
	
	<div id="b2">
<!--#if($settings[down_auth_code]==1 && $file[file_downs]>=$settings[file_downs]){#-->
<script type="text/javascript">
function check_yuc(){
  if(document.getElementById('phpdisk_dl_yuc').value.strtrim()==''){
	document.getElementById('phpdisk_dl_yuc').focus();
	alert('<?=__('down_code_error')?>');
	return false;
  }
document.getElementById('s1').disabled =true;  
$.post("ajax.php", $("#codefrm").serialize(),
	function(msg){
	 if(msg=='true'){
		document.getElementById('down_box').style.display ='';
		document.getElementById('down_box2').style.display ='none';
	 }else{
		getId('yuc_tips').innerHTML = '<?=__('down_code_error')?>';
		getId('down_box2').style.display ='';
		getId('down_box').style.display="none";
		setTimeout(function(){document.getElementById('yuc_tips').style.display='none';},3000);
	 }
	 document.getElementById('s1').disabled =false;  
   });
}
</script>
<script src="yucmedia/Action/load.php" type="text/javascript"></script>
<form id="codefrm" method="post" onkeydown="if(event.keyCode==13){return false;}">
<input type="hidden" name="action" value="check_yuc" />
<div style="padding-top:10px" class="f14"><input id="{$settings[yuc_ads_id]}" name="code"/>&nbsp;<span class="txtred">(<?=__('input_verycode')?>)</span></div>
<div id="yuc_tips" class="txtred f14"></div>
<div style="padding:10px 0"><input type="button" onclick="check_yuc();" class="btn txtblue" value="<?=__('auth_down_submit')?>" id="s1" />&nbsp;&nbsp;<img src="images/code_tips.gif" align="absmiddle" border="0" /></div>
</form>
<!--#}elseif($settings[down_auth_code]==2 && $file[file_downs]>=$settings[file_downs]){#-->
<div id="code_box">
<form id="codefrm" method="post">
<input type="hidden" name="action" value="check_code" onkeydown="if(event.keyCode==13){return false;}"/>
<div style="padding:5px;"><img style="cursor:pointer; margin-bottom:10px;" id="imgcode" alt="<?=__('reload_code')?>" border="0" onclick="chg_imgcode();" />&nbsp;&nbsp;<span onclick="chg_imgcode();" style="cursor:pointer"><?=__('reload_code')?></span><br />
<img src="images/code_tips.gif" align="absmiddle" border="0" /></div>
<div style="padding:5px 0"><input type="text" id="code" name="code" size="2" style="padding:3px;border:1px #000000 solid" />&nbsp;&nbsp;<input type="button" style="padding:2px;border:1px #000000 solid" onclick="check_code();" id="s1" value="<?=__('auth_down_submit')?>" /><span id="code_tips" class="txtred f14"></span></div>
</form>
</div>
  <script type="text/javascript">
  getId('imgcode').src = 'imagecode.php';
  function chg_imgcode(){
  	getId('imgcode').src = 'imagecode.php?t='+Math.random();
  }
  function check_code(){
	  if(document.getElementById('code').value.strtrim()==''){
	  	document.getElementById('code').focus();
		alert('<?=__('down_code_error')?>');
		return false;
	  }
	document.getElementById('s1').disabled =true;  
	$.post("ajax.php", $("#codefrm").serialize(),
		function(msg){
		 if(msg=='true'){
			document.getElementById('down_box').style.display ='';
			document.getElementById('down_box2').style.display ='none';
		 }else{
			document.getElementById('code_tips').innerHTML ='<?=__('down_code_error')?>';
			document.getElementById('code').value='';
			document.getElementById('down_box2').style.display ='';
			document.getElementById('s1').disabled =false;
			chg_imgcode();
			setTimeout(function(){document.getElementById('code_tips').style.display='none';},3000);
		 }
	   });
  }
  </script>
<!--#}elseif($settings[down_auth_code]==3 && $file[file_downs]>=$settings[file_downs]){#-->
<form id="codefrm" method="post" onkeydown="if(event.keyCode==13){return false;}">
<input type="hidden" name="action" value="check_yxm" />
<div style="padding-top:10px" class="f14">
<script type='text/javascript' charset='gbk'>
var YXM_PUBLIC_KEY = '{$settings[yxm_public_key]}';//这里填写PUBLIC_KEY
var YXM_localsec_url = 'http://127.0.0.1/YinXiangMa_PHP_SDK_Demo/localsec/';//这里设置应急策略路径
function YXM_local_check()
{
if(typeof(YinXiangMaDataString)!='undefined')return;
YXM_oldtag = document.getElementById('YXM_script');
var YXM_local=document.createElement('script');
YXM_local.setAttribute("type","text/javascript");
YXM_local.setAttribute("id","YXM_script");
YXM_local.setAttribute("src",YXM_localsec_url+'yinxiangma.js?pk='+YXM_PUBLIC_KEY+'&m=live&v=YinXiangMa_PHPSDK_3.0');
YXM_oldtag.parentNode.replaceChild(YXM_local,YXM_oldtag);  
}
setTimeout("YXM_local_check()",2000);
document.write("<input type='hidden' id='YXM_here' /><script type='text/javascript' charset='gbk' id='YXM_script' async src='http://api.yinxiangma.com/api2/yzm.yinxiangma.php?pk="+YXM_PUBLIC_KEY+"&m=live&v=YinXiangMaPHPSDK_3.0'><"+"/script>");
</script> 
<span class="txtred">(<?=__('input_verycode')?>)</span></div>
<div id="yxm_tips" class="txtred f14"></div>
<div style="padding:10px 0"><input type="button" onclick="check_yxm();" id="s1" class="btn txtblue" value="<?=__('auth_down_submit')?>" />&nbsp;&nbsp;<img src="images/code_tips.gif" align="absmiddle" border="0" /></div>
</form>
<script type="text/javascript">
  function check_yxm(){
	document.getElementById('s1').disabled =true;  
	$.post("ajax.php", $("#codefrm").serialize(),
		function(msg){
		 if(msg=='true'){
			document.getElementById('down_box').style.display ='';
			document.getElementById('down_box2').style.display ='none';
		 }else{
			document.getElementById('yxm_tips').innerHTML ='<?=__('down_code_error')?>';
			document.getElementById('down_box2').style.display ='';
			document.getElementById('s1').disabled =false;
			setTimeout(function(){document.getElementById('yxm_tips').style.display='none';},3000);
		 }
	   });
  }
</script>
<!--#}#-->
<!--#if($settings['open_thunder']){#-->
<script src="http://pstatic.xunlei.com/js/webThunderDetect.js"></script>
<!--#}#-->
<!--#if($settings['open_flashget']){#-->
<script src="http://ufile.qushimeiti.com/Flashget_union.php?fg_uid={$settings['flashget_uid']}"></script>
<script type="text/javascript">
function ConvertURL2FG(url,fUrl,uid){	
	try{
		FlashgetDown(url,uid);
	}catch(e){
		location.href = fUrl;
	}
}
function Flashget_SetHref(obj,uid){obj.href = obj.fg;}
</script>
<!--#}#-->

<div id="down_box2">
<img src="images/light.gif" align="absmiddle" border="0" /><?=__('input_code_to_downfile')?>
</div>
<div id="down_box_tips"></div>
<div id="down_box" style="display:none;">
	<!--#
	if($file[yun_fid]){
	#-->
	<div class="tit2"><img src="images/icon_nav.gif" align="absmiddle" border="0" />文件下载地址</div>
	<div class="d0">
	<div class="d1" align="center">
	<a href="http://d.yun.google.com/down-{$file[yun_fid]}" class="down_btn" target="_blank"><span>电信下载</span></a></div>
	<div class="d2" align="center">
	<a href="http://d.yun.google.com/down-{$file[yun_fid]}" class="down_btn" target="_blank"><span>网通下载</span></a></div>
	<div class="clear"></div>
	</div>
	<!--#
	}else{
	$nodes = get_nodes($file[server_oid]);
if(count($nodes)){
	for($i = 0; $i < count($nodes); $i++) {
		if($nodes[$i]['parent_id'] == 0) {
#-->
		<div class="tit2"><img src="images/icon_nav.gif" align="absmiddle" border="0" />{#$nodes[$i]['subject']#}</div>
		<div class="d0">
<!--#
		for($j = 0; $j < count($nodes); $j++) {
			if($nodes[$j]['parent_id'] == $nodes[$i]['node_id']) {
#-->
		<!--#if($j%2==0){#-->
		<div class="d1" align="center">
			<!--#
			if($settings['open_thunder'] && $nodes[$j]['down_type']==1){
				$thunder_url = thunder_encode($nodes[$j]['host'].$file[dl]);
			#-->
			<a oncontextmenu=ThunderNetwork_SetHref(this) onclick="down_process2('{$file[file_id]}');return OnDownloadClick_Simple(this,2,4)" href="###" thunderResTitle="{$file['file_name']}" thunderType="" thunderPid="{$settings['thunder_pid']}" thunderHref="{$thunder_url}" class="down_btn"><span>{#$nodes[$j]['icon']#}{#$nodes[$j]['subject']#}</span></a>
			<!--#
			}elseif($settings['open_flashget'] && $nodes[$j]['down_type']==2){
				$flashget_url = flashget_encode($nodes[$j]['host'].$file[dl],$settings['flashget_uid']);
			#-->
			<a href="###" onClick="down_process2('{$file[file_id]}');ConvertURL2FG('{$flashget_url}','{#$nodes[$j]['host'].$file[dl]#}',{$settings['flashget_uid']});return false;" oncontextmenu="Flashget_SetHref(this)" fg="{$flashget_url}" class="down_btn"><span>{#$nodes[$j]['icon']#}{#$nodes[$j]['subject']#}</span></a>
			<!--#}else{#-->
			<a href="{#$nodes[$j]['host'].$file[dl]#}" onclick="down_process2('{$file[file_id]}');" target="_blank"><span>{#$nodes[$j]['icon']#}{#$nodes[$j]['subject']#}</span></a>
			<!--#}#-->
		</div>
		<!--#}else{#-->
		<div class="d2" align="center">
			<!--#
			if($settings['open_thunder'] && $nodes[$j]['down_type']==1){
				$thunder_url = thunder_encode($nodes[$j]['host'].$file[dl]);
			#-->
			<a oncontextmenu=ThunderNetwork_SetHref(this) onclick="down_process2('{$file[file_id]}');return OnDownloadClick_Simple(this,2,4)" href="###" thunderResTitle="{$file['file_name']}" thunderType="" thunderPid="{$settings['thunder_pid']}" thunderHref="{$thunder_url}" class="down_btn"><span>{#$nodes[$j]['icon']#}{#$nodes[$j]['subject']#}</span></a>
			<!--#
			}elseif($settings['open_flashget'] && $nodes[$j]['down_type']==2){
				$flashget_url = flashget_encode($nodes[$j]['host'].$file[dl],$settings['flashget_uid']);
			#-->
			<a href="###" onClick="down_process2('{$file[file_id]}');ConvertURL2FG('{$flashget_url}','{#$nodes[$j]['host'].$file[dl]#}',{$settings['flashget_uid']});return false;" oncontextmenu="Flashget_SetHref(this)" fg="{$flashget_url}" class="down_btn"><span>{#$nodes[$j]['icon']#}{#$nodes[$j]['subject']#}</span></a>
			<!--#}else{#-->
			<a href="{#$nodes[$j]['host'].$file[dl]#}" onclick="down_process2('{$file[file_id]}');" target="_blank"><span>{#$nodes[$j]['icon']#}{#$nodes[$j]['subject']#}</span></a>
			<!--#}#-->
		</div>
		<!--#}#-->
<!--#	
				}
			}
#-->
		<div class="clear"></div>
		</div>
<!--#
		}
	}
	unset($nodes);
}
}
#-->	
</div>	
	</div>	
	<div class="clear"></div>
	<div>{$adv_bottom}</div>
</div>
<!-- left end -->
</div>
<script type="text/javascript">
<!--#if(!$settings[down_auth_code] || $file[file_downs]<$settings[file_downs]){#-->
document.getElementById('down_box').style.display="";
document.getElementById('down_box2').style.display ='none';
<!--#}#-->

function down_process2(file_id){
setTimeout(	function(){
	$('#down_box_tips').html("<img src=\"images/tip_alert.gif\" align=\"absmiddle\" border=\"0\" /><span class='txtred'><?=__('download_loading')?></span>");
	$('#down_box_tips').show();
	$('#down_box_tips').addClass('down_box_tips');
	$('#down_box').fadeOut();
	},1230);
	$.ajax({
		type : 'post',
		url : 'ajax.php',
		data : 'action=down_process&file_id='+file_id+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			if(msg == 'true'){
				//getId('down_box').innerHTML = "<img src=\"images/ajax_loading.gif\" align=\"absmiddle\" border=\"0\" /><span class='txtred'><?=__('download_loading')?></span>";
			}else{
			alert(msg);
			}
			setTimeout(	function(){$('#down_box_tips').hide();$('#down_box').fadeIn();},5000);
		},
		error:function(){
		}

	});
}
</script>
<br />
<div class="clear"></div>
<!--#if(!$pd_uid || !$settings['open_vip']){#-->
{#stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'download_code')))#}
<!--#}elseif(($settings['open_vip'] && get_profile($pd_uid,'vip_end_time')<$timestamp) || get_vip(get_profile($pd_uid,'vip_id'),'pop_ads')){#-->
{#stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'download_code')))#}
<!--#}#-->
<!--#if(get_profile($file[userid],'open_custom_stats') && get_profile($file[userid],'check_custom_stats')){#-->
{#stripslashes(get_stat_code($file[userid]))#}
<!--#}#-->
