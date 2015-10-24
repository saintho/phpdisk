<?php 
// This is PHPDISK auto-generated file. Do NOT modify me.

// Cache Time:2015-09-29 00:03:19

!defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied');

?>
<?php 
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
 ?>
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div id="container">
<div id="fd_dir_box">
<h2 align="center"><?=$space_title?></h2>
<?php require_once template_echo('sub/block_adv_middle','templates/fms_blue/'); ?>
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
function fd_stat(folder_id){
	$('#fd_s_'+folder_id).html('loading...');
	$.ajax({
		type : 'post',
		url : '<?=$ajax_url?>ajax.php',
		data : 'action=fd_stat&folder_id='+folder_id+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){	
		var arr = msg.split('|');
			if(arr[0]=='true'){
				$('#fd_s_'+folder_id).html(arr[1]);
			}else{
				alert(msg);
			}
		},
		error:function(){
		}

	});
}

</script>
<div id="fd_dir">
<div class="fd_wrap">
<div class="cp_nav"><span style="float:right"><!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_b" style="line-height: 12px;"><img src="http://bdimg.share.baidu.com/static/images/type-button-1.jpg?cdnversion=20120831" />
		<a class="shareCount"></a>
	</div>
<script type="text/javascript" id="bdshare_js" data="type=button&amp;uid=68752" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script>
<!-- Baidu Button END --></span><img src="images/home_icon.gif" align="absmiddle" border="0" /><?=$nav_path?></div>

<?php if($auth[open_my_announce]){ ?>
<div class="ann_box_s">
<div class="tit2"><img src="images/ann_icon.gif" align="absmiddle" border="0" /><?=__('mydisk_announce')?></div>
<div class="inbox"><?=get_profile($userid,'my_announce')?></div>
</div>
<?php } ?>
<div class="pub_ad_box">

<!-- ad -->
</div>
<br />
<table align="center" width="99%" cellpadding="0" cellspacing="0" border="0" id="f_tab" class="td_line f14">
<tr class="head_bar">
	<td width="50%" class="bold"><?=__('file_folder_name')?></td>
	<td align="center" class="bold"><?=__('file_size')?></td>
	<td align="right" class="bold">
	<?=__('operation')?>
	</td>
</tr>
<?php 
if(count($sub_folders)){
	foreach($sub_folders as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td>
	<a href="<?=$v[a_href]?>"><img src="images/share_folder.gif" align="absmiddle" border="0" /><?=$v[folder_name]?></a></td>
	<td align="center" class="txtgray"><u><span style="cursor:pointer" onclick="fd_stat('<?=$v[folder_id]?>')" id="fd_s_<?=$v[folder_id]?>" title="<?=__('folder_stat_reload')?>"><?=$v[folder_size]?></span></u><script type="text/javascript">fd_stat('<?=$v[folder_id]?>');</script></td>
	<td align="right" class="txtgray">-</td>
</tr>	
<?php 		
	}
	unset($sub_folders);
}	
 ?>

<?php 
if(count($files_array)){
	foreach($files_array as $k => $v){
		$color = ($k%2 ==0) ? 'color1' :'color4';
 ?>
<tr class="<?=$color?>">
	<td>
	<?php if($v['is_image']){ ?>
	<a href="<?=$v['a_viewfile']?>" id="p_<?=$k?>" target="_blank" ><?=file_icon($v['file_extension'])?><?=$v['file_name']?></a><?=$v[file_new]?>&nbsp;<span class="txtgray f12"><?=$v['file_description']?></span><br />
<div id="c_<?=$k?>" class="menu_thumb"><img src="<?=$v['file_thumb']?>" /></div>
<script type="text/javascript">on_menu('p_<?=$k?>','c_<?=$k?>','x','');</script>
	<?php }else{ ?>
	<a href="<?=$v['a_viewfile']?>" target="_blank" ><?=file_icon($v['file_extension'])?><?=$v['file_name']?></a><?=$v[file_new]?> <span class="txtgray"><?=$v['file_description']?></span>
	<?php } ?>
	</td>
	<td align="center" class="txtgray"><?=$v['file_size']?></td>
	<td align="right">
	<a href="javascript:;" onclick="copy_mytxt('<?=$settings[phpdisk_url]?><?=$v['a_viewfile']?>','<?=__('copy_link_success')?>');" title="<?=__('copy_link')?>"><img src="images/copy_go.png" align="absmiddle" border="0" /></a>
	<?php if(!$v[is_checked]){ ?>
	<img src="images/ico_lock.gif" align="absmiddle" border="0" alt="<?=__('file_checking')?>" />
	<?php } ?>
	<a href="javascript:;" onclick="copy_mytxt('<?=$v['file_key']?>','<?=__('extract_code_copy_success')?>');" title="<?=__('extract_code')?>"><img src="images/ico_code.gif" align="absmiddle" border="0" /></a>
	</td>
</tr>
<?php 		
	}
	unset($files_array);
 ?>

<tr>
	<td colspan="6" style="padding-top:10px;" align="right"><?=$page_nav?>&nbsp;</td>
</tr>
<?php 	
}else{	
 ?>
<tr>
	<td colspan="6" align="center"><?=__('file_not_found')?></td>
</tr>
<?php 	
}
 ?>
</table>
<br />
<div class="pub_ad_box"><?php show_adv_data('adv_public_list_bottom'); ?></div>
<br />
</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</div>
</div>

<div class="clear"></div>
<?php if(!$pd_uid || !$settings['open_vip']){ ?>
<?=stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'space_code')))?>
<?php }elseif(($settings['open_vip'] && get_profile($pd_uid,'vip_end_time')<$timestamp) || get_vip(get_profile($pd_uid,'vip_id'),'pop_ads')){ ?>
<?=stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'space_code')))?>
<?php } ?>
<?php if(get_profile($userid,'open_custom_stats') && get_profile($userid,'check_custom_stats')){ ?>
<?=stripslashes(get_stat_code($userid))?>
<?php } ?>
<br />
