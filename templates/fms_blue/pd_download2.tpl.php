<!--#
##
#	Project: PHPDISK File Storage Solution
#	This is NOT a freeware, use is subject to license terms.
#
#	Site: http://www.google.com
#
#	$Id: pd_download2.tpl.php 123 2014-03-04 12:40:37Z along $
#
#	Copyright (C) 2008-2014 PHPDisk Team. All Rights Reserved.
#
##
#-->
<?php !defined('IN_PHPDISK') && exit('[PHPDisk] Access Denied!'); ?>
<div class="layout_box">
<!--#include sub/block_adv_middle#-->
<div class="l">
<!--#show_adv_data('adv_right');#-->
<!--#include sub/block_cate_last_file#-->
<br />
</div>
<!--#if(!$action){#-->
<div class="r">
<!--#if($file['is_del']){#-->
<div class="msg_box f14"><img src="images/light.gif" align="absmiddle" border="0"/><?=__('file_is_delete')?><br /><br /><br /></div>
<!--#}else{#-->
<div class="file_box">
	<h3 class="file_tit">{#file_icon($file['file_extension'],'filetype_32','absbottom')#}{$file['file_name']}</h3>
	<div class="fb_l">
		<table width="100%" cellpadding="4" cellspacing="0" align="center" class="td_line f14">
		<tr>
			<td colspan="2"><?=__('file_category')?>: {#get_cate_path($file[cate_id])#}</td>
		</tr>
		<tr>
			<td width="50%"><?=__('upload_user')?>: {$file['username']}</td>
			<td><?=__('file_size')?>: {$file['file_size']}</td>
		</tr>
		<tr>
			<td><?=__('upload_ip')?>:<span id="file_upload_ip">{#ip_encode($file['ip'])#}</span></td>
			<td><?=__('upload_time')?>: <span id="file_upload_time">{$file['file_time']}</span></td>
		</tr>
		<tr>
			<td><?=__('file_downs')?>: <span id="file_downs">{$file['file_downs']}</span> </td>
			<td><?=__('file_views')?>: <span id="file_views">{$file['file_views']}</span> </td>
		</tr>
		<tr>
			<td colspan="2"><?=__('file_tag')?>: {$file['tags']}</td>
		</tr>
		<tr>
			<td colspan="2"><!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
<a class="bds_qzone"></a>
<a class="bds_tsina"></a>
<a class="bds_tqq"></a>
<a class="bds_renren"></a>
<a class="bds_t163"></a>
<span class="bds_more"></span>
<a class="shareCount"></a>
</div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=68752" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END --></td>
		</tr>
		</table>
	</div>
	<div class="fb_r">
	<br />
	<!--#show_adv_data('adv_viewfile_right');#-->
	</div>


<div class="file_link_box">
	<div align="center"><!--#show_adv_data('adv_viewfile_hits_bottom');#--></div>
	<div align="center"><!--#show_adv_data('adv_viewfile_download_top');#--></div>
	<div style="float:left; width:300px; margin-top:10px" id="down_link"><a href="{$file['a_downfile']}"><img src="{$user_tpl_dir}images/btn_download.png" align="absmiddle" border="0" /></a></div>
	<div align="center" class="clear"><!--#show_adv_data('adv_viewfile_download_bottom');#--></div>
</div>
<Br />

<div class="file_item file_desc">
	<div class="tit"><?=__('file_description')?>:</div>
	<div class="ctn">{$file[file_description]}</div>
</div>

</div>
<Br />

<script type="text/javascript">
function down_process(file_id){

}
function down_process2(file_id){
	$.ajax({
		type : 'post',
		url : 'ajax.php',
		data : 'action=down_process&file_id='+file_id+'&t='+Math.random(),
		dataType : 'text',
		success:function(msg){
			if(msg == 'true'){

			}else{
				alert(msg);
			}
		},
		error:function(){
		}

	});
}

function copy_text(id){
	var field = getId(id);
	if (field){
		if (document.all){
			field.createTextRange().execCommand('copy');
			alert("<?=__('txt_copy_success')?>");
		}else{
			alert("<?=__('not_ie_copy_tips')?>");
		}	
	}
}
</script>
<!--#}#-->
</div>
<!-- end not action -->
<!--#}#-->
<div class="clear"></div>
</div>
<!--#if(!$pd_uid || !$settings['open_vip']){#-->
{#stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'viewfile_code')))#}
<!--#}elseif(($settings['open_vip'] && get_profile($pd_uid,'vip_end_time')<$timestamp) || get_vip(get_profile($pd_uid,'vip_id'),'pop_ads')){#-->
{#stripslashes(base64_decode(get_plans(get_profile($file[userid],'plan_id'),'viewfile_code')))#}
<!--#}#-->
<br /><br />