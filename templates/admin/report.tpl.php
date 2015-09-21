<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: report.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<!--#
if($action == 'user' || $action =='system' || $action =='file_unlocked'){
#-->
<div id="container">
<h1>{$title}<!--#sitemap_tag($title);#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray">{$tips}</span>
</div>
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="td_line">
<!--#
if(count($files_array)){
#-->
<tr>
	<td width="40%" class="bold"><?=__('file_name')?></td>
	<td align="center" width="100" class="bold"><?=__('status')?></td>
	<td align="center" width="100" class="bold"><?=__('owner')?></td>
	<td align="center" width="100" class="bold"><?=__('reporter')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="center" width="150" class="bold"><?=__('file_upload_time')?></td>
</tr>
<form name="file_frm" action="{#urr(ADMINCP,"item=$item&menu=file")#}" method="post" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="{$action}"/>
<input type="hidden" name="formhash" value="{$formhash}" />
<!--#
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td><input type="checkbox" name="file_ids[]" id="file_ids" value="{$v['file_id']}" />{#file_icon($v['file_extension'])#}
	<!--#if($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" title="{$v['file_name_all']} {$v['file_size']}">{$v['file_name_all']}</a><br />
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
	<!--#}else{#-->
	<a href="{$v['a_viewfile']}" target="_blank" title="{$v['file_name_all']} {$v['file_size']}">{$v['file_name_all']}</a>
	<!--#}#-->
	<Br /><span class="txtgray">{$v['reason']}</span>
	</td>
	<td align="center">{$v['status_txt']}</td>
	<td align="center">{$v['owner']}</td>
	<td align="center">{$v['reporter']}</td>
	<td align="center">{$v['file_size']}</td>
	<td align="center" class="td_line txtgray">{$v['file_time']}</td>
</tr>
<!--#		
	}
	unset($files_array);
#-->
<tr>
	<td colspan="6"><a href="javascript:void(0);" onclick="reverse_ids(document.file_frm.file_ids);"><?=__('select_all')?></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="cancel_ids(document.file_frm.file_ids);"><?=__('select_cancel')?></a>&nbsp;&nbsp;
	<input type="radio" name="task" value="change_status" checked="checked" />{$op_action} 
	<input type="radio" name="task" value="checked_done" /><?=__('checked_done')?>
	<input type="radio" name="task" value="delete" /><span class="txtred"><?=__('delete')?></span>
	<input type="submit" class="btn" value="<?=__('btn_submit')?>"/></td>
</tr>
</form>
<!--#		
}else{
#-->
<tr>
	<td colspan="6"><?=__('file_not_found')?></td>
</tr>
<!--#
}
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
</div>
</div>
<!--#
}else{
#-->
<div id="container">
<h1><?=__('report_title')?><!--#sitemap_tag(__('report_title'));#--></h1>
<div>
<div class="tips_box"><img class="img_light" src="images/light.gif" align="absmiddle" /> <b><?=__('tips')?>: </b>
<span class="txtgray"><?=__('report_list_tips')?></span>
</div>
<form action="{#urr(ADMINCP,"item=$item&menu=file")#}" method="post">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="task" value="update" />
<input type="hidden" name="formhash" value="{$formhash}" />
<table align="center" width="100%" cellpadding="4" cellspacing="0" border="0" class="td_line">
<tr>
	<td width="40%"><span class="bold"><?=__('open_report')?></span>: <br /><span class="txtgray"><?=__('open_report_tips')?></span></td>
	<td><input type="radio" name="setting[open_report]" value="1" {#ifchecked(1,$setting['open_report'])#} /> <?=__('yes')?>&nbsp;&nbsp;<input type="radio" name="setting[open_report]" value="0" {#ifchecked(0,$setting['open_report'])#}/> <?=__('no')?></td>
</tr>
<tr>
	<td><span class="bold"><?=__('report_word')?></span>: <br /><span class="txtgray"><?=__('report_word_tips')?></span></td>
	<td><textarea name="setting[report_word]" id="report_word" style="width:300px;height:50px">{$settings['report_word']}</textarea><br />
	<a href="javascript:void(0);" onclick="resize_textarea('report_word','plus');">[+]</a> <a href="javascript:void(0);" onclick="resize_textarea('report_word','sub');">[-]</a></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td><input type="submit" class="btn" value="<?=__('btn_submit')?>"/>&nbsp;&nbsp;<input type="button" class="btn" value="<?=__('btn_back')?>" onclick="javascript:history.back();" /></td>
</tr>
</table>
</form>
</div>
</div>
<!--#
}
#-->
<script language="javascript">
function dosubmit(o){
	if(checkbox_ids("file_ids[]") != true){
		alert("<?=__('please_select_operation_files')?>");
		return false;
	}
}
getId('n_{$action}').className = 'sel_a';
</script>
