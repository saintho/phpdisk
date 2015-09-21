<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_space.tpl.php 121 2014-03-04 12:38:05Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<div id="fd_dir_box">
<h2 align="center">{$space_title}</h2>
<script language="javascript">
$(document).ready(function(){
	$("#f_tab tr").mouseover(function(){
		$(this).addClass("alt_bg");
	}).mouseout(function(){
		$(this).removeClass("alt_bg");
	});
	$("#fd_dir .fd_dir_1").mouseover(function(){
		$(this).addClass("alt_bg");
	}).mouseout(function(){
		$(this).removeClass("alt_bg");
	});
	$('#fd_dir .fd_dir_1').each(function(){
		var li_obj = $(this).find("span a");
		$(this).mouseover(function(){
			li_obj.css("display","");
		}).mouseout(function(){
			li_obj.css("display","none");
		});
	});
});
function copy_link(str){
   window.clipboardData.setData("Text",str);
   alert('<?=__('copy_link_success')?>');
}
</script>
<div id="fd_dir">
<div class="fd_l">
<script type="text/javascript">
tr = new tree('tr');
{$folder_list}
document.write(tr);
</script>

</div>
<div class="fd_r">
<div class="cp_nav"><img src="images/icon_nav.gif" align="absmiddle" border="0" />{$nav_path}</div>
<!--#if($auth[open_my_announce]){#-->
<div class="ann_box">
<div class="tit2"><img src="images/ann_icon.gif" align="absmiddle" border="0" /><?=__('mydisk_announce')?></div>
<div class="inbox">{#get_profile($userid,'my_announce')#}</div>
</div>
<!--#}#-->
<div class="pub_ad_box">

<!-- ad -->
</div>
<table align="center" width="99%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line f14">
<!--#
if(count($files_array)){
#-->
<tr>
	<td width="50%" class="bold"><?=__('file_name')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="right" class="bold">
	&nbsp;
	</td>
</tr>
<!--#
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
#-->
<tr class="{$color}">
	<td>
	{#file_icon($v['file_extension'])#}
	<!--#if($v['is_locked']){#-->
	<span class="txtgray" title="<?=__('file_locked')?>">{$v['file_name']} {$v['file_description']}</span>
	<!--#}elseif($v['is_image']){#-->
	<a href="{$v['a_viewfile']}" id="p_{$k}" target="_blank" >{$v['file_name']}</a>{$v[file_new]}&nbsp;<span class="txtgray f12">{$v['file_description']}</span><br />
<div id="c_{$k}" class="menu_thumb"><img src="{$v['file_thumb']}" /></div>
<script type="text/javascript">on_menu('p_{$k}','c_{$k}','x','');</script>
	<!--#}else{#-->
	<a href="{$v['a_viewfile']}" target="_blank" >{$v['file_name']}</a>{$v[file_new]} <span class="txtgray">{$v['file_description']}</span>
	<!--#}#-->
	</td>
	<td align="center" class="txtgray">{$v['file_size']}</td>
	<td align="right">
	<a href="javascript:;" onclick="copy_mytxt('{$settings[phpdisk_url]}{$v['a_viewfile']}','<?=__('copy_link_success')?>');return false;" title="<?=__('copy_link')?>"><img src="images/copy_go.png" align="absmiddle" border="0" /></a>
	</td>
</tr>
<!--#		
	}
	unset($files_array);
#-->
<tr>
	<td colspan="6" style="padding-top:10px;" align="right">{$page_nav}&nbsp;</td>
</tr>
<!--#	
}else{	
#-->
<tr>
	<td colspan="6" align="center"><?=__('file_not_found')?></td>
</tr>
<!--#	
}
#-->
</table>
<br />
<div class="pub_ad_box"><!--#show_adv_data('adv_public_list_bottom');#--></div>
<br />
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</div>
</div>

<div class="clear"></div>
<!--#if(!$pd_uid || !$settings['open_vip']){#-->
{#stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'space_code')))#}
<!--#}elseif(($settings['open_vip'] && get_profile($pd_uid,'vip_end_time')<$timestamp) || get_vip(get_profile($pd_uid,'vip_id'),'pop_ads')){#-->
{#stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'space_code')))#}
<!--#}#-->
<!--#if(get_profile($userid,'open_custom_stats') && get_profile($userid,'check_custom_stats')){#-->
{#stripslashes(get_stat_code($userid))#}
<!--#}#-->
<br />
