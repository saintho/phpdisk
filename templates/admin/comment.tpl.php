<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: comment.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<h1><?=__('comment_manage')?><!--#sitemap_tag(__('comment_manage'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('comment_manage_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item&menu=extend")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update_setting" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_comment')?></span>: <br /><span class="txtgray"><?=__('open_comment_tips')?></span></td>
	<td><input type="radio" name="setting[open_comment]" value="1" {#ifchecked(1,$setting['open_comment'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_comment]" value="0" {#ifchecked(0,$setting['open_comment'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('check_comment')?></span>: <br /><span class="txtgray"><?=__('check_comment_tips')?></span></td>
	<td><input type="radio" name="setting[check_comment]" value="1" {#ifchecked(1,$setting['check_comment'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[check_comment]" value="0" {#ifchecked(0,$setting['check_comment'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</table>
</form>
<br />
<br />
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<!--#
if(count($cmts)){
#-->
<tr>
	<td width="50%" class="bold"><?=__('cmt_content')?></td>
	<td width="30%" class="bold"><?=__('file_name')?></td>
	<td width="150" align="right" class="bold"><?=__('username')?>/<?=__('status')?></td>
</tr>
<form action="{#urr(ADMINCP,"item=$item&menu=extend")#}" name="user_form" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="formhash" value="{$formhash}" />
<!--#
	foreach($cmts as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}" height="20">
	<td>
	<input type="checkbox" name="cmt_ids[]" id="cmt_ids" value="{$v['cmt_id']}"  /><span title="<?=__('time')?>:{$v['in_time']}">{$v['content']}</span>
	</td>
	<td><a href="{$v['a_viewfile']}" target="_blank">{#file_icon($v['file_extension'])#}{$v['file_name']}</a></td>
	<td width="150" align="right">[<a href="{$v['a_space']}" target="_blank">{$v['username']}</a>] {$v['status']}</td>
</tr>	
<!--#
	}
	unset($cmts);
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="5">{$page_nav}</td>
</tr>
<!--#}#-->
<tr>
	<td colspan="6" class="td_line"><a href="javascript:void(0);" onclick="reverse_ids(document.user_form.cmt_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.user_form.cmt_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<input type="radio" name="task" value="is_checked" id="is_checked" /><label for="is_checked"><?=__('is_checked')?></label>&nbsp;
	<input type="radio" name="task" value="is_unchecked" id="is_unchecked" /><label for="is_unchecked"><?=__('is_unchecked')?></label>&nbsp;
	<input type="radio" name="task" value="del_cmts" id="del_cmts" /><label for="del_cmts"><?=__('delete')?></label>&nbsp;
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/>
	</td>
</tr>
<!--#	
}else{	
#-->
<tr>
	<td valign="middle"><?=__('cmts_not_found')?></td>
</tr>
<!--#
}
#-->
</form>
</table>
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("cmt_ids[]") != true){
		alert("<?=__('please_select_cmts')?>");
		return false;
	}
	if(getId('is_checked').checked ==false && getId('is_unchecked').checked ==false && getId('del_cmts').checked ==false){
		alert("<?=__('please_select_cmt_op')?>");
		return false;
	}
}
</script>
</div>
</div>
