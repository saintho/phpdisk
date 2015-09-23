<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2014-04-29 00:37:03

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: users.tpl.php 126 2014-03-17 07:51:04Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<?php if($action =='nodownline' && $auth[open_downline2]){ ?>
<div id="container">
<h1>独立的用户</h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray">您可以指定独立用户给其他的用户作为其下线用户</span>
</div>
<form action="<?=urr(ADMINCP,"item=users&menu=user")?>" name="user_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="change" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<?php 
if(count($users)){
 ?>
<tr>
	<td width="30%" class="bold"><?=__('user_name')?></td>
	<td class="bold"><?=__('user_email')?></td>
	<td align="center" width="150" class="bold">注册IP</td>
	<td align="center" width="150" class="bold"><?=__('reg_time')?></td>
</tr>
<?php 
	foreach($users as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td>
	<input type="checkbox" name="userids[]" id="userids" value="<?=$v['userid']?>"  /> 
	<a href="<?=$v['a_user_edit']?>"><?=$v['username']?></a></td>
	<td><?=$v['email']?></td>
	<td align="center" class="txtgray"><?=$v['reg_ip']?></td>
	<td align="center" class="txtgray"><?=$v['reg_time']?></td>
</tr>	
<?php 
	}
	unset($users);
 ?>
<tr>
	<td colspan="6"><a href="javascript:void(0);" onclick="reverse_ids(document.user_form.userids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.user_form.userids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	指定给：<input type="text" name="dist_name" value="" maxlength="30"/>&nbsp;&nbsp;<input type="submit" class="btn" value="<?=__('btn_submit')?>"/>
	</td>
</tr>
<?php 	
}else{	
 ?>
<tr>
	<td align="center" colspan="6"><?=__('user_not_found')?></td>
</tr>
<?php 
}
 ?>
<?php if($page_nav){ ?>
<tr>
	<td colspan="6"><?=$page_nav?></td>
</tr>
<?php } ?>
</table>
</form>
</div>
</div>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("userids[]") != true){
		alert("请选择要操作的用户");
		return false;
	}
	if(o.dist_name.value.strtrim() ==''){
		alert("请填写指定下线的目标用户");
		o.dist_name.focus();
		return false;
	}
}
</script>

