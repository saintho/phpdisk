<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: groups.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#if($action =='index'){#-->
<div id="container">
<h1><?=__('user_group_list')?><!--#sitemap_tag(__('user_group_list'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?> </b>
<span class="txtgray"><?=__('user_group_list_tips')?></span>
</div>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<!--#
if(count($groups)){
#-->
<tr>
	<td width="40%" class="bold"><?=__('group_name')?></td>
	<td align="center" class="bold"><?=__('user_count')?></td>
	<td align="center" width="80" class="bold"><?=__('group_type')?></td>
	<td align="center" width="150" class="bold"><?=__('group_server')?></td>
	<td align="center" class="bold"><?=__('operation')?></td>
</tr>

<!--#
	foreach($groups as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td>&nbsp;&nbsp;<a href="{$v['a_view']}" title="<?=__('view')?>">{$v['group_name']}</a></td>
	<td align="center">{$v['user_count']}</td>
	<td align="center">{$v['group_type_txt']}</td>
	<td align="center">{$v['group_server']}</td>
	<td align="center">
	<a href="{$v['a_group_setting']}"><?=__('group_setting')?></a>&nbsp;
	<a href="{$v['a_group_modify']}"><?=__('group_modify')?></a>&nbsp;
	<!--#if(!$v['group_type']){#-->
	<a href="{$v['a_group_delete']}" onclick="return confirm('<?=__('group_delete_confirm')?>');"><?=__('delete')?></a>
	<!--#}#-->
	</td>
</tr>	
<!--#
	}
	unset($groups);
}	
#-->
<tr>
	<td colspan="5"><input type="button" class="btn" onclick="go('{#urr(ADMINCP,"item=groups&menu=user&action=group_create")#}');" value="<?=__('create_group')?>" /></td>
</tr>
</table>
</div>
</div>
<!--#}elseif($action =='group_create' || $action =='group_modify'){#-->
<div id="container">
<h1><?=__('user_group_create')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_group_create_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=groups&menu=user")#}" method="post" onsubmit="return chkform(this);">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="gid" value="{$gid}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('group_name')?></span>: <br /><span class="txtgray"><?=__('group_name_tips')?></span></td>
	<td><input type="text" name="group_name" value="{$group_name}" size="40" maxlength="50"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" />&nbsp;
	<!--#if($remote_server_url){#-->
	<input type="button" class="btn" onclick="open_box('{$remote_server_url}',400,200);" value="<?=__('update_remote_config')?>" />
	<!--#}#-->
	&nbsp;<br /><span id="rm_tips" class="txtred"></span></td>
	</td>
</tr>
</table>
</form>
<script language="javascript">
function chkform(o){
	if(o.group_name.value.strtrim().length <2){
		alert("<?=__('js_group_name_error')?>");
		o.group_name.focus();
		return false;
	}	
}
</script>
</div>
</div>
<!--#}elseif($action =='group_setting'){#-->
<div id="container">
<h1><?=__('user_group_setting')?></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('user_group_setting_tips')?></span>
</div>
<div class="search_box">
<div class="l"><img src="{$admin_tpl_dir}images/it_nav.gif" align="absbottom" /><a href="{#urr(ADMINCP,"item=groups&menu=user&action=index")#}"><b><?=__('all_group_name')?></b></a>: {$group_set['group_name']}</div>
</div>
<div class="clear"></div>
<form action="{#urr(ADMINCP,"item=groups&menu=user")#}" method="post">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="task" value="{$action}"/>
<input type="hidden" name="gid" value="{$gid}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="50%"><b><?=__('max_storage')?></b>: <br /><span class="txtgray"><?=__('max_storage_tips')?></span></td>
	<td><input type="text" name="max_storage" value="{$group_set['max_storage']}"/></td>
</tr>
<tr>
	<td><b><?=__('max_filesize')?></b>: <br /><span class="txtgray"><?=__('max_filesize_tips')?></span></td>
	<td><input type="text" name="max_filesize" value="{$group_set['max_filesize']}"/></td>
</tr>
<tr>
	<td><b><?=__('group_file_types')?></b>: <br /><span class="txtgray"><?=__('group_file_types_tips')?></span></td>
	<td><input type="text" name="group_file_types" size="50" value="{$group_set['group_file_types']}"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
	</td>
</tr>
</table>
</form>
</div>
</div>
<!--#}#-->
