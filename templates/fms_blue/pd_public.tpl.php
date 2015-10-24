<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_public.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<!--#include sub/block_adv_middle#-->

<!--#if($cate_id){#-->
<br />
<div class="layout_box">
<div class="l">
<!--#include sub/block_public_cate_list#-->
<br />
<!--#show_adv_data('adv_right');#-->
<!--#include sub/block_cate_hot_file#-->
<br />
<!--#include sub/block_now_week_down_file#-->
</div>
<div class="r">
<div class="file_box">
	<h2 class="file_tit">{$nav_title}</h2>
<table align="center" width="98%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line">
<tr class="head_bar">
	<td width="60%" class="bold"><?=__('file_name')?></td>
	<td align="center" class="bold"><?=__('username')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="right" width="100" class="bold"><?=__('file_upload_time')?></td>
</tr>
<!--#
if(count($files_array)){
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td class="f14">&nbsp;{#file_icon($v['file_extension'])#}
	<!--#if($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{$v['file_name_all']}</a><br /><span class="txtgray">{$v['file_description']}</span>
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
	<!--#}else{#-->
	<a href="{$v['a_viewfile']}" target="_blank" >{$v['file_name_all']}</a><br /><span class="txtgray">{$v['file_description']}</span>
	<!--#}#-->
	</td>
	<td align="center"><a href="{$v['a_space']}" target="_blank">{$v['username']}</a></td>
	<td align="center">{$v['file_size']}</td>
	<td align="right" class="td_line txtgray">{$v['file_time']}</td>
</tr>
<!--#		
	}
	unset($files_array);
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
	<td colspan="6" class="head_bar">{$page_nav}</td>
</tr>
<!--#}#-->
</table>
</div>

</div>
<div class="clear"></div>
</div>

<!--#}else{#-->
<br />
<div class="layout_box">
<!--#
if(count($cate_list)){
	foreach($cate_list as $k => $v){
	$style = ($k+1)%3==0 ? 'r_box' : 'l_box';
#-->
<div class="pub_box {$style}">
<div class="tit2"><span style="float:right;"><a href="{#urr("public","cate_id=$v[cate_id]")#}" title="<?=__('more')?>" target="_blank"><img src="images/more.gif" align="absmiddle" border="0"></a></span><a href="{#urr("public","cate_id=$v[cate_id]")#}">{$v[cate_name]}</a></div>
	<!--#
	$file_list = get_cate_file($v[cate_id]);
	if(count($file_list)){
	#-->
	<ul>
	<!--#
		foreach($file_list as $v2){
	#-->
	<li>{$v2['file_time']}<a href="{$v2['a_viewfile']}" target="_blank">{$v2[file_icon]} {$v2['file_name']}</a></li>
	<!--#
		}
		unset($file_list);
	#-->
	</ul>
	<!--#
	}	
	#-->
</div>
<!--#
	if(($k+1)%3==0){ echo '<div class="clear"></div>';}
	}
	unset($cate_list);
}else{	
#-->

<div class="layout_box2">
<div class="m">
<div align="center"><?=__('file_not_found')?></div>
</div>
</div>
<!--#}#-->
<div class="clear"></div>
</div>

<!--#}#-->

