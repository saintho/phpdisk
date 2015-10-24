<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-03 16:52:38

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: email.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php 
if($action == 'setting'){
 ?>
<div id="container">
<h1><?=__('email_title')?><?php sitemap_tag(__('email_title')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('email_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=email&menu=user")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_email')?></span>: <br /><span class="txtgray"><?=__('open_email_tips')?></span></td>
	<td><input type="radio" name="setting[open_email]" value="1" <?=ifchecked(1,$setting['open_email'])?>/><?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_email]" value="0" <?=ifchecked(0,$setting['open_email'])?>/><?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('email_address')?></span>: <br /><span class="txtgray"><?=__('email_address_tips')?></span></td>
	<td><input type="text" id="email_address" name="setting[email_address]" value="<?=$setting['email_address']?>" maxlength="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('email_pwd')?></span>: <br /><span class="txtgray"><?=__('email_pwd_tips')?></span></td>
	<td><input type="text" id="email_pwd" name="setting[email_pwd]" value="<?=$setting['email_pwd']?>" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('email_user')?></span>: <br /><span class="txtgray"><?=__('email_user_tips')?></span></td>
	<td><input type="text" id="email_user" name="setting[email_user]" value="<?=$setting['email_user']?>" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('email_smtp')?></span>: <br /><span class="txtgray"><?=__('email_smtp_tips')?></span></td>
	<td><input type="text" id="email_smtp" name="setting[email_smtp]" value="<?=$setting['email_smtp']?>" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('email_port')?></span>: <br /><span class="txtgray"><?=__('email_port_tips')?></span></td>
	<td><input type="text" id="email_port" name="setting[email_port]" value="<?=$setting['email_port']?>" maxlength="50"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('email_ssl')?></span>: <br /><span class="txtgray"><?=__('email_ssl_tips')?></span></td>
	<td><input type="radio" name="setting[email_ssl]" value="1" <?=ifchecked(1,$setting['email_ssl'])?>/><?=__('yes')?>
	  <input type="radio" name="setting[email_ssl]" value="0" <?=ifchecked(0,$setting['email_ssl'])?>/><?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(getId('email_address').value.strtrim().length <6 || getId('email_address').value.strtrim().indexOf('@') ==-1 || getId('email_address').value.strtrim().indexOf('.') ==-1){
		alert("<?=__('email_address_error')?>");
		getId('email_address').focus();
		return false;
	}
	if(getId('email_user').value.strtrim().length <2){
		alert("<?=__('email_user_error')?>");
		getId('email_user').focus();
		return false;
	}
	if(getId('email_pwd').value.strtrim().length <2){
		alert("<?=__('email_pwd_error')?>");
		getId('email_pwd').focus();
		return false;
	}
	if(getId('email_smtp').value.strtrim().length <6 || getId('email_smtp').value.strtrim().indexOf('.') ==-1){
		alert("<?=__('email_smtp_error')?>");
		getId('email_smtp').focus();
		return false;
	}
	if(getId('email_port').value.strtrim().length <2){
		alert("<?=__('email_port_error')?>");
		getId('email_port').focus();
		return false;
	}
}
</script>
<?php }elseif($action =='mail_test'){ ?>
<div id="container">
<h1><?=__('email_test')?><?php sitemap_tag(__('email_test')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('email_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=email&menu=user")?>" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="mail_test" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('receive_address')?>:</span></td>
	<td><input type="text" name="receive_address" value="" maxlength="50" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('mail_subject')?>:</span></td>
	<td><input type="text" name="mail_subject" value="<?=__('test_mail_subject')?>" maxlength="80" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('mail_content')?>:</span></td>
	<td><textarea name="mail_content" id="mail_content" style="width:350px;height:100px"><?=__('test_mail_content')?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('mail_content','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('mail_content','sub');">[-]</a></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" id="s1" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">
function dosubmit(o){
	if(o.receive_address.value.strtrim().length <6 || o.receive_address.value.strtrim().indexOf('@') ==-1 || o.receive_address.value.strtrim().indexOf('.') ==-1){
		alert("<?=__('email_address_error')?>");
		o.receive_address.focus();
		return false;
	}
	if(o.mail_subject.value.strtrim().length <2){
		alert("<?=__('email_subject_error')?>");
		o.mail_subject.focus();
		return false;
	}
	if(o.mail_content.value.strtrim().length <2 || o.mail_content.value.strtrim().length >255){
		alert("<?=__('email_content_error')?>");
		o.mail_content.focus();
		return false;
	}
	getId('s1').disabled = true;
}
</script>
<?php } ?>