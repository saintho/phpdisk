<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_search.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<!--#include sub/block_adv_middle#-->
<div class="tit"><?=__('search_title')?></div>
<div class="layout_box2">
<div class="m" <!--#if($action =='search'){#-->style="padding:10px"<!--#}#-->>
<!--#if(!$error){#-->
<form name="search_frm" action="{#urr("search","")#}" method="get" onsubmit="return dosubmit(this);">
<input type="hidden" name="action" value="search" />
<table align="center"<!--#if($action =='search'){#--> width="98%" <!--#}#--> cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="td_box"><?=__('keyword')?>: <input type="text" name="word" size="30" value="{$word}" title="<?=__('search_files_tips')?>" class="td_input" />
	<!--#if($pd_uid){#-->
	<select name="scope" class="td_sel">
	<option value="all" {#ifselected('all',$scope,'str')#}><?=__('all_file')?></option>
	<option value="mydisk" {#ifselected('mydisk',$scope,'str')#}><?=__('scope_mydisk')?></option>
	</select>
	<!--#}#-->
	<input type="submit" class="btn" value="<?=__('search')?>" /></td>
</tr>
</table>
</form>
<script language="javascript">
document.search_frm.word.focus();
function dosubmit(o){
	if(o.word.value.strtrim().length <1){
		o.word.focus();
		return false;
	}
}
</script>
<!--#if($action =='search'){#-->
<script language="javascript">
$(document).ready(function(){
	$("#f_tab tr").mouseover(function(){
		$(this).addClass("alt_bg");
	}).mouseout(function(){
		$(this).removeClass("alt_bg");
	});
});
</script>
<br />
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<!--#
if(count($files_array)){
#-->
<tr class="head_bar">
	<td width="40%" class="bold"><a href="{$n_url}"><?=__('file_name')?>{$n_order}</a></td>
	<!--#if(!$settings['open_vip']){#-->
	<td align="center" class="bold"><a href="{$u_url}"><?=__('username')?>{$u_order}</a></td>
	<!--#}#-->
	<td align="center" class="bold"><?=__('file_views')?></td>
	<td align="center" class="bold"><?=__('file_downs')?></td>
	<td align="center" class="bold"><a href="{$s_url}"><?=__('file_size')?>{$s_order}</a></td>
	<td align="center" width="150" class="bold"><a href="{$t_url}"><?=__('file_upload_time')?>{$t_order}</a></td>
</tr>
<!--#
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td class="f14">
	<!--#if($settings['open_vip']){#-->
	<!--#if(!$pd_uid){#-->
		{#file_icon($v['file_extension'])#}<a href="javascript:alert('<?=__('vip_user_download')?>');">{$v['file_name_all']}</a><br /><span class="txtgray">{$v['file_description']}</span>
	<!--#}elseif(get_profile($pd_uid,'vip_end_time')>$timestamp){#-->
		<!--#if(get_vip(get_profile($pd_uid,'vip_id'),'search_down')){#-->
			{#file_icon($v['file_extension'])#}<a href="javascript:alert('<?=__('vip_user_download')?>');">{$v['file_name_all']}</a><br /><span class="txtgray">{$v['file_description']}</span>
		<!--#}else{#-->
			<!--#if($v['is_image']){#-->
			{#file_icon($v['file_extension'])#}<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{$v['file_name_all']}</a><br /><span class="txtgray">{$v['file_description']}</span>
		<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
		<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
			<!--#}else{#-->
			{#file_icon($v['file_extension'])#}<a href="{$v['a_viewfile']}" target="_blank" >{$v['file_name_all']}</a><br /><span class="txtgray">{$v['file_description']}</span>
			<!--#}#-->
		<!--#}#-->
		
	<!--#}else{#-->
		{#file_icon($v['file_extension'])#}<a href="javascript:alert('<?=__('vip_user_download')?>');">{$v['file_name_all']}</a><br /><span class="txtgray">{$v['file_description']}</span>
	<!--#}#-->
	
	<!--#}else{#-->
		<!--#if($v['is_image']){#-->
		{#file_icon($v['file_extension'])#}<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{$v['file_name_all']}</a><br /><span class="txtgray">{$v['file_description']}</span>
	<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
	<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
		<!--#}else{#-->
		{#file_icon($v['file_extension'])#}<a href="{$v['a_viewfile']}" target="_blank" >{$v['file_name_all']}</a><br /><span class="txtgray">{$v['file_description']}</span>
		<!--#}#-->
	<!--#}#-->
	</td>
	<!--#if(!$settings['open_vip']){#-->
	<td align="center"><a href="{$v['a_space']}" target="_blank">{$v['username']}</a></td>
	<!--#}#-->
	<td align="center">{#get_discount($v[userid],$v['file_views'])#}</td>
	<td align="center">{#get_discount($v[userid],$v['file_downs'])#}</td>
	<td align="center">{$v['file_size']}</td>
	<td align="center" width="150"  class="td_line txtgray">{$v['file_time']}</td>
</tr>
<!--#		
	}
	unset($files_array);
}else{	
#-->
<tr>
	<td colspan="6"><?=__('search_is_empty')?></td>
</tr>
<!--#
}
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="6" class="head_bar">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
<!--#}#-->
<!--#}#-->
</div>
</div>
</div>
<br />