<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-10-29 17:36:31

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_account.tpl.php 125 2014-03-05 13:10:19Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if(empty($action) || $action =='login' || $action =='relogin'){ ?>
<?php if(!$login_success){ ?>
<?php require_once template_echo('circle_box_header',$user_tpl_dir);  ?>
<div class="cboxcontent">
<h1><?=__('phpdisk_login')?></h1>
<?php 
if(count($sysmsg)){
	for($i=0;$i<count($sysmsg);$i++){
 ?>
<li><span>*</span> <?=$sysmsg[$i]?></li>
<?php 
	}
}
unset($sysmsg);
 ?>
<form name="user_form" action="<?=urr("account","")?>" method="post" onSubmit="return chkform(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="ref" value="<?=$ref?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table width="90%" border="0" cellspacing="0">
  <tbody valign="top">
  <tr>
    <td align="right" width="25%" headers="28"><?=__('username')?></td>
    <td ><em class="u_em"><input class="u_input" type="text" name="username" value="" maxlength="20" tabindex="1"></em>&nbsp;<a href="<?=urr("account","action=register")?>"><?=__('user_register')?></a>
    </td>
  </tr>
  <tr>
    <td align="right"><?=__('password')?></td>
    <td> <em class="u_em"><input class="u_input" type="password" name="password" value="" maxlength="20" tabindex="2"></em>&nbsp;<a href="<?=urr("account","action=forget_pwd")?>"><?=__('forget_pwd')?></a></td>
  </tr>
<?php if($settings['login_verycode'] && $settings['open_verycode']){ ?>  
  <tr>
    <td align="right"><?=__('verycode')?></td>
    <td><input class="verycode" tabindex="3" type="text" name="verycode" value="" size="8" maxlength="6">&nbsp;<img style="cursor:pointer" id="imgcode" alt="<?=__('refresh')?>" align="absmiddle" border="0" onclick="chg_imgcode();"/>
    </td>
  </tr>
  <script type="text/javascript">
  getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type=<?=$settings['verycode_type']?>';
  function chg_imgcode(){
  	getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type=<?=$settings['verycode_type']?>&t='+Math.random();
  }
  </script>
<?php } ?>  
  <tr>
    <td>&nbsp;</td>
    <td><input type="checkbox" id="remember" name="remember" value="1"><label for="remember" title="<?=__('warning_remember')?>"><span><?=__('remember_me')?></span></label>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td><input class="login_btn" type="submit" value="">&nbsp;&nbsp;<input type="button" class="reg_btn" value="" onClick="go('<?=urr("account","action=register")?>');" /></td>
	</tr>
  <tr>
  	<td>&nbsp;</td>
	<td>
	<?php if($settings[open_qq_fl]){ ?>
	<a href="fastlogin/qq/oauth/qq_login.php" target="_blank"><img src="fastlogin/qq/img/qq_login.png" align="absmiddle" border="0" /></a>
	<?php } ?>
	<?php if($settings[open_weibo_fl] && $auth[open_weibo]){ ?>
	<a href="fastlogin/weibo/weibo_login.php" target="_blank"><img src="fastlogin/weibo/sina_login_btn.png" align="absmiddle" border="0"/></a>
	<?php } ?>
	</td>
  </tr>
  </tbody>
</table>
</form>
<script language="javascript">
document.user_form.username.focus();
function chkform(o){
	if(o.username.value.strtrim().length <2){
		alert("<?=__('invalid_username')?>");
		o.username.focus();
		return false;
	}
	if(o.password.value.strtrim().length <6){
		alert("<?=__('invalid_password')?>");
		o.password.focus();
		return false;
	}
<?php if($settings['login_verycode'] && $settings['open_verycode']){ ?>  
	if(o.verycode.value.strtrim().length <4){
		alert("<?=__('invalid_verycode')?>");
		o.verycode.focus();
		return false;
	}
<?php } ?>	
}
</script>
<p>&nbsp;</p></div>
<?php require_once template_echo('circle_box_footer',$user_tpl_dir);  ?>
<?php } ?>

<?php }elseif($action =='adminlogin'){ ?>

<?php require_once template_echo('circle_box_header',$user_tpl_dir);  ?>
<div class="cboxcontent">
<h1><?=__('admin_login')?></h1>
<?php 
if(count($sysmsg)){
	for($i=0;$i<count($sysmsg);$i++){
 ?>
<li><span>*</span> <?=$sysmsg[$i]?></li>
<?php 
	}
}
unset($sysmsg);
 ?>
<form name="user_form" onSubmit="return chkform(this);" action="<?=urr("account","")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="ref" value="<?=$ref?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table width="90%" border="0">
  <tbody valign="top">
  <tr>
    <td align="right" width="25%"><?=__('username')?></td>
    <td><em class="u_em"><input class="u_input" tabindex="1" type="text" name="username" value="<?=$username?>" maxlength="20"></em>
    </td>
  </tr>
  <tr>
    <td align="right"><?=__('password')?></td>
    <td><em class="u_em"><input class="u_input" tabindex="2" type="password" name="password" maxlength="20"></em></td>
  </tr>
  <tr>
    <td align="right"><?=__('verycode')?></td>
    <td><input class="verycode" tabindex="3" type="text" name="verycode" value="" size="8" maxlength="6">&nbsp;<img style="cursor:pointer" id="imgcode" alt="<?=__('refresh')?>" border="0" align="absmiddle" onclick="chg_imgcode();"/>
    </td>
  </tr>
  <script type="text/javascript">
  getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type=<?=$settings['verycode_type']?>';
  function chg_imgcode(){
  	getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type=<?=$settings['verycode_type']?>&t='+Math.random();
  }
  </script>
  <tr>
    <td></td>
    <td><input class="login_btn" type="submit" value=""></td>
  </tr>
  </tbody>
</table>
</form>
<script language="javascript">
document.user_form.password.focus();
function chkform(o){
	if(o.username.value.strtrim().length <2){
		alert("<?=__('invalid_username')?>");
		o.username.focus();
		return false;
	}
	if(o.password.value.strtrim().length <6){
		alert("<?=__('invalid_password')?>");
		o.password.focus();
		return false;
	}
	if(o.verycode.value.strtrim().length <4){
		alert("<?=__('invalid_verycode')?>");
		o.verycode.focus();
		return false;
	}
}
</script>
<p>&nbsp;</p></div>
<?php require_once template_echo('circle_box_footer',$user_tpl_dir);  ?>

<?php }elseif($action =='forget_pwd'){ ?>

<?php require_once template_echo('circle_box_header',$user_tpl_dir);  ?>
<div class="cboxcontent">
<h1><?=__('forget_pwd')?></h1>
<?php 
if(count($sysmsg)){
	for($i=0;$i<count($sysmsg);$i++){
 ?>
<li><span>*</span> <?=$sysmsg[$i]?></li>
<?php 
	}
}
unset($sysmsg);
 ?>
<form name="user_form" action="<?=urr("account","")?>" method="post" onSubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table width="90%" border="0">
  <tbody valign="top">
  <tr>
    <td align="right" width="25%"><?=__('reg_username')?></td>
    <td><input class="input" type="text" name="username" value="<?=$username?>" maxlength="20">&nbsp;<span id="e1" class="txtred"></span>
    </td>
  </tr>
<?php if($settings['forget_verycode'] && $settings['open_verycode']){ ?> <tr>
    <td align="right"><?=__('verycode')?></td>
    <td><input class="verycode" type="text" name="verycode" value="" size="8" maxlength="6">&nbsp;<img style="cursor:pointer" alt="<?=__('refresh')?>" id="imgcode" border="0" align="absmiddle" onclick="chg_imgcode();" />&nbsp;<span id="e2" class="txtred"></span>
    </td>
  </tr>
  <script type="text/javascript">
  getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type=<?=$settings['verycode_type']?>';
  function chg_imgcode(){
  	getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type=<?=$settings['verycode_type']?>&t='+Math.random();
  }
  </script>
<?php } ?>  
  <tr>
  	<td>&nbsp;</td>
    <td><input class="btn" id="s1" type="submit" value="<?=__('btn_submit')?>"></td>
  </tr>
</tbody>
</table>
</form>
<script type="text/javascript">
document.user_form.username.focus();
function dosubmit(o){
	if(o.username.value.strtrim().length <2){
		getId('e1').innerText = "<?=__('username_too_short')?>";
		o.username.focus();
		return false;
	}
<?php if($settings['forget_verycode'] && $settings['open_verycode']){ ?> if(o.verycode.value.strtrim().length <4){
		getId('e2').innerText = "<?=__('invalid_verycode')?>";
		o.verycode.focus();
		return false;
	}
<?php } ?>	
	getId('s1').value = "<?=__('txt_processing')?>";
	getId('s1').disabled = true;
}
</script>
<p>&nbsp;</p></div>
<?php require_once template_echo('circle_box_footer',$user_tpl_dir);  ?>
<?php }elseif($action =='reset_pwd'){ ?>
<?php require_once template_echo('circle_box_header',$user_tpl_dir);  ?>
<div class="cboxcontent">
<h1><?=__('reset_pwd')?></h1>
<?php 
if(count($sysmsg)){
	for($i=0;$i<count($sysmsg);$i++){
 ?>
<li><span>*</span> <?=$sysmsg[$i]?></li>
<?php 
	}
}
unset($sysmsg);
 ?>
<form name="user_form" onSubmit="return dosubmit(this);" action="<?=urr("account","")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="userid" value="<?=$userid?>" />
<input type="hidden" name="code" value="<?=$code?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table width="90%" border="0">
  <tbody valign="top">
  <tr>
    <td align="right" width="25%"><?=__('password')?></td>
    <td><em class="u_em"><input class="input" type="password" name="pwd" value="" maxlength="20"></em>&nbsp;<span id="e1" class="txtred"></span>
    </td>
  </tr>
  <tr>
    <td align="right" width="25%"><?=__('confirm_password')?></td>
    <td><em class="u_em"><input class="input" type="password" name="pwd2" value="" maxlength="20"></em>&nbsp;<span id="e2" class="txtred"></span>
    </td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td><input class="btn" type="submit" value="<?=__('btn_submit')?>" <?=$disabled?>></td>
  </tr>
</tbody>
</table>
</form>
<script type="text/javascript">
document.user_form.pwd.focus();
function dosubmit(o){
	if(o.pwd.value.strtrim().length <6){
		getId('e1').innerText = "<?=__('password_too_short')?>";
		o.pwd.focus();
		return false;
	}
	if(o.pwd2.value.strtrim() != o.pwd.value.strtrim()){
		getId('e2').innerText = "<?=__('confirm_password_invalid')?>";
		o.pwd2.focus();
		return false;
	}
}
</script>
<p>&nbsp;</p></div>
<?php require_once template_echo('circle_box_footer',$user_tpl_dir);  ?>

<?php }elseif($action =='register' && $settings['allow_register']){ ?>
<?php require_once template_echo('circle_box_header',$user_tpl_dir);  ?>
<div class="cboxcontent">
<h1><?=__('phpdisk_register')?></h1>
<?php 
if(count($sysmsg)){
	for($i=0;$i<count($sysmsg);$i++){
 ?>
<li><span>*</span> <?=$sysmsg[$i]?></li>
<?php 
	}
}
unset($sysmsg);
 ?>
<form name="user_form" onSubmit="return chkform(this);" action="<?=urr("account","")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="invite_uid" value="<?=$invite_uid?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table width="90%" border="0">
  <tbody valign="top">
  <tr>
    <td width="25%" align="right"><?=__('reg_username')?></td>
    <td><em class="u_em"><input class="u_input" tabindex="1" type="text" name="username" id="r_username" value="<?=$username?>" maxlength="20" onblur="chk_username();"></em>&nbsp;<span class="txtred" id="e_username">*</span>
    </td>
  </tr>
  <tr>
    <td align="right"><?=__('password')?></td>
    <td><em class="u_em"><input class="u_input" tabindex="2" type="password" name="password" maxlength="20"></em>&nbsp;<span class="txtred">*</span></td>
  </tr>
  <tr>
    <td align="right"><?=__('confirm_password')?></td>
    <td><em class="u_em"><input class="u_input" tabindex="3" type="password" name="confirm_password" maxlength="20"></em>&nbsp;<span class="txtred">*</span></td>
  </tr>
  <tr>
    <td align="right"><?=__('email')?></td>
    <td><em class="u_em"><input class="u_input" tabindex="4" type="text" name="email" id="r_email" value="<?=$email?>" maxlength="50"></em>&nbsp;<span class="txtred" id="e_email">*</span>
    </td>
  </tr>
  <tr>
    <td align="right">联系QQ</td>
    <td><em class="u_em"><input class="u_input" tabindex="6" type="text" name="qq" maxlength="50"></em><span class="txtgray">(选填)</span></td>
  </tr>
  <tr>
    <td align="right">推荐人</td>
    <td><em class="u_em"><input class="u_input" tabindex="7" type="text" name="buddy_name" maxlength="50"></em><span class="txtgray">(选填)</span></td>
  </tr>
<?php if($settings['register_verycode'] && $settings['open_verycode']){ ?> <tr>
    <td align="right"><?=__('verycode')?></td>
    <td><input class="verycode" tabindex="8" type="text" name="verycode" value="" size="8" maxlength="6">&nbsp;<img style="cursor:pointer" id="imgcode" alt="<?=__('refresh')?>" border="0" align="absmiddle" onclick="chg_imgcode();" />&nbsp;<span class="txtred">*</span>
    </td>
  </tr>
  <script type="text/javascript">
  getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type=<?=$settings['verycode_type']?>';
  function chg_imgcode(){
  	getId('imgcode').src = 'includes/imgcode.inc.php?verycode_type=<?=$settings['verycode_type']?>&t='+Math.random();
  }
  </script>
<?php } ?>  
  <tr>
    <td></td>
    <td><input type="submit" class="reg_btn" value=""/>&nbsp;&nbsp;<a href="<?=urr("account","action=login")?>"><?=__('already_register')?></a></td>
  </tr>
  </tbody>
</table>
</form>
<script language="javascript">
function chk_username(){
	var r_username = getId('r_username').value.strtrim();
	$('#e_username').removeClass();
	$.ajax({
		type : 'post',
		url : 'ajax.php',
		data : 'action=chk_username&r_username='+r_username+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){	
			var arr = msg.split('|');
			if(arr[0]=='true'){
				$('#e_username').html(arr[1]);
				$('#e_username').addClass('txtgreen');
			}else{
				$('#e_username').html(msg);
				$('#e_username').addClass('txtred');
			}
		},
		error:function(){
		}

	});
}
function chk_email(){
	var r_email = getId('r_email').value.strtrim();
	$('#e_email').removeClass();
	$.ajax({
		type : 'post',
		url : 'ajax.php',
		data : 'action=chk_email&r_email='+r_email+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){	
			var arr = msg.split('|');
			if(arr[0]=='true'){
				$('#e_email').addClass('txtgreen');
				$('#e_email').html(arr[1]);
			}else{
				$('#e_email').addClass('txtred');
				$('#e_email').html(msg);
			}
		},
		error:function(){
		}

	});
}