<?php }elseif($action =='fastlogin'){ ?>
<div id="container">
<h1><?=__('user_fastlogin')?><?php sitemap_tag(__('user_fastlogin')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_fastlogin_tips')?></span>
</div>
<form action="<?=urr(ADMINCP,"item=users&menu=user")?>" name="user_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="fastlogin" />
<input type="hidden" name="task" value="fastlogin" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><span class="bold"><?=__('open_qq_fl')?></span>: <br /><span class="txtgray"><?=__('open_qq_fl_tips')?></span></td>
	<td><input type="radio" name="setting[open_qq_fl]" value="1" <?=ifchecked(1,$settings['open_qq_fl'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_qq_fl]" value="0" <?=ifchecked(0,$settings['open_qq_fl'])?>/> <?=__('no')?>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('fl_qq_appid')?></span>: <br /><span class="txtgray"><?=__('fl_qq_appid_tips')?></span></td>
	<td><input type="text" name="setting[fl_qq_appid]" value="<?=$settings['fl_qq_appid']?>" size="40" maxlength="100"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('fl_qq_appkey')?></span>: <br /><span class="txtgray"><?=__('fl_qq_appkey_tips')?></span></td>
	<td><input type="text" name="setting[fl_qq_appkey]" value="<?=$settings['fl_qq_appkey']?>" size="40" maxlength="100"/></td>
</tr>
<?php if($auth[open_weibo]){ ?>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><span class="bold"><?=__('open_weibo_fl')?></span>: <br /><span class="txtgray"><?=__('open_weibo_fl_tips')?></span></td>
	<td><input type="radio" name="setting[open_weibo_fl]" value="1" <?=ifchecked(1,$settings['open_weibo_fl'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_weibo_fl]" value="0" <?=ifchecked(0,$settings['open_weibo_fl'])?>/> <?=__('no')?>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('fl_weibo_appid')?></span>: <br /><span class="txtgray"><?=__('fl_weibo_appid_tips')?></span></td>
	<td><input type="text" name="setting[fl_weibo_appid]" value="<?=$settings['fl_weibo_appid']?>" size="40" maxlength="100"/></td>
</tr>
<tr>
	<td><span class="bold"><?=__('fl_weibo_appkey')?></span>: <br /><span class="txtgray"><?=__('fl_weibo_appkey_tips')?></span></td>
	<td><input type="text" name="setting[fl_weibo_appkey]" value="<?=$settings['fl_weibo_appkey']?>" size="40" maxlength="100"/></td>
</tr>
<?php } ?>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/></td>
</tr>
</table>
</form>
</div>
</div>

<?php }elseif($action =='index' || $action =='search'){ ?>
<div id="container">
<h1><?=__('user_list')?><?php sitemap_tag(__('user_list')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_list_tips')?></span>
</div>
<form name="search_frm" action="<?=urr(ADMINCP,"")?>" method="get" onsubmit="return dosearch(this);">
<input type="hidden" name="item" value="users" />
<input type="hidden" name="menu" value="<?=$menu?>" />
<input type="hidden" name="action" value="search" />
<div class="search_box">
<div class="l"><img src="<?=$admin_tpl_dir?>images/it_nav.gif" align="absbottom" /><?=__('view_group_type')?>: 
<select id="gid" onchange="chg_gid();">
<option value="0" class="txtgreen" <?=ifselected(0,$gid);?>><?=__('all_users')?></option>
<?php 
if(count($groups)){
	foreach($groups as $v){
 ?>
<option value="<?=$v['gid']?>" class="<?=$v['txtcolor']?>" <?=ifselected($v['gid'],$gid);?>><?=$v['group_name']?></option>
<?php 
	}
	unset($groups);
}
 ?>
</select>&nbsp;
<?=__('view_mode')?>: 
<select id="orderby" onchange="chg_orderby();">
<option value="0" class="txtgreen"><?=__('please_select')?></option>
<option value="credit_asc" <?=ifselected('credit_asc',$orderby,'str');?>><?=__('credit_asc')?></option>
<option value="credit_desc" <?=ifselected('credit_desc',$orderby,'str');?>><?=__('credit_desc')?></option>
<option value="time_asc" <?=ifselected('time_asc',$orderby,'str');?>><?=__('time_asc')?></option>
<option value="time_desc" <?=ifselected('time_desc',$orderby,'str');?>><?=__('time_desc')?></option>
<option value="is_locked" <?=ifselected('is_locked',$orderby,'str');?>><?=__('is_locked')?></option>
</select>
</div>
<div class="r"><input type="text" name="word" value="<?=$word?>" title="<?=__('search_users_tips')?>" />
<select name="o_type">
<option value="username" <?=ifselected('username',$o_type,'str')?>>用户名</option>
<option value="email" <?=ifselected('email',$o_type,'str')?>>E-mail</option>
</select>
 <input type="submit" class="btn" value="<?=__('search_users')?>" /></div>
</div>
</form>
<div class="clear"></div>
<script language="javascript">
function chg_gid(){
	var gid = parseInt(getId('gid').value);
	document.location.href = '<?=urr(ADMINCP,"item=users&menu=user&action=index&gid='+gid+'")?>';
}
function chg_orderby(){
	var orderby = getId('orderby').value.strtrim();
	var gid = parseInt(getId('gid').value);
	document.location.href = '<?=urr(ADMINCP,"item=users&menu=user&action=index&gid='+gid+'&orderby='+orderby+'")?>';
}
function dosearch(o){
	if(o.word.value.strtrim().length <1){
		o.word.focus();
		return false;
	}
}
</script>
<form action="<?=urr(ADMINCP,"item=users&menu=user")?>" name="user_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="index" />
<input type="hidden" name="task" value="move" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<?php 
if(count($users)){
 ?>
<tr>
	<td width="30%" class="bold"><?=__('user_name')?> / <?=__('now_money')?></td>
	<td class="bold"><?=__('other_info')?></td>
	<td align="center" width="80" class="bold"><?=__('user_group')?></td>
	<td align="center" width="80" class="bold">注册IP</td>
	<td align="center" width="150" class="bold"><?=__('reg_time')?></td>
	<td align="center" class="bold"><?=__('operation')?></td>
</tr>
<?php 
	foreach($users as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td>
	<?php if($v['is_admin']){ ?>
	<input type="checkbox" disabled="disabled"  />
	<?php }else{ ?>
	<input type="checkbox" name="userids[]" id="userids" value="<?=$v['userid']?>"  /> 
	<?php } ?>
	<a href="<?=$v['a_user_edit']?>"><?=$v['username']?></a> <span class="txtgray" title="<?=__('credit')?>"><?=$v['wealth']?></span>
	<a href="<?=urr("splogin","username=".rawurlencode($v[username]))?>" target="_blank"><?=__('sp_login')?></a>
	</td>
	<td>
	<?=$v['email']?><br />
	</td>
	<td align="center"><?=$v['group_name']?></td>
	<td align="center"><?=$v['reg_ip']?></td>
	<td align="center" class="txtgray"><?=$v['reg_time']?></td>
	<td align="center">
	<a href="<?=$v['a_user_edit']?>" id="p_<?=$k?>"><img src="images/menu_edit.gif" align="absmiddle" border="0" /></a>
	<div id="c_<?=$k?>" class="menu_box2 menu_common">
	<a href="<?=$v['a_user_viewfile']?>"><?=__('view')?></a>	
	<?php if(!$v['is_admin']){ ?>
	<a href="<?=$v['a_user_lock']?>"><?=$v['status_text']?></a>
	<a href="<?=$v['a_user_delete']?>" onclick="return confirm('<?=__('user_delete_confirm')?>');"><?=__('delete')?></a>
	<?php } ?>
	</div>
	<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','-x','');</script>
	</td>
</tr>	
<tr class="<?=$color?>">
	<td colspan="6">
		<?=__('credit')?>: <?=$v[credit]?><?php if($auth[open_discount]){ ?><?=$v[credit_dis]?><?php } ?>
	</td>
</tr>	
<?php 
	}
	unset($users);
 ?>
<tr>
	<td colspan="6"><a href="javascript:void(0);" onclick="reverse_ids(document.user_form.userids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.user_form.userids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<?=__('move_to')?>: 
	<select name="dest_gid">
	<option value="0" class="txtgreen"><?=__('please_select')?></option>
	<?php 
	if(count($mini_groups)){
		foreach($mini_groups as $v){
	 ?>
	<option value="<?=$v['gid']?>" class="<?=$v['txtcolor']?>"><?=$v['group_name']?></option>
	<?php 
		}
		unset($mini_groups);
	}
	 ?>
	</select>&nbsp;&nbsp;<input type="submit" class="btn" value="<?=__('btn_submit')?>"/>
	</td>
</tr>
<?php 	
}else{	
 ?>
<tr>
	<td align="center" colspan="6"><?=__('user_not_found')?></td>
</tr>
<?php 
}
 ?>
<?php if($page_nav){ ?>
<tr>
	<td colspan="6"><?=$page_nav?></td>
</tr>
<?php } ?>
</table>
</form>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("userids[]") != true){
		alert("<?=__('please_select_move_users')?>");
		return false;
	}
	if(o.dest_gid.value ==0){
		alert("<?=__('please_select_dest_gid')?>");
		o.dest_gid.focus();
		return false;
	}
}
</script>
</div>
</div>
<?php }elseif($action =='add_user'){ ?>
<div id="container">
<h1><?=__('add_user')?><?php sitemap_tag(__('add_user')); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('add_user_tips')?></span>
</div>
<form name="user_frm" action="<?=urr(ADMINCP,"item=users&menu=user")?>" method="post" onsubmit="return dosubmit1(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%" class="bold"><?=__('user_name')?> :</td>
	<td><input type="text" name="username" value="" maxlength="20" /> <span class="txtred">*</span></td>
</tr>
<tr>
	<td class="bold"><?=__('user_passwd')?> :</td>
	<td><input type="password" name="password" value="" maxlength="20" /> <span class="txtred">*</span></td>
</tr>
<tr>
	<td class="bold"><?=__('confirm_passwd')?> :</td>
	<td><input type="password" name="confirm_password" value="" maxlength="20" /> <span class="txtred">*</span></td>
</tr>
<tr>
	<td class="bold"><?=__('user_email')?> :</td>
	<td><input type="text" name="email" value="" maxlength="50" /> <span class="txtred">*</span></td>
</tr>
<tr>
	<td class="bold">QQ :</td>
	<td><input type="text" name="qq" value="" maxlength="50" /></td>
</tr>
<tr>
	<td class="bold"><?=__('user_group')?> :</td>
	<td>
	<select name="gid">
	<?php 
	if(count($groups)){
		foreach($groups as $v){
	 ?>
	<option value="<?=$v['gid']?>" class="<?=$v['txtcolor']?>" <?=ifselected($v['gid'],$default_gid)?>><?=$v['group_name']?></option>
	<?php 
		}
	}
	unset($groups);
	 ?>
	</select>
	</td>
</tr>
<tr>
	<td class="bold"><?=__('user_status')?> :</td>
	<td><input type="radio" name="is_locked" id="lock" value="1" /><label for="lock"><?=__('user_locked')?></label>&nbsp;
	<input type="radio" name="is_locked" id="open" value="0" checked/><label for="open"><?=__('user_open')?></label></td>
</tr>
<tr>
	<td class="bold"><?=__('active_user')?> :</td>
	<td><input type="radio" name="is_activated" id="ia1" value="1" /><label for="ia1"><?=__('yes')?></label>&nbsp;
	<input type="radio" name="is_activated" id="ia2" value="0" checked/><label for="ia2"><?=__('no')?></label></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_credit')?> :</span><br /><span class="txtgray"><?=__('user_credit_tips')?></span></td>
	<td><input type="text" name="credit" value="<?=$settings['credit_reg']?>" size="10" maxlength="10" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_wealth')?> :</span><br /><span class="txtgray"><?=__('user_wealth_tips')?></span></td>
	<td><input type="text" name="wealth" value="0" size="10" maxlength="10" /></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_income_rate')?>:</span><br /><span class="txtgray"><?=__('user_income_rate_tips')?></span></td>
	<td><input type="text" name="how_downs" value="" size="3" maxlength="6" /><?=__('credit')?>
	<input type="text" name="how_money" value="" size="3" maxlength="6" /><?=__('currency_unit')?>
	</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" class="btn" id="s1" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn"  onclick="javascript:history.back();" value="<?=__('btn_back')?>" /></td>
</tr>
</table>
</form>
<script language="javascript">
function dosubmit(o){
	if(o.username.value.strtrim().length <2){
		alert("<?=__('username_error')?>");
		o.username.focus();
		return false;
	}
	if(o.password.value.strtrim().length <6 || o.password.value.strtrim().length >20){
		alert("<?=__('password_error')?>");
		o.password.focus();
		return false;
	}
	if(o.password.value.strtrim() != o.confirm_password.value.strtrim()){
		alert("<?=__('confirm_pwd_not_same')?>");
		o.confirm_password.focus();
		return false;
	}
	if(o.email.value.strtrim() <6 || o.email.value.strtrim().indexOf('@') ==-1 || o.email.value.strtrim().indexOf('.') ==-1){
		alert("<?=__('invalid_email')?>");
		o.email.focus();
		return false;
	}
	getId('s1').disabled = true;
	getId('s1').value = "<?=__('txt_processing')?>";
	
}
</script>
</div>
</div>
<?php }elseif($action =='user_edit'){ ?>
<div id="container">
<h1><?=__('user_edit')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_edit_tips')?></span>
</div>
<form name="user_frm" action="<?=urr(ADMINCP,"item=users&menu=user")?>" method="post" onsubmit="return doedit(this);">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="<?=$action?>" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<input type="hidden" name="uid" value="<?=$uid?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td class="bold"><?=__('uid')?> :</td>
	<td><?=$uid?></td>
</tr>
<tr>
	<td width="50%" class="bold"><?=__('user_name')?> :</td>
	<td><?=$user['username']?></td>
</tr>
<?php if($auth[open_subdomain] && $settings['open_domain']){ ?>
<tr>
	<td class="bold">用户二级域名 :</td>
	<td><a href="http://<?=$user['domain']?><?=$settings[suffix_domain]?>" target="_blank">http://<?=$user['domain']?><?=$settings[suffix_domain]?></a></td>
</tr>
<?php } ?>
<tr>
	<td class="bold"><?=__('user_passwd')?> :</td>
	<td><input type="text" name="password" value="" maxlength="20" /> <span class="txtgray"><?=__('pwd_tips')?></span></td>
</tr>
<tr>
	<td class="bold">提现密码 :</td>
	<td><input type="text" name="income_pwd" value="" maxlength="30" /> <span class="txtgray"><?=__('pwd_tips')?></span></td>
</tr>
<tr>
	<td class="bold"><?=__('email')?> :</td>
	<td><input type="text" name="email" value="<?=$user['email']?>" maxlength="50" /></td>
</tr>
<tr>
	<td class="bold">QQ :</td>
	<td><input type="text" name="qq" value="<?=$user['qq']?>" maxlength="50" /></td>
</tr>
<tr>
	<td class="bold"><?=__('user_group')?> :</td>
	<td>
	<select name="gid">
	<?php 
	if(count($groups)){
		foreach($groups as $v){
	 ?>
	<option value="<?=$v['gid']?>" class="<?=$v['txtcolor']?>" <?=ifselected($v['gid'],$user['gid']);?>><?=$v['group_name']?></option>
	<?php 
		}
	}
	unset($groups);
	 ?>
	</select>
	</td>
</tr>
<tr>
	<td class="bold"><?=__('user_status')?> :</td>
	<td><input type="radio" name="is_locked" id="lock" value="1" <?=ifchecked($user['is_locked'],1)?> /><label for="lock"><?=__('user_locked')?></label>&nbsp;
	<input type="radio" name="is_locked" id="open" value="0" <?=ifchecked($user['is_locked'],0)?> /><label for="open"><?=__('user_open')?></label></td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_wealth')?> :</span><br /><span class="txtgray"><?=__('user_wealth_tips')?></span></td>
	<td><input type="text" name="wealth" value="<?=$user['wealth']?>" size="10" maxlength="10" /></td>
</tr>
<?php if($auth[open_user_select]){ ?>
<tr>
	<td class="bold"><?=__('user_curr_plan')?> :</td>
	<td>
	<select name="plan_id">
		<option value="0"><?=__('none_plan')?></option>

	<?php 
	if(count($plans)){
		foreach($plans as $v){
	 ?>
	<option value="<?=$v['plan_id']?>" <?=ifselected($v['plan_id'],$user['plan_id']);?>><?=$v['subject']?></option>
	<?php 
		}
	}
	unset($plans);
	 ?>
	</select>
	</td>
</tr>
<?php }else{ ?>
<tr>
	<td><span class="bold"><?=__('user_curr_plans')?>:</span><br /><span class="txtgray"><?=__('user_curr_plans_tips')?></span></td>
	<td><?=$user[plan_subject]?></td>
</tr>
<?php } ?>
<tr>
	<td><span class="bold"><?=__('income_item')?>:</span></td>
	<td>	
	<?=__('user_credit')?>：<input type="text" name="credit" value="<?=$myinfo['credit']?>" size="10" maxlength="10" />
		<?php if($auth[open_discount]){ ?><span class="txtred" title="<?=__('discount_show')?>"><?=get_discount($user[userid],$myinfo[credit])?></span>&nbsp;<?php } ?>
	
	<?=__('downline_credit')?>：<input type="text" name="dl_credit" value="<?=$myinfo['dl_credit']?>" size="10" maxlength="10" />
	<?php if($auth[open_downline2]){ ?>二级下线积分：<input type="text" name="dl_credit2" value="<?=$myinfo['dl_credit2']?>" size="10" maxlength="10" /><?php } ?>
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_income_rate')?>:</span><br /><span class="txtgray"><?=__('user_income_rate_tips')?></span></td>
	<td>
	<?php if($user[plan_id]){ ?>
	<div class="msg_tips"><img src="images/light.gif" align="baseline" border="0" /><?=__('join_plans_cannot_modify_rate')?></div>
	<?php } ?>
	<?=__('credit')?>：<input type="text" name="how_downs_credit" value="<?=$myinfo['credit_a']?>" size="3" maxlength="6" <?=$user[readonly]?> />==
	<input type="text" name="how_money_credit" value="<?=$myinfo['credit_b']?>" size="3" maxlength="6" <?=$user[readonly]?>/><?=__('currency_unit')?>&nbsp;&nbsp;
	<?php if($curr_credit_rate){ ?><span class="txtred"><?=__('rate_set')?>:<?=$curr_credit_rate?></span><?php } ?><br />
	</td>
</tr>
<?php if($auth[open_discount]){ ?>
<tr>
	<td><span class="bold"><?=__('user_discount_rate')?>:</span><br /><span class="txtgray"><?=__('user_discount_rate_tips')?></span></td>
	<td>
	<input type="text" name="discount_rate" value="<?=$user[discount_rate]?>" size="5" maxlength="3" />%&nbsp;&nbsp;
	<?php if($curr_discount_rate){ ?><span class="txtred"><?=__('curr_user_discount_rate')?>:<?=$curr_discount_rate?></span><?php } ?>&nbsp;&nbsp;
	<?php if($add_discount){ ?><span class="txtblue"><?=__('edit_user_discount_rate_credit')?>:<?=$add_discount?></span><?php } ?>
	<br />
	</td>
</tr>
<?php } ?>
<tr>
	<td><span class="bold"><?=__('downline_income_rate')?> :</span><br /><span class="txtgray"><?=__('downline_income_rate_tips')?></span></td>
	<td>
	<input type="text" name="downline_income" value="<?=$user[downline_income]?>" size="5" maxlength="3" />&nbsp;&nbsp;
	<?php if($curr_downline_rate){ ?><span class="txtred"><?=__('rate_set')?>:<?=$curr_downline_rate?></span><?php } ?><br />
	</td>
</tr>
<?php if($auth[open_downline2]){ ?>
<tr>
	<td><span class="bold">二级下线佣金 :</span><br /><span class="txtgray">设定二级下线提成佣金，百分之x ，只需要填写x 即可。</span></td>
	<td>
	<input type="text" name="downline_income2" value="<?=$user[downline_income2]?>" size="5" maxlength="3" />%&nbsp;&nbsp;
	<?php if($curr_downline_rate2){ ?><span class="txtred"><?=__('rate_set')?>:<?=$curr_downline_rate2?></span><?php } ?><br />
	</td>
</tr>
<?php } ?>
<?php if($auth[space_pwd]){ ?>
<tr>
	<td><span class="bold">网盘空间访问密码 :</span></td>
	<td>
	<input type="text" name="space_pwd" value="<?=$user[space_pwd]?>" maxlength="30" />
	</td>
</tr>
<?php } ?>
<tr>
	<td class="bold"><?=__('open_custom_stats')?> :</td>
	<td><input type="radio" name="open_custom_stats" value="1" <?=ifchecked($user['open_custom_stats'],1)?> /><?=__('yes')?>&nbsp;
	<input type="radio" name="open_custom_stats" value="0" <?=ifchecked($user['open_custom_stats'],0)?> /><?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold">审核通过统计代码 :</span><br /><span class="txtgray">第三方统计代码，可存在安全问题，只能由管理员审核通过后才能使用。</span></td>
	<td>
	<textarea name="stat_code" id="stat_code" cols="50" rows="10" style="width:400px;height:90px" ondblclick="resize_textarea('stat_code','expand');"><?=$user[stat_code]?></textarea>
	<a href="javascript:void(0);" onclick="resize_textarea('stat_code','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('stat_code','sub');">[-]</a><br />
	<input type="radio" name="check_custom_stats" value="1" <?=ifchecked($user['check_custom_stats'],1)?> /><?=__('yes')?>&nbsp;
	<input type="radio" name="check_custom_stats" value="0" <?=ifchecked($user['check_custom_stats'],0)?> /><?=__('no')?></td>
<tr>
	<td class="bold">网赚计划最后变更时间 :</td>
	<td><?=date('Y-m-d H:i:s',$user[plan_conv_time])?></td>
</tr>
<?php if($auth[buy_vip_a] || $auth[buy_vip_p]){ ?>
<tr>
	<td class="bold"><?=__('user_curr_vip')?> :</td>
	<td>
	<select name="vip_id">
		<option value="0"><?=__('no_vip')?></option>
	<?php 
	if(count($vips)){
		foreach($vips as $v){
	 ?>
	<option value="<?=$v['vip_id']?>" <?=ifselected($v['vip_id'],$user['vip_id']);?>><?=$v['subject']?></option>
	<?php 
		}
	}
	unset($vips);
	 ?>
	</select>&nbsp;<?=__('vip_end_time')?>: <input type="text" name="vip_end_time" value="<?=$vip_end_time_txt?>" />
	</td>
</tr>
<?php } ?>
<tr>
	<td><span class="bold"><?=__('downline_user')?> :</span><br /><span class="txtgray"><?=__('downline_user_tips')?></span></td>
	<td>
	<?php 
	if(count($buddy_list)){
		foreach($buddy_list as $v){
	 ?>	
	<a href="<?=$v['a_user_edit']?>"><?=$v['username']?></a>&nbsp;,&nbsp;
	<?php 
		}
		unset($buddy_list);
	}else{	
	 ?>
	<?=__('not_set')?>
	<?php 
	}
	 ?>	
	</td>
</tr>
<tr>
	<td><span class="bold"><?=__('user_income_account')?> :</span></td>
	<td>
	<?=__('account_type')?>：<?=$myinfo['income_type']?><br />
	<?=__('account_name')?>：<?=$myinfo['income_name']?><br />
	<?=__('income_account')?>：<?=$myinfo['income_account']?>
	</td>
</tr>
<?php if($auth[pd_a]){ ?>
<tr>
	<td><span class="bold">个人空间SEO标题</span>:</td>
	<td><textarea id="meta_title" name="meta_title" style="width:500px;height:60px"><?=$s['title']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_title','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_title','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">个人空间SEO关键字</span>:</td>
	<td><textarea id="meta_keywords" name="meta_keywords" style="width:500px;height:60px"><?=$s['keywords']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_keywords','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_keywords','sub');">[-]</a>
	</td>
</tr>
<tr>
	<td><span class="bold">个人空间SEO描述</span>: </td>
	<td><textarea id="meta_description" name="meta_description" style="width:500px;height:60px"><?=$s['description']?></textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('meta_description','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('meta_description','sub');">[-]</a>
	</td>
</tr>
<?php } ?>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_update')?>"/>&nbsp;&nbsp;<input type="button" class="btn"  onclick="javascript:history.back();" value="<?=__('btn_back')?>" /></td>
</tr>
</table>
</form>
<script language="javascript">
function doedit(o){
	if(o.email.value.strtrim() <6 || o.email.value.strtrim().indexOf('@') ==-1 || o.email.value.strtrim().indexOf('.') ==-1){
		alert("<?=__('invalid_email')?>");
		o.email.focus();
		return false;
	}
}
</script>
</div>
</div>
<?php }elseif($action=='credit_log'){ ?>
<div id="container">
<h1>收入日志<?php sitemap_tag('收入日志'); ?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray">您可以查看用户的积分收入报表</span>
</div>
<form action="<?=urr(ADMINCP,"item=users&menu=user")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>"/>
<input type="hidden" name="task" value="update"/>
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold">用户中心是否显示积分日志</span>: </td>
	<td><input type="radio" name="setting[show_credit_log]" value="1" <?=ifchecked(1,$settings['show_credit_log'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[show_credit_log]" value="0" <?=ifchecked(0,$settings['show_credit_log'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold">系统是否记录积分日志</span>:<br /><span class="txtgray">记录积分日志可以详细地了解整个系统的用户文件下载情况，但是会占用一部分系统数据库性能，如果不需要可以关闭。</span> </td>
	<td><input type="radio" name="setting[close_credit_log]" value="1" <?=ifchecked(1,$settings['close_credit_log'])?> /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[close_credit_log]" value="0" <?=ifchecked(0,$settings['close_credit_log'])?>/> <?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
<br />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td colspan="10" class="f14 txtblue">
	<?php if($userid){ ?>
	当前用户：<u><?=get_profile($userid,'username')?></u> 
	<?php }else{ ?>
	全部用户
	<?php } ?>
	的收入记录 ，
	【积分行为：
	<a href="<?=urr(ADMINCP,"item=users&menu=user&action=credit_log&task=&userid=$userid")?>" id="n_">全部</a>&nbsp;
	<a href="<?=urr(ADMINCP,"item=users&menu=user&action=credit_log&task=ref&userid=$userid")?>" id="n_ref">来路</a>&nbsp;
	<a href="<?=urr(ADMINCP,"item=users&menu=user&action=credit_log&task=download&userid=$userid")?>" id="n_download">下载</a>&nbsp;】&nbsp;
	共有日志： <span class="txtblue bold"><?=$log_count?></span> 条
	<script type="text/javascript">getId('n_<?=$task?>').className='sel_a';</script>
	</td>
</tr>
<tr>
	<td colspan="10">删除<input type="text" id="log_day" />天前的日志<input type="button" onclick="adm_del_log();" class="btn" value="提交" />&nbsp;<span id="sloading" class="txtblue"></span></td>
</tr>
<script language="javascript">
function adm_del_log(){
	var val = getId('log_day').value.strtrim();
	$('#sloading').html('<img src="images/ajax_loading.gif" align="absmiddle" border="0" />loading...');
	$('#sloading').show();
	$.ajax({
		type : 'post',
		url : 'adm_ajax.php',
		data : 'action=adm_del_log&log_day='+val+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			var arr = msg.split('|');
			if(arr[0] == 'true'){
				$('#sloading').html(arr[1]);
				document.location.reload();
			}else{
				$('#sloading').hide();
				alert(msg);
			}
		},
		error:function(){
		}

	});
}
</script>
<?php 
if(count($orders)){
 ?>
<tr>
	<td width="50%" class="bold">收入文件</td>
	<td class="bold">积分行为</td>
	<td class="bold">所属用户</td>
	<td class="bold" align="center">获得积分</td>
	<td class="bold">收入时间</td>
	<td class="bold">IP</td>
</tr>
<?php 
	foreach($orders as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td class="bw"><a href="<?=$settings[phpdisk_url]?><?=urr("viewfile","file_id=$v[file_id]")?>" target="_blank"><?=file_icon($v[file_extension])?><?=$v[file_name]?></a>
	<?php if($v[ref]){ ?>
	<br /><span id="ref_<?=$k?>" style="display:none">来路：<a href="<?=$v[ref]?>" target="_blank"><?=$v[ref]?></a></span>
	<?php } ?>
	</td>
	<td>
	<?php if($v[ref]){ ?>
	<span class="txtblue" onclick="rtn_display_status('ref_<?=$k?>');" title="查看来路" style="cursor:pointer"><?=$v[action]?></span>
	<?php }else{ ?>
	<?=$v[action]?>
	<?php } ?>
	</td>
	<td><a href="<?=$v[a_view]?>"><?=$v['username']?></a></td>
	<td class="txtgreen" align="center"><?=$v['credit']?></td>
	<td class="txtgray"><?=$v['in_time']?></td>
	<td class="txtgray"><?=$v['ip']?></td>
</tr>
<?php 		
	}
	unset($orders);
 ?>
<tr>
	<td colspan="6"><?=$page_nav?></td>
</tr>
<?php 	
}else{	
 ?>
<tr>
	<td colspan="6" align="center">暂无收入报表</td>
</tr>
<?php 
}
 ?>
</table>
</div>
</div>

<?php }elseif($action =='orders'){ ?>
<div id="container">
<h1><?=__('income_order_manage')?></h1>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('income_order_manage_tips')?></span>
</div>
<div>
<form action="<?=urr(ADMINCP,"")?>" method="get" onsubmit="return dosearch(this);">
<input type="hidden" name="item" value="<?=$item?>" />
<input type="hidden" name="action" value="<?=$action?>" />
<div class="search_box">
<div class="l"><img src="templates/admin/images/it_nav.gif" align="absbottom" />
<?=__('view_mode')?>: 
<select name="view" id="view" onchange="chg_view();">
<option value="all" <?=ifselected($view,'all','str')?>><?=__('view_all')?></option>
<option value="success" class="txtgreen" <?=ifselected($view,'success','str')?>><?=__('income_success')?></option>
<option value="fail" class="txtred" <?=ifselected($view,'fail','str')?>><?=__('income_fail')?></option>
<option value="pendding" class="txtblue" <?=ifselected($view,'pendding','str')?>><?=__('income_pendding')?></option>
</select>
</div>
<div class="r"><input type="text" name="word" value="<?=$word?>" title="<?=__('search_user_tips')?>" /> <input type="submit" class="btn" value="<?=__('search_user')?>" /></div>
</div>
</form>
<div class="clear"></div>
<script language="javascript">
function chg_view(){
	var view = getId('view').value.strtrim();
	document.location.href = '<?=ADMINCP?>.php?item=users&action=orders&view='+view;
}
function dosearch(o){
	if(o.word.value.strtrim().length <1){
		o.word.focus();
		return false;
	}
}
</script>
<form action="<?=urr(ADMINCP,"item=$item")?>" method="post">
<input type="hidden" name="action" value="<?=$action?>" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="<?=$formhash?>" />
<table align="center" width="98%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<?php 
if(count($logs)){
 ?>
<tr>
	<td class="bold"><?=__('order_number')?></td>
	<td align="center" class="bold"><?=__('user')?></td>
	<td class="bold"><?=__('income_account')?> / <?=__('account_name')?></td>
	<td align="center" class="bold"><?=__('money')?></td>
	<td class="bold"><?=__('order_status')?></td>
	<td align="center" class="bold"><?=__('order_time')?></td>
	<td align="center" class="bold"><?=__('order_ip')?></td>
</tr>
<?php 
}
 ?>
<?php 
if(count($logs)){
	foreach($logs as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td><?=$v['order_number']?>
	<?php if(!$v['status_txt']){ ?>
	<input type="hidden" name="order_ids[]" value="<?=$v['order_id']?>" />
	<?php } ?>
	</td>
	<td align="center"><a href="<?=$v['a_view']?>"><?=$v['username']?></a></td>
	<td><?=$v['income_account']?>/<?=$v['income_name']?><br /><span class="txtgray"><?=__('account_type')?>：<?=$income_type_arr[$v[income_type]]?></span></td>
	<td align="center"><span class="f14 bold txtblue">￥<?=$v['money']?></span></td>
	<td>
	<?php if($v['status_txt']){ ?>
	<?=$v['status_txt']?>
	<?php }else{ ?>
	<select name="o_status[]">
	<option value="success" class="txtgreen" <?=ifselected($v[o_status],'success','str')?>><?=__('income_success')?></option>
	<option value="fail" class="txtred" <?=ifselected($v[o_status],'fail','str')?>><?=__('income_fail')?></option>
	<option value="pendding" class="txtblue" <?=ifselected($v[o_status],'pendding','str')?>><?=__('income_pendding')?></option>
	</select>
	<?php } ?>
	</td>
	<td align="center" class="txtgray"><?=$v['in_time']?></td>
	<td align="center" class="txtgray"><?=$v['ip']?></td>
</tr>
<?php 
	}
}else{
 ?>
<tr>
	<td colspan="7" align="center"><?=__('income_order_not_found')?></td>
</tr>
<?php 
}
 ?>
<?php if($page_nav){ ?>
<tr>
	<td colspan="7"><?=$page_nav?></td>
</tr>
<?php } ?>
<?php 
if(count($logs)){
 ?>
<tr>
	<td colspan="7" align="center"><input type="submit" class="btn" value="<?=__('update_order')?>"/></td>
</tr>
<?php 
unset($logs);
}
 ?>
</table>
</form>
</div>
</div>
<?php } ?>
