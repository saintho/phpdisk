<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_tag.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<script language="javascript">
$(document).ready(function(){
	$("#f_tab tr").mouseover(function(){
		$(this).addClass("alt_bg");
	}).mouseout(function(){
		$(this).removeClass("alt_bg");
	});
});
</script>
<div id="container">
<div class="layout_box">
<!--#include sub/block_adv_middle#-->
<div class="l">
<!--#show_adv_data('adv_right');#-->
<!--#include sub/block_share_file_box#-->
<br />
<!--#include sub/block_last_week_down_file#-->
</div>
<div class="r">
<div class="tit">{$tag_title}</div>
<!--#if(!$tag){#-->
<div class="tag_list">
<div class="t_tit"><?=__('last_tag_title')?></div>
<ul>
<li>
<!--#
if(count($last_tags)){
	foreach($last_tags as $v){
#-->
<a href="{$v['a_view_tag']}">{$v['tag_name']}<span class="txtgray">{$v['tag_count']}</span></a>
<!--#
	}
	unset($last_tags);
}
#-->
</li>
</ul>
<br />
<div class="clear"></div>
</div>
<br />
<div class="tag_list">
<div class="t_tit"><?=__('hot_tag_title')?></div>
<ul>
<li>
<!--#
if(count($hot_tags)){
	foreach($hot_tags as $v){
#-->
<a href="{$v['a_view_tag']}">{$v['tag_name']}<span class="txtgray">{$v['tag_count']}</span></a>
<!--#
	}
	unset($hot_tags);
}
#-->
</li>
</ul>
<br />
<div class="clear"></div>
</div>
<!--#}else{#-->
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<!--#
if(count($files_array)){
#-->
<tr class="head_bar">
	<td width="50%" class="bold"><?=__('file_name')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="center" width="150" class="bold"><?=__('file_upload_time')?></td>
</tr>
<!--#
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}" height="20">
	<td class="td_line">&nbsp;{#file_icon($v['file_extension'])#}&nbsp;
	<!--#if($v['is_locked']){#-->
	<span class="txtgray" title="<?=__('file_locked')?>">{$v['file_name']} {$v['file_description']}</span>
	<!--#}elseif($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{$v['file_name']}</a>&nbsp;<span class="txtgray">{$v['file_description']}</span><br />
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
	<!--#}else{#-->
	<a href="{$v['a_viewfile']}" target="_blank" >{$v['file_name']}</a> <span class="txtgray">{$v['file_description']}</span>
	<!--#}#-->
	</td>
	<td align="center" class="td_line">{$v['file_size']}</td>
	<td align="center" width="150"  class="td_line txtgray">{$v['file_time']}</td>
</tr>
<!--#		
	}
	unset($files_array);
}	
#-->
<!--#if($page_nav){#-->
<tr>
	<td colspan="6">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
<!--#}#-->
</div>
<div class="clear"></div>
</div>
</div>
<Br />