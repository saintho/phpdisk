<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_fastlogin.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script type="text/javascript" src="{$abs_path}includes/js/jquery.js"></script>
<link href="{$abs_path}{$user_tpl_dir}images/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
BODY {
	background:#eee;font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif
}
form{margin:0; padding:0}
.btn {
	background:url("{$abs_path}images/sbtn_bg.gif") repeat-x; border:2px #8EBAEC solid; padding:3px 6px; padding:3px 0 0 0\9;
}

li{list-style:none; margin:0px; padding:0px;}
.td_line td{border-bottom:1px #cccccc dotted; height:30px}
.f14{font-size:14px}
.txtgray{color:#666666}

.info_box{height:auto; margin:auto; margin-top:100px; width:500px; padding:1px;border:#cce2ee solid 1px; background:#FFFFFF }
.info_box_tit{font-weight: bold; padding:4px; color:#376DA8;background:#F9FAFE;}
.info_box_msg{padding:18px 10px;line-height: 150%; display:block; width:inherit;}
</style>
</head>

<body>
<div class="info_box">
<div class="info_box_tit"><img src="{$abs_path}images/light.gif" align="absmiddle" border="0" /> {$title}</div>
<div class="info_box_msg">
<form id="frm">
<input type="hidden" name="action" value="bind_user" />
<input type="hidden" name="flid" value="{$flid}" />
<table align="center" width="95%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 txtgray">·<?=__('bind_user_tips')?></td>
</tr>	
<tr>
	<td width="25%" align="right"><?=__('bind_username')?>:</td>
	<td><input type="text" name="username" style="width:150px" /></td>
</tr>
<tr>
	<td align="right"><?=__('bind_password')?>:</td>
	<td><input type="password" name="password" style="width:150px" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="button" onClick="bind_user();" class="btn" value="<?=__('btn_submit')?>" />&nbsp;<span id="sloading"></span></td>
</tr>
</table>
</form>
<br><br>
<table align="center" width="95%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="2" class="f14 txtgray">·直接登录网站，暂时跳过绑定帐号</td>
</tr>	
<tr>
	<td width="25%">&nbsp;</td>
	<td>您好 , {$nickname}</td>
</tr>	
<tr>
	<td>&nbsp;</td>
	<td><input type="button" onclick="guest_visit();" class="btn" value="直接登录，暂时跳过绑定帐号" /></td>
</tr>
</table>
</div>
<br />

</div>
<script type="text/javascript">
function bind_user(){
	$('#sloading').html('<img src="{$abs_path}images/ajax_loading.gif" align="absmiddle" border="0" />loading...');
	$.post("{$abs_path}ajax.php", $("#frm").serialize(),
		function(msg){
		var arr = msg.split('|');
		 if(arr[0]=='true'){
			$('#sloading').html(arr[1]);
			document.location='{$settings[phpdisk_url]}{#urr("mydisk","")#}';
		 }else{
			$('#sloading').html(msg);
		 }
	});
}
function guest_visit(){
	$.ajax({
		type : 'post',
		url : '{$abs_path}ajax.php',
		data : 'action=guest_visit&flid={$flid}&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			var arr = msg.split('|');
			if(arr[0] == 'true'){
				document.location='{$settings[phpdisk_url]}{#urr("mydisk","")#}';
			}else{
				$('#sloading').html(msg);
			}			
		},
		error:function(){
		}

	});
}
</script>
</body>
</html>