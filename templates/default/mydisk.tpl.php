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
	<div class="col-md-2 md_l">
		<!--#if($pd_isteacher||$pd_isadmin){#-->
		<div class="panel panel-default">
			<div class="panel-heading"><?=__('file_menu')?></div>
			<ul class="list-group">
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=multi_upload")#}" id="n_multi_upload"><img src="images/upload_file_icon.gif" align="absmiddle" border="0" /><?=__('multi_upload')?></a>
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=files")#}" id="n_files"><img src="images/ico_home.gif" align="absmiddle" border="0" /><?=__('manage_file')?></a>
			</ul>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">课程菜单</div>
			<ul class="list-group">
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=course_manage")#}" id="n_course_manage"><img src="images/user/ico_audit.gif" align="absmiddle" border="0" />课程管理</a>
				<!--<li><a href="{#urr("mydisk","item=profile&action=course_review")#}" id="n_course_review"><img src="images/user/ico_history.gif" align="absmiddle" border="0" />课程审核</a></li>-->
			</ul>
		</div>
		<!--#}#-->
		<!--#if(DEBUG){#-->
		<div class="panel panel-default">
			<div class="panel-heading"><?=__('income_menu')?></div>
			<ul class="list-group">
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=income_plans")#}" id="n_income_plans"><img src="images/user/ico_audit.gif" align="absmiddle" border="0" /><?=__('income_plans')?></a>
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=income_set")#}" id="n_income_set"><img src="images/user/ico_audit.gif" align="absmiddle" border="0" /><?=__('income_set')?></a>
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=income")#}" id="n_income"><img src="images/user/ico_money.gif" align="absmiddle" border="0" /><?=__('to_income')?></a>
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=income_log")#}" id="n_income_log"><img src="images/user/ico_history.gif" align="absmiddle" border="0" /><?=__('income_log')?></a>
				<!--#if($auth[pd_a] && $settings[show_credit_log]){#-->
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=credit_log")#}" id="n_credit_log"><img src="images/user/ico_history.gif" align="absmiddle" border="0" /><?=__('credit_log')?></a>
				<!--#}#-->
			</ul>
		</div>
		<!--#}#-->

		<div class="panel panel-default">
			<div class="panel-heading"><?=__('profile_menu')?></div>
			<ul class="list-group">
				<a class="list-group-item" href="{#urr("mydisk","item=profile")#}" id="n_default"><img src="images/user/ico_profile.gif" align="absmiddle" border="0" /><?=__('myinfo')?></a>
				<!--#show_ext_menu('myannounce')#-->
				<!--<li><a href="{#urr("mydisk","item=profile&action=chg_logo")#}" id="n_chg_logo"><img src="images/user/ico_app.gif" align="absmiddle" border="0" /><?=__('space_setting')?></a></li>-->
				<!--<li><a href="{#urr("mydisk","item=profile&action=invite")#}" id="n_invite"><img src="images/link_icon.gif" align="absmiddle" border="0" /><?=__('invite_user')?></a></li>-->
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=application_teacher")#}" id="n_application_teacher"><img src="images/link_icon.gif" align="absmiddle" border="0" />申请教师</a>
				<a class="list-group-item" href="{#urr("mydisk","item=profile&action=mod_pwd")#}" id="n_mod_pwd"><img src="images/user/ico_profile.gif" align="absmiddle" border="0" /><?=__('mod_pwd')?></a>
				<a class="list-group-item" href="{#urr("account","action=logout")#}" onclick="return confirm('<?=__('confirm_logout')?>');"><img src="images/admin_icon.gif" align="absmiddle" border="0" /><?=__('exit')?></a>
			</ul>
		</div>
	</div>
	<div class="col-md-10 md_r "><!--#require_once $action_module;#--></div>
</div>
	<div class="clear"></div>

</div>
<br />