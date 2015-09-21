<!--#
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: mydisk.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script type="text/javascript">
function expand_menu(id){
	if(getId('nav_'+id).style.display=='none'){
		getId('img_'+id).src = 'images/ico_desc.gif';
		$("#nav_"+id).slideDown('slow');
		//getId('nav_'+id).style.display='';
	}else{
		getId('img_'+id).src = 'images/ico_add.gif';
		$("#nav_"+id).slideUp('slow');
		//getId('nav_'+id).style.display='none';
	}
}
</script>

<div id="md_box">
<div id="md_main">
	<div class="md_l">
	
<div class="user_menu">
<div class="tit" style="cursor:pointer" onclick="expand_menu(1);"><img id="img_1" src="images/ico_desc.gif" align="absmiddle" border="0" /> <?=__('file_menu')?></div>
<ul id="nav_1">
		<li><a href="{#urr("mydisk","item=profile&action=multi_upload")#}" id="n_multi_upload"><img src="images/upload_file_icon.gif" align="absmiddle" border="0" /><?=__('multi_upload')?></a></li>
		<!--#show_ext_menu('forum_upload')#-->
		<!--#if($settings[global_open_custom_stats] && get_profile($pd_uid,'open_custom_stats')){#-->
		<!--#show_ext_menu('mod_stat')#-->
		<!--#}#-->
		<li><a href="{#urr("mydisk","item=profile&action=files")#}" id="n_files"><img src="images/ico_home.gif" align="absmiddle" border="0" /><?=__('manage_file')?></a></li>
</ul>
</div>	

<div class="user_menu">
<div class="tit" style="cursor:pointer" onclick="expand_menu(2);"><img id="img_2" src="images/ico_desc.gif" align="absmiddle" border="0" /> <?=__('income_menu')?></div>
<ul id="nav_2">
		<li><a href="{#urr("mydisk","item=profile&action=income_plans")#}" id="n_income_plans"><img src="images/user/ico_audit.gif" align="absmiddle" border="0" /><?=__('income_plans')?></a></li>
		<li><a href="{#urr("mydisk","item=profile&action=income_set")#}" id="n_income_set"><img src="images/user/ico_audit.gif" align="absmiddle" border="0" /><?=__('income_set')?></a></li>
		<li><a href="{#urr("mydisk","item=profile&action=income")#}" id="n_income"><img src="images/user/ico_money.gif" align="absmiddle" border="0" /><?=__('to_income')?></a></li>
		<li><a href="{#urr("mydisk","item=profile&action=income_log")#}" id="n_income_log"><img src="images/user/ico_history.gif" align="absmiddle" border="0" /><?=__('income_log')?></a></li>
		<!--#if($auth[pd_a] && $settings[show_credit_log]){#-->
		<li><a href="{#urr("mydisk","item=profile&action=credit_log")#}" id="n_credit_log"><img src="images/user/ico_history.gif" align="absmiddle" border="0" /><?=__('credit_log')?></a></li>
		<!--#}#-->
</ul>
</div>	
<div class="user_menu">
<div class="tit" style="cursor:pointer" onclick="expand_menu(3);"><img id="img_3" src="images/ico_desc.gif" align="absmiddle" border="0" /> <?=__('profile_menu')?></div>
<ul id="nav_3">
		<li><a href="{#urr("mydisk","item=profile")#}" id="n_default"><img src="images/user/ico_profile.gif" align="absmiddle" border="0" /><?=__('myinfo')?></a></li>
		<!--#show_ext_menu('myannounce')#-->
		<li><a href="{#urr("mydisk","item=profile&action=chg_logo")#}" id="n_chg_logo"><img src="images/user/ico_app.gif" align="absmiddle" border="0" /><?=__('space_setting')?></a></li>
		<li><a href="{#urr("mydisk","item=profile&action=invite")#}" id="n_invite"><img src="images/link_icon.gif" align="absmiddle" border="0" /><?=__('invite_user')?></a></li>
		<li><a href="{#urr("mydisk","item=profile&action=dl_users")#}" id="n_dl_users"><img src="images/user/ico_buddy.gif" align="absmiddle" border="0" /><?=__('downline_user')?></a></li>
		<li><a href="{#urr("mydisk","item=profile&action=mod_pwd")#}" id="n_mod_pwd"><img src="images/user/ico_profile.gif" align="absmiddle" border="0" /><?=__('mod_pwd')?></a></li>
		<li><a href="{#urr("account","action=logout")#}" onclick="return confirm('<?=__('confirm_logout')?>');"><img src="images/admin_icon.gif" align="absmiddle" border="0" /><?=__('exit')?></a></li>
</ul>
</div>	
	</div>
	<div class="md_r"><!--#require_once $action_module;#--></div>
</div>
	<div class="clear"></div>

</div>
<br />