<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_space_pwd.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="info_box">
<div class="info_box_tit"><img src="images/light.gif" align="absmiddle" border="0" /> <?=__('tips_message')?></div>
<div class="info_box_msg">
<div class="f14 txtgray"><?=__('need_space_pwd_tips')?></div>
<div style="padding:8px;"><?=__('visit_password')?>: <input type="password" style="padding:5px;" name="code" id="code" />&nbsp;<input type="button" onclick="post_space_pwd();" class="btn" value="<?=__('btn_submit')?>" /><!--#if($pd_gid==1){#--><input type="button" onclick="admin_space_pwd();" class="btn" value="管理员无密码登录" /><!--#}#--><span id="sloading"></span></div>
</div>
<br />

</div>
<script type="text/javascript">
$('#code').focus();
function post_space_pwd(){
	var code = getId('code').value.strtrim();
	if(code==''){
		alert('<?=__('space_pwd_error')?>');
		$('#code').focus();
		return false;
	}
	$('#sloading').html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />loading...');
	$.ajax({
		type : 'post',
		url : "{$ajax_url}ajax.php",
		data : 'action=space_pwd&uid={$userid}&code='+code+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			var arr = msg.split('|');
			if(arr[0] == 'true'){
				$('#sloading').html(arr[1]);
			}else{
				$('#sloading').html(msg);
			}			
			setTimeout(function(){document.location.reload();},1250);
		},
		error:function(){
		}

	});
}
<!--#if($pd_gid==1){#-->
function admin_space_pwd(){
	$('#sloading').html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />loading...');
	$.ajax({
		type : 'post',
		url : "{$ajax_url}ajax.php",
		data : 'action=admin_space_pwd&uid={$userid}&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			var arr = msg.split('|');
			if(arr[0] == 'true'){
				$('#sloading').html(arr[1]);
			}else{
				$('#sloading').html(msg);
			}			
			setTimeout(function(){document.location.reload();},1250);
		},
		error:function(){
		}

	});
}
<!--#}#-->
</script>