<?php if($reg_success ==1){ ?>
function go_login(){
	document.location.href = '<?=urr("account","action=login")?>';
}
setTimeout('go_login();',2000);
<?php } ?>
document.user_form.username.focus();
function chkform(o){
	if(o.username.value.strtrim().length <2){
		alert("<?=__('username_too_short')?>");
		o.username.focus();
		return false;
	}
	if(o.password.value.strtrim().length <6){
		alert("<?=__('password_too_short')?>");
		o.password.focus();
		return false;
	}
	if(o.confirm_password.value.strtrim() != o.password.value.strtrim()){
		alert("<?=__('confirm_password_invalid')?>");
		o.password.focus();
		return false;
	}
	if(o.email.value.strtrim().length <6 || o.email.value.strtrim().indexOf('@') ==-1 || o.email.value.strtrim().indexOf('.') ==-1){
		alert("<?=__('invalid_email')?>");
		o.email.focus();
		return false;
	}
<?php if($settings['register_verycode'] && $settings['open_verycode']){ ?> if(o.verycode.value.strtrim().length <4){
		alert("<?=__('invalid_verycode')?>");
		o.verycode.focus();
		return false;
	}
<?php } ?>	
}
</script>
<p>&nbsp;</p></div>
<?php require_once template_echo('circle_box_footer',$user_tpl_dir);  ?>

<?php }elseif($action == 'demologin' && !$settings['open_demo_login']){ ?>
<?php require_once template_echo('circle_box_header',$user_tpl_dir);  ?>
<div class="cboxcontent">
<h1><?=__('system_message')?></h1>
<?php 
if(count($sysmsg)){
	for($i=0;$i<count($sysmsg);$i++){
 ?>
<li><span>*</span> <?=$sysmsg[$i]?></li>
<?php 
	}
}
unset($sysmsg);
 ?>
<p>&nbsp;</p></div>
<?php require_once template_echo('circle_box_footer',$user_tpl_dir);  ?>

<?php }else{ ?>
<?php require_once PHPDISK_ROOT."modules/front_msg.inc.php"; ?>
<?php } ?>
